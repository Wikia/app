<?php

$wgAutoloadClasses['ParserSpeedHooks'] = __DIR__ . "/ParserSpeedHooks.class.php";
$wgAutoloadClasses['ParserSpeedSpecialPageController'] = __DIR__ . "/ParserSpeedSpecialPageController.class.php";
$wgAutoloadClasses['ParserSpeedTablePager'] = __DIR__ . "/ParserSpeedTablePager.class.php";

$wgHooks['ParserAfterTidy'][] = 'ParserSpeedHooks::onParserAfterTidy';
$wgHooks['ArticleViewAfterParser'][] = 'ParserSpeedHooks::onArticleViewAfterParser';

$wgSpecialPages['ParserSpeed'] = 'ParserSpeedSpecialPageController';
$wgSpecialPageGroups['ParserSpeed'] = 'wikia';

$wgGroupPermissions['*']['parserspeed'] = false;
$wgGroupPermissions['staff']['parserspeed'] = true;
