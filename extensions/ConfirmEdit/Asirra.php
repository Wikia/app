<?php
/**
 * Asirra CAPTCHA module for the ConfirmEdit MediaWiki extension.
 * @author Bachsau
 * @author Niklas Laxström
 *
 * Makes use of the Asirra (Animal Species Image Recognition for
 * Restricting Access) CAPTCHA service, developed by John Douceur, Jeremy
 * Elson and Jon Howell at Microsoft Research.
 *
 * Asirra uses a large set of images from http://petfinder.com.
 *
 * For more information about Asirra, see:
 * http://research.microsoft.com/en-us/um/redmond/projects/asirra/
 *
 * This MediaWiki code is released into the public domain, without any
 * warranty. YOU CAN DO WITH IT WHATEVER YOU LIKE!
 *
 * @file
 * @ingroup Extensions
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	exit;
}

$dir = dirname( __FILE__ ) . '/';
require_once( "$dir/ConfirmEdit.php" );
$dir = dirname( __FILE__ ) . '/';

$wgCaptchaClass = 'Asirra';
$wgExtensionMessagesFiles['Asirra'] = "$dir/Asirra.i18n.php";
$wgAutoloadClasses['Asirra'] = "$dir/Asirra.class.php";

$wgResourceModules['ext.confirmedit.asirra'] = array(
	'localBasePath' => $dir,
	'remoteExtPath' => 'ConfirmEdit',
	'scripts' => 'ext.confirmedit.asirra.js',
	'messages' => array(
		'asirra-failed',
	),
);

