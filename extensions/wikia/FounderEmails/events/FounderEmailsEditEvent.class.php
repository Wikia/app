<?php

class FounderEmailsEditEvent extends FounderEmailsEvent {

	public function __construct(Array $data = array()) {
		parent::__construct( 'edit' );
		$this->setData($data);
	}

	public function process( Array $events ) {
		wfProfileIn( __METHOD__ );

		if( $this->isThresholdMet(count($events)) ) {
			// get just one event when we have more... for now, just randomly
			$eventData = $events[ rand(0,count($events)-1) ];

			$founderEmails = FounderEmails::getInstance();
			$emailParams = array(
				'$FOUNDERNAME' => $founderEmails->getWikiFounder()->getName(),
				'$USERNAME' => $eventData['data']['editorName'],
				'$USERPAGEURL' => $eventData['data']['editorPageUrl'],
				'$UNSUBSCRIBEURL' => $eventData['data']['unsubscribeUrl']
			);

			$msgKeys = array();
			if( $eventData['data']['registeredUserFirstEdit'] ) {
				$msgKeys['subject'] = 'founderemails-email-page-edited-reg-user-first-edit-subject';
				$msgKeys['body'] = 'founderemails-email-page-edited-reg-user-first-edit-body';
				$msgKeys['body-html'] = 'founderemails-email-page-edited-reg-user-first-edit-body-HTML';
			}
			else {
				$msgKeys['subject'] = 'founderemails-email-page-edited-reg-user-subject';
				$msgKeys['body'] = 'founderemails-email-page-edited-reg-user-body';
				$msgKeys['body-html'] = 'founderemails-email-page-edited-reg-user-body-HTML';
			}

			$langCode = $founderEmails->getWikiFounder()->getOption('language');
			$mailSubject = $this->getLocalizedMsgBody( $msgKeys['subject'], $langCode, array() );
			$mailBody = $this->getLocalizedMsgBody( $msgKeys['body'], $langCode, $emailParams );
			$mailBodyHTML = $this->getLocalizedMsgBody( $msgKeys['body-html'], $langCode, $emailParams );

			wfProfileOut( __METHOD__ );
			return $founderEmails->notifyFounder( $mailSubject, $mailBody, $mailBodyHTML );
		}

		wfProfileOut( __METHOD__ );
		return false;
	}

	public static function register( $oRecentChange ) {
		global $wgUser;
		wfProfileIn( __METHOD__ );

		if( FounderEmails::getInstance()->getLastEventType() == 'register' ) {
			// special case: creating userpage after user registration, ignore event
			wfProfileOut( __METHOD__ );
			return true;
		}

		$isRegisteredUser = false;
		$isRegisteredUserFirstEdit = false;
		$ctcUserpage = 'FE02';
		$ctcUnsubscribe = 'FE05';

		if( $oRecentChange->getAttribute('rc_user') ) {
			$editor = ( $wgUser->getId() == $oRecentChange->getAttribute('rc_user') ) ? $wgUser : User::newFromID( $oRecentChange->getAttribute('rc_user') );
			$isRegisteredUser = true;

			if( class_exists('Masthead') ) {
				$userStats = Masthead::getUserStatsData($editor->getName(), true);
				if( $userStats['editCount'] == 1 ) {
					$isRegisteredUserFirstEdit = true;
					$ctcUserpage = 'FE06';
					$ctcUnsubscribe = 'FE07';
				}
			}
		}
		else {
			// Anon user
			$editor = ( $wgUser->getName() == $oRecentChange->getAttribute('rc_user_text') ) ? $wgUser : User::newFromName( $oRecentChange->getAttribute('rc_user_text'), false );
		}

		$config = FounderEmailsEvent::getConfig( 'edit' );
		if( ( $editor->getId() == FounderEmails::getInstance()->getWikiFounder()->getId() ) || in_array( 'staff', $editor->getGroups() ) || in_array( $editor->getId(), $config['skipUsers'] ) ) {
			// page edited by founder, staff member or excluded user, skipping..
			wfProfileOut( __METHOD__ );
			return true;
		}

		$oTitle = Title::makeTitle( $oRecentChange->getAttribute('rc_namespace'), $oRecentChange->getAttribute('rc_title') );
		$eventData = array(
			'titleText' => $oTitle->getText(),
			'titleUrl' => $oTitle->getFullUrl(),
			'editorName' => $editor->getName(),
			'editorPageUrl' => $editor->getUserPage()->getFullUrl( 'ctc=' . $ctcUserpage ),
			'registeredUser' => $isRegisteredUser,
			'registeredUserFirstEdit' => $isRegisteredUserFirstEdit,
			'unsubscribeUrl' => Title::newFromText('Preferences', NS_SPECIAL)->getFullUrl( 'ctc=' . $ctcUnsubscribe )
		);

		FounderEmails::getInstance()->registerEvent( new FounderEmailsEditEvent($eventData) );

		wfProfileOut( __METHOD__ );
		return true;
	}

}
