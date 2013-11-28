<?php
/**
 * WikiaMobile Editor enhancements
 *
 * @author Bartek <Bart(at)wikia-inc.com>
 *
 */

$dir = dirname(__FILE__) . '/';

/**
 * classes
 */
$wgAutoloadClasses[ 'WikiaMobileEditorController' ] = $dir . 'WikiaMobileEditorController.class.php';

/**
 * hooks
 */
$wgHooks[ 'WikiaMobileAssetsPackages' ][] = 'WikiaMobileEditorController::onWikiaMobileAssetsPackages';
$wgHooks[ 'EditPage::showEditForm:initial' ][] = 'WikiaMobileEditorController::onEditPageInitial';
$wgHooks[ 'ArticleSaveComplete' ][] = 'WikiaMobileEditorController::onArticleSaveComplete';

/**
 * message files
 */
$wgExtensionMessagesFiles[ 'WikiaMobileEditor' ] = $dir . 'WikiaMobileEditor.i18n.php';

JSMessages::registerPackage( 'wikiamobileeditor', [
	'wikiamobileeditor-on-new',
	'wikiamobileeditor-wrong',
	'wikiamobileeditor-internet',
	'wikiamobileeditor-saving'
] );

JSMessages::registerPackage( 'wikiamobileeditor_on_save', [
	'wikiamobileeditor-on-success'
] );
