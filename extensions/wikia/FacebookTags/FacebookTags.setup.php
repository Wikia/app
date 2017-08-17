<?php
$wgExtensionCredits['parserhook'][] = [
	'name' => 'Facebook Tags',
	'author' => 'Wikia, Inc.',
	'descriptionmsg' => 'facebook-tags-desc',
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/FacebookTags',
];

$wgExtensionMessagesFiles['FacebookTags'] = __DIR__ . '/FacebookTags.i18n.php';

$wgAutoloadClasses['FacebookTagConstants'] = __DIR__ . '/FacebookTagConstants.php';
$wgAutoloadClasses['FacebookTagParser'] = __DIR__ . '/FacebookTagParser.php';
$wgAutoloadClasses['FacebookTagsHooks'] = __DIR__ . '/FacebookTagsHooks.php';

$wgHooks['ParserFirstCallInit'][] = 'FacebookTagsHooks::onParserFirstCallInit';
