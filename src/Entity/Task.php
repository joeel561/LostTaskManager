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
     * @ORM\Column(type="text")
     */
    private $name;
    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $tag;
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
     * @return mixed
     */
    public function getTag()
    {
        return $this->tag;
    }
    /**
     * @param mixed $tag
     */
    public function setTag($tag)
    {
        $this->tag = $tag;
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
