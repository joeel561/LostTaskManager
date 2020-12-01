<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Project;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Validator\Constraints\DateTime;


class ProjectController extends AbstractController
{
    /**
     * @var EntityManagerInterface
     * 
     * 
     * 
     */
    private $entityManager;
    /**
     * @var \Doctrine\Common\Persistence\ObjectRepository
     */
    private $projectRepository;
    /**
     * ProjectController constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->projectRepository = $entityManager->getRepository('App:Project');

    }

    /**
     * @Route("/projects", name="project")y
     */
    public function index()
    {
        $owner = $this->projectRepository->findOwner($this->getUser());
        $users = $this->projectRepository->findUsers();
       
        $jsonContent = $this->serializeObject($owner);

        return new Response($jsonContent, Response::HTTP_OK);
    }

    public function assignUsers()
    {
        $assignUsers = $this->getAssignedUser();
        $projects = [ ];
        foreach($assignUser as $key => $user) {
            $projects[] = $this->projectRepository->findByUser($this->getUser()->getId());
        }

        return $projects;
    }

    /** 
     * @param Request $request
     * @return Response
     * @Route("/projects/create", name="create_project")
     */

    public function saveProjects(Request $request)
    {
        $owner = $this->getUser();
        $content = json_decode($request->getContent(), true);

        if($content['name'] && $content['description']) {
            $project = new Project();
            $project->setOwner($this->getUser());
            $project->setName($content['name']);
            $project->setDescription($content['description']);
            $project->setCreatedAt(new \DateTime());
            $project->setUpdatedAt(new \DateTime());
            

            $assignUserIds = [
                1,
                2,
                3
            ];

            foreach($assignUserIds as $userId) {
                $user = $this->userRepository->find($userId);
                $project->assignUser($user);
            }
            
            
            $this->updateDatabase($project); 

            $jsonContent = $this->serializeObject($project);

            return new Response($jsonContent, Response::HTTP_OK);
        }   

        return new Response('Error', Response::HTTP_NOT_FOUND);
    }

    public function serializeObject($object)
    { 
        $encoders = new JsonEncoder();
        $defaultContext = [
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => function ($obj) {
                return $obj->getId();
            },
        ];

        $normalizers = new ObjectNormalizer(null, null, null, null, null, null, $defaultContext);
        $serializer = new Serializer(array($normalizers), array($encoders));
        $jsonContent = $serializer->serialize($object, 'json');

        return $jsonContent;
    }

    public function updateDatabase($object)
    {
        $this->entityManager->persist($object);
        $this->entityManager->flush();
    }
}
