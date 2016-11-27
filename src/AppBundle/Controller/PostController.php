<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

class PostController extends Controller
{
    /**
     * @Route("/", name="post_index")
     * @Method("GET")
     *
     * @return JsonResponse
     */
    public function indexAction()
    {
        $dbPath = $this->get('kernel')->getBundle('AppBundle')->getPath().'/Database/posts.json';
        $dbContent = file_get_contents($dbPath);
        $db = json_decode($dbContent, true);

        return new JsonResponse($db);
    }

    /**
     * @Route("/post/new", name="post_new")
     * @Method("POST")
     *
     * @return JsonResponse
     */
    public function newAction()
    {
        $dbPath = $this->get('kernel')->getBundle('AppBundle')->getPath().'/Database/posts.json';
        $dbContent = file_get_contents($dbPath);
        $db = json_decode($dbContent, true);

        end($db['posts']);
        $lastId = key($db['posts']);

        $newPostData = [
            'id' => $lastId + 1,
            'title' => 'post-title-'.($lastId + 1),
            'content' => 'post-title-'.($lastId + 1),
        ];

        array_push($db['posts'], $newPostData);
        file_put_contents($dbPath, json_encode($db));

        return new JsonResponse($db);
    }

    /**
     * @Route("/post/{id}", requirements={"id": "\d+"}, name="post_show")
     * @Method("GET")
     *
     * @param int $id
     *
     * @return JsonResponse
     */
    public function showAction($id)
    {
        $dbPath = $this->get('kernel')->getBundle('AppBundle')->getPath().'/Database/posts.json';
        $dbContent = file_get_contents($dbPath);
        $db = json_decode($dbContent, true);

        if (isset($db['posts'][$id])) {
            return new JsonResponse($db['posts'][$id]);
        } else {
            return new JsonResponse(['Error404:' => 'Not Found'], 404);
        }
    }

    /**
     * @Route("/post/{id}/edit", requirements={"id": "\d+"}, name="post_edit")
     * @Method({"PUT", "PATCH"})
     *
     * @param int $id
     *
     * @return JsonResponse
     */
    public function editAction($id)
    {
        $dbPath = $this->get('kernel')->getBundle('AppBundle')->getPath().'/Database/posts.json';
        $dbContent = file_get_contents($dbPath);
        $db = json_decode($dbContent, true);

        if (isset($db['posts'][$id])) {
            $editedPostData = [
                'id' => $id,
                'title' => '(edited)-post-title-'.($id),
                'content' => '(edited)-post-content-'.($id),
            ];

            $db['posts'][$id] = $editedPostData;

            file_put_contents($dbPath, json_encode($db));

            return new JsonResponse($db['posts'][$id]);
        } else {
            return new JsonResponse(['Error404:' => 'Not Found'], 404);
        }
    }

    /**
     * @Route("/post/{id}/delete", requirements={"id": "\d+"}, name="post_delete")
     * @Method("DELETE")
     *
     * @param int $id
     *
     * @return JsonResponse
     */
    public function deleteAction($id)
    {
        $dbPath = $this->get('kernel')->getBundle('AppBundle')->getPath().'/Database/posts.json';
        $dbContent = file_get_contents($dbPath);
        $db = json_decode($dbContent, true);

        if (isset($db['posts'][$id])) {
            unset($db['posts'][$id]);

            file_put_contents($dbPath, json_encode($db));

            return new JsonResponse($db);
        } else {
            return new JsonResponse(['Error404:' => 'Not Found'], 404);
        }
    }
}
