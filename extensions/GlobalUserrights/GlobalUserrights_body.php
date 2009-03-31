<?php
/**
 * Special:Userrights for global groups
 *
 * @file
 * @ingroup Extensions
 */

if (!defined('MEDIAWIKI')) die();

class GlobalUserrights extends UserrightsPage {

	/* Constructor */
	public function __construct() {
		SpecialPage::SpecialPage( 'GlobalUserrights' );
		wfLoadExtensionMessages( 'GlobalUserrights' );
	}
	
	/**
	 * Save global user groups changes in the DB
	 *
	 * @param $username String: username
	 * @param $reason String: reason
	 */
	function saveUserGroups( $username, $reason = '' ) {
		global $wgRequest;
		$user = $this->fetchUser( $username );
		if( !$user ) {
			return;
		}

		$allgroups = $this->getAllGroups();
		$addgroups = array();
		$removegroups = array();

		foreach ( $allgroups as $group ) {
			if ( $wgRequest->getCheck( "wpGroup-$group" ) ) {
				$addgroups[] = $group;
			} else {
				$removegroups[] = $group;
			}
		}

		$oldGroups = efGURgetGroups( $user );
		$newGroups = $oldGroups;

		if ( $removegroups ) {
			$newGroups = array_diff($newGroups, $removegroups);
			$dbw = wfGetDB( DB_MASTER );
			$uid = $user->getId();
			foreach( $removegroups as $group ) 
				// whole reason we're redefining this function is to make it use
				// $this->removeGroup instead of $user->removeGroup, etc.
				$this->removeGroup( $uid, $group, $dbw );
		}
		if ( $addgroups ) {
			$newGroups = array_merge($newGroups, $addgroups);
			$dbw = wfGetDB( DB_MASTER );
			$uid = $user->getId();
			foreach( $addgroups as $group )
				$this->addGroup( $uid, $group, $dbw );
		}
		// get rid of duplicate groups there might be
		$newGroups = array_unique( $newGroups );

		$user->invalidateCache(); // clear cache

		// if anything changed, log it
		if( $newGroups != $oldGroups )
			$this->addLogEntry( $user, $oldGroups, $newGroups );
	}

	function addGroup( $uid, $group, $dbw ) {
		$dbw->insert( 'global_user_groups', array(
			'gug_user' => $uid,
			'gug_group' => $group),
			__METHOD__,
			'IGNORE'
		);
		$dbw->commit();
	}
	
	function removeGroup( $uid, $group, $dbw ) {
		$dbw->delete( 'global_user_groups', array(
			'gug_user' => $uid,
			'gug_group' => $group),
			__METHOD__
		);
		$dbw->commit();
	}

	/**
	 * Add a gblrights log entry 
	 */
	function addLogEntry( $user, $oldGroups, $newGroups ) {
		global $wgRequest;
		$log = new LogPage( 'gblrights' );
		$log->addEntry( 'rights',
			$user->getUserPage(),
			$wgRequest->getText( 'user-reason' ),
				array(
					$this->makeGroupNameList( $oldGroups ),
					$this->makeGroupNameList( $newGroups )
				)
			);
	}

	function fetchUser( $username ) {
		global $wgOut;
		$user = User::newFromName( $username );
		if( !$user || $user->isAnon() ) {
			$wgOut->addWikiMsg( 'nosuchusershort', $username );
			return null;
		}

		return $user;
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
		$output->addHtml( Xml::element( 'h2', null, LogPage::logName( 'gblrights' ) . "\n" ) );
		LogEventsList::showLogExtract( $output, 'gblrights', $user->getUserPage()->getPrefixedText() );
	}

}
