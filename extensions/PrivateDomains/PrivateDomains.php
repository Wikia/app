<?php
/**
 * PrivateDomains extension - allows to restrict editing to users with a
 * certain e-mail address
 *
 * @file
 * @ingroup Extensions
 * @version 1.0
 * @author Inez Korczyński <korczynski@gmail.com>
 * @author Jack Phoenix <jack@countervandalism.net>
 * @link http://www.mediawiki.org/wiki/Extension:PrivateDomains Documentation
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	die( "This is not a valid entry point.\n" );
}

// Extension credits that will show up on Special:Version
$wgExtensionCredits['specialpage'][] = array(
	'name' => 'PrivateDomains',
	'version' => '1.0',
	'author' => array( 'Inez Korczyński', 'Jack Phoenix' ),
	'description' => 'Allows to restrict editing to users with a certain e-mail address',
	'url' => 'https://www.mediawiki.org/wiki/Extension:PrivateDomains',
);

// Set up the new special page
$dir = dirname( __FILE__ ) . '/';
$wgAutoloadClasses['PrivateDomains'] = $dir . 'SpecialPrivateDomains.php';
$wgExtensionMessagesFiles['PrivateDomains'] = $dir . 'PrivateDomains.i18n.php';
$wgSpecialPages['PrivateDomains'] = 'PrivateDomains';
// Special page group for MW 1.13+
$wgSpecialPageGroups['PrivateDomains'] = 'wiki';

$wgHooks['AlternateEdit'][] = 'pd_AlternateEdit'; // Occurs whenever action=edit is called
$wgHooks['UserLoginComplete'][] = 'pd_UserLoginComplete'; // Occurs after a user has successfully logged in
$wgHooks['ConfirmEmailComplete'][] = 'pd_UserLoginComplete'; // Occurs after a user has successfully confirm email

# set 'privatedomains' right to users in staff or bureaucrat group
$wgAvailableRights[] = 'privatedomains';
$wgGroupPermissions['staff']['privatedomains'] = true;
$wgGroupPermissions['bureaucrat']['privatedomains'] = true;

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

/**
 * If user isn't in group privatedomains/staff/bureaucrat then
 * deny access to edit page and show information box.
 */
function pd_AlternateEdit( &$editpage ) {
	global $wgUser;
	$groups = $wgUser->getEffectiveGroups();
	if (
		$wgUser->isLoggedIn() && !in_array( 'privatedomains', $groups ) &&
		!in_array( 'staff', $groups ) && !in_array( 'bureaucrat', $groups )
	)
	{
		global $wgOut;
		$affiliateName = PrivateDomains::getParam( 'privatedomains-affiliatename' );
		$wgOut->addHTML( '<div class="errorbox" style="width:92%;"><strong>' );
		$wgOut->addWikiMsg( 'privatedomains-invalidemail', $affiliateName );
		$wgOut->addHTML( '</strong></div><br /><br /><br />' );
		return false;
	}
	return true;
}

/**
 * If user has confirmed and allowed address email
 * then add him/her to privatedomains user group.
 */
function pd_UserLoginComplete( $user ) {
	if( $user->isEmailConfirmed() ) {
		$domainsStr = PrivateDomains::getParam( 'privatedomains-domains' );
		if( $domainsStr != '' ) {
			$email = strtolower( $user->mEmail );
			// get suffix domain name
			preg_match( "/([^@]+)@(.+)$/i", $email, $matches );
			$emailDomain = $matches[2];
			$domainsArr = explode( "\n", $domainsStr );
			foreach ( $domainsArr as $allowedDomain ) {
				$allowedDomain = strtolower( $allowedDomain );
				if ( preg_match( "/.*?$allowedDomain$/", $emailDomain ) ) {
					$user->addGroup( 'privatedomains' );
					return true;
				}
			}
		}
	}
	$user->removeGroup( 'privatedomains' );
	return true;
}