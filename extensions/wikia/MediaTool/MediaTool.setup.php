<?php
/**
 * MediaTool setup
 *
 * @author mech, Piotr Bablok
 *
 */ 
$dir = dirname(__FILE__) . '/';
$app = F::app();
//classes
$app->registerClass('MediaToolHelper', $dir . 'MediaToolHelper.class.php');
$app->registerClass('MediaToolHooksHelper', $dir . 'MediaToolHooksHelper.class.php');
$app->registerClass('MediaToolController', $dir . 'MediaToolController.class.php');

// hooks
$app->registerHook('EditPageLayoutExecute', 'MediaToolHooksHelper', 'onEditPageLayoutExecute');
$app->registerHook('EditPage::showEditForm:initial2', 'MediaToolHooksHelper', 'onShowEditFormInitial2');

// i18n mapping
$wgExtensionMessagesFiles['MediaTool'] = $dir . 'MediaTool.i18n.php';
F::build('JSMessages')->registerPackage('MediaTool', array('mediatool-*'));
