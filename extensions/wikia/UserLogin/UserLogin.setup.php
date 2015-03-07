<?php
/**
 * UserLogin
 *
 * @author Hyun Lim, Saipetch Kongkatong
 *
 */

$wgExtensionCredits['specialpage'][] = array(
	'name' => 'UserLogin',
	'author' => array('Hyun Lim', 'Saipetch Kongkatong'),
	'descriptionmsg' => 'userlogin-desc',
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/UserLogin'
);

$dir = dirname(__FILE__) . '/';

//classes
$wgAutoloadClasses['FacebookButtonController'] =  $dir . 'FacebookButtonController.class.php';
$wgAutoloadClasses['FacebookSignupController'] =  $dir . 'FacebookSignupController.class.php';
$wgAutoloadClasses['UserLoginSpecialController'] =  $dir . 'UserLoginSpecialController.class.php';
$wgAutoloadClasses['UserSignupSpecialController'] =  $dir . 'UserSignupSpecialController.class.php';
$wgAutoloadClasses['WikiaConfirmEmailSpecialController'] =  $dir . 'WikiaConfirmEmailSpecialController.class.php';
$wgAutoloadClasses['UserLoginController'] =  $dir . 'UserLoginController.class.php';
$wgAutoloadClasses['UserLoginHelper'] =  $dir . 'UserLoginHelper.class.php';
$wgAutoloadClasses['UserLoginForm'] =  $dir . 'UserLoginForm.class.php';
$wgAutoloadClasses['UserLoginFacebookForm'] =  $dir . 'UserLoginFacebookForm.class.php';
$wgAutoloadClasses['UserLoginHooksHelper'] =  $dir . 'UserLoginHooksHelper.class.php';

// hooks
$wgHooks['MakeGlobalVariablesScript'][] = 'UserLoginHooksHelper::onMakeGlobalVariablesScript';
$wgHooks['Preferences::SetUserEmail'][] = 'UserLoginHooksHelper::onSetUserEmail';
$wgHooks['UserSendReConfirmationMail'][] = 'UserLoginHooksHelper::onUserSendReConfirmationMail';
$wgHooks['AbortNewAccountErrorMessage'][] = 'UserLoginHooksHelper::onAbortNewAccountErrorMessage';
$wgHooks['ConfirmEmailShowRequestForm'][] = 'UserLoginHooksHelper::onConfirmEmailShowRequestForm';
$wgHooks['UserSendConfirmationMail'][] = 'UserLoginHooksHelper::onUserSendConfirmationMail';
$wgHooks['PreferencesGetEmailAuthentication'][] = 'UserLoginHooksHelper::onGetEmailAuthentication';
$wgHooks['isValidEmailAddr'][] = 'UserLoginHooksHelper::isValidEmailAddr';
$wgHooks['SavePreferences'][] = 'UserLoginHooksHelper::onSavePreferences';
$wgHooks['ConfirmEmailComplete'][] = 'UserLoginHooksHelper::onConfirmEmailComplete';
$wgHooks['WikiaMobileAssetsPackages'][] = 'UserLoginHooksHelper::onWikiaMobileAssetsPackages';
$wgHooks['AbortNewAccount'][] = 'UserLoginHooksHelper::onAbortNewAccount';
// Add the JavaScript messages to the output
$wgHooks['BeforePageDisplay'][] = "UserLoginHooksHelper::onBeforePageDisplay";


// i18n mapping
$wgExtensionMessagesFiles['UserLogin'] = $dir . 'UserLogin.i18n.php';
$wgExtensionMessagesFiles['UserSignup'] = $dir . 'UserSignup.i18n.php';
$wgExtensionMessagesFiles['UserSignupAliases'] = $dir . 'UserSignup.alias.php';
$wgExtensionMessagesFiles['WikiaConfirmEmail'] = $dir . 'WikiaConfirmEmail.i18n.php';

JSMessages::registerPackage('UserLogin', ['userlogin-login-*']);

/**
 * Use ResourceLoader to load the JavaScript module
 */
$wgResourceModules['ext.userLogin'] = [
	'localBasePath' => __DIR__ . '/scripts',
	'remoteExtPath' => 'wikia/UserLogin/js',
	'messages' => [
		'usersignup-error-password-length',
		'userlogin-error-wrongpasswordempty',
	],
];


// special pages
$wgSpecialPages['Userlogin'] = 'UserLoginSpecialController';
$wgSpecialPages['UserSignup'] = 'UserSignupSpecialController';
$wgSpecialPages['WikiaConfirmEmail'] = 'WikiaConfirmEmailSpecialController';
$wgSpecialPages['Signup'] = 'Signup';

// redirects from Signup to UserLogin or UserSignup
class Signup extends SpecialRedirectToSpecial {
	function __construct() {
		parent::__construct( 'Signup', 'UserLogin', false, array( 'returnto', 'type' ) );
	}
}
