<?php
namespace GergelyPolonkai\FrontBundle\Entity;

use FPN\TagBundle\Entity\Tagging as BaseTagging;
use Doctrine\ORM\Mapping as ORM;

/**
 * Description of Tagging
 *
 * @author polesz
 *
 * @ORM\Entity
 * @ORM\Table(name="tagging", uniqueConstraints={
 *     @ORM\UniqueConstraint(name="tagging_idx", columns={"tag_id", "resource_type", "resource_id"})
 * })
 */
class Tagging extends BaseTagging
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
     * @var GergelyPolonkai\FrontBundle\Entity\Tag $tag
     *
     * @ORM\ManyToOne(targetEntity="Tag")
     */
    protected $tag;
}