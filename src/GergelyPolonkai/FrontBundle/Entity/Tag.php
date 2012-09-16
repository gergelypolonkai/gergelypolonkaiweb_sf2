<?php
namespace GergelyPolonkai\FrontBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FPN\TagBundle\Entity\Tag as BaseTag;

/**
 * Description of Tag
 *
 * @author polesz
 *
 * @ORM\Entity
 * @ORM\Table(name="tags")
 */
class Tag extends BaseTag
{
    /**
     *
     * @var integer $id
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     *
     * @var Doctrine\Common\Collections\ArrayCollection $tagging
     *
     * @ORM\OneToMany(targetEntity="Tagging", mappedBy="tag", fetch="EAGER")
     */
    protected $tagging;
}
