<?php
/**
 * WikiaSignup
 *
 * @author Hyun Lim, Saipetch Kongkatong
 *
 */
$dir = dirname(__FILE__) . '/';
$app = F::app();
//classes
$app->registerClass('WikiaSignupSpecialController', $dir . 'WikiaSignupSpecialController.class.php');

// i18n mapping
$wgExtensionMessagesFiles['WikiaSignup'] = $dir . 'WikiaSignup.i18n.php';

// special pages
$app->registerSpecialPage('WikiaSignup', 'WikiaSignupSpecialController');
