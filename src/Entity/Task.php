<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TaskRepository")
 */
class Task
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     * @ORM\Column(type="string", name="name", length=100)
     */
    private $name;
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Project", inversedBy="allLocatedTasks")
     */
    private $project;

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
    /**
     * @param mixed $project
     */
    public function setProject(Project $newProject)
    {
        $this->project = $newProject;
    }

    /**
     * @param mixed
     */
    public function getProject()
    {
        return $this->project;
    }
}
