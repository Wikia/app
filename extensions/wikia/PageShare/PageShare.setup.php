<?php
/**
 * PageShare
 *
 * @author Bartosz "V." Bentkowski
 */

$wgExtensionCredits[ 'specialpage' ][] = [
	'name' => 'PageShare',
	'author' => 'Bartosz "V." Bentkowski',
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/PageShare',
	'version' => 1
];


//i18n
$wgExtensionMessagesFiles['PageShare'] = __DIR__ . '/PageShare.i18n.php';

// controller classes
$wgAutoloadClasses[ 'PageShareController' ] =  __DIR__ . '/PageShareController.class.php';
$wgAutoloadClasses[ 'PageShareHelper' ] =  __DIR__ . '/PageShareHelper.class.php';
