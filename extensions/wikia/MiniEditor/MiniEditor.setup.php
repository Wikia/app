<?php
/**
 * MiniEditor - A miniature editor
 * 
 * Most of this extension is dynamic / javascript.  We do need some messages from other extensions.
 *
 * @author Owen Davis, Liz Lee, Kyle Florence
 *
 */

$wgExtensionCredits['specialpage'][] = array(
	'name' => 'MiniEditor',
	'author' => array( 'Liz Lee', 'Kyle Florence', 'Owen Davis' ),
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/MiniEditor',
	'descriptionmsg' => 'minieditor-desc'
);

$dir = dirname(__FILE__) . '/';

/**
 * Controllers
 */
$wgAutoloadClasses['MiniEditorController'] =  $dir . '/MiniEditorController.class.php';
$wgAutoloadClasses['MiniEditorHelper'] =  $dir . '/MiniEditorHelper.class.php';
$wgAutoloadClasses['MiniEditorSpecialController'] =  $dir . 'MiniEditorSpecialController.class.php';

/**
 * Special page
 */
$wgSpecialPages['MiniEditorDemo'] = 'MiniEditorSpecialController';

/**
 * Message files
 */
$wgExtensionMessagesFiles['MiniEditor'] = $dir . 'MiniEditor.i18n.php';