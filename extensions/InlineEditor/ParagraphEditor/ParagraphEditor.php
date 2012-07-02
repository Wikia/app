<?php
/**
 * ParagraphEditor extension for the InlineEditor.
 *
 * @file
 * @ingroup Extensions
 *
 * This is the include file for the ParagraphEditor.
 *
 * Usage: Include the following line in your LocalSettings.php
 * require_once( "$IP/extensions/InlineEditor/ParagraphEditor/ParagraphEditor.php" );
 *
 * @author Jan Paul Posma <jp.posma@gmail.com>
 * @license GPL v2 or later
 * @version 0.0.0
 */

if ( !defined( 'MEDIAWIKI' ) ) die();

// current directory including trailing slash
$dir = dirname( __FILE__ ) . '/';

// add autoload classes
$wgAutoloadClasses['ParagraphEditor']         = $dir . 'ParagraphEditor.class.php';

// register hooks
$wgHooks['InlineEditorMark'][]                = 'ParagraphEditor::mark';
