<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Notes;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class NotesController extends AbstractController
{
     /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    /**
     * @var \Doctrine\Common\Persistence\ObjectRepository
     */
    private $notesRepository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->notesRepository = $entityManager->getRepository('App:Notes');
    }

    /**
     * @Route("/notes", name="notes_page")
     */
    public function index(): Response
    {
        return $this->render('notes/index.html.twig');
    }

    /**
     * @Route("/notes/list", name="notes")
     */
    public function allNotes(): Response
    {
        $notes = $this->notesRepository->findByUser($this->getUser());
        
        $jsonContent = $this->serializeObject($notes);

        return new Response($jsonContent, Response::HTTP_OK);
    }

    /** @param Request $request
     * @return Response
     * @Route("/notes/createNote", name="create_note")
     */
    public function createNote(Request $request)
    {
        $content = json_decode($request->getContent(), true);

        if($content['text']) {
            $note = new Notes();
            $note->setUser($this->getUser());
            $note->setText($content['text']);
            $this->updateDatabase($note);
            $jsonContent = $this->serializeObject($note);

            return new Response($jsonContent, Response::HTTP_OK);
        }
    }

    /** @param Request $request
     * @return Response
     * @Route("/notes/{id}/deleteNote", name="delete_note")
     */
    public function deleteNote(Request $request,int $id)
    {
        $content = json_decode($request->getContent(), true);

        $note = $this->notesRepository->find($id);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($note);
        $entityManager->flush();

        return new Response(Response::HTTP_OK);


    }

    /** @param Request $request
     * @return Response
     * @Route("/notes/{id}/editNote", name="edit_note", methods={"PATCH"})
     */
    public function editNote(Request $request,int $id) 
    {
        $content = json_decode($request->getContent(), true);

        $note = $this->notesRepository->find($id);
        
        if($note) {
            $note->setText($content['text']);
            $note->setUser($this->getUser());
            $this->updateDatabase($note);
            $jsonContent = $this->serializeObject($note);

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
        $jsonContent = $serializer->serialize($object, 'json', [AbstractNormalizer::IGNORED_ATTRIBUTES => ['ownedProjects', 'participant', 'assignedProjects', 'owner', 'participant' ,'plainPassword', 'password', 'sentMessages']]);

        return $jsonContent;
    }

    public function updateDatabase($object)
    {
        $this->entityManager->persist($object);
        $this->entityManager->flush();
    }
}
