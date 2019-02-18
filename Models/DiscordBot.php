<?php

namespace Qa\Plugin\DiscordNotification;


use RestCord\DiscordClient;

class DiscordBot {

    /**
     * @var DiscordClient
     */
    private $client;

    /**
     * DiscordBot constructor.
     * @param DiscordClient $client
     */
    public function __construct(DiscordClient $client) {
        $this->client = $client;
    }

    /**
     * @param int $channelId
     * @param string $content
     * @return array
     */
    public function send(int $channelId, string $content) {
        return $this->client->channel->createMessage([
            'channel.id' => $channelId,
            'content' => $content
        ]);
    }

}