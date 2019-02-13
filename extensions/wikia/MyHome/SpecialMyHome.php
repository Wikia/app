<?php

$wgExtensionCredits['specialpage'][] = array(
	'name' => 'WikiActivity',
	'descriptionmsg' => 'myhome-desc',
	'author' => array('Inez Korczyński', 'Maciej Brencz', '[http://www.wikia.com/wiki/User:Marooned Maciej Błaszkowski (Marooned)]'),
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/MyHome'
);

$dir = dirname(__FILE__) . '/';

// Special:WikiActivity
$wgAutoloadClasses['SpecialWikiActivity'] = $dir.'SpecialWikiActivity.class.php';
$wgSpecialPages['WikiActivity'] = 'SpecialWikiActivity';
$wgSpecialPageGroups['WikiActivity'] = 'changes';
$wgExtensionMessagesFiles['WikiActivityAliases'] = "$dir/SpecialWikiActivity.alias.php";

// hooks
$wgHooks['InitialQueriesMainPage'][] = 'MyHome::getInitialMainPage';
$wgHooks['GetPreferences'][] = 'MyHome::onGetPreferences';
$wgHooks['RevisionInsertComplete'][] = 'MyHome::onRevisionInsertComplete';
