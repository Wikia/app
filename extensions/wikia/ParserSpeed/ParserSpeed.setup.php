<?php

$app = F::app();

$app->registerClass('ParserSpeedHooks',__DIR__ . "/ParserSpeedHooks.class.php");
$app->registerHook('ArticleViewAfterParser','ParserSpeedHooks','onArticleViewAfterParser');
