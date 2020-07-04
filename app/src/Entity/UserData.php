<?php
/**
 * UserData entity.
 */
namespace App\Entity;


use Doctrine\ORM\Mapping as ORM;
use DateTimeInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class UserData.
 *
 * @ORM\Entity(repositoryClass="App\Repository\UserDataRepository")
 * @ORM\Table(name="userdata")
 */
class UserData
{
    /**
     * Primary key.
     *
     * @var int
     *
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * Updated at.
     *
     * @var DateTimeInterface
     *
     * @ORM\Column(type="datetime")
     *
     * @Assert\DateTime
     *
     *
     */
    private $updatedAt;

    /**
     * Firstname.
     *
     * @ORM\Column(
     *     type="string",
     *     length=50
     *     )
     *
     * @Assert\NotBlank
     * @Assert\Type(type="string")
     * @Assert\Length(
     *     min="3",
     *     max="50"
     * )
     */
    private $firstname;

    /**
     * Lastname.
     *
     * @ORM\Column(
     *     type="string",
     *     length=50
     *     )
     *
     * @Assert\NotBlank
     * @Assert\Type(type="string")
     * @Assert\Length(
     *     min="3",
     *     max="50"
     * )
     */
    private $lastname;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\User", mappedBy="userdata", cascade={"persist", "remove"})
     */
    private $user;


    /**
     * Getter for Id.
     *
     * @return int|null Result.
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Getter for Updated at.
     *
     * @return DateTimeInterface|null Updated at
     */
    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    /**
     * Setter for Updated at.
     *
     * @param DateTimeInterface $updatedAt Updated at.
     *
     */
    public function setUpdatedAt(\DateTimeInterface $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * Getter for Firstname.
     *
     * @return string|null Result
     */
    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    /**
     * Setter for Firstname.
     *
     * @param string $firstname Firstname
     */
    public function setFirstname(string $firstname): void
    {
        $this->firstname = $firstname;
    }

    /**
     * Getter for Lastname.
     *
     * @return string|null Result
     */
    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    /**
     * Setter for Lastname.
     *
     * @param string $lastname Lastname
     */
    public function setLastname(string $lastname): void
    {
        $this->lastname = $lastname;
    }

    /**
     * Getter for the User.
     *
     * @return User|null
     */
    public function getUser(): ?User
    {
        return $this->user;
    }

    /**
     * Setter for the User.
     *
     * @param User|null $user
     */
    public function setUser(?User $user): void
    {
        $this->user = $user;
    }


}