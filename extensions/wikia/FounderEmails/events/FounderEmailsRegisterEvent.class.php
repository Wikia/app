<?php

class FounderEmailsRegisterEvent extends FounderEmailsEvent {

	public function __construct(Array $data = array()) {
		parent::__construct( 'register' );
		$this->setData($data);
	}

	public function process( Array $events ) {
		wfProfileIn( __METHOD__ );

		if( $this->isThresholdMet(count($events)) ) {
			// get just one event when we have more... for now, just randomly
			$eventData = $events[rand(0,count($events)-1)];

			$founderEmails = FounderEmails::getInstance();
			$emailParams = array(
				'$FOUNDERNAME' => $founderEmails->getWikiFounder()->getName(),
				'$USERNAME' => $eventData['data']['userName'],
				'$USERPAGEURL' => $eventData['data']['userPageUrl'],
				'$USERTALKPAGEURL' => $eventData['data']['userTalkPageUrl'],
				'$UNSUBSCRIBEURL' => $eventData['data']['unsubscribeUrl']
			);

			$langCode = $founderEmails->getWikiFounder()->getOption('language');
			$mailSubject = $this->getLocalizedMsgBody( 'founderemails-email-user-registered-subject', $langCode, array() );
			$mailBody = $this->getLocalizedMsgBody( 'founderemails-email-user-registered-body', $langCode, $emailParams );
			$mailBodyHTML = $this->getLocalizedMsgBody( 'founderemails-email-user-registered-body-HTML', $langCode, $emailParams );

			wfProfileOut( __METHOD__ );
			return $founderEmails->notifyFounder( $mailSubject, $mailBody, $mailBodyHTML );
		}

		wfProfileOut( __METHOD__ );
		return false;
	}

	public static function register( $user ) {
		wfProfileIn( __METHOD__ );

		$eventData = array(
			'userName' => $user->getName(),
			'userPageUrl' => $user->getUserPage()->getFullUrl('ctc=FE01'),
			'userTalkPageUrl' => $user->getTalkPage()->getFullUrl('ctc=FE01'),
			'unsubscribeUrl' => Title::newFromText('Preferences', NS_SPECIAL)->getFullUrl('ctc=FE04')
		);

		FounderEmails::getInstance()->registerEvent( new FounderEmailsRegisterEvent($eventData) );

		wfProfileOut( __METHOD__ );
		return true;
	}

}
