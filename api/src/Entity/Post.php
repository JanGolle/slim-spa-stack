<?php
declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="post")
 */
class Post
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @var int
     */
    private $id;

    /**
     * @ORM\Column(type="string", unique=true, length=128)
     *
     * @var string
     */
    private $title;

    /**
     * @ORM\Column(type="datetime_immutable")
     *
     * @var \DateTimeImmutable
     */
    private $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity="User", fetch="LAZY")
     *
     * @var User
     */
    private $author;

    /**
     * @return int|null
     */
    public function getId() : ?int
    {
        return $this->id;
    }

    /**
     * @param int $id
     *
     * @return Post
     */
    public function setId(int $id) : Post
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getTitle() : string
    {
        return $this->title;
    }

    /**
     * @param string $title
     *
     * @return Post
     */
    public function setTitle(string $title) : Post
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getCreatedAt() : \DateTimeImmutable
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTimeImmutable $createdAt
     *
     * @return Post
     */
    public function setCreatedAt(\DateTimeImmutable $createdAt) : Post
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return User
     */
    public function getAuthor() : User
    {
        return $this->author;
    }

    /**
     * @param User $author
     *
     * @return Post
     */
    public function setAuthor(User $author) : Post
    {
        $this->author = $author;

        return $this;
    }

    /**
     * @ORM\PrePersist
     */
    public function prePersist()
    {
        $this->createdAt = new \DateTimeImmutable();
    }
}
