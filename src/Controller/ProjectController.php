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
        $this->userRepository = $entityManager->getRepository('App:User');
    }

    /**
     * @Route("/projects", name="projects")
     */
    public function index(): Response
    {
        return $this->render('project/index.html.twig');
    }

    /**
     * @Route("/api/projects/list", name="projects_list")
     */
    public function allProjects(): Response
    {
        $myProjects = $this->projectRepository->findOwner($this->getUser());
        
        $projectsAssigned = $this->projectRepository->getProjectsAssigned($this->getUser());
        

        $projects = array_merge($myProjects, $projectsAssigned);
        $projects = array_map("unserialize", array_unique(array_map("serialize", $projects)));
        sort($projects);
        $jsonContent = $this->serializeObject($projects);

        return new Response($jsonContent, Response::HTTP_OK);
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
            $project->setDate(new \DateTime($content['date']));
            $project->setDescription($content['description']);
            $project->setCreatedAt(new \DateTime());

            foreach ($content['user'] as $user) {
                if (empty($user['id'])) {
                    continue;
                }

                $userEntity = $this->userRepository->find($user['id']);

                if (empty($userEntity)) {
                    continue;
                }

                $project->addAssignedUser($userEntity);
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
