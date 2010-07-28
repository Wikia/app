<?php

if (!defined('MEDIAWIKI')) {
        exit( 1 );
}

$wgExtensionCredits['specialpage'][] = array(
        'name' => 'Wiki Stickies',
        'author' => 'Bartek Lapinski',
        //'url' => 'http://www.mediawiki.org/wiki/Extension:MyExtension',
        'description' => 'The big, sticky Wiki Stickies to capture your eye!',
        'descriptionmsg' => 'wikistickies-desc',
        'version' => '0.1.6',
);

$dir = dirname(__FILE__) . '/';

// autoloader
$wgAutoloadClasses['ApiQueryWithoutimages'] = $dir . 'ApiQueryWithoutimages.php';
$wgAutoloadClasses['ApiQueryWantedpages'] = $dir . 'ApiQueryWantedpages.php';
$wgAutoloadClasses['SpecialWikiStickies'] = $dir.'SpecialWikiStickies.class.php';
$wgAutoloadClasses['WikiStickies'] = $dir.'WikiStickies.class.php';

// special page
$wgSpecialPages['WikiStickies'] = 'SpecialWikiStickies';
$wgSpecialPageGroups['WikiStickies'] = 'users';

// i18n
$wgExtensionAliasesFiles['WikiStickies'] = $dir . 'SpecialWikiStickies.alias.php';
$wgExtensionMessagesFiles['WikiStickies'] = $dir . 'WikiStickies.i18n.php';

// API
$wgAPIListModules['wantedpages'] = 'ApiQueryWantedpages';
$wgAPIListModules['withoutimages'] = 'ApiQueryWithoutimages';

// Hooks
include( $dir . 'WikiStickies.hooks.php' );
$wgHooks['MyHome::sidebarBeforeContent'][] = 'efAddWikiSticky';
$wgHooks['RecentChange_save'][] = 'efRemoveFromSpecialWantedpages';
$wgHooks['MakeGlobalVariablesScript'][] = 'WikiStickiesJSVars';

// Special:Withoutimages
include( $dir . 'SpecialWithoutimages.php' );
