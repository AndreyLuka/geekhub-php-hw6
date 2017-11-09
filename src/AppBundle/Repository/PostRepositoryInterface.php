<?php

namespace AppBundle\Repository;

use AppBundle\Entity\PostEntity;

/**
 * Interface PostRepositoryInterface.
 */
interface PostRepositoryInterface
{
    /**
     * @param PostEntity $entityData
     *
     * @return mixed
     */
    public function insert(PostEntity $entityData);

    /**
     * @param PostEntity $entityData
     *
     * @return mixed
     */
    public function update(PostEntity $entityData);

    /**
     * @param $id
     *
     * @return mixed
     */
    public function remove($id);

    /**
     * @param $id
     *
     * @return mixed
     */
    public function find($id);

    /**
     * @return mixed
     */
    public function findAll();
}
