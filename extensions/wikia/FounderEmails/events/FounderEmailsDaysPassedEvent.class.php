<?php

class FounderEmailsDaysPassedEvent extends FounderEmailsEvent {
	public function __construct( Array $data = array() ) {
		parent::__construct( 'daysPassed' );
		$this->setData( $data );
	}

	public function enabled ( $wgCityId, User $user ) {
		// disable if all Wikia email disabled
		if ( $user->getBoolOption( "unsubscribed" ) ) {
			return false;
		}

		// This type of email cannot be disabled or avoided without unsubscribing from all email
		return true;
	}

	public function process( Array $events ) {
		global $wgExternalSharedDB, $wgEnableAnswers, $wgTitle, $wgContLang;
		wfProfileIn( __METHOD__ );

		$wgTitle = Title::newMainPage();
		$founderEmailObj = FounderEmails::getInstance();
		$wikiService = (new WikiService);
		foreach ( $events as $event ) {
			$wikiId = $event['wikiId'];
			if ($wikiId == 0) continue;  // should "never" happen BugId:12717
			$activateTime = $event['data']['activateTime'];
			$activateDays = $event['data']['activateDays'];

			$user_ids = $wikiService->getWikiAdminIds( $wikiId );
			if ( time() >= $activateTime ) {

				$emailParams = array(
					'$WIKINAME' => $event['data']['wikiName'],
					'$WIKIURL' => $event['data']['wikiUrl'],
					'$WIKIMAINPAGEURL' => $event['data']['wikiMainpageUrl'],
					'$ADDAPAGEURL' => $event['data']['addapageUrl'],
					'$ADDAPHOTOURL' => $event['data']['addaphotoUrl'],
					'$CUSTOMIZETHEMEURL' => $event['data']['customizethemeUrl'],
					'$EDITMAINPAGEURL' => $event['data']['editmainpageUrl'],
					'$EXPLOREURL' => $event['data']['exploreUrl'],
				);

				$wikiType = !empty( $wgEnableAnswers ) ? '-answers' : '';

				foreach ($user_ids as $user_id) {
					$user = User::newFromId($user_id);

					// skip if not enable
					if (!$this->enabled($wikiId, $user)) {
						continue;
					}
					self::addParamsUser($wikiId, $user->getName(), $emailParams);
					$emailParams['$USERPAGEEDITURL'] = $user->getUserPage()->getFullUrl(array('action' => 'edit'));

					$langCode = $user->getOption( 'language' );
					// force loading messages for given languege, to make maintenance script works properly
					$wgContLang = Language::factory($langCode);

					$mailSubject = strtr(wfMsgExt('founderemails' . $wikiType . '-email-' . $activateDays . '-days-passed-subject', array('content')), $emailParams);
					$mailBody = strtr(wfMsgForContent('founderemails' . $wikiType . '-email-' . $activateDays . '-days-passed-body'), $emailParams);
					$mailCategory = FounderEmailsEvent::CATEGORY_DEFAULT;
					if($activateDays == 3) {
						$mailCategory = FounderEmailsEvent::CATEGORY_3_DAY;
					} else if($activateDays == 10) {
						$mailCategory = FounderEmailsEvent::CATEGORY_10_DAY;
					} else if($activateDays == 0) {
						$mailCategory = FounderEmailsEvent::CATEGORY_0_DAY;
					}
					$mailCategory .= (!empty($langCode) && $langCode == 'en' ? 'EN' : 'INT');

					if (empty( $wgEnableAnswers )) {
						$links = array(
							'$WIKINAME' => $emailParams['$WIKIURL'],
						);
						$emailParams_new = FounderEmails::addLink($emailParams,$links);
						$emailParams_new['$HDWIKINAME'] = str_replace('#2C85D5', '#fa5c1f', $emailParams_new['$WIKINAME']);	// header color = #fa5c1f
						$mailBodyHTML = F::app()->renderView("FounderEmails", $event['data']['dayName'], array('language' => 'en'));
						$mailBodyHTML = strtr($mailBodyHTML, $emailParams_new);
					} else {
						$mailBodyHTML = $this->getLocalizedMsg( 'founderemails' . $wikiType . '-email-' . $activateDays . '-days-passed-body-HTML', $emailParams );
					}

					$founderEmailObj->notifyFounder( $user, $this, $mailSubject, $mailBody, $mailBodyHTML, $wikiId, $mailCategory );
				}

				$dbw = wfGetDB( DB_MASTER, array(), $wgExternalSharedDB );
				$dbw->delete( 'founder_emails_event', array( 'feev_id' => $event['id'] ) );
			}
		}

		// always return false to prevent deleting from FounderEmails::processEvent
		wfProfileOut( __METHOD__ );
		return false;
	}

	public static function register( $wikiParams, $debugMode = false ) {
		global $wgFounderEmailsExtensionConfig, $wgCityId;
		wfProfileIn( __METHOD__ );

		$founderEmailObj = FounderEmails::getInstance();
		$wikiFounder = $founderEmailObj->getWikiFounder();
		$mainpageTitle = Title::newFromText( wfMsgForContent( 'Mainpage' ) );

		// set FounderEmails notifications enabled by default for wiki founder
//		$wikiFounder->setOption( 'founderemailsenabled', true );
		$wikiFounder->setOption("founderemails-joins-$wgCityId", true);
		$wikiFounder->setOption("founderemails-edits-$wgCityId", true);

		$wikiFounder->saveSettings();

		foreach ( $wgFounderEmailsExtensionConfig['events']['daysPassed']['days'] as $daysToActivate ) {
			switch( $daysToActivate ) {
				case 0:
					$dayName = 'DayZero';
					$doProcess = true;
					break;
				case 3:
					$dayName = 'DayThree';
					$doProcess = false;
					break;
				case 10:
					$dayName = 'DayTen';
					$doProcess = false;
					break;
				default:
					$dayName = 'DayZero';
					$doProcess = true;
			}

			$mainPage = wfMsgForContent( 'mainpage' );

			$eventData = array(
				'activateDays' => $daysToActivate,
				'activateTime' => time() + ( 86400 * $daysToActivate ),
				'wikiName' => $wikiParams['title'],
				'wikiUrl' => $wikiParams['url'],
				'wikiMainpageUrl' => $mainpageTitle->getFullUrl(),
				'addapageUrl' => Title::newFromText( 'Createpage', NS_SPECIAL )->getFullUrl( array('modal' => 'AddPage') ),
				'addaphotoUrl' => Title::newFromText( 'NewFiles', NS_SPECIAL )->getFullUrl( array('modal' => 'UploadImage') ),
				'customizethemeUrl' => Title::newFromText('ThemeDesigner', NS_SPECIAL)->getFullUrl( array('modal' => 'Login') ),
				'editmainpageUrl' => Title::newFromText($mainPage)->getFullUrl( array('action' => 'edit', 'modal' => 'Login') ),
				'exploreUrl' => 'http://www.wikia.com',
				'dayName' => $dayName,
			);

			if ( $debugMode ) {
				$eventData['activateTime'] = 0;
			}

			$founderEmailObj->registerEvent( new FounderEmailsDaysPassedEvent( $eventData ), $doProcess );
		}

		wfProfileOut( __METHOD__ );
		return true;
	}
}
