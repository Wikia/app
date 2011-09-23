<?php
/**
 * WikiaLogin
 *
 * @author Hyun Lim, Saipetch Kongkatong
 *
 */
$dir = dirname(__FILE__) . '/';
$app = F::app();
//classes
$app->registerClass('WikiaLoginSpecialController', $dir . 'WikiaLoginSpecialController.class.php');

// i18n mapping
$wgExtensionMessagesFiles['WikiaLogin'] = $dir . 'WikiaLogin.i18n.php';

// special pages
$app->registerSpecialPage('WikiaLogin', 'WikiaLoginSpecialController');
