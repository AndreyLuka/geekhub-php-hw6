<?php

namespace AppBundle\Repository;

use AppBundle\Entity\PostEntity;

class PostRepository implements RepositoryInterface
{
    /**
     * @var Connector
     */
    private $connector;

    /**
     * @var mixed
     */
    private $db;

    /**
     * @var PostEntity
     */
    private $post;

    /**
     * PostRepository constructor.
     */
    public function __construct()
    {
        $this->connector = new Connector();

        $this->db = $this->connector->getDb();

        $this->post = new PostEntity();
    }

    /**
     * @return mixed
     */
    public function findAll()
    {
        return $this->db;
    }

    /**
     * @param $postData
     */
    public function insert($postData)
    {
        $this->post = $postData;

        $id = $this->db['posts'][count($this->db['posts']) - 1]['id'] + 1;

        $this->post->setId($id);

        $newPostData = [
            'id' => $this->post->getId(),
            'title' => $this->post->getTitle(),
            'content' => $this->post->getContent(),
        ];

        array_push($this->db['posts'], $newPostData);
        file_put_contents($this->connector->getDbFilePath(), json_encode($this->db));
    }

    /**
     * @param $id
     * @return bool
     */
    public function find($id)
    {
        $i = 0;

        foreach ($this->db['posts'] as $post) {
            if ($post['id'] == $id) {
                return $this->db['posts'][$i];
            }

            ++$i;
        }

        return false;
    }

    /**
     * @param $postData
     * @return bool
     */
    public function update($postData)
    {
        $this->post = $postData;

        $i = 0;

        foreach ($this->db['posts'] as $post) {
            if ($post['id'] == $this->post->getId()) {
                $editedPostData = [
                    'id' => $this->post->getId(),
                    'title' => $this->post->getTitle(),
                    'content' => $this->post->getContent(),
                ];

                $this->db['posts'][$i] = $editedPostData;
                file_put_contents($this->connector->getDbFilePath(), json_encode($this->db));

                return $this->db['posts'][$i];
            }

            ++$i;
        }

        return false;
    }

    /**
     * @param $id
     */
    public function remove($id)
    {
        $i = 0;

        foreach ($this->db['posts'] as $post) {
            if ($post['id'] == $id) {
                unset($this->db['posts'][$i]);

                $this->db['posts'] = array_values($this->db['posts']);

                file_put_contents($this->connector->getDbFilePath(), json_encode($this->db));
            }

            ++$i;
        }
    }
}
