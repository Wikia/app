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
		$task->queue();
	}

	/**
	 * Enqueues a job based on a few simple preliminary checks.
	 *
	 * Called once an article has been saved.
	 *
	 * @param $oArticle Object The WikiPage object for the contribution.
	 * @param $oUser Object The User object for the contribution.
	 * @param $sText String The contributed text.
	 * @param $sSummary String The summary for the contribution.
	 * @param $iMinorEdit Integer Indicates whether a contribution has been marked as a minor one.
	 * @param $nWatchThis Null Not used as of MW 1.8
	 * @param $nSectionAnchor Null Not used as of MW 1.8
	 * @param $iFlags Integer Bitmask flags for the edit.
	 * @param $oRevision Object The Revision object.
	 * @param $oStatus Object The Status object returned by Article::doEdit().
	 * @param $iBaseRevId Integer The ID of the revision, the current edit is based on (or Boolean False).
	 * @return Boolean True so the calling method would continue.
	 * @see http://www.mediawiki.org/wiki/Manual:$wgHooks
	 * @see http://www.mediawiki.org/wiki/Manual:Hooks/ArticleSaveComplete
	 * @since MediaWiki 1.19.4
	 * @internal
	 */
	public static function onArticleSaveComplete( &$oArticle, &$oUser, $sText, $sSummary, $iMinorEdit, $nWatchThis, $nSectionAnchor, &$iFlags, $oRevision, $oStatus, $iBaseRevId ) {

		/**
		 *
		 * Deprecated: Use HAWelcomeTaskHooks::onArticleSaveComplete.
		 * Remove once this HAWelcomeTask has been tested in production.
		 *
		 */

		wfProfileIn( __METHOD__ );

		if ( is_null( $oRevision ) ) {
			// if oRevision is null, that means we're dealing with a null edit (no content change)
			// and therefore we don't have to welcome anybody
			wfProfileOut( __METHOD__ );
			return true;
		}

		/** @global Boolean Show PHP Notices. Set via WikiFactory. */
		global $wgHAWelcomeNotices, $wgCityId;
		/** @type Interget Store the original error reporting level. */
		$iErrorReporting = error_reporting();
		error_reporting( E_ALL );
		// Abort if the feature has been disabled by the admin of the wiki.
		if ( in_array( trim( wfMessage( 'welcome-user' )->inContentLanguage()->text() ), array( '@disabled', '-' ) ) ) {
			if ( !empty( $wgHAWelcomeNotices ) ) {
				trigger_error( sprintf( '%s Terminated. The feature has been disabled.', __METHOD__ ) , E_USER_NOTICE );
			}
			// Restore the original error reporting level.
			error_reporting( $iErrorReporting );
			wfProfileOut( __METHOD__ );
			return true;
		}
		/**
		 * @global Boolean True in scripts that may be run from the command line.
		 * @see http://www.mediawiki.org/wiki/Manual:$wgCommandLineMode
		 */
		global $wgCommandLineMode;
		// Ignore revisions created in the command-line mode. Otherwise HAWelcome::run() could
		// invoke HAWelcome::onRevisionInsertComplete(), too which may cause an infinite loop
		// and serious performance problems.
		if ( !$wgCommandLineMode ) {
			/**
			 * @global Object MemcachedPhpBagOStuff A pure-PHP memcached client instance.
			 * @see https://doc.wikimedia.org/mediawiki-core/master/php/html/classMemcachedPhpBagOStuff.html
			 */
			global $wgMemc;
			// Abort if the contributor has been welcomed recently.
			if ( $wgMemc->get( wfMemcKey( 'HAWelcome-isPosted', $oRevision->getRawUserText() ) ) ) {
				if ( !empty( $wgHAWelcomeNotices ) ) {
					trigger_error( sprintf( '%s Done. The contributor has been welcomed recently.', __METHOD__ ) , E_USER_NOTICE );
				}
				// Restore the original error reporting level.
				error_reporting( $iErrorReporting );
				wfProfileOut( __METHOD__ );
				return true;
			}
			// Handle an edit made by an anonymous contributor.
			if ( ! $oRevision->getRawUser() ) {
				if ( !empty( $wgHAWelcomeNotices ) ) {
					trigger_error( sprintf( '%s An edit made by an anonymous contributor.', __METHOD__ ) , E_USER_NOTICE );
				}
			// Handle an edit made by a registered contributor.
			} else {
				if ( !empty( $wgHAWelcomeNotices ) ) {
					trigger_error( sprintf( '%s An edit made by a registered contributor.', __METHOD__ ) , E_USER_NOTICE );
				}
				/**
				 * @global Object User The state of the user viewing/using the site
				 * @see http://www.mediawiki.org/wiki/Manual:$wgUser
				 */
				global $wgUser;
				$wiki = WikiFactory::getWikiById( $wgCityId );
				$founderId = isset( $wiki->city_founding_user ) ? intval( $wiki->city_founding_user ) : false;
				// Abort if the contributor is a member of a group that should not be welcomed or the default welcomer
				// Also, don't welcome founders as they are welcomed separately
				if ( $wgUser->isAllowed( 'welcomeexempt' ) ||
					$wgUser->getName() == HAWelcomeTask::DEFAULT_WELCOMER ||
					$founderId === intval( $oRevision->getRawUser() )
				) {
					if ( !empty( $wgHAWelcomeNotices ) ) {
						trigger_error( sprintf( '%s Done. The registered contributor is a bot, a staff member, the wiki founder or the default welcomer.', __METHOD__ ) , E_USER_NOTICE );
					}
					// Restore the original error reporting level.
					error_reporting( $iErrorReporting );
					wfProfileOut( __METHOD__ );
					return true;
				}
				// Abort if the registered contributor has made edits before this one.
				if ( 1 < $wgUser->getEditCountLocal() ) {
					// Check the extension settings...
					/** @type String The user to become the welcomer. */
					$sSender = trim( wfMessage( 'welcome-user' )->inContentLanguage()->text() );
					if ( in_array( $sSender, array( '@latest', '@sysop' ) ) ) {
						if ( !empty( $wgHAWelcomeNotices ) ) {
							trigger_error( sprintf( '%s Taking the chance to update admin activity.', __METHOD__ ) , E_USER_NOTICE );
						}
						// ... and take the opportunity to update admin activity variable.
						/** @type Array Implicit group memberships the user has. */
						$aGroups =  $wgUser->getEffectiveGroups();
						if ( in_array( 'sysop', $aGroups ) && ! in_array( 'bot' , $aGroups ) ) {
							if ( !empty( $wgHAWelcomeNotices ) ) {
								trigger_error( sprintf( '%s Updating admin activity.', __METHOD__ ) , E_USER_NOTICE );
							}
							$wgMemc->set( wfMemcKey( 'last-sysop-id' ),  $wgUser->getId() );
						}
					}
					if ( !empty( $wgHAWelcomeNotices ) ) {
						trigger_error( sprintf( '%s Done. The registered contributor has already made edits.', __METHOD__ ) , E_USER_NOTICE );
					}
					// Restore the original error reporting level.
					error_reporting( $iErrorReporting );
					wfProfileOut( __METHOD__ );
					return true;
				}
			}
			// Mark that we have handled this particular contributor to prevent
			// creating more jobs. Improves performance if the contributor is editing massively.
			$wgMemc->set( wfMemcKey( 'HAWelcome-isPosted', $oRevision->getRawUserText() ), true );
			/** @type Object Title Title associated with the revision */
			$oTitle = $oRevision->getTitle();
			// Sometimes, for some reason or other, the Revision object
			// does not contain the associated Title object. It has to be
			// recreated based on the associated Page object.
			if ( !$oTitle ) {
				$oTitle = Title::newFromId( $oRevision->getPage(), Title::GAID_FOR_UPDATE );
				if ( !empty( $wgHAWelcomeNotices ) ) {
					trigger_error( sprintf(
						'%s Recreated Title for page %d, revision %d, URL %s',
						__METHOD__, $oRevision->getPage(), $oRevision->getId(), $oTitle->getFullURL()
					), E_USER_NOTICE );
				}
			}
			/** @type Array Parameters for the job */
			$aParams = array(
				// The id of the user to be welcome (0 if anon).
				'iUserId' => $oRevision->getRawUser(),
				// The name of the user to be welcome (IP if anon).
				'sUserName' => $oRevision->getRawUserText(),
				// The time when the job has been scheduled (as UNIX timestamp).
				'iTimestamp' => time()
			);
			if ( !empty( $wgHAWelcomeNotices ) ) {
				trigger_error( sprintf( '%s Scheduling a job.', __METHOD__ ) , E_USER_NOTICE );
			}

			self::queueHAWelcomeTask( $wgCityId, $oTitle, $aParams );
		}

		if ( !empty( $wgHAWelcomeNotices ) ) {
			trigger_error( sprintf( '%s Done.', __METHOD__ ) , E_USER_NOTICE );
		}
		// Restore the original error reporting level.
		error_reporting( $iErrorReporting );
		wfProfileOut( __METHOD__ );
		return true;
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
	 * @param Array $sAddedGroups
	 * @param Array $sRemovedGroups
	 */
	public static function onUserRightsChange( &$oUser, $aAddedGroups, $aRemovedGroups ) {
		global $wgMemc;
		if ( $oUser->getId() == $wgMemc->get( wfMemcKey( 'last-sysop-id' ) ) ) {
			$wgMemc->delete( wfMemcKey( 'last-sysop-id' ) );
		}
		return true;
	}


}
