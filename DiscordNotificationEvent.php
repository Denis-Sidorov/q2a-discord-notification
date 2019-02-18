<?php


use Qa\Plugin\DiscordNotification\DiscordBot;
use Qa\Plugin\DiscordNotification\MessageBuilder;
use Qa\Plugin\DiscordNotification\Question;
use Qa\Plugin\DiscordNotification\Subject;
use RestCord\DiscordClient;

class DiscordNotificationEvent {

    const PLUGIN_PREFIX = 'plugin_discord_notification_';

    private $notableEvents = [
        'q_post',
        'a_post',
        'c_post',

        'q_edit',
        'a_edit',
        'c_edit',

        'q_close',
        'q_reopen',

        /** best answer */
        'a_select',
        'a_unselect',
    ];

    /**
     * @link http://docs.question2answer.org/plugins/modules/ Implementing plugin modules
     * @param string $directory
     * @param string $urltoroot
     * @param string $type
     * @param string $name
     */
    public function load_module($directory, $urltoroot, $type, $name) {
        require_once $directory . 'Models/Question.php';
        require_once $directory . 'Models/Subject.php';
        require_once $directory . 'Models/DiscordBot.php';
        require_once $directory . 'Models/MessageBuilder.php';
        require_once $directory . '../../vendor/autoload.php';
    }

    /**
     * @link http://docs.question2answer.org/plugins/modules/ Implementing plugin modules
     * @param $option
     * @return string|null
     */
    public function option_default($option) {
        return $option === self::PLUGIN_PREFIX . 'bot_token' ? '' :
            $option === self::PLUGIN_PREFIX . 'channel_id' ? '' :
            null;
    }

    function admin_form(&$qa_content) {
        $saved = false;

        if (qa_clicked(self::PLUGIN_PREFIX . 'save_button')) {
            qa_opt(self::PLUGIN_PREFIX . 'bot_token', qa_post_text(self::PLUGIN_PREFIX . 'bt_field'));
            qa_opt(self::PLUGIN_PREFIX . 'channel_id', (int) qa_post_text(self::PLUGIN_PREFIX . 'ci_field'));
            $saved = true;
        }

        return array(
            'ok' => $saved ? qa_lang('admin/options_saved') : null,

            'fields' => array(

                array(
                    'label' => 'Bot token:',
                    'type' => 'text',
                    'value' => qa_opt(self::PLUGIN_PREFIX . 'bot_token'),
                    'tags' => 'NAME="' . self::PLUGIN_PREFIX . 'bt_field' . '"',
                ),

                array(
                    'label' => 'Channel id:',
                    'type' => 'number',
                    'style' => 'fix-low-width',
                    'value' => (int) qa_opt(self::PLUGIN_PREFIX . 'channel_id'),
                    'tags' => 'NAME="' . self::PLUGIN_PREFIX . 'ci_field' . '"',
                ),
            ),

            'buttons' => array(
                array(
                    'label' => qa_lang_html('main/save_button'),
                    'tags' => 'NAME="' . self::PLUGIN_PREFIX . 'save_button' . '"',
                ),
            ),
        );
    }

    /**
     * @link http://docs.question2answer.org/plugins/modules-event/ Event Modules
     * @param string $event
     * @param int $userid
     * @param string $handle user login
     * @param string $cookieid
     * @param array $params
     */
    public function process_event($event, $userid, $handle, $cookieid, $params) {
        if (!in_array($event, $this->notableEvents)) {
            return;
        }

        $question = $this->getQuestion($params);
        $subject = $this->getSubject($event, $params);

        $message = (new MessageBuilder())
            ->on($question, $subject)
            ->invoked($event)
            ->by($handle)
            ->create();

        $bot = new DiscordBot(new DiscordClient(['token' => qa_opt(self::PLUGIN_PREFIX . 'bot_token')]));
        $bot->send(qa_opt(self::PLUGIN_PREFIX . 'channel_id'), $message);
//        $bot->send(446224386140274700, 'q2a bot test');
    }

    /**
     * @param array $params
     * @return Question Question params
     */
    private function getQuestion($params): Question {
        return
            isset($params['question']) ? (new Question(
                $params['question']['postid'],
                $params['question']['title']
            ))->setTags($params['question']['tags']) :
            isset($params['parent']) ? (new Question(
                $params['parent']['postid'],
                $params['parent']['title']
            ))->setTags($params['parent']['tags']) :
            (new Question(
                $params['postid'],
                $params['title']
            ))->setTags($params['tags']);
    }

    /**
     * @param string $event
     * @param array $params
     * @return Subject
     */
    private function getSubject($event, $params): Subject {
        return new Subject($params['postid'], $this->getSubjectType($event));
    }

    /**
     * @param string $event
     * @return string Q - question | A - answer | C - comment
     */
    private function getSubjectType($event) {
        return strtoupper(substr($event, 0, 1));
    }

}