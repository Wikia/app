<?php

$dir = dirname( __FILE__ );

$wgAutoloadClasses['ScribeProducer'] =  $dir . '/ScribeProducer.php';  //was this removed?
$wgAutoloadClasses['ScribeEventProducer'] =  $dir . '/ScribeEventProducer.class.php';
$wgAutoloadClasses['ScribeEventProducerController'] =  $dir . '/ScribeEventProducerController.class.php';

$app->registerHook('ArticleSaveComplete', 'ScribeEventProducerController', 'onSaveComplete' );
$app->registerHook('NewRevisionFromEditComplete', 'ScribeEventProducerController', 'onSaveRevisionComplete' );
$app->registerHook('ArticleDeleteComplete', 'ScribeEventProducerController', 'onDeleteComplete' );
$app->registerHook('ArticleUndelete', 'ScribeEventProducerController', 'onArticleUndelete' );
$app->registerHook('TitleMoveComplete', 'ScribeEventProducerController', 'onMoveComplete' ); 

