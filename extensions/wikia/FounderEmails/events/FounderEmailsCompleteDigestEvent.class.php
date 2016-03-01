<?php

class FounderEmailsCompleteDigestEvent extends FounderEmailsEvent {
	const EMAIL_CONTROLLER = Email\Controller\FounderActivityDigestController::class;

	public function __construct( Array $data = array() ) {
		parent::__construct( 'completeDigest' );
		$this->setData( $data );
	}

	public function enabled ( User $user, $wikiId = null ) {
		if ( self::isAnswersWiki() ) {
			return false;
		}

		return true;
	}

	/**
	 * Called from maintenance script only.  Send Digest emails for any founders with that preference enabled
	 *
	 * @param array $events This array is empty most of the time.  If the --wikiId flag is given to
	 *                      the maintenance script however, that single wiki ID will be given as the only
	 *                      array element.
	 */
	public function process ( Array $events ) {
		global $wgTitle;
		wfProfileIn( __METHOD__ );

		$wgTitle = Title::newMainPage();
		$founderEmailObj = FounderEmails::getInstance();
		// Get list of founders with digest mode turned on (defined in FounderEmailsEvent)
		if ( empty( $events ) ) {
			$cityList = $founderEmailObj->getWikisWithFounderPreference( 'founderemails-complete-digest' );
		} else {
			$cityList = $events;
		}
		$wikiService = new WikiService();

		foreach ( $cityList as $cityID ) {
			Wikia::initAsyncRequest( $cityID );
			$userIds = $wikiService->getWikiAdminIds( $cityID );
			$emailParams = [
				'wikiId' => $cityID,
				'pageViews' => $founderEmailObj->getPageViews( $cityID ),
				'pageEdits' => $founderEmailObj->getDailyEdits( $cityID ),
				'newUsers' => $founderEmailObj->getNewUsers( $cityID )
			];

			// Only send email if there is some kind of activity to report
			if ( $emailParams['pageViews'] == 0 && $emailParams['newUsers'] == 0 && $emailParams['userEdits'] == 0 ) {
				continue;
			}

			foreach ( $userIds as $userId ) {
				$user = User::newFromId( $userId );

				// skip if not enabled
				if ( !$this->enabled( $user, $cityID ) ) {
					continue;
				}

				$emailParams['targetUser'] = $user->getName();
				F::app()->sendRequest( self::EMAIL_CONTROLLER, 'handle', $emailParams );
			}
		}

		wfProfileOut( __METHOD__ );
	}
}
