<?php

namespace App\Controller;

use App\Entity\Project;
use App\Repository\ProjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class ProjectController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    private ProjectRepository $projectRepository;

    /**
     * ProjectController constructor.
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->projectRepository = $entityManager->getRepository(Project::class);
    }

    /**
     * @Route("/projects", name="project")
     */
    public function index(): Response
    {
        $projects = $this->projectRepository->findBy(['user' => $this->getUser()->getId()]);
        $jsonContent = $this->serializeObject($projects);

        return new Response($jsonContent, Response::HTTP_OK);
    }

    /**
     * @Route("/projects/create", name="create_project")
     */
    public function saveProjects(Request $request): Response
    {
        $content = json_decode($request->getContent(), true);

        if (!isset($content['name']) || !isset($content['description'])) {
            return new Response('Error', Response::HTTP_NOT_FOUND);
        }

        $project = new Project();
        $project->setUser($this->getUser());
        $project->setName($content['name']);
        $project->setDescription($content['description']);
        $project->setTasks([]);
        $project->setCreatedAt(new \DateTime());
        $project->setUpdatedAt(new \DateTime());
        $this->updateDatabase($project);

        $jsonContent = $this->serializeObject($project);

        return new Response($jsonContent, Response::HTTP_OK);
    }

    public function serializeObject(object $object): string
    {
        $encoders = new JsonEncoder();
        $defaultContext = [
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => function ($obj) {
                return $obj->getId();
            },
        ];

        $normalizers = new ObjectNormalizer(null, null, null, null, null, null, $defaultContext);
        $serializer = new Serializer([$normalizers], [$encoders]);
        return $serializer->serialize($object, 'json');
    }

    public function updateDatabase(object $object): void
    {
        $this->entityManager->persist($object);
        $this->entityManager->flush();
    }
}
