<?php

namespace AppBundle\Repository;

use AppBundle\Entity\PostEntity;

/**
 * Class PostRepository.
 */
class PostRepository implements PostRepositoryInterface
{
    /**
     * @var Storage
     */
    private $storage;

    /**
     * @var mixed
     */
    private $postsData;

    /**
     * PostRepository constructor.
     */
    public function __construct()
    {
        $this->storage = new Storage();
        $this->postsData = $this->storage->getData('posts');
    }

    /**
     * @return mixed
     */
    public function findAll()
    {
        return $this->postsData;
    }

    /**
     * @param PostEntity $postData
     *
     * @return bool
     */
    public function insert(PostEntity $postData)
    {
        $id = $this->postsData['auto_id'];

        $postData->setId($id);

        $this->postsData[] = [
            'id' => $postData->getId(),
            'title' => $postData->getTitle(),
            'content' => $postData->getContent(),
        ];

        ++$this->postsData['auto_id'];

        return $this->storage->setData('posts', $this->postsData);
    }

    /**
     * @param $id
     *
     * @return bool|mixed
     */
    public function find($id)
    {
        $i = -1;
        foreach ($this->postsData as $post) {
            if ($post['id'] == $id) {
                return $this->postsData[$i];
            }
            ++$i;
        }

        return false;
    }

    /**
     * @param PostEntity $postData
     *
     * @return bool|mixed
     */
    public function update(PostEntity $postData)
    {
        $i = -1;
        foreach ($this->postsData as $post) {
            if ($post['id'] == $postData->getId()) {
                $this->postsData[$i]['title'] = $postData->getTitle();
                $this->postsData[$i]['content'] = $postData->getContent();

                $this->storage->setData('posts', $this->postsData);

                return $this->postsData[$i];
            }
            ++$i;
        }

        return false;
    }

    /**
     * @param $id
     *
     * @return bool
     */
    public function remove($id)
    {
        $i = -1;
        foreach ($this->postsData as $post) {
            if ($post['id'] == $id) {
                unset($this->postsData[$i]);

                $this->postsData = array_merge($this->postsData);

                return $this->storage->setData('posts', $this->postsData);
            }
            ++$i;
        }

        return false;
    }
}
