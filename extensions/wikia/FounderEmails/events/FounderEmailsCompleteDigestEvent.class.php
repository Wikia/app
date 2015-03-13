<?php
class FounderEmailsCompleteDigestEvent extends FounderEmailsEvent {
	public function __construct( Array $data = array() ) {
		parent::__construct( 'completeDigest' );
		$this->setData( $data );
	}

	public function enabled ( $wgCityId, User $user ) {
        if ( self::isAnswersWiki() ) {
            return false;
        }

        if ( $user->getOption( "founderemails-complete-digest-$wgCityId" ) ) {
            return true;
        }

        // disable if all Wikia email disabled
        if ( $user->getBoolOption( "unsubscribed" ) ) {
            return false;
        }

        return false;
	}

	/**
	 * Called from maintenance script only.  Send Digest emails for any founders with that preference enabled
	 * @param array $events
	 */
	public function process ( Array $events ) {
		global $wgTitle;
		wfProfileIn( __METHOD__ );

		$wgTitle = Title::newMainPage();
		$founderEmailObj = FounderEmails::getInstance();
		// Get list of founders with digest mode turned on (defined in FounderEmailsEvent
		$cityList = $founderEmailObj->getFoundersWithPreference('founderemails-complete-digest');
		$wikiService = (new WikiService);

		foreach ($cityList as $cityID) {
			$user_ids = $wikiService->getWikiAdminIds( $cityID );
			$foundingWiki = WikiFactory::getWikiById( $cityID );
			$page_url = GlobalTitle::newFromText( 'WikiActivity', NS_SPECIAL, $cityID )->getFullUrl();

			$emailParams = array(
				'$WIKINAME' => $foundingWiki->city_title,
				'$WIKIURL' => $foundingWiki->city_url,
				'$PAGEURL' => $page_url,
				'$UNIQUEVIEWS' => $founderEmailObj->getPageViews( $cityID ),
				'$USERJOINS' => $founderEmailObj->getNewUsers( $cityID ),
				'$USEREDITS' => $founderEmailObj->getDailyEdits( $cityID ),
			);

			foreach($user_ids as $user_id) {
				$user = User::newFromId($user_id);

				// skip if not enable
				if (!$this->enabled($cityID, $user)) {
					continue;
				}

				self::addParamsUser($cityID, $user->getName(), $emailParams);

				// Only send email if there is some kind of activity to report
                                if ( $emailParams['$UNIQUEVIEWS'] == 0 && $emailParams['$USERJOINS'] == 0 && $emailParams['$USEREDITS'] == 0 ) {
					continue;
				}

				$langCode = $user->getOption( 'language' );
				$links = array(
					'$WIKINAME' => $emailParams['$WIKIURL'],
				);

				$mailSubject = strtr(wfMsgExt('founderemails-email-complete-digest-subject', array( 'language' => $langCode )), $emailParams);
				$mailBody = strtr(wfMsgExt('founderemails-email-complete-digest-body', array( 'language' => $langCode,'parsemag'), $emailParams['$UNIQUEVIEWS'], $emailParams['$USEREDITS'], $emailParams['$USERJOINS']), $emailParams);
				$mailBodyHTML = F::app()->renderView("FounderEmails", "GeneralUpdate", array_merge($emailParams, array('language' => $langCode, 'type' => 'complete-digest')));
				$mailBodyHTML = strtr($mailBodyHTML, FounderEmails::addLink($emailParams,$links));
				$mailCategory = FounderEmailsEvent::CATEGORY_COMPLETE_DIGEST.(!empty($langCode) && $langCode == 'en' ? 'EN' : 'INT');

				// Send the e-mail
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
