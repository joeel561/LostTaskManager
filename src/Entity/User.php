<?php

    namespace App\Entity;

    use Doctrine\ORM\Mapping as ORM;
    use Symfony\Component\Serializer\Annotation\MaxDepth;
    use Symfony\Component\Validator\Constraints as Assert;
    use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
    use Symfony\Component\Security\Core\User\UserInterface;
    use Doctrine\Common\Collections\ArrayCollection;
    use Doctrine\Common\Collections\Collection;

    /**
     * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
     * @UniqueEntity(fields="email", message="Email already taken")
     * @UniqueEntity(fields="username", message="Username already taken")
     * 
     */
    class User implements UserInterface, \Serializable

    {

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;



    /**
     * @ORM\Column(type="string", length=255, unique=true)
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    private $email;



    /**

        * @ORM\Column(type="string", length=100, unique=true)

        * @Assert\NotBlank()

        */

    private $username;



    /**

        * @Assert\NotBlank()

        * @Assert\Length(max="4096")

        */

    private $plainPassword;



    /**

        * @ORM\Column(type="string", length=64)

        */

    private $password;

    /**

        * @ORM\Column(name="is_active", type="boolean")

        */

    private $isActive;

    /**
     * @MaxDepth(1)
     * @ORM\OneToMany(targetEntity="App\Entity\Project", mappedBy="owner")
     */

    private $ownedProjects;

    /**
     * @MaxDepth(1)
     * @ORM\OneToMany(targetEntity="App\Entity\PrivateMessage", mappedBy="recipient")
     */

    private $receivedMessages;

    /**
     * @MaxDepth(1)
     * @ORM\OneToMany(targetEntity="App\Entity\PrivateMessage", mappedBy="sender")
     */

    private $sentMessages;


    /**
    * @MaxDepth(1)
     * @ORM\ManyToMany(targetEntity="App\Entity\Project", inversedBy="assignedUsers")
     * @ORM\JoinTable(name="users_projects")
     */

    private $assignedProjects;

    /**
     * @MaxDepth(1)
     * @ORM\OneToMany(targetEntity="App\Entity\Notes", mappedBy="user")
    */
    private $notesList;

    public function __construct()

    {

        $this->isActive = true;
        $this->assignedProjects = new ArrayCollection();

    }



    /**
        * Returns the username used to authenticate the user.

        *

        * @return string The username

    */

    public function getUsername()

    {

        return $this->username;
    }



    /**

        * @param mixed $username

        */

    public function setUsername($username)

    {

        $this->username = $username;
    }

    /**

        * @return mixed

        */

    public function getId()

    {

        return $this->id;
    }

    /**

        * @return mixed $id

        */

    public function setId()

    {

        $this->id = $id;
    }

    /**
    * @return mixed
    */
    public function getOwnedProjects()
    {
        return $this->ownedProjects;
    }

    /**
    * @param mixed $ownedProjects
    */
    public function setOwnedProjects($ownedProject)
    {
        $this->ownedProjects = $ownedProjects;
    }


    /**
    * @return mixed
    */
    public function getReceivedMessages()
    {
        return $this->receivedMessages;
    }

    /**
    * @param mixed $receivedMessages
    */
    public function setReceivedMessages($receivedMessages)
    {
        $this->receivedMessage = $receivedMessages;
    }

    /**
    * @return mixed
    */
    public function getSentMessages()
    {
        return $this->sentMessages;
    }

    /**
    * @param mixed $sentMessages
    */
    public function setSentMessages($sentMessages)
    {
        $this->sentMessage = $sentMessages;
    }

    /**
    * @return mixed
    */
    public function getNotesList()
    {
        return $this->notesList;
    }

    /**
    * @param mixed $notesList
    */
    public function setNotesList($notesList)
    {
        $this->notesList = $notesList;
    }

    /**
    * @return Collection|Project[]
    */
    public function getAssignedProjects(): ?Collection
    {
        return $this->assignedProjects;
    }

    public function addAssignedProject(Project $assignedProject): self
    {
        if (!$this->assignedProjects->contains($assignedProject)) {
            $this->assignedProjects[] = $assignedProject;

        }

        return $this;
    }

    public function removeAssignedProject(Project $assignedProject): self 
    {
        if ($this->assignedProjects->contains($assignedProject)) {
            $this->assignedProjects->removeElement($assignedProject);
        }

        return $this;
    }

    public function setEmail($email)

    {

        $this->email = $email;
    }

    /**
     * @return mixed
     */

    public function getEmail()
    {
        return $this->email;
    }


    /**

     * @return mixed

     */

    public function getisActive()

    {

        return $this->isActive;
    }

    /**

     * @param mixed $isActive

     */

    public function setIsActive($isActive)

    {

        $this->isActive = $isActive;
    }

 
    /**
     * Returns the salt that was originally used to encode the password.
     * This can return null if the password was not encoded using a salt.
     * @return string|null The salt

     */

    public function getSalt()

    {

        return null;
    }



    /**

     * @return mixed

     */

    public function getPlainPassword()

    {

        return $this->plainPassword;
    }



    /**

     * @param mixed $password

     */

    public function setPlainPassword($password)

    {

        $this->plainPassword = $password;
    }

    /**

     * Returns the password used to authenticate the user.

     *

     * @return string The password

     */

    public function getPassword()

    {

        return $this->password;
    }



    /**

     * @param mixed $password

     */

    public function setPassword($password)

    {

        $this->password = $password;
    }

    /**

     * @return array

     */

    public function getRoles()

    {

        return array('ROLE_USER');
    }

    public function eraseCredentials()

    {
    }



    public function serialize()

    {

        return serialize(array(

            $this->id,

            $this->username,

            $this->password,

        ));
    }

    public function unserialize($serialized)

    {

        list(

            $this->id,

            $this->username,

            $this->password,

        ) = unserialize($serialized);
    }
}
