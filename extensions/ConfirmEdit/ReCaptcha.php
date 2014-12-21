<?php

/**
 * Captcha class using the Google reCAPTCHA/noCAPTCHA
 *
 * @addtogroup Extensions
 * @author Andrzej 'nAndy' Łukaszewski <nandy@wikia-inc.com>
 * @copyright Copyright (c) 2014 reCAPTCHA -- http://recaptcha.net
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	exit;
}

require_once dirname( __FILE__ ) . '/ConfirmEdit.php';
$wgCaptchaClass = 'ReCaptcha';

$dir = dirname( __FILE__ );

$wgExtensionMessagesFiles['ReCaptcha'] = $dir . '/ReCaptcha.i18n.php';

$wgAutoloadClasses['ReCaptcha'] = $dir . '/ReCaptcha.class.php';

$wgHooks['BeforePageDisplay'][] = 'efReCaptchaOnBeforePageDisplay';

// Set these in LocalSettings.php
$wgReCaptchaPublicKey = '6Lduj_8SAAAAAMjr7vGPC7oODOjgwLi-EmU7NWwz'; // called site key on Google Recaptcha Admin site
$wgReCaptchaPrivateKey = '6Lduj_8SAAAAAAMTdBfXb90dTkWsiI8JUZafO3Ts'; // called secret key on Google Recaptcha Admin site
// For backwards compatibility
# $recaptcha_public_key = '';
# $recaptcha_private_key = '';

/**
 * Sets the theme for ReCaptcha
 *
 * See http://code.google.com/apis/recaptcha/docs/customization.html
 */
$wgReCaptchaTheme = 'white';

$wgExtensionFunctions[] = 'efReCaptcha';

/**
 * Make sure the keys are defined.
 */
function efReCaptcha() {
	global $wgReCaptchaPublicKey, $wgReCaptchaPrivateKey;
	global $recaptcha_public_key, $recaptcha_private_key;
	global $wgServer;

	// Backwards compatibility
	if ( $wgReCaptchaPublicKey == '' ) {
		$wgReCaptchaPublicKey = $recaptcha_public_key;
	}
	if ( $wgReCaptchaPrivateKey == '' ) {
		$wgReCaptchaPrivateKey = $recaptcha_private_key;
	}

	if ( $wgReCaptchaPublicKey == '' || $wgReCaptchaPrivateKey == '' ) {
		die ( 'You need to set $wgReCaptchaPrivateKey and $wgReCaptchaPublicKey in LocalSettings.php to ' .
				"use the reCAPTCHA plugin. You can sign up for a key <a href='" .
				htmlentities( recaptcha_get_signup_url ( str_replace( 'http://', '', $wgServer ), "mediawiki" ) ) . "'>here</a>." );
	}
}

function efReCaptchaOnBeforePageDisplay( OutputPage &$out, Skin &$skin ) {
	$out->addScript( '<script src="https://www.google.com/recaptcha/api.js" async defer></script>' );
	return true;
}
