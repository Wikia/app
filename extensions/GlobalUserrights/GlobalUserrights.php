<?php
/**
 * GlobalUserrights -- Special page to allow management of global user groups
 *
 * @file
 * @ingroup Extensions
 * @author Nathaniel Herman <redwwjd@yahoo.com>
 * @copyright Copyright © 2008 Nathaniel Herman
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * @note Some of the code based on stuff by Lukasz 'TOR' Garczewski, as well as SpecialUserrights.php and CentralAuth
 */

if (!defined('MEDIAWIKI')) die();

// Extension credits
$wgExtensionCredits['specialpage'][] = array(
	'name'           => 'GlobalUserrights',
	'url'            => 'http://www.mediawiki.org/wiki/Extension:GlobalUserrights',
	'version'        => '1.0.2',
	'author'         => 'Nathaniel Herman',
	'description'    => 'Easy [[Special:GlobalUserRights|global user rights]] administration',
	'descriptionmsg' => 'gur-desc',
);

// Set up the new special page
$dir = dirname( __FILE__ ) . '/';
$wgExtensionMessagesFiles['GlobalUserrights'] = $dir . 'GlobalUserrights.i18n.php';
$wgExtensionAliasesFiles['GlobalUserrights'] = $dir . 'GlobalUserrights.alias.php';
$wgAutoloadClasses['GlobalUserrights'] = $dir . 'GlobalUserrights_body.php';
$wgSpecialPages['GlobalUserrights'] = 'GlobalUserrights';
$wgSpecialPageGroups['GlobalUserrights'] = 'users';

// New user right, required to use Special:GlobalUserrights
$wgAvailableRights[] = 'userrights-global';
$wgGroupPermissions['staff']['userrights-global'] = true;

// New log type for global right changes
$wgLogTypes[] = 'gblrights';
$wgLogNames['gblrights'] = 'gur-rightslog-name';
$wgLogHeaders['gblrights'] = 'gur-rightslog-header';
$wgLogActions['gblrights/rights'] = 'gur-rightslog-entry';

// Hooked functions
$wgHooks['UserEffectiveGroups'][] = 'efAddGlobalUserrights';
$wgHooks['SpecialListusersQueryInfo'][] = 'efGURUpdateQueryInfo';

/** 
 * Function to get a given user's global groups
 *
 * @param $user instance of User class
 * @return array of global groups
 */
function efGURgetGroups( $user ) {
	if ( $user instanceof User ) {
		$uid = $user->mId;
	} else {
		// if $user isn't an instance of user, assume it's the uid
		$uid = $user;
	}

	$dbw = wfGetDB( DB_MASTER );
	$groups = array();

	$res = $dbw->select( 'global_user_groups',
		array( 'gug_group' ),
		array( 'gug_user' => $uid )
	);

	while( $row = $dbw->fetchObject( $res ) ) {
		$groups[] = $row->gug_group;
	}

	$dbw->freeResult( $res );

	return $groups;

}

/** 
 * Hook function for UserEffectiveGroups
 * Adds any global groups the user has to $groups
 *
 * @param $user instance of User
 * @param &$groups array of groups the user is in
 */
function efAddGlobalUserrights( $user, &$groups ) {
	$groups = array_merge( $groups, efGURgetGroups( $user ) );
	$groups = array_unique( $groups );

	return true;
}

/** 
 * Hook function for SpecialListusersQueryInfo
 * Updates UsersPager::getQueryInfo() to account for the global_user_groups table
 * This ensures that global rights show up on Special:Listusers
 *
 * @param $that instance of UsersPager
 * @param &$query the query array to be returned
 */
function efGURUpdateQueryInfo( $that, &$query ) {
	$dbr = wfGetDB( DB_SLAVE );
	list( $gug ) = $dbr->tableNamesN( 'global_user_groups' );
	$query['tables'] .= "LEFT JOIN $gug ON user_id=gug_user";
	$query['fields'][3] = 'COUNT(ug_group) + COUNT(gug_group) AS numgroups';
	// kind of yucky statement, I blame MySQL 5.0.13 http://bugs.mysql.com/bug.php?id=15610
	$query['fields'][4] = 'GREATEST(COALESCE(ug_group, gug_group), COALESCE(gug_group, ug_group)) AS singlegroup';

	// if there's a $query['conds']['ug_group'], destroy it and make one that accounts for gug_group
	if( isset( $query['conds']['ug_group'] ) ) {
		unset($query['conds']['ug_group']);
		$reqgrp = $dbr->addQuotes( $that->requestedGroup );
		$query['conds'][] = 'ug_group = ' . $reqgrp . 'OR gug_group = ' . $reqgrp;
	}

	return true;
}
