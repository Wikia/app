<?php
/**
 * Adds wikitext syntax highlighting in source editor
 *
 * @package Wikia\extensions\EditorSyntaxHighlighting
 * @author Kamil Koterba <kamil@wikia-inc.com>
 */

/**
 * Load classes
 */
$wgAutoloadClasses['Wikia\EditorSyntaxHighlighting\EditorSyntaxHighlightingRegisterHooks'] =  __DIR__ . '/EditorSyntaxHighlightingRegister.hooks.php' ;
$wgAutoloadClasses['Wikia\EditorSyntaxHighlighting\EditorSyntaxHighlightingHooks'] =  __DIR__ . '/EditorSyntaxHighlighting.hooks.php' ;

/**
 * Register hooks
 */
$wgExtensionFunctions[] = 'Wikia\EditorSyntaxHighlighting\EditorSyntaxHighlightingRegisterHooks::registerHooks';
