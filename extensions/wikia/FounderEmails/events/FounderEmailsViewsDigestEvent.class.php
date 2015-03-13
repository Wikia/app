<?php
class FounderEmailsViewsDigestEvent extends FounderEmailsEvent {
	public function __construct( Array $data = array() ) {
		parent::__construct( 'viewsDigest' );
		$this->setData( $data );
	}

	public function enabled ( $wgCityId, User $user ) {
		if ( self::isAnswersWiki() ) {
			return false;
		}

		// disable if all Wikia email disabled
		if ( $user->getBoolOption( "unsubscribed" ) ) {
			return false;
		}

		// If complete digest mode is enabled, do not send views only digest
		if ( $user->getOption( "founderemails-complete-digest-$wgCityId" ) ) {
			return false;
		}
		if ( $user->getOption( "founderemails-views-digest-$wgCityId" ) ) {
			return true;
		}
		return false;
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
		$cityList = $founderEmailObj->getFoundersWithPreference('founderemails-views-digest');
		$wikiService = (new WikiService);

		// Gather daily page view stats for each wiki requesting views digest
		foreach ($cityList as $cityID) {
			$user_ids = $wikiService->getWikiAdminIds( $cityID );
			$foundingWiki = WikiFactory::getWikiById( $cityID );
			$page_url = GlobalTitle::newFromText( 'Createpage', NS_SPECIAL, $cityID )->getFullUrl( array('modal' => 'AddPage') );

			$emailParams = array(
				'$WIKINAME' => $foundingWiki->city_title,
				'$WIKIURL' => $foundingWiki->city_url,
				'$PAGEURL' => $page_url,
				'$UNIQUEVIEWS' => $founderEmailObj->getPageViews( $cityID ),
			);

			foreach ($user_ids as $user_id) {
				$user = User::newFromId($user_id);

				// skip if not enable
				if (!$this->enabled($cityID, $user)) {
					continue;
				}
				self::addParamsUser($cityID, $user->getName(), $emailParams);

				$langCode = $user->getOption( 'language' );
				$links = array(
					'$WIKINAME' => $emailParams['$WIKIURL'],
				);
				$mailSubject = strtr(wfMsgExt('founderemails-email-views-digest-subject', array('content')), $emailParams);
				$mailBody = strtr(wfMsgExt('founderemails-email-views-digest-body', array('content','parsemag'), $emailParams['$UNIQUEVIEWS']), $emailParams);
				$mailBodyHTML = F::app()->renderView("FounderEmails", "GeneralUpdate", array_merge($emailParams, array('language' => 'en', 'type' => 'views-digest')));
				$mailBodyHTML = strtr($mailBodyHTML, FounderEmails::addLink($emailParams,$links));
				$mailCategory = FounderEmailsEvent::CATEGORY_VIEWS_DIGEST.(!empty($langCode) && $langCode == 'en' ? 'EN' : 'INT');

				$founderEmailObj->notifyFounder( $user, $this, $mailSubject, $mailBody, $mailBodyHTML, $cityID, $mailCategory );
			}
		}
		wfProfileOut( __METHOD__ );
	}

	/*  Not used by DailyDigest event
	public static function register ( ) {

	}
	 */
}
