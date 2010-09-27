<?php

$wgExtensionCredits['specialpage'][] = array(
	'name' => 'WikiBuilder',
	'description' => 'WikiBuilder for Oasis',
	'author' => 'Hyun Lim',
);

$dir = dirname(__FILE__).'/';

// autoloads
$wgAutoloadClasses['WikiBuilderModule'] = $dir.'WikiBuilderModule.class.php';
$wgAutoloadClasses['SpecialWikiBuilder'] = $dir.'SpecialWikiBuilder.class.php';

// special pages
$wgSpecialPages['WikiBuilder'] = 'SpecialWikiBuilder';

// i18n 
$wgExtensionMessagesFiles['WikiBuilder'] = $dir.'WikiBuilder.i18n.php';

// TODO: Permissions
$wgAvailableRights[] = 'wikibuilder';
$wgGroupPermissions['*']['wikibuilder'] = false;
$wgGroupPermissions['sysop']['wikibuilder'] = true;
$wgGroupPermissions['bureaucrat']['wikibuilder'] = true;
$wgGroupPermissions['staff']['wikibuilder'] = true;