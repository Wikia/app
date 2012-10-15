<?php
/**
 * ReferenceEditor extension for the InlineEditor.
 *
 * @file
 * @ingroup Extensions
 *
 * This is the include file for the ReferenceEditor.
 *
 * Usage: Include the following line in your LocalSettings.php
 * require_once( "$IP/extensions/InlineEditor/ReferenceEditor/ReferenceEditor.php" );
 *
 * @author Jan Paul Posma <jp.posma@gmail.com>
 * @license GPL v2 or later
 * @version 0.0.0
 */

if ( !defined( 'MEDIAWIKI' ) ) die();

// current directory including trailing slash
$dir = dirname( __FILE__ ) . '/';

// add autoload classes
$wgAutoloadClasses['ReferenceEditor']        = $dir . 'ReferenceEditor.class.php';

// register hooks
$wgHooks['InlineEditorMark'][]               = 'ReferenceEditor::mark';
