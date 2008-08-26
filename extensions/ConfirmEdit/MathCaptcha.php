<?php

/**
 * Captcha class using simple sums and the math renderer
 * Not brilliant, but enough to dissuade casual spam bots
 *
 * @addtogroup Extensions
 * @author Rob Church <robchur@gmail.com>
 * @copyright © 2006 Rob Church
 * @licence GNU General Public Licence 2.0
 */

if( !defined( 'MEDIAWIKI' ) ) {
	echo( "This file is an extension to the MediaWiki software and cannot be used standalone.\n" );
	die( 1 );
}
$wgAutoloadClasses['MathCaptcha'] = dirname( __FILE__ ) . '/MathCaptcha.class.php';

