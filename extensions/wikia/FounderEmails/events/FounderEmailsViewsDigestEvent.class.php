<?php
class FounderEmailsViewsDigestEvent extends FounderEmailsEvent {
	const EMAIL_CONTROLLER = 'Email\Controller\FounderPageViewsDigest';

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
	 * @param array $events Events is empty for this type
	 */
	public function process ( Array $events ) {
		global $wgTitle;
		wfProfileIn( __METHOD__ );
		$founderEmailObj = FounderEmails::getInstance();

		$wgTitle = Title::newMainPage();
		// Get list of founders with digest mode turned on
		$cityList = $founderEmailObj->getFoundersWithPreference( 'founderemails-views-digest' );
		$wikiService = new WikiService();

		// Gather daily page view stats for each wiki requesting views digest
		foreach ( $cityList as $cityID ) {
			$userIds = $wikiService->getWikiAdminIds( $cityID );
			$emailParams = [
				'pageViews' => $founderEmailObj->getPageViews( $cityID )
			];

			foreach ( $userIds as $userId ) {
				$user = User::newFromId( $userId );

				// skip if not enable
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
