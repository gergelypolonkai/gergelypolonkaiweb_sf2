<?php
namespace GergelyPolonkai\FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Security\Core\SecurityContext;

use GergelyPolonkai\FrontBundle\Form\PostType;
use GergelyPolonkai\FrontBundle\Entity\Post;

/**
 * Description of AdminController
 *
 * @author polonkai.gergely
 * 
 * @Route("/admin")
 */
class AdminController extends Controller
{
    /**
     * @return array
     *
     * @Route("/login.html")
     * @Template
     */
    public function loginAction()
    {
        $request = $this->getRequest();
        $session = $request->getSession();

        if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
        } else {
            $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
            $session->remove(SecurityContext::AUTHENTICATION_ERROR);
        }

        return array(
            'last_username' => $session->get(SecurityContext::LAST_USERNAME),
            'error'         => $error,
        );
    }

    /**
     * @Route("/login-check.do", name="GergelyPolonkaiFrontBundle_adminLoginCheck")
     */
    public function loginCheckAction()
    {
    }

    /**
     * @Route("/blog/post", name="GergelyPolonkaiFrontBundle_adminNewBlogPost")
     * @Template
     */
    public function newBlogPostAction()
    {
        $post = new Post();
        $form = $this->createForm(new PostType(), $post);
        $request = $this->getRequest();
        $user = $this->get('security.context')->getToken()->getUser();

        if ($request->getMethod() === 'POST') {
            $form->bind($request);
            if ($form->isValid()) {
                $post->setUser($user);
                $em = $this->getDoctrine()->getEntityManager();
                $em->persist($post);
                $em->flush();

                return $this->redirect($this->generateUrl('GergelyPolonkaiFrontBundle_adminNewBlogPost'));
            }
        }

        return array(
            'form' => $form->createView(),
        );
    }
}
