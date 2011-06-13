<?php

class FounderEmailsRegisterEvent extends FounderEmailsEvent {
	public function __construct( Array $data = array() ) {
		parent::__construct( 'register' );
		$this->setData( $data );
	}

	public function enabled ( $wgCityId ) {
 		
		// If digest mode is enabled, do not create user registration event notifications
		if ( FounderEmails::getInstance()->getWikiFounder()->getOption( "founderemails-complete-digest-$wgCityId" ) ) {
			return false;
		}
		if ( FounderEmails::getInstance()->getWikiFounder()->getOption( "founderemails-joins-$wgCityId" ) ) {
			return true;
		}
		return false;
	}
	
	public function process( Array $events ) {
		global $wgEnableAnswers, $wgSitename, $wgCityId;
		wfProfileIn( __METHOD__ );

		if ( $this->isThresholdMet( count( $events ) ) ) {
			// get just one event when we have more... for now, just randomly
			$eventData = $events[rand( 0, count( $events ) -1 )];

			$founderEmails = FounderEmails::getInstance();
			$emailParams = array(
				'$FOUNDERNAME' => $founderEmails->getWikiFounder()->getName(),
				'$USERNAME' => $eventData['data']['userName'],
				'$USERPAGEURL' => $eventData['data']['userPageUrl'],
				'$USERTALKPAGEURL' => $eventData['data']['userTalkPageUrl'],
				'$UNSUBSCRIBEURL' => $eventData['data']['unsubscribeUrl'],
				'$WIKINAME' => $wgSitename,
			);

			$wikiType = !empty( $wgEnableAnswers ) ? '-answers' : '';
			$langCode = $founderEmails->getWikiFounder()->getOption( 'language' );
			$mailSubject = $this->getLocalizedMsg( 'founderemails' . $wikiType . '-email-user-registered-subject', $emailParams );
			$mailBody = $this->getLocalizedMsg( 'founderemails' . $wikiType . '-email-user-registered-body', $emailParams );
			
			if(!empty($langCode) && $langCode == 'en' && empty( $wgEnableAnswers )) { // FounderEmailv2.1
				$mailBodyHTML = wfRenderModule("FounderEmails", "GeneralUpdate", array_merge($emailParams, array('language' => 'en', 'type' => 'user-registered')));
				$mailBodyHTML = strtr($mailBodyHTML, $emailParams);
			} else {
				$mailBodyHTML = $this->getLocalizedMsg( 'founderemails' . $wikiType . '-email-user-registered-body-HTML', $emailParams );
			}
			
			$mailCategory = FounderEmailsEvent::CATEGORY_REGISTERED.(!empty($langCode) && $langCode == 'en' ? 'EN' : 'INT');

			wfProfileOut( __METHOD__ );
			return $founderEmails->notifyFounder( $this, $mailSubject, $mailBody, $mailBodyHTML, $wgCityId, $mailCategory );
		}

		wfProfileOut( __METHOD__ );
		return false;
	}

	public static function register( $user ) {
		wfProfileIn( __METHOD__ );

		// Build unsubscribe url
		$wikiFounder = FounderEmails::getInstance()->getWikiFounder();
		$hash_url = Wikia::buildUserSecretKey( $wikiFounder->getName(), 'sha256' );
		$unsubscribe_url = Title::newFromText('Unsubscribe', NS_SPECIAL)->getFullURL( array( 'key' => $hash_url, 'ctc' => 'FE04' ) );

		$eventData = array(
			'userName' => $user->getName(),
			'userPageUrl' => $user->getUserPage()->getFullUrl( 'ctc=FE01' ),
			'userTalkPageUrl' => $user->getTalkPage()->getFullUrl( 'ctc=FE01' ),
			'unsubscribeUrl' => $unsubscribe_url
		);

		FounderEmails::getInstance()->registerEvent( new FounderEmailsRegisterEvent( $eventData ) );

		wfProfileOut( __METHOD__ );
		return true;
	}
}
