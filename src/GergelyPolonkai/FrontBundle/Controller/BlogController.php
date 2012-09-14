<?php
namespace GergelyPolonkai\FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use GergelyPolonkai\FrontBundle\Entity\Post;

/**
 * Description of BlogController
 *
 * @author polonkai.gergely
 *
 * @Route("/blog")
 */
class BlogController extends Controller
{
    /**
     * @Route("/{year}/{month}/{day}/{slug}.html", name="GergelyPolonkaiFront_blogViewPost")
     * @Template
     */
    public function viewPostAction($year, $month, $day, $slug)
    {
        $date = new \DateTime();
        $date->setDate($year, $month, $day);
        $date->setTime(0, 0, 0);
        $date2 = new \DateTime();
        $date2->setDate($year, $month, $day);
        $date2->setTime(0, 0, 0);
        $date2->add(new \DateInterval('P1D'));

        $query = $this->getDoctrine()->getEntityManager()->createQuery("SELECT p FROM GergelyPolonkaiFrontBundle:Post p WHERE p.slug = :slug AND p.createdAt BETWEEN :date1 AND :date2");
        $query->setParameter(':slug', $slug);
        $query->setParameter(':date1', $date);
        $query->setParameter(':date2', $date2);
        $post = $query->getOneOrNullResult();

        return array(
            'post' => $post,
        );
    }
}
