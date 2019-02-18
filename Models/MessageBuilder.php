<?php

namespace Qa\Plugin\DiscordNotification;


class MessageBuilder {

    /**
     * @var string
     */
    private $user;

    /**
     * @var string
     */
    private $event;

    /**
     * @var Question
     */
    private $question;

    /**
     * @var Subject
     */
    private $subject;

    private $eventDescriptions = [
        'q_post' => 'asked a question',
        'a_post' => 'answered for a question',
        'c_post' => 'commented a question',

        'q_edit' => 'edited a question',
        'a_edit' => 'edited an answer',
        'c_edit' => 'edited a comment',

        'q_close' => 'closed a question',
        'q_reopen' => 'reopen a question',

        'a_select' => 'selected best answer',
        'a_unselect' => 'removed best answer',
    ];

    /**
     * @param string $login
     * @return $this
     */
    public function by(string $login): self {
        $this->user = $login;
        return $this;
    }

    /**
     * @param string $event
     * @return $this
     */
    public function invoked(string $event): self {
        $this->event = $event;
        return $this;
    }

    /**
     * @param Question $question
     * @param Subject $subject
     * @return $this
     */
    public function on(Question $question, Subject $subject): self {
        $this->question = $question;
        $this->subject = $subject;
        return $this;
    }

    /**
     * @return string
     */
    public function create(): string {
        $parts = array_filter([
            $this->user,
            !empty($this->event) ? $this->eventDescriptions[$this->event] : null,
            (!empty($this->subject) && $this->subject->getType() === Subject::QUESTION) ? 'at ' .$this->question->getUrl() : 'at ' . $this->subject->getUrl($this->question)
        ]);

        return ucfirst(implode(" ", $parts));
    }

}