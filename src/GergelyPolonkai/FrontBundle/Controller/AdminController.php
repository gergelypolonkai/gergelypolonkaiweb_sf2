<?php
namespace GergelyPolonkai\FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Security\Core\SecurityContext;

use GergelyPolonkai\FrontBundle\Form\PostType;
use GergelyPolonkai\FrontBundle\Form\CodeChunkType;
use GergelyPolonkai\FrontBundle\Entity\Post;
use GergelyPolonkai\FrontBundle\Entity\CodeChunk;

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
     * @Route("/blog/post/{id}", name="GergelyPolonkaiFrontBundle_adminEditBlogPost", defaults={"id": null})
     * @Template
     */
    public function editBlogPostAction($id = null)
    {
        if (is_numeric($id)) {
            $post = $this->getDoctrine()->getRepository('GergelyPolonkaiFrontBundle:Post')->findOneById($id);
            if ($post === null) {
                throw $this->createNotFoundException();
            }
        } else {
            $post = new Post();
            $post->setDraft(true);
        }
        $form = $this->createForm(new PostType(), $post);
        $request = $this->getRequest();
        $user = $this->get('security.context')->getToken()->getUser();

        if ($request->getMethod() === 'POST') {
            $form->bind($request);
            if ($form->isValid()) {
                $tagManager = $this->get('fpn_tag.tag_manager');
                if (($tags = $form->get('tags')->getData()) != '') {
                    $tagNames = $tagManager->splitTagNames($tags);
                    $tagList = $tagManager->loadOrCreateTags($tagNames);
                    $tagManager->addTags($tagList, $post);
                }
                if ($form->get('updateDate')->getData() == 1) {
                    $post->setCreatedAt(new \DateTime('now'));
                }
                $post->setUser($user);
                $em = $this->getDoctrine()->getEntityManager();
                $em->persist($post);
                $em->flush();
                $tagManager->saveTagging($post);

                return $this->redirect($this->generateUrl('GergelyPolonkaiFrontBundle_adminBlogList'));
            }
        }
        $tagManager = $this->get('fpn_tag.tag_manager');
        $tagManager->loadTagging($post);

        return array(
            'form' => $form->createView(),
            'post' => $post,
        );
    }

    /**
     * @Route("/blog/", name="GergelyPolonkaiFrontBundle_adminBlogList")
     * @Template
     */
    public function listBlogAction()
    {
        $postRepo = $this->getDoctrine()->getRepository('GergelyPolonkaiFrontBundle:Post');

        $posts = $postRepo->findBy(array(), array('createdAt' => 'DESC'));

        return array(
            'posts' => $posts,
        );
    }

    /**
     * @Route("/code-chunk/", name="GergelyPolonkaiFrontBundle_adminListChunk")
     * @Template
     */
    public function listCodeChunkAction()
    {
        $chunkRepo = $this->getDoctrine()->getRepository('GergelyPolonkaiFrontBundle:CodeChunk');
        $chunks = $chunkRepo->findBy(array(), array('title' => 'ASC'));

        return array(
            'chunks' => $chunks,
        );
    }

    /**
     * @Route("/code-chunk/edit/{id}", name="GergelyPolonkaiFrontBundle_adminEditChunk", defaults={"id": null})
     * @Template
     */
    public function editChunkAction($id)
    {
        if (is_numeric($id)) {
            $chunk = $this->getDoctrine()->getRepository('GergelyPolonkaiFrontBundle:CodeChunk')->findOneById($id);
            if ($chunk === null) {
                throw $this->createNotFoundException();
            }
        } else {
            $chunk = new CodeChunk();
        }

        $form = $this->createForm(new CodeChunkType(), $chunk);
        $request = $this->getRequest();
        $user = $this->get('security.context')->getToken()->getUser();

        if ($request->getMethod() === 'POST') {
            $form->bind($request);
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getEntityManager();
                $em->persist($chunk);
                $em->flush();

                return $this->redirect($this->generateUrl('GergelyPolonkaiFrontBundle_adminListChunk'));
            }
        }

        return array(
            'form'  => $form->createView(),
            'chunk' => $chunk,
        );
    }

    /**
     * @Route("/")
     * @Template
     */
    public function indexAction()
    {
        return array();
    }
}
