<?php
/*
 * This script generates a sprite sheet given a folder of icons
 * Run like: sudo SERVER_ID=177 php generateSpriteSheet.php --conf /usr/wikia/docroot/wiki.factory/LocalSettings.php
 */

ini_set('include_path', dirname(__FILE__).'/../../../../maintenance');
require_once('commandLine.inc');

$name = 'Chat';
$dir = "{$IP}/extensions/wikia/{$name}2";

$srv = new SpriteService(array(
	'name' => $name,
	'source' => "{$dir}/images/sprite-{$name}/",
	'sprite' => "{$dir}/images/sprite-{$name}.png",
	'scss' => "{$dir}/css/mixins/_sprite-{$name}.scss"
));

$srv->process(false);
