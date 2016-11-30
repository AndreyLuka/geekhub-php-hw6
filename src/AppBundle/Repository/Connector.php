<?php

namespace AppBundle\Repository;

class Connector
{
    /**
     * @var string
     */
    private $dbFilePath;

    /**
     * @var array
     */
    private $data;

    /**
     * @var mixed
     */
    private $db;

    /**
     * Connector constructor.
     */
    public function __construct()
    {
        $this->dbFilePath = '../var/cache/db/posts.json';

        $this->data = ['posts' => []];

        if (!file_exists($this->dbFilePath)) {
            mkdir('../var/cache/db');

            for ($i = 1; $i <= 3; ++$i) {
                $this->data['posts'][] = [
                    'id' => $i,
                    'title' => 'post-title',
                    'content' => 'post-content',
                ];
            }

            file_put_contents($this->dbFilePath, json_encode($this->data));
        }

        $this->db = json_decode(file_get_contents($this->dbFilePath), true);
    }

    /**
     * @return mixed
     */
    public function getDb()
    {
        return $this->db;
    }

    /**
     * @return string
     */
    public function getDbFilePath()
    {
        return $this->dbFilePath;
    }
}
