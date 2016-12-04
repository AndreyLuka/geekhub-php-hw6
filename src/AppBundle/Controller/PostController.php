<?php

namespace AppBundle\Controller;

use AppBundle\Entity\PostEntity;
use AppBundle\Repository\PostRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class PostController.
 */
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
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|JsonResponse
     */
    public function newAction(Request $request)
    {
        $this->repository = new PostRepository();

        $newPostData = json_decode($request->getContent(), true);

        $request->request->replace($newPostData);

        if (empty($newPostData['title'])) {
            return new JsonResponse('Error: Title is empty.');
        }

        $post = new PostEntity();
        $post->setTitle($newPostData['title']);
        $post->setContent($newPostData['content']);

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
     * @param int     $id
     *
     * @return JsonResponse
     */
    public function editAction(Request $request, $id)
    {
        $this->repository = new PostRepository();

        $editedPostData = json_decode($request->getContent(), true);

        $request->request->replace($editedPostData);

        if (empty($editedPostData['title'])) {
            return new JsonResponse('Error: Title is empty.');
        }

        $post = new PostEntity();
        $post->setId($id);
        $post->setTitle($editedPostData['title']);
        $post->setContent($editedPostData['content']);

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
