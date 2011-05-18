<?php
/**
 * Game Guides API setup file
 * 
 * @author Federico "Lox" Lucignano
 */
$dir = dirname( __FILE__ );
$app = F::app();

/**
 * classes
 */
$app->registerClass( 'GameGuidesController', "{$dir}/GameGuidesController.class.php" );
$app->registerClass( 'GameGuidesWrongAPIVersionException', "{$dir}/GameGuidesController.class.php" );
$app->registerClass( 'GameGuidesModel', "{$dir}/GameGuidesModel.class.php" );