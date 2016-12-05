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
$wgAutoloadClasses['EmbeddableDiscussionsApiController'] =  __DIR__ . '/EmbeddableDiscussionsApiController.class.php';

// hooks
$wgHooks['ParserFirstCallInit'][] = 'EmbeddableDiscussionsController::onParserFirstCallInit';
$wgHooks['BeforePageDisplay'][] = 'EmbeddableDiscussionsController::onBeforePageDisplay';

// i18n
$wgExtensionMessagesFiles['EmbeddableDiscussions'] = __DIR__ . '/EmbeddableDiscussions.i18n.php';

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
	'embeddable-discussions-done-button',
	'embeddable-discussions-show-latest-short',
	'embeddable-discussions-show-trending-short',
	'embeddable-discussions-heading',
	'embeddable-discussions-description',
	'embeddable-discussions-sort-by',
	'embeddable-discussions-filter-by',
	'embeddable-discussions-filter-by-all',
] );
