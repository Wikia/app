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
	'url' => 'http://www.wikia.com',
	'descriptionmsg' => 'minieditor-desc'
);

$dir = dirname(__FILE__) . '/';
$app = F::app();

/**
 * Controllers
 */
$app->registerClass('MiniEditorController', $dir . '/MiniEditorController.class.php');
$app->registerClass('MiniEditorHelper', $dir . '/MiniEditorHelper.class.php');
$app->registerClass('MiniEditorSpecialController', $dir . 'MiniEditorSpecialController.class.php');

/**
 * Special page
 */
$app->registerSpecialPage('MiniEditorDemo', 'MiniEditorSpecialController');

/**
 * Message files
 */
$app->registerExtensionMessageFile('MiniEditor', $dir . 'MiniEditor.i18n.php');

/**
 * Permissions
 */
$wgAvailableRights[] = 'minieditor-specialpage';
$wgGroupPermissions['*']['minieditor-specialpage'] = false;
$wgGroupPermissions['staff']['minieditor-specialpage'] = true;