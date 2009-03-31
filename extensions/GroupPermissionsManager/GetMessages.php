<?php

/**
* get default and plugin messages
*/

if(!defined('MEDIAWIKI')) {
	echo("This file is an extension to the MediaWiki software and is not a valid access point");
	die(1);
}

global $wgExtensionMessagesFiles;
require(dirname(__FILE__) . '/GroupPermissionsManager.i18n.php');

$files = scandir(dirname(__FILE__) . '/plugins/messages');
foreach($files as $file) {
	if(preg_match('/\.i18n\.php5?$/i', $file)) {
		$wgExtensionMessagesFiles[$file] = dirname(__FILE__) . '/plugins/messages/' . $file;
		wfLoadExtensionMessages($file);
	}
}
