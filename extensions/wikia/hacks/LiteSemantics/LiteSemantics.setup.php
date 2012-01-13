<?php

/**
 * @author Jakub Kurcek <jakub at wikia-inc.com>
 * @date 2012-01-09
 * @copyright Copyright (C) 2010 Jakub Kurcek, Wikia Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

/**
 * @var WikiaApp
 */
$app = F::app();
$dir = dirname( __FILE__ );
$app->registerClass( 'LiteSemanticsHooks', $dir . '/LiteSemanticsHooks.class.php' );
$app->registerClass( 'LiteSemanticsParser', $dir . '/LiteSemantics.class.php' );
$app->registerClass( 'LiteSemanticsData', $dir . '/LiteSemantics.class.php' );
$app->registerClass( 'LiteSemanticsProperty', $dir . '/LiteSemantics.class.php' );
$app->registerClass( 'LiteSemanticsParserPattern', $dir . '/LiteSemantics.class.php' );

/**
 * hooks
 */
$app->registerHook( 'InternalParseBeforeLinks', 'LiteSemanticsHooks', 'onInternalParseBeforeLinks' );