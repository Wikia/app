<?php

$wgExtensionCredits['specialpage'][] = array(
	'name' => 'My Home',
	'description' => 'A private home of Wikia for logged-in users',
	'author' => array('Inez Korczyński', 'Maciej Brencz', '[http://www.wikia.com/wiki/User:Marooned Maciej Błaszkowski (Marooned)]')
);

$dir = dirname(__FILE__) . '/';

// Special:MyHome
$wgAutoloadClasses['SpecialMyHome'] = $dir.'SpecialMyHome.class.php';
$wgSpecialPages['MyHome'] = 'SpecialMyHome';
$wgSpecialPageGroups['MyHome'] = 'users';
$wgExtensionAliasesFiles['MyHome'] = $dir . 'SpecialMyHome.alias.php';

// Special:ActivityFeed
$wgAutoloadClasses['SpecialActivityFeed'] = $dir.'SpecialActivityFeed.class.php';
$wgSpecialPages['ActivityFeed'] = 'SpecialActivityFeed';

// hooks
$wgHooks['CustomUserData'][] = 'MyHome::addToUserMenu';
$wgHooks['InitialQueriesMainPage'][] = 'MyHome::getInitialMainPage';
$wgHooks['UserToggles'][] = 'MyHome::userToggles';
$wgHooks['AddNewAccount2'][] = 'MyHome::addNewAccount';
