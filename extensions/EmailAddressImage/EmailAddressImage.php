<?php
if ( ! defined( 'MEDIAWIKI' ) )
	die();
/**
 * Allows the use of tag <email>foo@domain.com</email> which will result in
 * inline insertion of an image with the text foo@domain.com
 *
 * @file
 * @ingroup Extensions
 *
 * @author Maarten van Dantzich (http://www.mediawiki.org/wiki/User:Thinkling)
 * @comment email address regexp pattern borrowed from: http://www.regular-expressions.info/email.html
 */

$wgExtensionCredits['other'][] = array(
	'path'           => __FILE__,
	'name'           => 'EmailAddressImage',
	'version'        => '1.1',
	'author'         => 'Maarten van Dantzich',
	'descriptionmsg' => 'emailaddressimage-desc',
	'url'            => 'https://www.mediawiki.org/wiki/Extension:EmailAddressImage',
);

$wgExtensionMessagesFiles['AdvancedRandom'] = dirname(__FILE__) . '/EmailAddressImage.i18n.php';
$wgHooks['ParserFirstCallInit'][] = 'emailAddressImage';

function emailAddressImage( $parser ) {
	$parser->setHook( 'email', 'doAddressImage' );
	return true;
}

function doAddressImage( $input, $argv ) {
	$email_pattern = '/\b[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}\b/';

	$found = preg_match($email_pattern, $input, $matches);

	$addr = ( empty( $found ) ? '[INVALID EMAIL ADDR]' : $matches[0] );

	global $wgScriptPath; // wiki's root path, defined in LocalSettings

	return "<img src='" . $wgScriptPath
	. "/extensions/EmailAddressImage/EmailAddressImage-generator.php?str="
	. $addr
	. "' style='vertical-align: text-top;'>";
}
