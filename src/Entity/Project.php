<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

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
     * @ORM\Column(type="text")
     */
    private $name;
    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="ownedProjects")
     */
    private $owner;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\User", mappedBy="assignedProjects")
    **/
    private $assignedUsers;

    /**
     * @ORM\Column(type="datetime", name="created_at")
     */
    private $createdAt;
    /**
     * @ORM\Column(type="datetime", name="date")
     */
    private $date;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Task", mappedBy="project")
    */
    private $allLocatedTasks;

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
    public function getDate()
    {
        return $this->date;
    }
    /**
     * @param mixed $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }
    public function __toString()
    {
        // TODO: Implement __toString() method.
        return $this->name;
    }

    public function __construct() {
        $this->assignedUsers = new ArrayCollection();
    }

    /**
     * @return Collection|User[]
     */
    public function getAssignedUsers(): ?Collection
    {
       return $this->assignedUsers;
    }


    public function addAssignedUser(User $assignedUser): self 
    {
        if (!$this->assignedUsers->contains($assignedUser)) {
            $this->assignedUsers[] = $assignedUser;
            $assignedUser->addAssignedProject($this);
        }

        return $this;
    }

    public function removeAssignedUser(User $assignedUser): self 
    {
        if ($this->assignedUsers->contains($assignedUser)) {
            $this->assignedUsers->removeElement($assignedUser);
            $assignedUser->removeAssignedProject($this);
        }

        return $this;
    }

    /**
    * @return mixed
    */
    public function getAllLocatedTasks()
    {
        return $this->allLocatedTasks;
    }

    /**
    * @param mixed $allLocatedTasks
    */
    public function setAllLocatedTasks($allLocatedTasks)
    {
        $this->allLocatedTasks = $allLocatedTasks;
    }
}
