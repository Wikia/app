<?php
class FounderEmailsViewsDigestEvent extends FounderEmailsEvent {
	const EMAIL_CONTROLLER = Email\Controller\FounderPageViewsDigestController::class;

	public function __construct( Array $data = array() ) {
		parent::__construct( 'viewsDigest' );
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
		$founderEmailObj = FounderEmails::getInstance();

		F::app()->wg->Title = Title::newMainPage();
		// Get list of founders with digest mode turned on
		if ( empty( $events ) ) {
			$cityList = $founderEmailObj->getWikisWithFounderPreference( 'founderemails-complete-digest' );
		} else {
			$cityList = $events;
		}
		$wikiService = new WikiService();

		// Gather daily page view stats for each wiki requesting views digest
		foreach ( $cityList as $cityID ) {
			Wikia::initAsyncRequest( $cityID );
			$userIds = $wikiService->getWikiAdminIds( $cityID );
			$views = $founderEmailObj->getPageViews( $cityID );

			// Don't bother sending this email if there are no page views for this period
			if ( empty( $views ) ) {
				continue;
			}

			$emailParams = [
				'pageViews' => $views,
				'wikiId' => $cityID,
			];

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
	}
}
