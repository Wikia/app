<?php
if(!defined('MEDIAWIKI')) {
	exit(1);
}

$dir = dirname(__FILE__) . '/';

$wgAutoloadClasses['WysiwygInterface'] = $dir . 'WysiwygInterface_body.php';
$wgExtensionMessagesFiles['WysiwygInterface'] = $dir . 'WysiwygInterface.i18n.php';
$wgSpecialPages['WysiwygInterface'] = 'WysiwygInterface';