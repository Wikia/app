<?php

if ( !defined( 'MEDIAWIKI' ) ) {
	die();
}

$wgExtensionCredits['specialpage'][] = array(
	'name' => 'Wikia Special Unlockdb',
	'author' => 'Piotr Molski (MoLi)',
	'url' => 'http://www.wikia.com' ,
	'description' => 'Wikia version of MW Special::UnlockDB'
);

$dir = dirname(__FILE__).'/';
<<<<<<< HEAD
//i18n
$wgExtensionMessagesFiles['SpecialUnlockdb'] = $dir . 'SpecialUnlockdb.i18n.php';

=======
>>>>>>> upstream/dev
$wgAutoloadClasses['WikiaSpecialUnlockdb'] = $dir . 'SpecialUnlockdb.class.php';
$wgSpecialPages['Unlockdb'] = 'WikiaSpecialUnlockdb';
