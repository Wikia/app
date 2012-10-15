<?php


$dir = dirname(__FILE__) . '/';
/* @var $app WikiaApp */
$app = F::build('App');

/**
 * classes
 */
$app->registerClass('UAD', $dir . 'UAD.class.php');
$app->registerClass('UADController', $dir . 'UADController.class.php');

F::addClassConstructor( 'UAD', array( 'app' => $app ) );
F::addClassConstructor( 'UADController', array( 'app' => $app, 'uad' => F::build( 'UAD' ) ) );


/**
 * hooks
 */
$app->registerHook( 'OutputPageBeforeHTML', 'UADController', 'onOutputPageBeforeHTML' );
