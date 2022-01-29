<?php

namespace App\Entity;

use App\Repository\MessageRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\MaxDepth;

/**
 * @ORM\Entity(repositoryClass=MessageRepository::class)
 */
class Message
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"chatroom_user"})
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"chatroom_user"})
     * 
     */
    private $messageId;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Project", inversedBy="projectMessages")
     */
    private $projectRecipient;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"chatroom_user"})
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
    public function getMessageId(): ?int
    {
        return $this->messageId;
    }

    public function setMessageId(int $messageId): self
    {
        $this->messageId = $messageId;

        return $this;
    }

    public function getProjectRecipient(): ?int
    {
        return $this->projectRecipient;
    }

    public function setProjectRecipient(User $newProjectRecipient)
    {
        $this->projectRecipient = $newProjectRecipient;

        return $this;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(?string $text): self
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
