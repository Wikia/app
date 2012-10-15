<?php
/**
 * CustomUserSignup extension -- allows for customizable messages during the
 * account creation process
 *
 * @file
 * @ingroup Extensions
 * @version 0.1.0
 * @author Nimish Gautam
 * @link http://www.mediawiki.org/wiki/Extension:CustomUserSignup Documentation
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	die( 'This is not a valid entry point to MediaWiki.' );
}

// Extension credits that will show up on Special:Version
$wgExtensionCredits['other'][] = array(
	'path' => __FILE__,
	'name' => 'CustomUserSignup',
	'author' => 'Nimish Gautam',
	'version' => '0.1.0',
	'descriptionmsg' => 'customusersignup-desc',
	'url' => 'https://www.mediawiki.org/wiki/Extension:CustomUserSignup'
);

// Autoloading
$dir = dirname( __FILE__ ) . '/';
$wgAutoloadClasses['CustomUserSignupHooks'] = $dir . 'CustomUserSignup.hooks.php';
$wgAutoloadClasses['CustomUserloginTemplate'] = $dir . 'CustomUserTemplate.php';
$wgAutoloadClasses['CustomUsercreateTemplate'] = $dir . 'CustomUserTemplate.php';
$wgExtensionMessagesFiles['CustomUserSignup'] = $dir . 'CustomUserSignup.i18n.php';

// Hooks
$wgHooks['UserCreateForm'][] = 'CustomUserSignupHooks::userCreateForm';
$wgHooks['UserLoginForm'][] = 'CustomUserSignupHooks::userCreateForm';
$wgHooks['BeforeWelcomeCreation'][] = 'CustomUserSignupHooks::welcomeScreen';

// NOTE: This hook includes JS for the account creation project
$wgHooks['BeforePageDisplay'][] = 'CustomUserSignupHooks::beforePageDisplay';
$wgHooks['AddNewAccount'][] = 'CustomUserSignupHooks::addNewAccount';


$wgCustomUserSignupVersion = 1;
$wgCustomUserSignupSetBuckets = true;
// For Account Creation Project
ClickTrackingHooks::addCampaign($dir. 'modules', 'CustomUserSignup/modules', 'AccountCreationUserBucket' );

