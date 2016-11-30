<?php

namespace AppBundle\Repository;

/**
 * Interface RepositoryInterface
 */
interface RepositoryInterface
{
    /**
     * @param $entityData
     * @return mixed
     */
    public function insert($entityData);

    /**
     * @param $entityData
     * @return mixed
     */
    public function update($entityData);

    /**
     * @param $id
     * @return mixed
     */
    public function remove($id);

    /**
     * @param $id
     * @return mixed
     */
    public function find($id);

    /**
     * @return mixed
     */
    public function findAll();
}
