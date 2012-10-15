<?php
/**
 * Special:GlobalUserrights, Special:Userrights for global groups
 *
 * @file
 * @ingroup Extensions
 */

class GlobalUserrights extends UserrightsPage {

	/* Constructor */
	public function __construct() {
		SpecialPage::__construct( 'GlobalUserrights' );
	}

	/**
	 * Save global user groups changes in the DB
	 *
	 * @param $username String: username
	 * @param $reason String: reason
	 */
	function doSaveUserGroups( $user, $add, $remove, $reason = '' ) {
		$oldGroups = efGURgetGroups( $user );
		$newGroups = $oldGroups;

		// remove then add groups
		if ( $remove ) {
			$newGroups = array_diff( $newGroups, $remove );
			$uid = $user->getId();
			foreach ( $remove as $group ) {
				// whole reason we're redefining this function is to make it use
				// $this->removeGroup instead of $user->removeGroup, etc.
				$this->removeGroup( $uid, $group );
			}
		}
		if ( $add ) {
			$newGroups = array_merge( $newGroups, $add );
			$uid = $user->getId();
			foreach ( $add as $group ) {
				$this->addGroup( $uid, $group );
			}
		}
		// get rid of duplicate groups there might be
		$newGroups = array_unique( $newGroups );

		// Ensure that caches are cleared
		$user->invalidateCache();

		// if anything changed, log it
		if ( $newGroups != $oldGroups ) {
			$this->addLogEntry( $user, $oldGroups, $newGroups, $reason );
		}
		return array( $add, $remove );
	}

	function addGroup( $uid, $group ) {
		$dbw = wfGetDB( DB_MASTER );
		$dbw->insert(
			'global_user_groups',
			array(
				'gug_user' => $uid,
				'gug_group' => $group
			),
			__METHOD__,
			'IGNORE'
		);
		$dbw->commit();
	}
	
	function removeGroup( $uid, $group ) {
		$dbw = wfGetDB( DB_MASTER );
		$dbw->delete(
			'global_user_groups',
			array(
				'gug_user' => $uid,
				'gug_group' => $group
			),
			__METHOD__
		);
		$dbw->commit();
	}

	/**
	 * Add a gblrights log entry 
	 */
	function addLogEntry( $user, $oldGroups, $newGroups, $reason ) {
		$log = new LogPage( 'gblrights' );

		$log->addEntry( 'rights',
			$user->getUserPage(),
			$reason,
			array(
				$this->makeGroupNameListForLog( $oldGroups ),
				$this->makeGroupNameListForLog( $newGroups )
			)
		);
	}

	protected function showEditUserGroupsForm( $user, $groups ) {
		// override the $groups that is passed, which will be 
		// the user's local groups
		$groups = efGURgetGroups( $user );
		parent::showEditUserGroupsForm( $user, $groups );
	}

	function changeableGroups() {
		global $wgUser;
		if ( $wgUser->isAllowed( 'userrights-global' ) ) {
			// all groups can be added globally
			$all = array_merge( User::getAllGroups() );
			return array(
				'add' => $all,
				'remove' => $all,
				'add-self' => array(),
				'remove-self' => array()
			);
		} else {
			return array();
		}
	}

	protected function showLogFragment( $user, $output ) {
		$output->addHTML( Xml::element( 'h2', null, LogPage::logName( 'gblrights' ) . "\n" ) );
		LogEventsList::showLogExtract( $output, 'gblrights', $user->getUserPage()->getPrefixedText() );
	}

}
