<?php
/**
 * UserLogin
 *
 * @author Hyun Lim, Saipetch Kongkatong
 *
 */

$wgExtensionCredits['specialpage'][] = array(
	'name' => 'UserLogin',
);
 
$dir = dirname(__FILE__) . '/';
$app = F::app();
//classes
$app->registerClass('FacebookButtonController', $dir . 'FacebookButtonController.class.php');
$app->registerClass('FacebookSignupController', $dir . 'FacebookSignupController.class.php');
$app->registerClass('UserLoginSpecialController', $dir . 'UserLoginSpecialController.class.php');
$app->registerClass('UserSignupSpecialController', $dir . 'UserSignupSpecialController.class.php');
$app->registerClass('WikiaConfirmEmailSpecialController', $dir . 'WikiaConfirmEmailSpecialController.class.php');
$app->registerClass('UserLoginController', $dir . 'UserLoginController.class.php');
$app->registerClass('UserLoginHelper', $dir . 'UserLoginHelper.class.php');
$app->registerClass('TempUser', $dir . 'TempUser.class.php');
$app->registerClass('UserLoginForm', $dir . 'UserLoginForm.class.php');
$app->registerClass('UserLoginFacebookForm', $dir . 'UserLoginFacebookForm.class.php');

// hooks
$app->registerHook('MakeGlobalVariablesScript', 'UserLoginHelper', 'onMakeGlobalVariablesScript');

// i18n mapping
$wgExtensionMessagesFiles['UserLogin'] = $dir . 'UserLogin.i18n.php';
$wgExtensionMessagesFiles['UserSignup'] = $dir . 'UserSignup.i18n.php';
$wgExtensionMessagesFiles['WikiaConfirmEmail'] = $dir . 'WikiaConfirmEmail.i18n.php';

// special pages
$app->registerSpecialPage('Userlogin', 'UserLoginSpecialController');
$app->registerSpecialPage('UserSignup', 'UserSignupSpecialController');
$app->registerSpecialPage('WikiaConfirmEmail', 'WikiaConfirmEmailSpecialController');

// redirects from userlogin to UserLogin
$wgSpecialPages['Signup'] = array( 'SpecialRedirectToSpecial', 'Signup', 'UserLogin', '', array('returnto') );
