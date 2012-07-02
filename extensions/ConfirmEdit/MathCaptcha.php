<?php

/**
 * Captcha class using simple sums and the math renderer
 * Not brilliant, but enough to dissuade casual spam bots
 *
 * @file
 * @ingroup Extensions
 * @author Rob Church <robchur@gmail.com>
 * @copyright © 2006 Rob Church
 * @licence GNU General Public Licence 2.0
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	exit;
}

require_once dirname( __FILE__ ) . '/ConfirmEdit.php';
$wgCaptchaClass = 'MathCaptcha';

$wgAutoloadClasses['MathCaptcha'] = dirname( __FILE__ ) . '/MathCaptcha.class.php';
