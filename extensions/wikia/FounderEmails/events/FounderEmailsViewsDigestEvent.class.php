<?php
class FounderEmailsViewsDigestEvent extends FounderEmailsEvent {
	public function __construct( Array $data = array() ) {
		parent::__construct( 'viewsDigest' );
		$this->setData( $data );
	}

	public function enabled ( $wgCityId ) {
		// If complete digest mode is enabled, do not send views only digest
		if ( FounderEmails::getInstance()->getWikiFounder( $wgCityId )->getOption( "founderemails-complete-digest-$wgCityId" ) ) {
			return false;
		}
		if ( FounderEmails::getInstance()->getWikiFounder( $wgCityId )->getOption( "founderemails-views-digest-$wgCityId" ) ) {
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
		global $wgSharedDB, $wgCityId, $wgTitle;
		wfProfileIn( __METHOD__ );
		$founderEmailObj = FounderEmails::getInstance();

		$cWikiId = ( $wgSharedDB ) ? WikiFactory::DBtoID( $wgSharedDB ) : $wgCityId;
		$wgTitle = Title::newMainPage();
		// Get list of founders with digest mode turned on
		$cityList = $founderEmailObj->getFoundersWithPreference('founderemails-views-digest');
		
		// Gather daily page view stats for each wiki requesting views digest		
		foreach ($cityList as $cityID) {
			
			$foundingUser = $founderEmailObj->getWikiFounder($cityID);
			$foundingWiki = WikiFactory::getWikiById( $cityID );
			$hash_url = Wikia::buildUserSecretKey( $foundingUser->getName(), 'sha256' );
			$unsubscribe_url = GlobalTitle::newFromText('Unsubscribe', NS_SPECIAL, $cWikiId )->getFullURL( array( 'key' => $hash_url ) );
			$page_url = GlobalTitle::newFromText( 'Createpage', NS_SPECIAL, $cityID )->getFullUrl( array('modal' => 'AddPage') );

			$emailParams = array(
				'$FOUNDERNAME' => $foundingUser->getName(),
				'$UNSUBSCRIBEURL' => $unsubscribe_url,
				'$WIKINAME' => $foundingWiki->city_sitename,
				'$WIKIURL' => $foundingWiki->city_url,
				'$PAGEURL' => $page_url,
				'$UNIQUEVIEWS' => $founderEmailObj->getPageViews( $cityID ),				
			);

			$langCode = $foundingUser->getOption( 'language' );
			// Only send digest emails for English users until translation is done 
			if ($langCode == 'en') {
				$mailSubject = strtr(wfMsgExt('founderemails-email-views-digest-subject', array('content')), $emailParams);
				$mailBody = strtr(wfMsgExt('founderemails-email-views-digest-body', array('content')), $emailParams);
				$mailBodyHTML = wfRenderModule("FounderEmails", "GeneralUpdate", array_merge($emailParams, array('language' => 'en', 'type' => 'views-digest')));
				$mailBodyHTML = strtr($mailBodyHTML, $emailParams);
				$mailCategory = FounderEmailsEvent::CATEGORY_VIEWS_DIGEST.(!empty($langCode) && $langCode == 'en' ? 'EN' : 'INT');

				$founderEmailObj->notifyFounder( $this, $mailSubject, $mailBody, $mailBodyHTML, $cityID, $mailCategory );
			}
		}
		wfProfileOut( __METHOD__ );		
	}

	/*  Not used by DailyDigest event
	public static function register ( ) {
		
	}
	 */
}
