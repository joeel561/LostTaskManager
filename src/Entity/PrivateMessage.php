<?php

namespace App\Entity;

use Symfony\Component\Serializer\Annotation\MaxDepth;
use App\Repository\PrivateMessageRepository;
use Doctrine\ORM\Mapping as ORM;
use DateTimeInterface;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=PrivateMessageRepository::class)
 */
class PrivateMessage
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"privat_messages"})
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Chatroom", inversedBy="messages")
     * @MaxDepth(2)
     * @Groups({"privat_messages"})
     *  @ORM\JoinColumn(onDelete="CASCADE")
     * 
     */
    private $chatroom;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="sentMessages")
     * @MaxDepth(2)
     * @Groups({"privat_messages"})
     */
    private $sender;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"privat_messages"})
     */
    private $text;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"privat_messages"})
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

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }
    /**
     * @param mixed $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }
}
