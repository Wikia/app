<?php
/**
* SharedUserrights -- adds a global rights table to the SharedDB
*
* @package MediaWiki
* @subpackage Extensions
*
* @author: Lucas 'TOR' Garczewski <tor@wikia.com>
*
* @copyright Copyright (C) 2008 Lucas 'TOR' Garczewski, Wikia, Inc.
* @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
*
* @todo: display global rights in Listusers
*
*/

if (!defined('MEDIAWIKI')){
    echo ('THIS IS NOT VALID ENTRY POINT.'); exit (1);
}

$wgExtensionFunctions [] = 'efInitializeGlobalUserrights';

$wgExtensionCredits['other'][] = array(
    'name' => 'Shared UserRights' ,
    'author' => "[http://www.wikia.com/wiki/User:TOR Lucas 'TOR' Garczewski]",
    'description' => 'Easy global user rights administration'
);

function efInitializeGlobalUserrights(){
	global $wgSharedDB, $wgHooks;

	# Paranoia: only initialize if using SharedDB
	if (empty($wgSharedDB)) {
		return true;
	}

	$wgHooks['UserEffectiveGroups'][] = 'efAddSharedUserRights';
	$wgHooks['UserRights'][] = 'efManageSharedUserRights';
	$wgHooks['UserRights::showEditUserGroupsForm'][] = 'efAddSharedUserRightsToForm';
}

function efAddSharedUserRights($user, $groups) {
	global $wgSharedDB, $wgDBname;	

	$dbr =& wfGetDB( DB_SLAVE );

	if ($dbr->selectDB($wgSharedDB)) {
		$res = $dbr->select(
			'shared_user_groups',
			'sug_group',
			array ('sug_user' => $user->mId));
		while ( $row = $dbr->fetchObject( $res ) ) {
		       $groups[] = $row->sug_group;
		}
		$dbr->freeResult( $res );
		$dbr->selectDB( $wgDBname ); # to prevent Listusers from breaking
	}
	
	return $groups;
}

function efManageSharedUserRights($user, $addgroup, $removegroup) {
	global $wgWikiaGlobalUserGroups;

	# Remove groups if there is anything to remove
	if (!empty($removegroup)) {
		$global_removable = array_intersect($removegroup, $wgWikiaGlobalUserGroups);

		if (!empty($global_removable)) {
	                $dbw =& wfGetDB( DB_MASTER );

		        foreach ($global_removable as $group) {
                	        $dbw->delete(wfSharedTable('shared_user_groups'), array(
                        	        'sug_user' => $user->getId(),
	                                'sug_group' => $group),
        	                        'SharedUserRights::removeGroup'
	                        );
        	        }
	        }
	}

	# Add groups if there is anything to add
	if (!empty($addgroup)) {
		$global_addable = array_intersect($addgroup, $wgWikiaGlobalUserGroups);	
	
		if (!empty($global_addable)) {
			global $wgDBname, $wgDBprefix;

			$dbw =& wfGetDB( DB_MASTER );

			foreach ($global_addable as $group) {

				# INSERT into global table
				$dbw->insert(wfSharedTable('shared_user_groups'), array(
					'sug_user' => $user->getId(),
					'sug_group' => $group),
					'SharedUserRights::addGroup',
					'IGNORE'
				);

				# DELETE from local table, since it was added by Special:Userrights
				$dbw->selectDB($wgDBname);

				$dbw->delete($wgDBprefix . 'user_groups', array(
					'ug_user' => $user->getId(),
					'ug_group' => $group),
					'SharedUserRights::cleanupLocal'
				);
			}
		}
	}

	return true;
}

function efAddSharedUserRightsToForm ($user, $addable, $removable) {
	global $wgWikiaGlobalUserGroups;

	$all_groups = $user->getEffectiveGroups();
	$global_groups = array_intersect($all_groups, $wgWikiaGlobalUserGroups);

	$removable = array_merge($removable, array_intersect($all_groups, $wgWikiaGlobalUserGroups));
	$addable = array_diff($addable, $global_groups);

	return true;
}
