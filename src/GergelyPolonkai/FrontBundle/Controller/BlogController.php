<?php
namespace GergelyPolonkai\FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Doctrine\ORM\Tools\Pagination\Paginator;

use GergelyPolonkai\FrontBundle\Entity\Post;
use GergelyPolonkai\FrontBundle\Entity\Tag;

/**
 * Description of BlogController
 *
 * @author polonkai.gergely
 *
 * @Route("/blog")
 */
class BlogController extends Controller
{
    // TODO: Make this a config parameter
    private $postsPerPage = 10;

    /**
     * @Route("/", name="GergelyPolonkaiFrontBundle_blogListing")
     * @Route("/page/{cPage}", name="GergelyPolonkaiFrontBundle_blogListingPage", requirements={"cPage": "\d+"})
     * @Template
     */
    public function listAction($cPage = 1)
    {
        --$cPage;

        $query = $this
                ->getDoctrine()
                ->getEntityManager()
                ->createQuery("SELECT p FROM GergelyPolonkaiFrontBundle:Post p WHERE p.draft = FALSE ORDER BY p.createdAt DESC")
                ->setFirstResult($cPage * $this->postsPerPage)
                ->setMaxResults($this->postsPerPage);

        $paginator = new Paginator($query, $fetchJoinCollection = true);
        $tagManager = $this->get('fpn_tag.tag_manager');
        foreach ($paginator as $post) {
            $tagManager->loadTagging($post);
        }

        $count = $paginator->count();
        $pageCount = ceil($count / $this->postsPerPage);

        return array(
            'cpage'   => $cPage,
            'count'   => $pageCount,
            'posts'   => $paginator,
            'perPage' => $this->postsPerPage,
        );
    }

    /**
     * @Route("/{year}/{month}/{day}/{slug}.html", name="GergelyPolonkaiFrontBundle_blogViewPost")
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
        $this->get('fpn_tag.tag_manager')->loadTagging($post);

        return array(
            'post' => $post,
        );
    }

    /**
     * @Route("/feed", name="GergelyPolonkaiFrontBundle_blogFeed", defaults={"_format": "xml"})
     * @Template
     */
    public function feedAction()
    {
        $query = $this->getDoctrine()->getEntityManager()->createQuery("SELECT p FROM GergelyPolonkaiFrontBundle:Post p WHERE p.draft = FALSE ORDER BY p.createdAt DESC");
        $query->setMaxResults(10);
        $posts = $query->getResult();

        return array(
            'now'   => new \DateTime('now'),
            'posts' => $posts,
        );
    }

    /**
     * @Route("/tag/{name}/", name="GergelyPolonkaiFrontBundle_blogTagList")
     * @Route("/tag/{name}/page/{cPage}", name="GergelyPolonkaiFrontBundle_blogListingPage", requirements={"cPage": "\d+"})
     * @Template("GergelyPolonkaiFrontBundle:Blog:list.html.twig")
     * @ParamConverter("tag")
     */
    public function tagListAction(Tag $tag, $cPage = 1)
    {
        $tagRepository = $this->getDoctrine()->getRepository('GergelyPolonkaiFrontBundle:Tag');

        $ids = $tagRepository->getResourceIdsForTag('gergelypolonkaifront_post', $tag->getName());

        --$cPage;

        $query = $this
                    ->getDoctrine()
                    ->getEntityManager()
                    ->createQuery("SELECT p FROM GergelyPolonkaiFrontBundle:Post p WHERE p.draft = FALSE AND p.id IN (:idList) ORDER BY p.createdAt DESC")
                    ->setParameter('idList', $ids)
                    ->setFirstResult($cPage * $this->postsPerPage)
                    ->setMaxResults($this->postsPerPage);

        $paginator = new Paginator($query, $fetchJoinCollection = true);
        $tagManager = $this->get('fpn_tag.tag_manager');
        foreach ($paginator as $post) {
            $tagManager->loadTagging($post);
        }

        $count = $paginator->count();
        $pageCount = ceil($count / $this->postsPerPage);

        return array(
            'cpage'   => $cPage,
            'count'   => $pageCount,
            'posts'   => $paginator,
            'perPage' => $this->postsPerPage,
        );
    }
}
