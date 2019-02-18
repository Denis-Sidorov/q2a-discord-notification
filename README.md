# Q2A plugin for discord notifications

## Bot

Create app and bot on developer page: `https://discordapp.com/developers/applications/me`

There places bot's token and client id.

Add bot to channel (change client id and permissions): `https://discordapp.com/api/oauth2/authorize?client_id=157730590492196864&scope=bot&permissions=1`

Check channel permissions.

Init bot by connecting to gateway:

    php init.php
    
## Install

Copy plugin to `qa-plugin` directory

Install composer dependencies described in composer.json:

    composer require restcord/restcord textalk/websocket
    
## Configuration

Specify `bot token` and `channel id` in admin panel (plugins config)