<?php

include __DIR__.'/vendor/autoload.php';

use RestCord\DiscordClient;
use WebSocket\Client;

$botToken = '';

$discord = new DiscordClient(['token' => $botToken]); // Token is required

/** @var \GuzzleHttp\Command\Result $gateway */
$gateway = ($discord->gateway->getGatewayBot([]))->toArray()['url'];

$socket = new Client($gateway);
$socket->send(json_encode([
    'op' => 2,
    'd' => [
        'token' => $botToken,
        'v' => 6,
        'compress' => false,
        'properties' => [
            '$os' => PHP_OS,
            '$browser' => 'q2a',
            '$device' => 'q2a',
            '$referrer' => '',
            '$referring_domain' => '',
        ],
    ],
]));
$response = $socket->receive();
var_export($response);