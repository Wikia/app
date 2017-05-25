<?php

/**
 * Parse external images white-list addresses
 *
 * @author Piotr Molski <moli@wikia.com>
 */

$wgExtensionCredits['other'][] = [
	'name' => 'Global External Image Whitelist',
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/WikiaWhiteList',
	'author' => [ 'Piotr Molski' ],
	'descriptionmsg' => 'wikiawhitelist-desc'
];

$wgExtensionMessagesFiles['WikiaExternalImageList'] = __DIR__ . '/WikiaExternalImageList.i18n.php';

$wgAutoloadClasses['WikiaExternalImageList'] = __DIR__ . '/WikiaExternalImageList.class.php';

// Register hooks
$wgHooks['outputMakeExternalImage'][] = 'WikiaExternalImageList::onOutputMakeExternalImage' ;
