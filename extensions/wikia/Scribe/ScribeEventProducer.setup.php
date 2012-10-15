<?php

$app = F::app();
$dir = dirname( __FILE__ );

$app->registerClass('ScribeEventProducer', $dir . '/ScribeEventProducer.class.php');
$app->registerClass('ScribeEventProducerController', $dir . '/ScribeEventProducerController.class.php');

$app->registerHook('ArticleSaveComplete', 'ScribeEventProducerController', 'onSaveComplete' );
$app->registerHook('NewRevisionFromEditComplete', 'ScribeEventProducerController', 'onSaveRevisionComplete' );
$app->registerHook('ArticleDeleteComplete', 'ScribeEventProducerController', 'onDeleteComplete' );
$app->registerHook('ArticleUndelete', 'ScribeEventProducerController', 'onArticleUndelete' );
$app->registerHook('TitleMoveComplete', 'ScribeEventProducerController', 'onMoveComplete' ); 

F::addClassConstructor( 'ScribeEventProducer', array( 'app' => $app ) );
F::addClassConstructor( 'ScribeEventProducerController', array( 'app' => $app ) );
