<?php

class FounderEmailsDaysPassedEvent extends FounderEmailsEvent {

	public function __construct(Array $data = array()) {
		parent::__construct( 'daysPassed' );
		$this->setData($data);
	}

	public function process( Array $events ) {
		global $wgExternalSharedDB;
		wfProfileIn( __METHOD__ );

		$founderEmails = FounderEmails::getInstance();
		foreach($events as $event) {
			$wikiId = $event['wikiId'];
			$activateTime = $event['data']['activateTime'];
			$activateDays = $event['data']['activateDays'];

			if( time() >= $activateTime ) {

				$emailParams = array(
					'$FOUNDERNAME' => $event['data']['founderUsername'],
					'$FOUNDERPAGEEDITURL' => $event['data']['founderUserpageEditUrl'],
					'$WIKINAME' => $event['data']['wikiName'],
					'$WIKIURL' => $event['data']['wikiUrl'],
					'$WIKIMAINPAGEURL' => $event['data']['wikiMainpageUrl'],
					'$UNSUBSCRIBEURL' => $event['data']['unsubscribeUrl']
				);

				$langCode = $founderEmails->getWikiFounder( $wikiId )->getOption('language');
				$mailSubject = $this->getLocalizedMsgBody( 'founderemails-email-' . $activateDays . '-days-passed-subject', $langCode, array() );
				$mailBody = $this->getLocalizedMsgBody( 'founderemails-email-' . $activateDays . '-days-passed-body', $langCode, $emailParams );
				$mailBodyHTML = $this->getLocalizedMsgBody( 'founderemails-email-' . $activateDays . '-days-passed-body-HTML', $langCode, $emailParams );

				$founderEmails->notifyFounder( $mailSubject, $mailBody, $mailBodyHTML, $wikiId );

				$dbw = wfGetDB( DB_MASTER, array(), $wgExternalSharedDB );
				$dbw->delete( 'founder_emails_event', array( 'feev_id' => $event['id'] ) );
			}
		}

		// always return false to prevent deleting from FounderEmails::processEvent
		wfProfileOut( __METHOD__ );
		return false;
	}

	public static function register( $wikiParams, $debugMode = false ) {
		global $wgFounderEmailsExtensionConfig;
		wfProfileIn( __METHOD__ );

		$founderEmails = FounderEmails::getInstance();
		$wikiFounder = $founderEmails->getWikiFounder();
		$mainpageTitle = Title::newFromText( wfMsgForContent('Mainpage') );
		foreach($wgFounderEmailsExtensionConfig['events']['daysPassed']['days'] as $daysToActivate) {
			switch($daysToActivate) {
				case 0:
					$ctcUnsubscribe = 'FE03';
					break;
				case 3:
					$ctcUnsubscribe = 'FE08';
					break;
				case 10:
					$ctcUnsubscribe = 'FE09';
					break;
				default:
					$ctcUnsubscribe = 'FE03';
			}

			$eventData = array(
				'activateDays' => $daysToActivate,
				'activateTime' => time() + ( 86400 * $daysToActivate ),
				'wikiName' => $wikiParams['title'],
				'wikiUrl' => $wikiParams['url'],
				'wikiMainpageUrl' => $mainpageTitle->getFullUrl(),
				'founderUsername' => $wikiFounder->getName(),
				'founderUserpageEditUrl' => $wikiFounder->getUserPage()->getFullUrl( 'action=edit' ),
				'unsubscribeUrl' => Title::newFromText('Preferences', NS_SPECIAL)->getFullUrl( 'ctc=' . $ctcUnsubscribe )
			);

			if($debugMode) {
				$eventData['activateTime'] = 0;
			}

			// set FounderEmails notifications enabled by default for wiki founder
			$wikiFounder->setOption('founderemailsenabled', true);
			$wikiFounder->saveSettings();

			$founderEmails->registerEvent( new FounderEmailsDaysPassedEvent($eventData), false );
		}

		wfProfileOut( __METHOD__ );
		return true;
	}
}
