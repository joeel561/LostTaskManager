<?php

namespace App\Entity;

use App\Repository\ChatroomRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Serializer\Annotation\MaxDepth;

/**
 * @ORM\Entity(repositoryClass=ChatroomRepository::class)
 */
class Chatroom
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;


    /**
     * @MaxDepth(1)
     * @ORM\OneToMany(targetEntity="App\Entity\PrivateMessage", mappedBy="chatroom")
     */
    private $messages;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\User", mappedBy="participant")
    */
    private $participants;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMessages()
    {
        return $this->messages;
    }

    public function setMessages($messages)
    {
        $this->messages = $messages;

        return $this;
    }

    public function __construct() {
        $this->participants = new ArrayCollection();
    }

    /**
     * @return Collection|User[]
     */
    public function getParticipants(): ?Collection
    {
       return $this->participants;
    }

    public function setParticipant(User $participant): self 
    {
        if (!$this->participants->contains($participant)) {
            $this->participants[] = $participant;
            $participant->setParticipant($this);
        }

        return $this;
    }
}
