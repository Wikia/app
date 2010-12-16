<?php
/**
 * EmailPage extension - Send rendered HTML page to an email address or list of addresses using phpmailer
 *
 * See http://www.mediawiki.org/wiki/Extension:EmailPage for installation and usage details
 *
 * @package MediaWiki
 * @subpackage Extensions
 * @author Aran Dunkley [http://www.organicdesign.co.nz/nad User:Nad]
 * @copyright © 2007 Aran Dunkley
 * @licence GNU General Public Licence 2.0 or later
 */

if ( !defined( 'MEDIAWIKI' ) ) die( 'Not an entry point.' );

define( 'EMAILPAGE_VERSION', '1.3.4, 2009-05-04' );

$wgEmailPageGroup           = 'sysop';              # Users must belong to this group to send emails (empty string means anyone can send)
$wgEmailPageContactsCat     = '';                   # This specifies the name of a category containing categories of contact pages
$wgEmailPageCss             = 'EmailPage.css';      # A minimal CSS page to embed in the email (eg. monobook/main.css without portlets, actions etc)
$wgEmailPageAllowRemoteAddr = array( '127.0.0.1' ); # Allow anonymous sending from these addresses
$wgEmailPageAllowAllUsers   = false;                # Whether to allow sending to all users (the "user" group)
$wgEmailPageToolboxLink     = true;                 # Add a link to the sidebar toolbox?
$wgEmailPageActionLink      = true;                 # Add a link to the actions links?
$wgPhpMailerClass           = dirname( __FILE__ ) . '/phpMailer_v2.1.0beta2/class.phpmailer.php'; # From http://phpmailer.sourceforge.net/

if ( $wgEmailPageGroup ) $wgGroupPermissions['sysop'][$wgEmailPageGroup] = true;

if ( isset( $_SERVER['SERVER_ADDR'] ) ) $wgEmailPageAllowRemoteAddr[] = $_SERVER['SERVER_ADDR'];

$dir = dirname( __FILE__ ) . '/';
$wgAutoloadClasses['SpecialEmailPage'] = $dir . 'EmailPage_body.php';
$wgExtensionMessagesFiles['EmailPage'] = $dir . 'EmailPage.i18n.php';
$wgExtensionAliasesFiles['EmailPage']  = $dir . 'EmailPage.alias.php';
$wgSpecialPages['EmailPage']           = 'SpecialEmailPage';

$wgExtensionCredits['specialpage'][] = array(
	'path'           => __FILE__,
	'name'           => 'EmailPage',
	'author'         => '[http://www.organicdesign.co.nz/nad User:Nad]',
	'description'    => 'Send rendered HTML page to an email address or list of addresses using [http://phpmailer.sourceforge.net phpmailer].',
	'descriptionmsg' => 'ea-desc',
	'url'            => 'http://www.mediawiki.org/wiki/Extension:EmailPage',
	'version'        => EMAILPAGE_VERSION
);

# If form has been posted, include the phpmailer class
if ( isset( $_REQUEST['ea-send'] ) ) require_once( $wgPhpMailerClass );

# Add toolbox and action links
if ( $wgEmailPageToolboxLink ) $wgHooks['SkinTemplateToolboxEnd'][] = 'wfEmailPageToolboxLink';
if ( $wgEmailPageActionLink )  $wgHooks['SkinTemplateTabs'][] = 'wfEmailPageActionLink';

function wfEmailPageToolboxLink() {
	global $wgTitle, $wgUser, $wgEmailPageGroup;
	if ( is_object( $wgTitle ) && ( empty($wgEmailPageGroup) || in_array( $wgEmailPageGroup, $wgUser->getEffectiveGroups() ) ) ) {
		$url = Title::makeTitle( NS_SPECIAL, 'EmailPage' )->getLocalURL( 'ea-title='.$wgTitle->getPrefixedText() );
		echo( "<li><a href=\"$url\">" . wfMsg( 'emailpage' ) . "</a></li>" );
	}
	return true;
}

function wfEmailPageActionLink( $skin, &$actions ) {
	global $wgTitle, $wgUser, $wgEmailPageGroup;
	if ( is_object( $wgTitle ) && ( empty( $wgEmailPageGroup ) || in_array( $wgEmailPageGroup, $wgUser->getEffectiveGroups() ) ) ) {
		$url = Title::makeTitle( NS_SPECIAL, 'EmailPage' )->getLocalURL('ea-title='.$wgTitle->getPrefixedText() );
		$actions['email'] = array( 'text' => wfMsg( 'email' ), 'class' => false, 'href' => $url );
	}
	return true;
}
