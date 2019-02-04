<?php
$wgAutoloadClasses['EditDraftSavingHooks'] = __DIR__.'/EditDraftSavingHooks.class.php';

/**
 * Resources Loader modules
 */

// a base "EditDraftSaving" AMD module with a generic code
$wgResourceModules['ext.wikia.EditDraftSaving.base'] = [
	'scripts' => [
		'js/index.js',
	],
	'messages' => [],
	'localBasePath' => __DIR__,
	'remoteExtPath' => 'wikia/EditDraftSaving',
];

// RTE-specific module
$wgResourceModules['ext.wikia.EditDraftSaving.rte'] = [
	'scripts' => [
		'js/rte.js',
	],
	'dependencies' => ['ext.wikia.EditDraftSaving.base'],
	'localBasePath' => __DIR__,
	'remoteExtPath' => 'wikia/EditDraftSaving',
];

// mediawiki source editor specific module
$wgResourceModules['ext.wikia.EditDraftSaving.mediawiki'] = [
	'scripts' => [
		'js/mediawiki.js',
	],
	'dependencies' => ['ext.wikia.EditDraftSaving.base'],
	'localBasePath' => __DIR__,
	'remoteExtPath' => 'wikia/EditDraftSaving',
];

$wgHooks['EditPage::showEditForm:initial'][] = 'EditDraftSavingHooks::onEditPage_showEditForm_initial';
