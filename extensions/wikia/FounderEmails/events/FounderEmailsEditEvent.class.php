<?php

class FounderEmailsEditEvent extends FounderEmailsEvent {
	public function __construct( Array $data = array() ) {
		parent::__construct( 'edit' );
		$this->setData( $data );
	}

	public function enabled ( $wgCityId, $user ) {
		if (self::isAnswersWiki())
			return false;

		// If digest mode is enabled, do not create edit event notifications
		if ( $user->getOption( "founderemails-complete-digest-$wgCityId" ) ) {
			return false;
		}
		if ( $user->getOption( "founderemails-edits-$wgCityId" ) ) {
			return true;
		}
		return false;
	}

	public function process( Array $events ) {
		global $wgCityId, $wgEnableAnswers, $wgMemc;
		wfProfileIn( __METHOD__ );

		if ( $this->isThresholdMet( count( $events ) ) ) {
			// get just one event when we have more... for now, just randomly
			$eventData = $events[ rand( 0, count( $events ) -1 ) ];

			// quit if this particular user has generated an edit email in the last hour
			$memcKey = wfMemcKey("FounderEmail", "EditEvent", $eventData['data']['editorName']);
			if ($wgMemc->get($memcKey) == "1") {
				wfProfileOut( __METHOD__ );
				return true;
			}

			$foundingWiki = WikiFactory::getWikiById($wgCityId);
			$founderEmailObj = FounderEmails::getInstance();
			$wikiService = (new WikiService);
			$user_ids = $wikiService->getWikiAdminIds();
			$emailParams = array(
				'$EDITORNAME' => $eventData['data']['editorName'],
				'$EDITORPAGEURL' => $eventData['data']['editorPageUrl'],
				'$EDITORTALKPAGEURL' => $eventData['data']['editorTalkPageUrl'],
				'$MYHOMEURL' => $eventData['data']['myHomeUrl'],
				'$WIKINAME' => $foundingWiki->city_title,
				'$PAGETITLE' => $eventData['data']['titleText'],
				'$PAGEURL' => $eventData['data']['titleUrl'],
				'$WIKIURL' => $foundingWiki->city_url,
			);

			$msgKeys = array();
			$today = date( 'Y-m-d' );
			$wikiType = !empty( $wgEnableAnswers ) ? '-answers' : '';

			foreach($user_ids as $user_id) {
				$user = User::newFromId($user_id);

				// skip if not enable
				if (!$this->enabled($wgCityId, $user)) {
					continue;
				}

				// skip if reciever is the editor
				if ($user->getName() == $eventData['data']['editorName']) {
					continue;
				}

				// BugID: 1961 Quit if the founder email is not confirmed
				if ( !$user->isEmailConfirmed() ) {
					wfProfileOut( __METHOD__ );
					return true;
				}

				$aAllCounter = unserialize( $user->getOption( 'founderemails-counter' ) );
				if ( empty( $aAllCounter ) ) {
					$aAllCounter = array();
				}

				// quit if the Founder has recieved enough emails today

				$aWikiCounter = empty( $aAllCounter[$wgCityId] ) ? array() : $aAllCounter[$wgCityId];

				if ( !empty( $aWikiCounter[0] ) && $aWikiCounter[0] == $today && $aWikiCounter[1] === 'full' ) {
					wfProfileOut( __METHOD__ );
					return true;
				}

				// initialize or reset counter for today
				if ( empty( $aWikiCounter[0] ) || $aWikiCounter[0] !== $today ) {
					$aWikiCounter[0] = $today;
					$aWikiCounter[1] = 0;
				}
				self::addParamsUser($wgCityId, $user->getName(), $emailParams);
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

				$user->setOption( 'founderemails-counter', serialize( $aAllCounter ) );
				$user->saveSettings();

				$langCode = $user->getOption( 'language' );
				$mailCategory .= (!empty($langCode) && $langCode == 'en' ? 'EN' : 'INT');
				$mailSubject = strtr(wfMsgExt($msgKeys['subject'], array('content')), $emailParams);
				$mailBody = strtr(wfMsgExt($msgKeys['body'], array('content')), $emailParams);

				if(empty( $wgEnableAnswers )) { // FounderEmailv2.1
					$links = array(
						'$EDITORNAME' => $emailParams['$EDITORPAGEURL'],
						'$PAGETITLE' => $emailParams['$PAGEURL'],
						'$WIKINAME' => $emailParams['$WIKIURL'],
					);
					$mailBodyHTML = F::app()->renderView("FounderEmails", "GeneralUpdate", array_merge($emailParams, array('language' => 'en', 'type' => $mailKey)));
					$mailBodyHTML = strtr($mailBodyHTML, FounderEmails::addLink($emailParams,$links));
				} else {	// old emails
					$mailBodyHTML = $this->getLocalizedMsg( $msgKeys['body-html'], $emailParams );
				}

				wfProfileOut( __METHOD__ );
				$founderEmailObj->notifyFounder( $user, $this, $mailSubject, $mailBody, $mailBodyHTML, $wgCityId, $mailCategory );
			}
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
		if ( in_array( 'staff', $editor->getGroups() ) || in_array( $editor->getId(), $config['skipUsers'] ) ) {
			// page edited by founder, staff member or excluded user, skipping..
			wfProfileOut( __METHOD__ );
			return true;
		}

		if ( $editor->isAllowed( 'bot' ) ) {
			// skip bots
			wfProfileOut( __METHOD__ );
			return true;
		}

		$oTitle = Title::makeTitle( $oRecentChange->getAttribute( 'rc_namespace' ), $oRecentChange->getAttribute( 'rc_title' ) );
		$eventData = array(
			'titleText' => $oTitle->getText(),
			'titleUrl' => $oTitle->getFullUrl(),
			'editorName' => $editor->getName(),
			'editorPageUrl' => $editor->getUserPage()->getFullUrl(),
			'editorTalkPageUrl' => $editor->getTalkPage()->getFullUrl(),
			'registeredUser' => $isRegisteredUser,
			'registeredUserFirstEdit' => $isRegisteredUserFirstEdit,
			'myHomeUrl' => Title::newFromText( 'WikiActivity', NS_SPECIAL )->getFullUrl()
		);

		FounderEmails::getInstance()->registerEvent( new FounderEmailsEditEvent( $eventData ) );

		wfProfileOut( __METHOD__ );
		return true;
	}
}
