<?php

namespace Qa\Plugin\DiscordNotification;

class Subject {

    const QUESTION = 'Q';
    const ANSWER = 'A';
    const COMMENT = 'C';

    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $type;

    /**
     * Subject constructor.
     * @param int $id
     * @param string $type
     * @throws \InvalidArgumentException
     */
    public function __construct($id, $type) {
        if (
            $type !== self::QUESTION &&
            $type !== self::ANSWER &&
            $type !== self::COMMENT
        ) {
            throw new \InvalidArgumentException("Unknown subject type: {$type}");
        }

        $this->id = $id;
        $this->type = $type;
    }

    /**
     * @param Question $question
     * @return string
     */
    public function getUrl(Question $question) {
        return qa_q_path($question->getId(), $question->getTitle(), true, $this->getType(), $this->getId());
    }

    /**
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getType() {
        return $this->type;
    }

}