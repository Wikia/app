<?php

$app = F::app();

/**
 * classes
 */
$app->registerClass( 'NewWikis', dirname( __FILE__ ) . '/NewWikis.class.php' );
$app->registerClass( 'NewWikisArticle', dirname( __FILE__ ). '/NewWikisArticle.class.php');
$app->registerClass( 'NewWikisController', dirname( __FILE__ ). '/NewWikisController.class.php');
$app->registerClass( 'ActiveNewWikisController', dirname( __FILE__ ). '/ActiveNewWikisController.class.php');

/**
 * factory configuration
 */
F::addClassConstructor( 'NewWikis', array( 'app' => $app ) );
F::addClassConstructor( 'NewWikisController', array( 'app' => $app ) );

/**
 * hooks
 */
$app->registerHook( 'ArticleFromTitle', 'NewWikisController', 'onArticleFromTitle' );

/**
 * special pages
 */
$app->registerSpecialPage( 'NewWikis', 'NewWikisController', 'highuse' );
$app->registerSpecialPage( 'ActiveNewWikis', 'ActiveNewWikisController', 'highuse' );
