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
$app->registerClass( 'LiteSemanticsCollection', $dir . '/LiteSemanticsCollection.class.php' );
$app->registerClass( 'LiteSemanticsHashCollection', $dir . '/LiteSemanticsCollection.class.php' );
$app->registerClass( 'LiteSemanticsListCollection', $dir . '/LiteSemanticsCollection.class.php' );

$app->registerClass( 'LiteSemanticsEntity', $dir . '/LiteSemanticsEntity.class.php' );
$app->registerClass( 'LiteSemanticsProperty', $dir . '/LiteSemanticsEntity.class.php' );
$app->registerClass( 'LiteSemanticsAttribute', $dir . '/LiteSemanticsEntity.class.php' );
$app->registerClass( 'LiteSemanticsData', $dir . '/LiteSemanticsEntity.class.php' );
$app->registerClass( 'LiteSemanticsDocument', $dir . '/LiteSemanticsEntity.class.php' );

$app->registerClass( 'LiteSemanticsParser', $dir . '/LiteSemanticsParser.class.php' );

$app->registerClass( 'LiteSemanticsModel', $dir . '/LiteSemanticsModel.class.php' );

$app->registerClass( 'LiteSemanticsHooks', $dir . '/LiteSemanticsHooks.class.php' );

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