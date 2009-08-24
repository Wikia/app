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

$wgExtensionCredits['specialpage'][] = array(
	'name' => 'ContactPage',
	'svn-date' => '$LastChangedDate: 2009-01-11 12:16:13 +0000 (Sun, 11 Jan 2009) $',
	'svn-revision' => '$LastChangedRevision: 45666 $',
	'author' => 'Daniel Kinzler',
	'url' => 'http://www.mediawiki.org/wiki/Extension:ContactPage',
	'description' => 'Contact form for visitors',
	'descriptionmsg' => 'contactpage-desc',
);

$dir = dirname(__FILE__) . '/';
$wgExtensionMessagesFiles['ContactPage'] = $dir . 'ContactPage.i18n.php';
$wgExtensionAliasesFiles['ContactPage'] = $dir . 'ContactPage.alias.php';

$wgAutoloadClasses['SpecialContact'] = $dir . 'SpecialContact.php';
$wgSpecialPages['Contact'] = 'SpecialContact';

$wgContactUser = NULL;
$wgContactSender = NULL;
$wgContactSenderName = 'Contact Form on ' . $wgSitename;

$wgContactRequireAll = false;
