<?php

namespace AppBundle\Entity;

class Comment
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var Post
     */
    private $post;

    /**
     * @var string
     */
    private $content;

    /**
     * @var string
     */
    private $authorEmail;

    /**
     * @var \DateTime
     */
    private $publishedAt;

    /**
     * Comment constructor.
     */
    public function __construct()
    {
        $this->publishedAt = new \DateTime();
    }

    /**
     * @return bool
     */
    public function isLegitComment()
    {
        $containsInvalidCharacters = false !== strpos($this->content, '@');

        return !$containsInvalidCharacters;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param string $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * @return string
     */
    public function getAuthorEmail()
    {
        return $this->authorEmail;
    }

    /**
     * @param string $authorEmail
     */
    public function setAuthorEmail($authorEmail)
    {
        $this->authorEmail = $authorEmail;
    }

    /**
     * @return \DateTime
     */
    public function getPublishedAt()
    {
        return $this->publishedAt;
    }

    /**
     * @param \DateTime $publishedAt
     */
    public function setPublishedAt(\DateTime $publishedAt)
    {
        $this->publishedAt = $publishedAt;
    }

    /**
     * @return Post
     */
    public function getPost()
    {
        return $this->post;
    }

    /**
     * @param Post $post
     */
    public function setPost(Post $post)
    {
        $this->post = $post;
    }
}
