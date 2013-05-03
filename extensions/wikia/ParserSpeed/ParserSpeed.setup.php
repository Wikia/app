<?php

$app = F::app();

$wgAutoloadClasses['ParserSpeedHooks'] = __DIR__ . "/ParserSpeedHooks.class.php";
$wgAutoloadClasses['ParserSpeedSpecialPageController'] = __DIR__ . "/ParserSpeedSpecialPageController.class.php";
$wgAutoloadClasses['ParserSpeedTablePager'] = __DIR__ . "/ParserSpeedTablePager.class.php";

$app->registerHook('ParserAfterTidy','ParserSpeedHooks','onParserAfterTidy');
$app->registerHook('ArticleViewAfterParser','ParserSpeedHooks','onArticleViewAfterParser');

$wgSpecialPages['ParserSpeed'] = 'ParserSpeedSpecialPageController';
$wgSpecialPageGroups['ParserSpeed'] = 'wikia';

$wgGroupPermissions['*']['parserspeed'] = false;
$wgGroupPermissions['staff']['parserspeed'] = true;
