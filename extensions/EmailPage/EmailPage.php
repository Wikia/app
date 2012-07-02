<?php
/**
 * EmailPage extension - Send rendered HTML page to an email address or list of addresses using
 *                       the phpmailer class from http://phpmailer.sourceforge.net/
 *
 * See http://www.mediawiki.org/wiki/Extension:EmailPage for installation and usage details
 *
 * @file
 * @ingroup Extensions
 * @author Aran Dunkley [http://www.organicdesign.co.nz/nad User:Nad]
 * @copyright © 2007 Aran Dunkley
 * @licence GNU General Public Licence 2.0 or later
 */
if( !defined( 'MEDIAWIKI' ) ) die( "Not an entry point." );

define( 'EMAILPAGE_VERSION', "2.1.2, 2010-11-01" );

$wgEmailPageGroup           = "sysop";               # Users must belong to this group to send emails (empty string means anyone can send)
$wgEmailPageCss             = false;                 # A minimal CSS page to embed in the email (eg. monobook/main.css without portlets, actions etc)
$wgEmailPageAllowRemoteAddr = array( "127.0.0.1" );  # Allow anonymous sending from these addresses
$wgEmailPageAllowAllUsers   = false;                 # Whether to allow sending to all users (the "user" group)
$wgEmailPageToolboxLink     = true;                  # Add a link to the sidebar toolbox?
$wgEmailPageActionLink      = true;                  # Add a link to the actions links?
$wgEmailPageSepPattern      = "|[\\x00-\\x20,;*]+|"; # Regular expression for splitting emails
if( $wgEmailPageGroup ) $wgGroupPermissions['sysop'][$wgEmailPageGroup] = true;

if( isset( $_SERVER['SERVER_ADDR'] ) ) $wgEmailPageAllowRemoteAddr[] = $_SERVER['SERVER_ADDR'];

$dir = dirname( __FILE__ );
$wgAutoloadClasses['SpecialEmailPage'] = "$dir/EmailPage_body.php";
$wgExtensionMessagesFiles['E-mailPage'] = "$dir/EmailPage.i18n.php";
$wgExtensionMessagesFiles['E-mailPageAlias']  = "$dir/EmailPage.alias.php";
$wgSpecialPages['E-mailPage']           = "SpecialEmailPage";

$wgExtensionCredits['specialpage'][] = array(
	'path'           => __FILE__,
	'name'           => "EmailPage",
	'author'         => "[http://www.organicdesign.co.nz/nad User:Nad]",
	'descriptionmsg' => "ea-desc",
	'url'            => "http://www.mediawiki.org/wiki/Extension:EmailPage",
	'version'        => EMAILPAGE_VERSION
);

# If form has been posted, include the phpmailer class
if( isset( $_REQUEST['ea-send'] ) ) {
	if( $files = glob( "$dir/*/class.phpmailer.php" ) ) require_once( $files[0] );
	else die( "PHPMailer class not found!" );
}

# Add toolbox and action links
if( $wgEmailPageToolboxLink ) $wgHooks['SkinTemplateToolboxEnd'][] = 'wfEmailPageToolboxLink';
if( $wgEmailPageActionLink )  {
	$wgHooks['SkinTemplateTabs'][] = 'wfEmailPageActionLink';
	$wgHooks['SkinTemplateNavigation'][] = 'wfEmailPageActionLinkVector';
}

function wfEmailPageToolboxLink() {
	global $wgTitle, $wgUser, $wgEmailPageGroup;
	if ( is_object( $wgTitle ) && ( empty( $wgEmailPageGroup ) || in_array( $wgEmailPageGroup, $wgUser->getEffectiveGroups() ) ) ) {
		$url = htmlspecialchars( SpecialPage::getTitleFor( 'E-mailPage' )->getLocalURL( array( 'ea-title' => $wgTitle->getPrefixedText() ) ) );
		echo( "<li><a href=\"$url\">" . wfMsg( 'e-mailpage' ) . "</a></li>" );
	}
	return true;
}

function wfEmailPageActionLink( $skin, &$actions ) {
	global $wgTitle, $wgUser, $wgEmailPageGroup;
	if( is_object( $wgTitle ) && ( empty( $wgEmailPageGroup ) || in_array( $wgEmailPageGroup, $wgUser->getEffectiveGroups() ) ) ) {
		$url = SpecialPage::getTitleFor( 'E-mailPage' )->getLocalURL( array( 'ea-title' => $wgTitle->getPrefixedText() ) );
		$actions['email'] = array( 'text' => wfMsg( 'email' ), 'class' => false, 'href' => $url );
	}
	return true;
}

function wfEmailPageActionLinkVector( $skin, &$actions ) {
	global $wgTitle, $wgUser, $wgEmailPageGroup;
	if( is_object( $wgTitle ) && ( empty( $wgEmailPageGroup ) || in_array( $wgEmailPageGroup, $wgUser->getEffectiveGroups() ) ) ) {
		$url = SpecialPage::getTitleFor( 'E-mailPage' )->getLocalURL( array( 'ea-title' => $wgTitle->getPrefixedText() ) );
		$actions['views']['email'] = array( 'text' => wfMsg( 'email' ), 'class' => false, 'href' => $url );
	}
	return true;
}
