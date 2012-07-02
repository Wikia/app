<?php
/**
 * SentenceEditor extension for the InlineEditor.
 *
 * @file
 * @ingroup Extensions
 *
 * This is the include file for the SentenceEditor.
 *
 * Usage: Include the following line in your LocalSettings.php
 * require_once( "$IP/extensions/InlineEditor/SentenceEditor/SentenceEditor.php" );
 *
 * @author Jan Paul Posma <jp.posma@gmail.com>
 * @license GPL v2 or later
 * @version 0.0.0
 */

if ( !defined( 'MEDIAWIKI' ) ) die();

// current directory including trailing slash
$dir = dirname( __FILE__ ) . '/';

// add autoload classes
$wgAutoloadClasses['SentenceEditor']         = $dir . 'SentenceEditor.class.php';
$wgAutoloadClasses['ISentenceDetection']     = $dir . 'SentenceDetection/ISentenceDetection.class.php';
$wgAutoloadClasses['SentenceDetectionBasic'] = $dir . 'SentenceDetection/SentenceDetectionBasic.class.php';

// register hooks
$wgHooks['InlineEditorMark'][]               = 'SentenceEditor::mark';

// default settings
$wgSentenceEditorDetectionDefault = 'SentenceDetectionBasic';
