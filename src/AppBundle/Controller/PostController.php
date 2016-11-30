<?php

namespace AppBundle\Controller;

use AppBundle\Entity\PostEntity;
use AppBundle\Repository\PostRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class PostController extends Controller
{
    /**
     * @var PostRepository
     */
    private $repository;

    /**
     * @Route("/posts", name="post_index")
     * @Method("GET")
     *
     * @return JsonResponse
     */
    public function indexAction()
    {
        $this->repository = new PostRepository();

        $postsData = $this->repository->findAll();

        return new JsonResponse($postsData);
    }

    /**
     * @Route("/posts", name="post_new")
     * @Method("POST")
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function newAction(Request $request)
    {
        $this->repository = new PostRepository();

        $request->initialize(
            array(),
            array(),
            array(),
            array(),
            array(),
            array(),
            '{"title": "post-title-NEW", "content": "post-content-NEW"}'
        );

        $newPostData = json_decode($request->getContent(), true);

        $request->request->replace($newPostData);

        $post = new PostEntity();
        $post->setTitle($request->request->get('title'));
        $post->setContent($request->request->get('content'));

        $this->repository->insert($post);

        return $this->redirectToRoute('post_index');
    }

    /**
     * @Route("/posts/{id}", requirements={"id": "\d+"}, name="post_show")
     * @Method("GET")
     *
     * @param int $id
     *
     * @return JsonResponse
     */
    public function showAction($id)
    {
        $this->repository = new PostRepository();

        $postData = $this->repository->find($id);

        if (!empty($postData)) {
            return new JsonResponse($postData);
        } else {
            return new JsonResponse(['Error404:' => 'Not Found'], 404);
        }
    }

    /**
     * @Route("/posts/{id}", requirements={"id": "\d+"}, name="post_edit")
     * @Method({"PUT", "PATCH"})
     *
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
    public function editAction(Request $request, $id)
    {
        $this->repository = new PostRepository();

        $request->initialize(
            array(),
            array(),
            array(),
            array(),
            array(),
            array(),
            '{"title": "post-title-EDITED", "content": "post-content-EDITED"}'
        );

        $editedPostData = json_decode($request->getContent(), true);

        $request->request->replace($editedPostData);

        $post = new PostEntity();
        $post->setId($id);
        $post->setTitle($request->request->get('title'));
        $post->setContent($request->request->get('content'));

        return new JsonResponse($this->repository->update($post));
    }

    /**
     * @Route("/posts/{id}", requirements={"id": "\d+"}, name="post_delete")
     * @Method("DELETE")
     *
     * @param int $id
     *
     * @return JsonResponse
     */
    public function deleteAction($id)
    {
        $this->repository = new PostRepository();

        $this->repository->remove($id);

        return new JsonResponse(null, 204);
    }
}
