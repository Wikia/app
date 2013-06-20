<?php

/**
 * Lite Semantics
 *
 * @author Jakub Kurcek <jakub at wikia-inc.com>
 * @author Federico "Lox" Lucignano <federico(at)wikia-inc.com>
 * @date 2012-01-09
 * @copyright Copyright (C) 2012 Jakub Kurcek, Federico "Lox" Lucignano, Wikia Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

/**
 * @var WikiaApp
 */
$app = F::app();
$dir = dirname( __FILE__ );

/**
 * classes
 */
$wgAutoloadClasses[ 'LiteSemanticsCollection'] =  $dir . '/LiteSemanticsCollection.class.php' ;
$wgAutoloadClasses[ 'LiteSemanticsHashCollection'] =  $dir . '/LiteSemanticsCollection.class.php' ;
$wgAutoloadClasses[ 'LiteSemanticsListCollection'] =  $dir . '/LiteSemanticsCollection.class.php' ;

$wgAutoloadClasses[ 'LiteSemanticsEntity'] =  $dir . '/LiteSemanticsEntity.class.php' ;
$wgAutoloadClasses[ 'LiteSemanticsProperty'] =  $dir . '/LiteSemanticsEntity.class.php' ;
$wgAutoloadClasses[ 'LiteSemanticsAttribute'] =  $dir . '/LiteSemanticsEntity.class.php' ;
$wgAutoloadClasses[ 'LiteSemanticsData'] =  $dir . '/LiteSemanticsEntity.class.php' ;
$wgAutoloadClasses[ 'LiteSemanticsDocument'] =  $dir . '/LiteSemanticsEntity.class.php' ;

$wgAutoloadClasses[ 'LiteSemanticsParser'] =  $dir . '/LiteSemanticsParser.class.php' ;

$wgAutoloadClasses[ 'LiteSemanticsModel'] =  $dir . '/LiteSemanticsModel.class.php' ;

$wgAutoloadClasses[ 'LiteSemanticsHooks'] =  $dir . '/LiteSemanticsHooks.class.php' ;

/**
 * hooks
 */
$app->registerHook( 'InternalParseBeforeLinks', 'LiteSemanticsHooks', 'onInternalParseBeforeLinks' );
$app->registerHook( 'SanitizerTagsLists', 'LiteSemanticsHooks', 'onSanitizerTagsLists' );
$app->registerHook( 'SanitizerAttributesSetup', 'LiteSemanticsHooks', 'onSanitizerAttributesSetup' );
$app->registerHook( 'ArticleDeleteComplete', 'LiteSemanticsHooks', 'onArticleDeleteComplete' );
$app->registerHook( 'ArticleSaveComplete', 'LiteSemanticsHooks', 'onArticleSaveComplete' );

//test
$app->registerHook( 'LiteSemanticsRenderData', 'LiteSemanticsHooks', 'onLiteSemanticsRenderData' );