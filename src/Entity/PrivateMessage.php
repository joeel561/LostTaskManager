<?php

namespace App\Entity;

use Symfony\Component\Serializer\Annotation\MaxDepth;
use App\Repository\PrivateMessageRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PrivateMessageRepository::class)
 */
class PrivateMessage
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @MaxDepth(1)
     * @ORM\ManyToOne(targetEntity="App\Entity\Chatroom", inversedBy="messages")
     */
    private $chatroom;

    /**
     * @MaxDepth(1)
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="sentMessages")
     */
    private $sender;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $text;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getChatroom()
    {
        return $this->chatroom;
    }

    public function setChatroom($newChatroom)
    {
        $this->chatroom = $newChatroom;

        return $this;
    }


    public function getSender()
    {
        return $this->sender;
    }

    public function setSender(User $newSender)
    {
        $this->sender = $newSender;

        return $this;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(string $text): self
    {
        $this->text = $text;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}
