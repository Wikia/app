<?php
/**
 *
 * @package MediaWiki
 * @subpackage SpecialPage
 * @author Inez Korczyński (inez@wikia.com)
 *
 * Add 'wfRunHooks('ConfirmEmailComplete', array(&$user));' in SpecialConfirmemail.php at 86 line.
 */

if ( ! defined( 'MEDIAWIKI' ) ) {
	die();
}

# set function to call when loading extension
$dir = dirname( __FILE__ );
$wgAutoloadClasses["PrivateDomains"] = $dir . "/SpecialPrivateDomains_body.php";
$wgExtensionMessagesFiles["PrivateDomains"] = $dir . "/SpecialPrivateDomains.i18n.php";
$wgSpecialPages['PrivateDomains'] = array( 'SpecialPage', 'PrivateDomains', 'PrivateDomains' );
$wgSpecialPageGroups['PrivateDomains'] = 'wiki';

$wgHooks['AlternateEdit'][] = 'pd_AlternateEdit'; // Occurs whenever action=edit is called
$wgHooks['UserLoginComplete'][] = 'pd_UserLoginComplete'; // Occurs after a user has successfully logged in
$wgHooks['ConfirmEmailComplete'][] = 'pd_UserLoginComplete'; // Occurs after a user has successfully confirm email (not standard hook)

# set 'PrivateDomains' right to users in staff or bureaucrat group
$wgAvailableRights [] = 'PrivateDomains';
$wgGroupPermissions ['staff']['PrivateDomains'] = true;
$wgGroupPermissions ['bureaucrat']['PrivateDomains'] = true;

# overwrite standard groups permissions
$wgGroupPermissions['staff']['edit'] = true;
$wgGroupPermissions['bureaucrat']['edit'] = true;
$wgGroupPermissions['user']['edit'] = false;
$wgGroupPermissions['*']['edit'] = false;
$wgGroupPermissions['privatedomains']['edit'] = true;

$wgGroupPermissions['staff']['upload'] = true;
$wgGroupPermissions['bureaucrat']['upload'] = true;
$wgGroupPermissions['user']['upload'] = false;
$wgGroupPermissions['*']['upload'] = false;
$wgGroupPermissions['privatedomains']['upload'] = true;

$wgGroupPermissions['staff']['move'] = true;
$wgGroupPermissions['bureaucrat']['move'] = true;
$wgGroupPermissions['user']['move'] = false;
$wgGroupPermissions['*']['move'] = false;
$wgGroupPermissions['privatedomains']['move'] = true;

$wgGroupPermissions['user']['reupload'] = false;
$wgGroupPermissions['*']['reupload'] = false;
$wgGroupPermissions['privatedomains']['reupload'] = true;

$wgGroupPermissions['user']['reupload-shared'] = false;
$wgGroupPermissions['*']['reupload-shared'] = false;
$wgGroupPermissions['privatedomains']['reupload-shared'] = true;

$wgGroupPermissions['user']['minoredit'] = false;
$wgGroupPermissions['*']['minoredit'] = false;
$wgGroupPermissions['privatedomains']['minoredit'] = true;


/*
 * If user isn't in group privatedomains/staff/bureaucrat then
 * deny access to edit page and show information box.
 */
function pd_AlternateEdit(&$editpage) {
	global $wgUser;
	$groups = $wgUser->getGroups();
	if ( $wgUser->isLoggedIn() && !in_array('privatedomains', $groups) &&  !in_array('staff', $groups) && !in_array('bureaucrat', $groups)) {
		global $wgOut;
		$privatedomains_affiliatename = PrivateDomains::getParam("privatedomains_affiliatename");
		$wgOut->addHTML('<div class="errorbox" style="width:92%;"><strong>');
		$wgOut->addWikiMsg( 'privatedomains_invalidemail', $privatedomains_affiliatename );
		$wgOut->addHTML('</strong></div><br><br><br>');
		return false;
	}
	return true;
}

/*
 * If user have confirmed and allowed address email
 * then add him to privatedomains user group.
 */
function pd_UserLoginComplete($user) {
	if( $user->isEmailConfirmed() ) {
		$domainsStr = PrivateDomains::getParam('privatedomains_domains');
		if($domainsStr != '') {
			$email = strtolower($user->mEmail);
			# get suffix domain name
			preg_match("/([^@]+)@(.+)$/i",$email, $matches);
			$emailDomain = $matches[2];
			$domainsArr = explode("\n", $domainsStr);
			foreach ( $domainsArr as $allowedDomain ) {
				$allowedDomain = strtolower($allowedDomain);
				if ( preg_match("/.*?$allowedDomain$/",$emailDomain) ) {
					$user->addGroup('privatedomains');
					return true;
				}
			}
		}
	}
	$user->removeGroup('privatedomains');
	return true;
}

function wfSpecialPrivateDomains() {
    $page = new PrivateDomains();
    $page->execute();
}
