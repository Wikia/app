<?php
/**
 * FilterListUsers -- filters out users that haven't edited from Special:ListUsers
 *
 * @file
 * @ingroup Extensions
 * @version 1.0
 * @date February 22, 2010
 * @author Jack Phoenix <jack@countervandalism.net>
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	die( "This is not a valid entry point.\n" );
}

// Extension credits that will show up on Special:Version
$wgExtensionCredits['other'][] = array(
	'path' => __FILE__,
	'name' => 'FilterListUsers',
	'version' => '1.0.1',
	'author' => 'Jack Phoenix',
	'descriptionmsg' => 'filterlistusers-desc',
	'url' => 'https://www.mediawiki.org/wiki/Extension:FilterListUsers',
);

// New user right, required to view all users in Special:ListUsers
$wgAvailableRights[] = 'viewallusers';
$wgGroupPermissions['sysop']['viewallusers'] = true;

// i18n file
$dir = dirname( __FILE__ ) . '/';
$wgExtensionMessagesFiles['FilterListUsers'] = $dir . 'FilterListUsers.i18n.php';

$wgHooks['SpecialListusersQueryInfo'][] = 'efFilterListUsersAlterQuery';
/**
 * Alters the SQL query so that when there is no "showall" parameter in the URL
 * or when the user isn't privileged, only users with 5 (or more) edits will be
 * shown.
 *
 * @param $usersPager Object: instance of UsersPager
 * @param $query Array: SQL query parameters
 * @return Boolean: true
 */
function efFilterListUsersAlterQuery( $usersPager, &$query ) {
	global $wgRequest, $wgUser;

	// Members of these groups will always be shown if the user selects this
	// group from the dropdown menu, no matter if they haven't edited the wiki
	// at all
	$exemptGroups = array(
		'sysop', 'bureaucrat', 'steward', 'staff', 'globalbot'
	);

	if (
		!$wgRequest->getVal( 'showall' ) && !in_array( $usersPager->requestedGroup, $exemptGroups ) ||
		!$wgUser->isAllowed( 'viewallusers' ) && !in_array( $usersPager->requestedGroup, $exemptGroups )
	)
	{
		$dbr = wfGetDB( DB_SLAVE );
		$revisionTable = $dbr->tableName( 'revision' );
		$query['tables'] .= " JOIN (SELECT rev_user, COUNT(*) AS cnt FROM {$revisionTable} GROUP BY rev_user HAVING cnt > 5) AS tmp ON user_id = rev_user ";
	}

	return true;
}

$wgHooks['SpecialListusersHeaderForm'][] = 'efFilterListUsersHeaderForm';
/**
 * Adds the "Show all users" checkbox for privileged users.
 *
 * @param $usersPager Object: instance of UsersPager
 * @param $out String: HTML output
 * @return Boolean: true
 */
function efFilterListUsersHeaderForm( $usersPager, &$out ) {
	global $wgRequest, $wgUser;

	// Show this checkbox only to privileged users
	if ( $wgUser->isAllowed( 'viewallusers' ) ) {
		$out .= Xml::checkLabel(
			wfMsg( 'listusers-showall' ),
			'showall',
			'showall',
			$wgRequest->getVal( 'showall' )
		);
		$out .= '&nbsp;';
	}

	return true;
}