<?php

$wgExtensionCredits['specialpage'][] = array(
	'name' => 'FinishCreateWiki',
	'descriptionmsg' => 'createnewwiki-desc',
	'author' => array('Hyun Lim')
);

$dir = dirname(__FILE__).'/';

// class autoloads mappings
$wgAutoloadClasses['FinishCreateWikiController'] = $dir . 'FinishCreateWikiController.class.php';

// i18n mapping
$wgExtensionMessagesFiles['CreateNewWiki'] = $dir . 'CreateNewWiki.i18n.php';