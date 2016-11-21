<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Post;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/admin")
 */
class AdminBlogController extends Controller
{
    /**
     * @Route("/", name="admin_index")
     * @Route("/", name="admin_post_index")
     * @Method("GET")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        return $this->render('AppBundle:admin:blog:index.html.twig', ['posts' => $posts]);
    }

    /**
     * @Route("/post/new", name="admin_post_new")
     * @Method({"GET", "POST"})
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function postNewAction(Request $request)
    {
        $post = new Post();

        return $this->render('AppBundle:admin:blog:post_new.html.twig', ['post' => $post]);
    }

    /**
     * @Route("/post/{id}", requirements={"id": "\d+"}, name="admin_post_show")
     * @Method("GET")
     *
     * @param Post $post
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function postShowAction(Post $post)
    {
        return $this->render('AppBundle:admin:blog:post_show.html.twig', ['post' => $post]);
    }

    /**
     * @Route("/post/{id}/edit", requirements={"id": "\d+"}, name="admin_post_edit")
     * @Method({"GET", "POST"})
     *
     * @param Post $post
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function postEditAction(Post $post, Request $request)
    {
        return $this->render('AppBundle:admin:blog:post_edit.html.twig', ['post' => $post]);
    }

    /**
     * @Route("/post/{id}", name="admin_post_delete")
     * @Method("DELETE")
     * 
     * @param Request $request
     * @param Post $post
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(Request $request, Post $post)
    {
        return $this->redirectToRoute('admin_post_index');
    }
}
