<?php
$wgExtensionCredits['parserhook'][] = [
	'name' => 'Flite Tag Extension',
	'author' => 'Ad Engineering @Wikia',
	'descriptionmsg' => 'flitetag-desc',
	'version' => '0.1',
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/FliteTag',
];

// Autoload
$wgAutoloadClasses['FliteTagController'] =  __DIR__ . '/FliteTagController.class.php';

// Hooks
$wgHooks['ParserFirstCallInit'][] = 'FliteTagController::onParserFirstCallInit';

// i18n
$wgExtensionMessagesFiles['FliteTag'] = __DIR__ . '/FliteTag.i18n.php';
