<?php
$wgExtensionCredits['parserhook'][] = [
	'name' => 'Facebook Tags',
	'author' => 'Wikia, Inc.',
	'descriptionmsg' => 'facebook-tags-desc',
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/FacebookTags',
];


$wgAutoloadClasses['FacebookTagConstants'] = __DIR__ . '/FacebookTagConstants.php';
$wgAutoloadClasses['FacebookTagParser'] = __DIR__ . '/FacebookTagParser.php';
$wgAutoloadClasses['FacebookTagsHooks'] = __DIR__ . '/FacebookTagsHooks.php';

$wgHooks['ParserFirstCallInit'][] = 'FacebookTagsHooks::onParserFirstCallInit';
$wgHooks['BeforePageDisplay'][] = 'FacebookTagsHooks::onBeforePageDisplay';

$wgResourceModules['ext.wikia.facebookTags'] = [
	'scripts' => 'modules/ext.facebookTags.js',

	// apply domain sharding
	'source' => 'common',
	'localBasePath' => __DIR__,
	'remoteExtPath' => 'wikia/FacebookTags',
];
