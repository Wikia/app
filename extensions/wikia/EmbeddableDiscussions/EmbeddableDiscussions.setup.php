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

// controller
$wgAutoloadClasses['EmbeddableDiscussionsController'] =  __DIR__ . '/EmbeddableDiscussionsController.class.php';

// hooks
$wgHooks['ParserFirstCallInit'][] = 'EmbeddableDiscussionsController::onParserFirstCallInit';
$wgHooks['BeforePageDisplay'][] = 'EmbeddableDiscussionsController::onBeforePageDisplay';

// i18n

// messages exported to JS
JSMessages::registerPackage( 'EmbeddableDiscussions', [
	'embeddable-discussions-share-heading',
	'embeddable-discussions-reply',
	'embeddable-discussions-share',
	'embeddable-discussions-show-all',
	'embeddable-discussions-upvote',
	'embeddable-discussions-zero',
	'embeddable-discussions-zero-detail',
	'embeddable-discussions-forum-name',
	'embeddable-discussions-error-loading',
	'embeddable-discussions-cancel-button',
] );
