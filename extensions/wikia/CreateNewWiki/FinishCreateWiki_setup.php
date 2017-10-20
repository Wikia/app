<?php

$wgExtensionCredits['specialpage'][] = array(
	'name' => 'FinishCreateWiki',
	'descriptionmsg' => 'createnewwiki-desc',
	'author' => array('Hyun Lim')
);

$dir = dirname(__FILE__).'/';

// class autoloads mappings
$wgAutoloadClasses['FinishCreateWikiController'] = $dir . 'FinishCreateWikiController.class.php';
$wgAutoloadClasses['SpecialFinishCreate'] = $dir . 'SpecialFinishCreate.class.php';

// special page mapping
$wgSpecialPages['FinishCreate'] = 'SpecialFinishCreate';

// i18n mapping
$wgExtensionMessagesFiles['CreateNewWiki'] = $dir . 'CreateNewWiki.i18n.php';