<?php
/**
 * Class Comment.
 */

namespace App\Entity;

use App\Repository\CommentRepository;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Comment.
 *
 * @ORM\Entity(repositoryClass=CommentRepository::class)
 * @ORM\Table(name="comments")
 */
class Comment
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * Content.
     *
     * @var string
     *
     * @ORM\Column(
     *     type="string",
     *     length=255
     * )
     *
     * @Assert\Type(type="string")
     * @Assert\NotBlank
     * @Assert\Length(
     *     min="3",
     *     max="255",
     * )
     */
    private $content;

    /**
     * Created At.
     *
     * @var DateTimeInterface
     *
     * @ORM\Column(type="datetime")
     *
     * @Assert\Type(type="\DateTimeInterface")
     *
     * @Gedmo\Timestampable(on="create")
     */
    private $createdAt;

    /**
     * Task.
     *
     * @ORM\ManyToOne(
     *     targetEntity=Task::class,
     *     inversedBy="comments"
     * )
     * @ORM\JoinColumn(nullable=false)
     *
     * @Assert\Type(type="App\Entity\Task")
     */
    private $task;

    /**
     * Getter for Id.
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Getter for Content.
     */
    public function getContent(): ?string
    {
        return $this->content;
    }

    /**
     * Setter for Content.
     *
     * @return $this
     */
    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    /**
     * Getter for CreatedAt.
     */
    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    /**
     * Setter for CreatedAt.
     */
    public function setCreatedAt(\DateTimeInterface $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * Getter for Task.
     */
    public function getTask(): ?Task
    {
        return $this->task;
    }

    /**
     * Setter for Task.
     *
     * @return $this
     */
    public function setTask(?Task $task): void
    {
        $this->task = $task;
    }
}
