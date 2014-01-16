<?php

$wgExtensionCredits['specialpage'][] = [
	'path' => __FILE__,
	'author' => [ 'Władysław Bodzek' ],
	'name' => 'ParserSpeed',
	'descriptionmsg' => 'parserspeed-desc',
];

$wgAutoloadClasses['ParserSpeedHooks'] = __DIR__ . '/ParserSpeedHooks.class.php';
$wgAutoloadClasses['ParserSpeedSpecialPageController'] = __DIR__ . '/ParserSpeedSpecialPageController.class.php';
$wgAutoloadClasses['ParserSpeedTablePager'] = __DIR__ . '/ParserSpeedTablePager.class.php';

$wgHooks['ParserAfterTidy'][] = 'ParserSpeedHooks::onParserAfterTidy';
$wgHooks['ArticleViewAfterParser'][] = 'ParserSpeedHooks::onArticleViewAfterParser';

$wgSpecialPages['ParserSpeed'] = 'ParserSpeedSpecialPageController';
$wgSpecialPageGroups['ParserSpeed'] = 'wikia';

$wgExtensionMessagesFiles['ParserSpeed'] = __DIR__ . '/ParserSpeed.i18n.php';
