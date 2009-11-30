<?php

if (!defined('MEDIAWIKI')) {
        exit( 1 );
}

$wgExtensionCredits['specialpage'][] = array(
        'name' => 'Wiki Stickies',
        'author' => 'Bartek Lapinski',
        'url' => 'http://www.mediawiki.org/wiki/Extension:MyExtension',
        'description' => 'The big, sticky Wiki Stickies to capture your eye!',
        'descriptionmsg' => 'The extension that will capture your attention!',
        'version' => '0.1.5',
);

$dir = dirname(__FILE__) . '/';

// special page
$wgAutoloadClasses['WikiStickies'] = $dir.'WikiStickies.class.php';
$wgSpecialPages['WikiStickies'] = 'WikiStickies';
$wgSpecialPageGroups['WikiStickies'] = 'users';
$wgExtensionMessagesFiles['WikiStickies'] = $dir . 'WikiStickies.i18n.php';
$wgAutoloadClasses['ApiQueryWantedpages'] = $dir . 'ApiQueryWantedpages.php';
$wgAutoloadClasses['ApiQueryWantedimages'] = $dir . 'ApiQueryWantedimages.php';
$wgAPIListModules['wantedpages'] = 'ApiQueryWantedpages';
$wgAPIListModules['wantedimages'] = 'ApiQueryWantedimages';

