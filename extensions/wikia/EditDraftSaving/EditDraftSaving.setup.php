<?php
$wgAutoloadClasses['EditDraftSavingHooks'] = __DIR__.'/EditDraftSavingHooks.class.php';

// Resources Loader module
$GLOBALS['wgResourceModules']['ext.wikia.EditDraftSaving'] = [
	'scripts' => [
		'js/index.js',
	],
	'dependencies' => [],
	'messages' => [],
	'localBasePath' => __DIR__,
	'remoteExtPath' => 'wikia/EditDraftSaving',
];

$wgHooks['EditPage::showEditForm:initial'][] = 'EditDraftSavingHooks::onEditPage_showEditForm_initial';

