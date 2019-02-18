<?php

namespace Qa\Plugin\DiscordNotification;

class Question {

    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $tags;

    /**
     * Question constructor.
     * @param int $id
     * @param string $title
     */
    public function __construct($id, $title) {
        $this->id = $id;
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getUrl() {
        return qa_q_path($this->getId(), $this->getTitle(), true);
    }

    /**
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Question
     */
    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getTitle() {
        return $this->title;
    }

    /**
     * @param string $title
     * @return Question
     */
    public function setTitle($title) {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string
     */
    public function getTags() {
        return $this->tags;
    }

    /**
     * @param string $tags
     * @return Question
     */
    public function setTags($tags) {
        $this->tags = $tags;
        return $this;
    }

}