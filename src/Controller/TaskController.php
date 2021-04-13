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
     * @param Request $request
     * @return Response
     * @Route("/projects/{id}/tasks", name="task")
     */
    public function createTask(Request $request,int $id)
    {
        $content = json_decode($request->getContent(), true);

        $project = $this->projectRepository->find($id);

        if($content['name']) {
            $task = new Task();
            $task->setName($content['name']);
            $task->setProject($project);
            $this->updateDatabase($task);
            $jsonContent = $this->serializeObject($task);

            return new Response($jsonContent, Response::HTTP_OK);
        }
    }

        /**
     * @param Request $request
     * @return Response
     * @Route("/projects/{id}/deleteTask", name="delete_task", methods={"DELETE"})
     */
    public function deleteTask(Request $request, int $id)
    {
        $content = json_decode($request->getContent(), true);

        $task = $this->taskRepository->find($content['id']);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($task);
        $entityManager->flush();

        return new Response(Response::HTTP_OK);
    }

    /**
     * @param Request $request
     * @return Response
     * @Route("/projects/{id}/editTag", name="edit_tag", methods={"PATCH"})
     */
    public function editTag(Request $request, int $id)
    {
        $content = json_decode($request->getContent(), true);

        $task = $this->taskRepository->find($content['taskId']);

        if($task) {
            $task->setTag($content['tag']);
            $this->updateDatabase($task);
            $jsonContent = $this->serializeObject($task);

            return new Response($jsonContent, Response::HTTP_OK);
        }

        return new Response(Response::HTTP_OK);
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
