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


$wgAutoloadClasses['ReCaptcha'] = $dir . '/ReCaptcha.class.php';

$wgExtensionFunctions[] = 'efReCaptcha';

/**
 * Make sure the keys are defined.
 *
 * @throws Exception
 */
function efReCaptcha() {
	$wg = F::app()->wg;

	if ( $wg->ReCaptchaPublicKey == '' || $wg->ReCaptchaPrivateKey == '' ) {
		throw new Exception( wfMessage( 'recaptcha-misconfigured' )->escaped() );
	}
}
