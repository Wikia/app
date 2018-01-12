<?php

/**
 * @package MediaWiki
 * @subpackage SpecialPage
 * @author Piotr Molski <moli@wikia.com>
 * @version: $Id$
 */

class ListusersHooks {

	/**
	 * redirect Special::Activeusers to Special::Listusers
	 *
	 * @author      Piotr Molski <moli@wikia-inc.com>
	 * @version     1.0.0
	 * @param       array   $list
	 * @return bool
	 */
	public static function Activeusers( &$list ) {
		wfProfileIn( __METHOD__ );
		$list['Activeusers'] = array( 'SpecialPage', 'Listusers' );
		wfProfileOut( __METHOD__ );
		return true;
	}


	static public function updateUserRights( User $user ) {
		if ( !$user->isAllowed( 'bot' ) ) {
			$listUsersUpdate = new ListUsersUpdate();
			$listUsersUpdate->setUserId( $user->getId() );
			$listUsersUpdate->setUserGroups( $user->getGroups() );

			$task = UpdateListUsersTask::newLocalTask();
			$task->call( 'updateUserGroups', $listUsersUpdate );
			$task->queue();
		}
	}

	public static function doEditUpdate( WikiPage $wikiPage, Revision $revision, $baseRevId, User $user ) {
		if ( $user->isAnon() || $user->isAllowed( 'bot' ) ) {
			return;
		}

		$editUpdate = new ListUsersEditUpdate();
		$editUpdate->setUserId( $user->getId() );
		$editUpdate->setUserGroups( $user->getGroups() );
		$editUpdate->setLatestRevisionId( $revision->getId() );
		$editUpdate->setLatestRevisionTimestamp( $revision->getTimestamp() );

		$task = UpdateListUsersTask::newLocalTask();
		$task->call( 'updateEditInformation', $editUpdate );
		$task->queue();
	}
}
