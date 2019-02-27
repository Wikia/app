<?php

$wgExtensionCredits['other'][] = [
	'name' => 'Edit Draft Saving',
	'description' => 'Provides edit draft saving functionality. It acts as a "backup" of edited content in case your browser crashes.',
];

/**
 * Resources Loader modules
 */

// a base "EditDraftSaving" AMD module with a generic code
$wgResourceModules['ext.wikia.EditDraftSaving.base'] = [
	'scripts' => [
		'js/index.js',
	],
	'messages' => [
		'edit-draft-loaded',
		'edit-draft-edit-conflict',
	],
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

$wgAutoloadClasses['EditDraftSavingHooks'] = __DIR__.'/EditDraftSavingHooks.class.php';

// inject above ResourceLoader modules
$wgHooks['EditPage::showEditForm:initial'][] = 'EditDraftSavingHooks::onEditPage_showEditForm_initial';

// invalidate drafts after successful edits
$wgHooks['ArticleSaveComplete'][] = 'EditDraftSavingHooks::onArticleSaveComplete';
$wgHooks['MakeGlobalVariablesScript'][] = 'EditDraftSavingHooks::onMakeGlobalVariablesScript';
