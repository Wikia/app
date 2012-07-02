<?php
/**
 * Setup for ContactPage extension, a special page that implements a contact form
 * for use by anonymous visitors.
 *
 * @file
 * @ingroup Extensions
 * @author Daniel Kinzler, brightbyte.de
 * @copyright © 2007 Daniel Kinzler
 * @licence GNU General Public Licence 2.0 or later
 */

if( !defined( 'MEDIAWIKI' ) ) {
	echo( "This file is an extension to the MediaWiki software and cannot be used standalone.\n" );
	die( 1 );
}

// Extension credits that will show up on Special:Version
$wgExtensionCredits['specialpage'][] = array(
	'path' => __FILE__,
	'name' => 'ContactPage',
	'author' => 'Daniel Kinzler',
	'url' => 'https://www.mediawiki.org/wiki/Extension:ContactPage',
	'descriptionmsg' => 'contactpage-desc',
);

// Set up the new special page
$dir = dirname( __FILE__ ) . '/';
$wgExtensionMessagesFiles['ContactPage'] = $dir . 'ContactPage.i18n.php';
$wgExtensionMessagesFiles['ContactPageAliases'] = $dir . 'ContactPage.alias.php';

$wgAutoloadClasses['SpecialContact'] = $dir . 'ContactPage_body.php';
$wgSpecialPages['Contact'] = 'SpecialContact';

# Configuration
// Name of a registered wiki user who will receive the mails
$wgContactUser = null;
// E-mail address used as the sender of the contact email, if the visitor does
// not supply an email address. Defaults to $wgEmergencyContact.
$wgContactSender = null;

// The name to be used with $wgContactSender.
// This will be shown in the recipient's e-mail program
$wgContactSenderName = 'Contact Form on ' . $wgSitename;

// If true, users will be required to supply a name and an e-mail address
// on Special:Contact.
$wgContactRequireAll = false;

// If true, the form will include a checkbox offering to put the IP address of the submitter in the subject line
$wgContactIncludeIP = false;
