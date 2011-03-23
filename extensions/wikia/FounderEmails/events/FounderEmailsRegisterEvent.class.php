<?php

class FounderEmailsRegisterEvent extends FounderEmailsEvent {
	public function __construct( Array $data = array() ) {
		parent::__construct( 'register' );
		$this->setData( $data );
	}

	public function process( Array $events ) {
		global $wgEnableAnswers, $wgSitename;
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
			$mailSubject = $this->getLocalizedMsgBody( 'founderemails' . $wikiType . '-email-user-registered-subject', $langCode, array() );
			$mailBody = $this->getLocalizedMsgBody( 'founderemails' . $wikiType . '-email-user-registered-body', $langCode, $emailParams );
			$mailBodyHTML = $this->getLocalizedMsgBody( 'founderemails' . $wikiType . '-email-user-registered-body-HTML', $langCode, $emailParams );
			
			$mailCategory = FounderEmailsEvent::CATEGORY_REGISTERED.(!empty($langCode) && $langCode == 'en' ? 'EN' : 'INT');

			wfProfileOut( __METHOD__ );
			return $founderEmails->notifyFounder( $mailSubject, $mailBody, $mailBodyHTML, $mailCategory );
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
