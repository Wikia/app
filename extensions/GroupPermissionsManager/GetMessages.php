<?php

/**
* get default and plugin messages
*/

if(!defined('MEDIAWIKI')) {
	echo("This file is an extension to the MediaWiki software and is not a valid access point");
	die(1);
}

$evMessages = array();
require_once(dirname(__FILE__) . '/GroupPermissionsManager.i18n.php');
$evMessages = array_merge($evMessages, $messages);

$files = scandir(dirname(__FILE__) . '/plugins/messages');
foreach($files as $file) {
	if(preg_match('/\.i18n\.php5?$/i', $file)) {
		require_once(dirname(__FILE__) . '/plugins/messages/' . $file);
		$evMessages = array_merge($evMessages, $messages);
	}
}

$messages = $evMessages;