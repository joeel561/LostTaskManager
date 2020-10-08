<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Task;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;


class TaskController extends AbstractController
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    /**
     * @var \Doctrine\Common\Persistence\ObjectRepository
     */
    private $projectRepository;
    /**
     * @var \Doctrine\Common\Persistence\ObjectRepository
     */
    private $taskRepository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->projectRepository = $entityManager->getRepository('App:Project');
        $this->taskRepository = $entityManager->getRepository('App:Task');
    }

    /**
     * @Route("/projects/{id}/tasks", name="task")
     */
    public function createTask(Request $request,int $id)
    {
        $content = json_decode($request->getContent(), true);

        $project = $this->projectRepository->find($id);

        $task = new Task();
        $task->setName($content['name']);
        $task->setUser($this->getUser());
        $task->setProject($project);
        $this->updateDatabase($task);

        $jsonContent = $this->serializeObject($task);

        return new Response($jsonContent, Response::HTTP_OK);
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
