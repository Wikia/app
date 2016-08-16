<?php
$wgExtensionCredits['parserhook'][] = [
	'name' => 'Embeddable Discussions',
	'author' => [
		'pgroland',
	],
	'version' => '1',
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/EmbeddableDiscussions',
];

// model
$wgAutoloadClasses['DiscussionsThreadModel'] = __DIR__ . '/models/DiscussionsThreadModel.class.php';
$wgAutoloadClasses['DiscussionsCategoryModel'] = __DIR__ . '/models/DiscussionsCategoryModel.class.php';

// controller
$wgAutoloadClasses['EmbeddableDiscussionsController'] =  __DIR__ . '/EmbeddableDiscussionsController.class.php';

// hooks
$wgHooks['ParserFirstCallInit'][] = 'EmbeddableDiscussionsController::onParserFirstCallInit';
$wgHooks['BeforePageDisplay'][] = 'EmbeddableDiscussionsController::onBeforePageDisplay';

// i18n
$wgExtensionMessagesFiles['EmbeddableDiscussions'] = __DIR__ . '/EmbeddableDiscussions.i18n.php';
