<?php

if (!defined('MEDIAWIKI')) {
        exit( 1 );
}

$wgExtensionCredits['specialpage'][] = array(
        'name' => 'Action Box',
        'author' => 'Bartek Lapinski',
        'url' => 'http://www.mediawiki.org/wiki/Extension:MyExtension',
        'description' => 'The brand new user Action Box!',
        'descriptionmsg' => 'The extension that will allow users to take ACTION!',
        'version' => '0.1.0',
);

$dir = dirname(__FILE__) . '/';

// special page
$wgAutoloadClasses['ActionBox'] = $dir.'ActionBox.class.php';
$wgSpecialPages['ActionBox'] = 'ActionBox';
$wgSpecialPageGroups['ActionBox'] = 'users';
$wgExtensionMessagesFiles['ActionBox'] = $dir . 'ActionBox.i18n.php';

