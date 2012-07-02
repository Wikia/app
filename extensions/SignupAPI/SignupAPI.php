<?php
/**
 * Setup for SignupAPI extension, a special page that cleans up SpecialUserLogin
 * from signup related stuff, adds an API for signup, adds sourcetracking for
 *account creation & AJAX-ifies the signup form
 *
 * @file
 * @ingroup Extensions
 * @author Akshay Agarwal, akshayagarwal.in
 * @copyright © 2011 Akshay Agarwal
 * @licence GNU General Public Licence 2.0 or later
 */

if( !defined( 'MEDIAWIKI' ) ) {
	echo( "This file is an extension to the MediaWiki software and cannot be used standalone.\n" );
	die( 1 );
}

$wgExtensionCredits['specialpage'][] = array(
	'path' => __FILE__,
	'name' => 'SignupAPI',
	'version' => 1.0,
	'author' => 'Akshay Agarwal',
	'url' => 'https://www.mediawiki.org/wiki/Extension:SignupAPI',
	'descriptionmsg' => 'signupapi-desc',
);

$wgSignupAPIUseAjax = true;
$wgSignupAPISourceTracking = true;

# Includes

$dir = dirname(__FILE__);
$wgExtensionMessagesFiles['SignupAPI'] = $dir . '/SignupAPI.i18n.php';
$wgAutoloadClasses['SignupAPIHooks'] = $dir . '/includes/SignupAPI.hooks.php';

// Special page class
$wgSpecialPages['UserSignup'] = 'SpecialUserSignup';
$wgSpecialPageGroups['UserSignup'] = 'login';
$wgAutoloadClasses['SpecialUserSignup'] = $dir . '/includes/SpecialUserSignup.php';

// Apis
$wgAPIModules['signup'] = 'ApiSignup';
$wgAutoloadClasses['ApiSignup'] = $dir . '/includes/ApiSignup.php';

$wgAPIModules['validatesignup'] = 'ApiValidateSignup';
$wgAutoloadClasses['ApiValidateSignup']= $dir . '/includes/ApiValidateSignup.php';

# Modules

$wgResourceModules['ext.SignupAPI'] = array(
	'scripts' => 'includes/verification.js',
	'messages' => array(
		'signupapi-ok',
		'signupapi-noname',
		'signupapi-userexists',
		'signupapi-enterpassword',
		'signupapi-passwordtooshort',
		'signupapi-weak',
		'signupapi-medium',
		'signupapi-strong',
		'signupapi-badretype',
		'signupapi-passwordsmatch',
		'signupapi-invalidemailaddress',
	),
	'dependencies' => array( 'jquery.ui.progressbar' ),
	'localBasePath' => dirname( __FILE__ ),
	'remoteExtPath' => 'SignupAPI'
);

# Hooks

if ( $wgSignupAPISourceTracking ) {

	// Schema updates for update.php
	$wgHooks['LoadExtensionSchemaUpdates'][] = 'SignupAPIHooks::onSourceTracking';

	// Add source tracking to personal URL's
	$wgHooks['PersonalUrls'][] = 'SignupAPIHooks::addSourceTracking';
}




