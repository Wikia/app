<?php
/**
 * ControlCenter
 *
 * @author Hyun Lim
 *
 */

$dir = dirname(__FILE__) . '/';

//classes
F::build('App')->registerClass('ControlCenterSpecialPageController', $dir . 'ControlCenterSpecialPageController.class.php');

// i18n mapping
$wgExtensionMessagesFiles['ControlCenter'] = $dir . 'ControlCenter.i18n.php';

// special pages
F::build('App')->registerSpecialPage('ControlCenter', 'ControlCenterSpecialPageController');