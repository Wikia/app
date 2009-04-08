<?php
if(!defined('MEDIAWIKI')) {
	exit(1);
}

$wgExtensionCredits['specialpage'][] = array(
	'name' => 'WysiwygInterface',
	'description' => 'Wysiwyg modified parser development tool',
	'version' => '1.0',
	'author' => array('Inez Korczyński', 'Maciej Brencz', 'Maciej Błaszkowski (Marooned)'),
);

$dir = dirname(__FILE__) . '/';

$wgAutoloadClasses['WysiwygInterface'] = $dir . 'WysiwygInterface_body.php';
$wgExtensionMessagesFiles['WysiwygInterface'] = $dir . 'WysiwygInterface.i18n.php';
$wgSpecialPages['WysiwygInterface'] = 'WysiwygInterface';
