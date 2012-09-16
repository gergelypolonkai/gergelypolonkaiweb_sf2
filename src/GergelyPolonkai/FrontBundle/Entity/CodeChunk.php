<?php
namespace GergelyPolonkai\FrontBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as GedmoORM;

/**
 * Description of CodeChunk
 *
 * @author polonkai.gergely
 *
 * @ORM\Entity
 * @ORM\Table(name="code_chunks")
 */
class CodeChunk
{
    /**
     *
     * @var integer $id
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     *
     * @var string $language
     *
     * @ORM\Column(type="string", length=20, nullable=false)
     */
    private $language;

    /**
     *
     * @var string $title
     *
     * @ORM\Column(type="string", length=100, nullable=false)
     */
    private $title;

    /**
     *
     * @var string $slug
     *
     * @GedmoORM\Slug(fields={"title"})
     * @ORM\Column(type="string", length=100, nullable=false)
     */
    private $slug;

    /**
     *
     * @var string $description
     *
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     *
     * @var string $content
     *
     * @ORM\Column(type="text", nullable=false)
     */
    private $content;

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
     * Set language
     *
     * @param  string    $language
     * @return CodeChunk
     */
    public function setLanguage($language)
    {
        $this->language = $language;

        return $this;
    }

    /**
     * Get language
     *
     * @return string
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * Set title
     *
     * @param  string    $title
     * @return CodeChunk
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
     * Set slug
     *
     * @param  string    $slug
     * @return CodeChunk
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
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
     * Set description
     *
     * @param  string    $description
     * @return CodeChunk
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set content
     *
     * @param  string    $content
     * @return CodeChunk
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
}