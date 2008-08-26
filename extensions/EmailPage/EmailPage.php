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

if (!defined('MEDIAWIKI')) die('Not an entry point.');

define('EMAILPAGE_VERSION', '1.2.0, 2008-07-13');

$wgEmailPageGroup           = 'sysop';            # Users must belong to this group to send emails (empty string means anyone can send)
$wgEmailPageContactsCat     = '';                 # This specifies the name of a category containing categories of contact pages
$wgEmailPageCss             = 'EmailPage.css';    # A minimal CSS page to embed in the email (eg. monobook/main.css without portlets, actions etc)
$wgEmailPageAllowRemoteAddr = array($_SERVER['SERVER_ADDR'],'127.0.0.1'); # Allow anonymous sending from these addresses
$wgEmailPageAllowAllUsers   = false;              # Whether to allow sending to all users (the "user" group)
$wgEmailPageToolboxLink     = 'Send to email';    # Link title for toolbox link (set to "" to not have any link in toolbox)
$wgEmailPageActionLink      = 'email';            # Link title for action link (set to "" to not have any action link)
$wgPhpMailerClass              = dirname(__FILE__).'/phpMailer_v2.1.0beta2/class.phpmailer.php'; # From http://phpmailer.sourceforge.net/

if ($wgEmailPageGroup) $wgGroupPermissions['sysop'][$wgEmailPageGroup] = true;

$dir = dirname(__FILE__) . '/';
$wgAutoloadClasses['SpecialEmailPage'] = $dir . 'EmailPage_body.php';
$wgExtensionMessagesFiles['EmailPage'] = $dir . 'EmailPage.i18n.php';
$wgExtensionAliasesFiles['EmailPage'] = $dir . 'EmailPage.alias.php';
$wgSpecialPages['EmailPages'] = 'SpecialEmailPage';

$wgExtensionCredits['specialpage'][] = array(
	'name'           => 'Special:EmailPages',
	'author'         => '[http://www.organicdesign.co.nz/nad User:Nad]',
	'description'    => 'Send rendered HTML page to an email address or list of addresses using [http://phpmailer.sourceforge.net phpmailer].',
	'descriptionmsg' => 'ea-desc',
	'url'            => 'http://www.mediawiki.org/wiki/Extension:EmailPage',
	'version'        => EMAILPAGE_VERSION
);

# If form has been posted, include the phpmailer class
if (isset($_REQUEST['ea-send'])) require_once($wgPhpMailerClass);

# Add toolbox and action links
if ($wgEmailPageToolboxLink) {
	$wgHooks['MonoBookTemplateToolboxEnd'][] = 'wfEmailPageToolboxLink';
}

if ($wgEmailPageActionLink) {
	$wgHooks['SkinTemplateTabs'][] = 'wfEmailPageActionLink';
}

function wfEmailPageToolboxLink() {
	global $wgEmailPageToolboxLink, $wgTitle, $wgUser, $wgEmailPageGroup;
	if (is_object($wgTitle) && (empty($wgEmailPageGroup) || in_array($wgEmailPageGroup, $wgUser->getEffectiveGroups()))) {
		$url = Title::makeTitle(NS_SPECIAL, 'EmailPages')->getLocalURL('ea-title='.$wgTitle->getPrefixedText());
		echo("<li><a href=\"$url\">$wgEmailPageToolboxLink</li>");
		}
	return true;
}

function wfEmailPageActionLink(&$skin, &$actions) {
	global $wgEmailPageActionLink, $wgTitle, $wgUser, $wgEmailPageGroup;
	if (is_object($wgTitle) && (empty($wgEmailPageGroup) || in_array($wgEmailPageGroup, $wgUser->getEffectiveGroups()))) {
		$url = Title::makeTitle(NS_SPECIAL, 'EmailPage')->getLocalURL('ea-title='.$wgTitle->getPrefixedText());
		$actions['email'] = array('text' => $wgEmailPageActionLink, 'class' => false, 'href' => $url);
	}
	return true;
}
