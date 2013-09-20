<?php


$dir = dirname(__FILE__) . '/';
/* @var $app WikiaApp */
$app = F::app();

/**
 * classes
 */
$wgAutoloadClasses['UAD'] =  $dir . 'UAD.class.php';
$wgAutoloadClasses['UADController'] =  $dir . 'UADController.class.php';


/**
 * hooks
 */
$app->registerHook( 'OutputPageBeforeHTML', 'UADController', 'onOutputPageBeforeHTML' );
