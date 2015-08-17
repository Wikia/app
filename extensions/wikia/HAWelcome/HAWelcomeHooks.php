<?php

class HAWelcomeHooks {

	/**
	 * Queue the HAWelcome communication using the new task system. This function
	 * will toggle between the old and the new based on the configuration in TaskRunner.
	 *
	 * This will be removed once the system is fully migrated.
	 *
	 * @param int   $wgCityId the city id
	 * @param Title $oTitle
	 * @param array $aParams
	 * @return void
	 */
	public static function queueHAWelcomeTask( $wgCityId, $oTitle, $aParams ) {
		$task = new HAWelcomeTask();
		$task->call( 'sendWelcomeMessage', $aParams );
		$task->wikiId( $wgCityId );
		$task->title( $oTitle ); // use $this->title in the job
		$task->prioritize();
		$task->queue();
	}

	/**
	 * Function called on UserRights hook
	 *
	 * Invalidates cached welcomer user ID if equal to changed user ID
	 *
	 * @author Kamil Koterba kamil@wikia-inc.com
	 * @since MediaWiki 1.19.12
	 *
	 * @param User $oUser
	 * @param Array $aAddedGroups
	 * @param Array $aRemovedGroups
	 *
	 * @return bool
	 */
	public static function onUserRightsChange( &$oUser, $aAddedGroups, $aRemovedGroups ) {
		global $wgMemc;
		if ( $oUser->getId() == $wgMemc->get( wfMemcKey( 'last-sysop-id' ) ) ) {
			$wgMemc->delete( wfMemcKey( 'last-sysop-id' ) );
		}
		return true;
	}


}
