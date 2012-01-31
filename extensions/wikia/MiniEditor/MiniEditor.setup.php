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
	'name' => 'Mini Editor',
	'author' => array( 'Liz Lee', 'Kyle Florence', 'Owen Davis' ),
	'url' => 'http://www.wikia.com',
	'descriptionmsg' => 'minieditor-desc',
);

 
$wgSpecialPageGroups['MiniEditor'] = 'specialpages-group-other';


$dir = dirname(__FILE__) . '/';
$app = F::app();

/**
 * class
 */

$app->registerClass('MiniEditor', $dir . 'MiniEditor.class.php');

/**
 * controllers
 */
$app->registerClass('MiniEditorController', $dir . '/MiniEditorController.class.php');
$app->registerClass('MiniEditorHelper', $dir . '/MiniEditorHelper.class.php');
$app->registerClass('MiniEditorSpecialController', $dir . 'MiniEditorSpecialController.class.php');

/**
 * special pages
 */
$app->registerSpecialPage('MiniEditor', 'MiniEditorSpecialController');

/**
 * message files
 */
$app->registerExtensionMessageFile('MiniEditor', $dir . 'MiniEditor.i18n.php');


// MiniEditor depends on several other extensions so load those dependencies here

// add global JS variables for MiniEditor
$app->registerHook('MakeGlobalVariablesScript', 'MiniEditorHelper', 'makeGlobalVariablesScript');

