<?php

namespace GergelyPolonkai\FrontBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as GedmoORM;

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
    public function setUser(\GergelyPolonkai\FrontBundle\Entity\User $user)
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
}
