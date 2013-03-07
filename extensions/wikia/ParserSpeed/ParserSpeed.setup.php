<?php

$app = F::app();

$app->registerClass('ParserSpeedHooks',__DIR__ . "/ParserSpeedHooks.class.php");
$app->registerClass('ParserSpeedSpecialPageController',__DIR__ . "/ParserSpeedSpecialPageController.class.php");
$app->registerClass('ParserSpeedTablePager',__DIR__ . "/ParserSpeedTablePager.class.php");

$app->registerHook('ArticleViewAfterParser','ParserSpeedHooks','onArticleViewAfterParser');

$app->registerSpecialPage('ParserSpeed','ParserSpeedSpecialPageController','wikia');

$wgGroupPermissions['*']['parserspeed'] = false;
$wgGroupPermissions['staff']['parserspeed'] = true;
