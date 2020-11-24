<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProjectRepository")
 */
class Project
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     * @ORM\Column(type="string", name="name", length=20)
     */
    private $name;
    /**
     * @ORM\Column(type="string", name="description", length=200)
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", mappedBy="owned_projects")
     */
    private $owner;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\User", mappedBy="assigned_projects")
     **/
    private $assigned_user;
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Task", mappedBy="projects")
     */
    private $tasks;
    /**
     * @ORM\Column(type="datetime", name="created_at")
     */
    private $createdAt;
    /**
     * @ORM\Column(type="datetime", name="updated_at")
     */
    private $updatedAt;
    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }
    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }
    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }
    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }
    public function getDescription()
    {
        return $this->description;
    }
    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @param mixed $owner
     */
    public function setOwner(User $newOwner)
    {
        $this->owner = $newOwner;
    }

    /**
     * @param mixed
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * @param mixed $assignedUser
     */
    public function setAssignedUser($users)
    {
        $this->assigned_user = $users;
    }

    /**
     * @param mixed $assignedUsers
     */
    public function getAssignedUser()
    {
        return $this->assigned_user;
    }

    /**
     * @return mixed
     */
    public function getTasks()
    {
        return $this->tasks;
    }

    /**
     * @param mixed $tasks
     */
    public function setTasks($tasks)
    {
        $this->tasks = $tasks;
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
    /**
     * @return mixed
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }
    /**
     * @param mixed $updatedAt
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }
    public function __toString()
    {
        // TODO: Implement __toString() method.
        return $this->name;
    }

    public function __construct() {
        $this->user = new \Doctrine\Common\Collections\ArrayCollection();
    }
}
