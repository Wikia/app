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
$app->registerClass('UserLoginHooksHelper', $dir . 'UserLoginHooksHelper.class.php');

// hooks
$app->registerHook('MakeGlobalVariablesScript', 'UserLoginHelper', 'onMakeGlobalVariablesScript');
$app->registerHook('Preferences::SetUserEmail', 'UserLoginHooksHelper', 'onSetUserEmail' );
$app->registerHook('UserSendReConfirmationMail', 'UserLoginHooksHelper', 'onUserSendReConfirmationMail' );
$app->registerHook('AbortNewAccountErrorMessage', 'UserLoginHooksHelper', 'onAbortNewAccountErrorMessage' );
$app->registerHook('MailPasswordTempUser', 'UserLoginHooksHelper', 'onMailPasswordTempUser' );
$app->registerHook('ConfirmEmailShowRequestForm', 'UserLoginHooksHelper', 'onConfirmEmailShowRequestForm' );
$app->registerHook('UserSendConfirmationMail', 'UserLoginHooksHelper', 'onUserSendConfirmationMail' );
$app->registerHook('PreferencesGetEmailAuthentication', 'UserLoginHooksHelper', 'onGetEmailAuthentication' );
$app->registerHook('isValidEmailAddr', 'UserLoginHooksHelper', 'isValidEmailAddr');
$app->registerHook('SavePreferences', 'UserLoginHooksHelper', 'onSavePreferences');

// i18n mapping
$wgExtensionMessagesFiles['UserLogin'] = $dir . 'UserLogin.i18n.php';
$wgExtensionMessagesFiles['UserSignup'] = $dir . 'UserSignup.i18n.php';
$wgExtensionMessagesFiles['WikiaConfirmEmail'] = $dir . 'WikiaConfirmEmail.i18n.php';

// special pages
$app->registerSpecialPage('Userlogin', 'UserLoginSpecialController');
$app->registerSpecialPage('UserSignup', 'UserSignupSpecialController');
$app->registerSpecialPage('WikiaConfirmEmail', 'WikiaConfirmEmailSpecialController');
$app->registerSpecialPage('Signup', 'Signup');

// redirects from Signup to UserLogin or UserSignup
class Signup extends SpecialRedirectToSpecial {
	function __construct() {
		parent::__construct( 'Signup', 'UserLogin', false, array( 'returnto', 'type' ) );
	}
}
