<?php

class FounderEmailsEditEvent extends FounderEmailsEvent {
	public function __construct( Array $data = array() ) {
		parent::__construct( 'edit' );
		$this->setData( $data );
	}

	public function enabled ( $wgCityId ) {
 		
		// If digest mode is enabled, do not create edit event notifications
		if ( FounderEmails::getInstance()->getWikiFounder( $wgCityId )->getOption( "founderemails-complete-digest-$wgCityId" ) ) {
			return false;
		}
		if ( FounderEmails::getInstance()->getWikiFounder( $wgCityId )->getOption( "founderemails-edits-$wgCityId" ) ) {
			return true;
		}
		return false;
	}
	
	public function process( Array $events ) {
		global $wgCityId, $wgEnableAnswers, $wgSitename, $wgMemc;
		wfProfileIn( __METHOD__ );

		if ( $this->isThresholdMet( count( $events ) ) ) {
			// get just one event when we have more... for now, just randomly
			$eventData = $events[ rand( 0, count( $events ) -1 ) ];

			$foundingWiki = WikiFactory::getWikiById($wgCityId);
			$founderEmails = FounderEmails::getInstance();
			$emailParams = array(
				'$FOUNDERNAME' => $founderEmails->getWikiFounder()->getName(),
				'$USERNAME' => $eventData['data']['editorName'],
				'$USERPAGEURL' => $eventData['data']['editorPageUrl'],
				'$USERTALKPAGEURL' => $eventData['data']['editorTalkPageUrl'],
				'$UNSUBSCRIBEURL' => $eventData['data']['unsubscribeUrl'],
				'$MYHOMEURL' => $eventData['data']['myHomeUrl'],
				'$WIKINAME' => $wgSitename,
				'$PAGETITLE' => $eventData['data']['titleText'],
				'$PAGEURL' => $eventData['data']['titleUrl'],
				'$WIKIURL' => $foundingWiki->city_url,
			);

			$msgKeys = array();
			$today = date( 'Y-m-d' );
			$wikiType = !empty( $wgEnableAnswers ) ? '-answers' : '';

			$oFounder = $founderEmails->getWikiFounder();

			// BugID: 1961 Quit if the founder email is not confirmed
			if ( !$oFounder->isEmailConfirmed() ) {
				return true;
			}

			$aAllCounter = unserialize( $oFounder->getOption( 'founderemails-counter' ) );
			if ( empty( $aAllCounter ) ) {
				$aAllCounter = array();
			}

			// quit if this particular user has generated an edit email in the last hour
			$memcKey = wfMemcKey("FounderEmail", "EditEvent", $eventData['data']['editorName']);
			if ($wgMemc->get($memcKey) == "1") {
				return true;
			}
			// quit if the Founder has recieved enough emails today			

			$aWikiCounter = empty( $aAllCounter[$wgCityId] ) ? array() : $aAllCounter[$wgCityId];
			
			if ( !empty( $aWikiCounter[0] ) && $aWikiCounter[0] == $today && $aWikiCounter[1] === 'full' ) {
				return true;
			}

			// initialize or reset counter for today
			if ( empty( $aWikiCounter[0] ) || $aWikiCounter[0] !== $today ) {
				$aWikiCounter[0] = $today;
				$aWikiCounter[1] = 0;
			}
			
			$mailCategory = FounderEmailsEvent::CATEGORY_DEFAULT;
			// @FIXME magic number, move to config
			if ( $aWikiCounter[1] === 15 ) {
				$msgKeys['subject'] = 'founderemails-lot-happening-subject';
				$msgKeys['body'] = 'founderemails-lot-happening-body';
				$msgKeys['body-html'] = 'founderemails-lot-happening-body-HTML';
				$mailCategory = FounderEmailsEvent::CATEGORY_EDIT_HIGH_ACTIVITY;
				$mailKey = 'lot-happening';
			} elseif ( $eventData['data']['registeredUserFirstEdit'] ) {
				$msgKeys['subject'] = 'founderemails' . $wikiType . '-email-page-edited-reg-user-first-edit-subject';
				$msgKeys['body'] = 'founderemails' . $wikiType . '-email-page-edited-reg-user-first-edit-body';
				$msgKeys['body-html'] = 'founderemails' . $wikiType . '-email-page-edited-reg-user-first-edit-body-HTML';
				$mailCategory = FounderEmailsEvent::CATEGORY_FIRST_EDIT_USER;
				$mailKey = 'first-edit';
			} elseif ( $eventData['data']['registeredUser'] ) {
				$msgKeys['subject'] = 'founderemails' . $wikiType . '-email-page-edited-reg-user-subject';
				$msgKeys['body'] = 'founderemails' . $wikiType . '-email-page-edited-reg-user-body';
				$msgKeys['body-html'] = 'founderemails' . $wikiType . '-email-page-edited-reg-user-body-HTML';
				$mailCategory = FounderEmailsEvent::CATEGORY_EDIT_USER;
				$mailKey = 'general-edit';
			} else {
				$msgKeys['subject'] = 'founderemails' . $wikiType . '-email-page-edited-anon-subject';
				$msgKeys['body'] = 'founderemails' . $wikiType . '-email-page-edited-anon-body';
				$msgKeys['body-html'] = 'founderemails' . $wikiType . '-email-page-edited-anon-body-HTML';
				$mailCategory = FounderEmailsEvent::CATEGORY_EDIT_ANON;
				$mailKey = 'anon-edit';
			}

			// Set flag so this user won't generate edit notifications for 1 hour
			$wgMemc->set($memcKey, "1", 3600);
			
			// Increment counter for daily notification limit
			$aWikiCounter[1] = ( $aWikiCounter[1] === 15 ) ? 'full' : $aWikiCounter[1] + 1;
			$aAllCounter[$wgCityId] = $aWikiCounter;

			$oFounder->setOption( 'founderemails-counter', serialize( $aAllCounter ) );
			$oFounder->saveSettings();

			$langCode = $oFounder->getOption( 'language' );
			$mailCategory .= (!empty($langCode) && $langCode == 'en' ? 'EN' : 'INT');
			$mailSubject = strtr(wfMsgExt($msgKeys['subject'], array('content')), $emailParams);
			$mailBody = strtr(wfMsgExt($msgKeys['body'], array('content')), $emailParams);

			if(!empty($langCode) && $langCode == 'en' && empty( $wgEnableAnswers )) { // FounderEmailv2.1
				$links = array(
					'$USERNAME' => $emailParams['$USERPAGEURL'],
					'$PAGETITLE' => $emailParams['$PAGEURL'],
					'$WIKINAME' => $emailParams['$WIKIURL'],
				);
				$mailBodyHTML = wfRenderModule("FounderEmails", "GeneralUpdate", array_merge($emailParams, array('language' => 'en', 'type' => $mailKey)));
				$mailBodyHTML = strtr($mailBodyHTML, FounderEmails::addLink($emailParams,$links));
			} else {	// old emails
				$mailBodyHTML = $this->getLocalizedMsg( $msgKeys['body-html'], $emailParams );
			}

			wfProfileOut( __METHOD__ );
			$founderEmails->notifyFounder( $this, $mailSubject, $mailBody, $mailBodyHTML, $wgCityId, $mailCategory );
			return true;
		}

		wfProfileOut( __METHOD__ );
		return false;
	}

	public static function register( $oRecentChange ) {
		global $wgUser, $wgCityId;
		wfProfileIn( __METHOD__ );

		if ( FounderEmails::getInstance()->getLastEventType() == 'register' ) {
			// special case: creating userpage after user registration, ignore event
			wfProfileOut( __METHOD__ );
			return true;
		}

		$isRegisteredUser = false;
		$isRegisteredUserFirstEdit = false;

		if ( $oRecentChange->getAttribute( 'rc_user' ) ) {
			$editor = ( $wgUser->getId() == $oRecentChange->getAttribute( 'rc_user' ) ) ? $wgUser : User::newFromID( $oRecentChange->getAttribute( 'rc_user' ) );
			$isRegisteredUser = true;

			if ( class_exists( 'Masthead' ) ) {
				$userStats = Masthead::getUserStatsData( $editor->getName(), true );
				if ( $userStats['editCount'] == 1 ) {
					$isRegisteredUserFirstEdit = true;
				}
			}
		} else {
			// Anon user
			$editor = ( $wgUser->getName() == $oRecentChange->getAttribute( 'rc_user_text' ) ) ? $wgUser : User::newFromName( $oRecentChange->getAttribute( 'rc_user_text' ), false );
		}

		$config = FounderEmailsEvent::getConfig( 'edit' );
		if ( ( $editor->getId() == FounderEmails::getInstance()->getWikiFounder()->getId() ) || in_array( 'staff', $editor->getGroups() ) || in_array( $editor->getId(), $config['skipUsers'] ) ) {
			// page edited by founder, staff member or excluded user, skipping..
			wfProfileOut( __METHOD__ );
			return true;
		}

		if ( $editor->isAllowed( 'bot' ) ) {
			// skip bots
			wfProfileOut( __METHOD__ );
			return true;
		}

		// Build unsubscribe url
		$wikiFounder = FounderEmails::getInstance()->getWikiFounder();
		$hash_url = Wikia::buildUserSecretKey( $wikiFounder->getName(), 'sha256' );
		$unsubscribe_url = Title::newFromText('Unsubscribe', NS_SPECIAL)->getFullURL( array( 'key' => $hash_url ) );

		$oTitle = Title::makeTitle( $oRecentChange->getAttribute( 'rc_namespace' ), $oRecentChange->getAttribute( 'rc_title' ) );
		$eventData = array(
			'titleText' => $oTitle->getText(),
			'titleUrl' => $oTitle->getFullUrl(),
			'editorName' => $editor->getName(),
			'editorPageUrl' => $editor->getUserPage()->getFullUrl(),
			'editorTalkPageUrl' => $editor->getTalkPage()->getFullUrl(),
			'registeredUser' => $isRegisteredUser,
			'registeredUserFirstEdit' => $isRegisteredUserFirstEdit,
			'unsubscribeUrl' => $unsubscribe_url,
			'myHomeUrl' => Title::newFromText( 'WikiActivity', NS_SPECIAL )->getFullUrl()
		);

		FounderEmails::getInstance()->registerEvent( new FounderEmailsEditEvent( $eventData ) );

		wfProfileOut( __METHOD__ );
		return true;
	}
}
