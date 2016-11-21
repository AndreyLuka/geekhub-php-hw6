<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Comment;
use AppBundle\Entity\Post;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class BlogController extends Controller
{
    /**
     * @Route("/", name="blog_homepage")
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('AppBundle:blog:index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
        ]);
    }

    /**
     * @Route("/posts/{slug}", name="blog_post")
     * @Method("GET")
     *
     * @param Post $post
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function postShowAction(Post $post)
    {
        return $this->render('AppBundle:blog:post_show.html.twig', ['post' => $post]);
    }

    /**
     * @Route("/comment/{slug}/new", name="comment_new")
     * @Method("POST")
     *
     * @param Request $request
     * @param Post $post
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function commentNewAction(Request $request, Post $post)
    {
        return $this->render('AppBundle:blog:post_show.html.twig', ['post' => $post]);
    }
}
