<?php

/*
  Plugin Name: Discord notification
  Plugin Description: Send messages on specified events by discord bot
  Plugin Date: 2019-02-18
  Plugin Author: Denis Sidorov
  Plugin License: Free
  Plugin Minimum Question2Answer Version: 1.8
*/

if (!defined('QA_VERSION')) { // don't allow this page to be requested directly from browser
  header('Location: ../../');
  exit;
}

qa_register_plugin_module('event', 'DiscordNotificationEvent.php', 'DiscordNotificationEvent', 'Discord Notifications');