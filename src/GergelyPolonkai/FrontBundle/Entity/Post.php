<?php

namespace GergelyPolonkai\FrontBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as GedmoORM;
use Symfony\Component\Validator\Constraints as Assert;

use Doctrine\Common\Collections\ArrayCollection;

use GergelyPolonkai\FrontBundle\Entity\Comment;
use GergelyPolonkai\FrontBundle\Entity\User;

/**
 * Description of Post
 *
 * @author polonkai.gergely
 *
 * @ORM\Entity
 * @ORM\Table(name="blog_posts")
 */
class Post
{
    /**
     * @var integer $id
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var GergelyPolonkai\FrontBundle\Entity\User $user
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @var string $title
     *
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank()
     */
    private $title;

    /**
     * @var string $slug
     *
     * @GedmoORM\Slug(fields={"title"})
     * @ORM\Column(type="string", length=100)
     */
    private $slug;

    /**
     * @var string $content
     *
     * @ORM\Column(type="text", nullable=false)
     * @Assert\NotBlank()
     */
    private $content;

    /**
     * @var DateTime $createdAt
     *
     * @GedmoORM\Timestampable(on="create")
     * @ORM\Column(type="datetime", nullable=false, name="created_at")
     */
    private $createdAt;

    /**
     *
     * @var boolean $draft
     *
     * @ORM\Column(type="boolean")
     */
    private $draft;

    /**
     *
     * @var Doctrine\Common\Collections\ArrayCollection $comments
     *
     * @ORM\OneToMany(targetEntity="Comment", mappedBy="post", fetch="LAZY")
     */
    private $comments;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->comments = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param  string $title
     * @return Post
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set user
     *
     * @param  GergelyPolonkai\FrontBundle\Entity\User $user
     * @return Post
     */
    public function setUser(User $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return GergelyPolonkai\FrontBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set content
     *
     * @param  string $content
     * @return Post
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set slug
     *
     * @param  string $slug
     * @return Post
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Set createdAt
     *
     * @param  \DateTime $createdAt
     * @return Post
     */
    public function setCreatedAt(\DateTime $createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Set draft
     *
     * @param  boolean $draft
     * @return Post
     */
    public function setDraft($draft)
    {
        $this->draft = $draft;

        return $this;
    }

    /**
     * Get draft
     *
     * @return boolean
     */
    public function getDraft()
    {
        return $this->draft;
    }
    /**
     * Add comments
     *
     * @param  GergelyPolonkai\FrontBundle\Entity\Comment $comments
     * @return Post
     */
    public function addComment(Comment $comments)
    {
        $this->comments[] = $comments;

        return $this;
    }

    /**
     * Remove comments
     *
     * @param GergelyPolonkai\FrontBundle\Entity\Comment $comments
     */
    public function removeComment(Comment $comments)
    {
        $this->comments->removeElement($comments);
    }

    /**
     * Get comments
     *
     * @return Doctrine\Common\Collections\Collection
     */
    public function getComments()
    {
        return $this->comments;
    }
}
