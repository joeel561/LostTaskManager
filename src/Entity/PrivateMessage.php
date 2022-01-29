<?php

namespace App\Entity;

use Symfony\Component\Serializer\Annotation\MaxDepth;
use App\Repository\PrivateMessageRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=PrivateMessageRepository::class)
 */
class PrivateMessage
{
    /**
     * @MaxDepth(1)
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"chatroom_user"})
     */
    private $id;

    /**
     * @MaxDepth(1)
     * @ORM\ManyToOne(targetEntity="App\Entity\Chatroom", inversedBy="messages")
     * 
     */
    private $chatroom;

    /**
     * @MaxDepth(1)
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="sentMessages")
     * * @Groups({"chatroom_user"})
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
    /**
     * @Groups({"chatroom_user"})
     */

    public function getChatroom()
    {
        return $this->chatroom;
    }

    public function setChatroom($newChatroom)
    {
        $this->chatroom = $newChatroom;

        return $this;
    }
    
    /**
     * 
     */
    public function getSender()
    {
        return $this->sender;
    }

    public function setSender(User $newSender)
    {
        $this->sender = $newSender;

        return $this;
    }

    /**
     *  
     * @Groups({"chatroom_user"})
     */
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
