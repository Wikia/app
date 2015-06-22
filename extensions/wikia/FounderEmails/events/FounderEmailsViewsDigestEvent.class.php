<?php
class FounderEmailsViewsDigestEvent extends FounderEmailsEvent {
	public function __construct( Array $data = array() ) {
		parent::__construct( 'viewsDigest' );
		$this->setData( $data );
	}

	public function enabled ( $wikiId, User $user ) {
		if ( self::isAnswersWiki() ) {
			return false;
		}

		// If complete digest mode is enabled, do not send views only digest
		if ( $user->getOption( "founderemails-complete-digest-$wikiId" ) ) {
			return false;
		}
		if ( $user->getOption( "founderemails-views-digest-$wikiId" ) ) {
			return true;
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
				if ( !$this->enabled( $cityID, $user ) ) {
					continue;
				}

				$emailParams['targetUser'] = $user->getName();
				F::app()->sendRequest( 'Email\Controller\FounderPageViewsDigest', 'handle', $emailParams );
			}
		}
		wfProfileOut( __METHOD__ );
	}

	/*  Not used by DailyDigest event
	public static function register ( ) {

	}
	 */
}
