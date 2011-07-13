<?php
/**
 * HuluVideoPanel
 *
 * @author William Lee
 *
 */

$dir = dirname(__FILE__) . '/';
$app = F::app();
//classes
$app->registerClass('HuluVideoPanelSpecialPageController', $dir . 'HuluVideoPanelSpecialPageController.class.php');

// i18n mapping
$wgExtensionMessagesFiles['HuluVideoPanel'] = $dir . 'HuluVideoPanel.i18n.php';

// special pages
$app->registerSpecialPage('HuluVideoPanel', 'HuluVideoPanelSpecialPageController');