<?php

namespace GergelyPolonkai\FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * @Route("/")
 */
class DefaultController extends Controller
{
    /**
     * @Route("/", name="GergelyPolonkaiFrontBundle_homepage")
     * @Template
     */
    public function indexAction()
    {
        $query = $this->getDoctrine()->getEntityManager()->createQuery("SELECT p FROM GergelyPolonkaiFrontBundle:Post p ORDER BY p.createdAt DESC");
        $query->setMaxResults(4);
        $posts = $query->getResult();

        return array(
            'posts' => $posts,
        );
    }

    /**
     * @Route("/disclaimer.html", name="GergelyPolonkaiFrontBundle_disclaimer")
     * @Template
     */
    public function disclaimerAction()
    {
        return array();
    }

    /**
     * @param string $_format
     *
     * @Route("/resume.{_format}", name="GergelyPolonkaiFrontBundle_resume")
     * @Template
     */
    public function resumeAction($_format)
    {
        if ($_format === 'pdf') {
            return $this
                ->get('io_tcpdf')
                ->quick_pdf(
                        $this->renderView(
                                'GergelyPolonkaiFrontBundle:Default:resume.html.twig',
                                array(
                                    'format' => $_format
                                )
                        )
                );
        } else {
            return array(
                'format' => $_format,
            );
        }
    }
}
