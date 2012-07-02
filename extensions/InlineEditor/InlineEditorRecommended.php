<?php
/**
 * InlineEditor extension, recommended include file.
 *
 * @file
 * @ingroup Extensions
 *
 * This is the recommended include file for the InlineEditor, which also loads a 
 * lot of editing detecting extensions that are part of the InlineEditor.
 *
 * Usage: Add this line to LocalSettings.php:
 * require_once( "$IP/extensions/InlineEditor/InlineEditorRecommended.php" );
 *
 * @author Jan Paul Posma <jp.posma@gmail.com>
 * @license GPL v2 or later
 * @version 0.0.0
 */
require_once( dirname(__FILE__) . "/InlineEditor.php" );
require_once( dirname(__FILE__) . "/SentenceEditor/SentenceEditor.php" );
require_once( dirname(__FILE__) . "/ListEditor/ListEditor.php" );
require_once( dirname(__FILE__) . "/ReferenceEditor/ReferenceEditor.php" );
require_once( dirname(__FILE__) . "/MediaEditor/MediaEditor.php" );
require_once( dirname(__FILE__) . "/TemplateEditor/TemplateEditor.php" );
require_once( dirname(__FILE__) . "/ParagraphEditor/ParagraphEditor.php" );
require_once( dirname(__FILE__) . "/SectionEditor/SectionEditor.php" );
