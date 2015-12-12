<?php

/**
 * Internal Linking
 */

$wgExtensionCredits['internallinking'][] = [
	'name' => 'InternalLinking',
	'descriptionmsg' => 'internallinking-desc',
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/InternalLinking'
];

$dir = dirname( __FILE__ ) . '/';

// autoload
$wgAutoloadClasses['InternalLinkingController'] =  $dir . 'InternalLinkingController.class.php';
$wgAutoloadClasses['InternalLinkingHelper'] = $dir . 'InternalLinkingHelper.class.php';

// i18n mapping
$wgExtensionMessagesFiles['InternalLinking'] = $dir . 'InternalLinking.i18n.php';
