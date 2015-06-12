<?php

class FounderEmailsEditEvent extends FounderEmailsEvent {

	/**
	 * Prefix for memcache key storing information about whether first edit notification was sent
	 */
	const FIRST_EDIT_NOTIFICATION_SENT_MEMC_PREFIX = 'founderemails-first-edit-notification-sent';

	/**
	 * Period describing how long to throttle of emails; default of 1 hour
	 */
	const USER_EMAILS_THROTTLE_EXPIRY_TIME = 3600;

	/**
	 * Minimum number of non-profile edit revisions needed to determine if user made only
	 * one edit on a wiki
	 */
	const FIRST_EDIT_REVISION_THRESHOLD = 2;

	const DAILY_NOTIFICATION_LIMIT = 15;

	/**
	 * Constansts for describing Users edit status for purpose of sending founder notification
	 * on first edit
	 */
	const NO_EDITS = 0;
	const FIRST_EDIT = 1;
	const MULTIPLE_EDITS = 2;


	public function __construct( Array $data = array() ) {
		parent::__construct( 'edit' );
		$this->setData( $data );
	}

	public function enabled ( $wgCityId, User $user ) {
		if ( self::isAnswersWiki() ) {
			return false;
		}

		// disable if all Wikia email disabled
		if ( $user->getBoolOption( 'unsubscribed' ) ) {
			return false;
		}

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
		global $wgCityId, $wgMemc;

		if ( !$this->isThresholdMet( count( $events ) ) ) {
			return false;
		}

		// get just one event when we have more... for now, just randomly
		$eventData = $events[ rand( 0, count( $events ) -1 ) ];

		// quit if this particular user has generated an edit email in the last hour
		$memcKey = wfMemcKey( 'FounderEmail', 'EditEvent', $eventData['data']['editorName'] );
		if ( $wgMemc->get( $memcKey ) == '1' ) {
			return true;
		}
		// Set flag so this user won't generate edit notifications for given period of time
		$wgMemc->set( $memcKey, '1', self::USER_EMAILS_THROTTLE_EXPIRY_TIME );

		$foundingWiki = WikiFactory::getWikiById( $wgCityId );
		$wikiService = new WikiService();
		$user_ids = $wikiService->getWikiAdminIds();
		$emailParams = [
			'$EDITORNAME' => $eventData['data']['editorName'],
			'$EDITORPAGEURL' => $eventData['data']['editorPageUrl'],
			'$EDITORTALKPAGEURL' => $eventData['data']['editorTalkPageUrl'],
			'$MYHOMEURL' => $eventData['data']['myHomeUrl'],
			'$WIKINAME' => $foundingWiki->city_title,
			'$PAGETITLE' => $eventData['data']['titleText'],
			'$PAGENS' => $eventData['data']['titleNs'],
			'$PAGEURL' => $eventData['data']['titleUrl'],
			'$WIKIURL' => $foundingWiki->city_url,
		];

		foreach ( $user_ids as $user_id ) {
			$user = User::newFromId( $user_id );
			if ( $this->shouldSkipUser( $user, $eventData ) ) {
				continue;
			}

			// Increase the count of notifications we've made on this wiki
			$this->updateUserNotificationCount( $user );

			self::addParamsUser( $wgCityId, $user->getName(), $emailParams );
			$mailCategory = $mailKey = '';
			$msgKeys = [];

			if ( $this->hasHitNotificationLimit( $user ) ) {
				$msgKeys['subject'] = 'founderemails-lot-happening-subject';
				$msgKeys['body'] = 'founderemails-lot-happening-body';
				$msgKeys['body-html'] = 'founderemails-lot-happening-body-HTML';
				$mailCategory = FounderEmailsEvent::CATEGORY_EDIT_HIGH_ACTIVITY;
				$mailKey = 'lot-happening';
			} elseif ( $eventData['data']['registeredUserFirstEdit'] ) {
				$controller = 'Email\Controller\FounderEdit';
			} elseif ( $eventData['data']['registeredUser'] ) {
				$controller = 'Email\Controller\FounderMultiEdit';
			} else {
				$controller = 'Email\Controller\FounderAnonEdit';
			}

			if ( !empty( $controller ) ) {
				$this->sendUsingEmailExtension( $controller, $user, $emailParams );
			} else {
				$this->sendEmailDirectly( $user, $mailCategory, $emailParams, $msgKeys, $mailKey );
			}
		}

		return true;
	}

	private function shouldSkipUser( User $user, array $eventData ) {
		// skip if not enabled
		if ( !$this->enabled( F::app()->wg->CityId, $user ) ) {
			return true;
		}

		// skip if receiver is the editor
		if ( $user->getName() == $eventData['data']['editorName'] ) {
			return true;
		}

		// BugID: 1961 Quit if the founder email is not confirmed
		if ( !$user->isEmailConfirmed() ) {
			return true;
		}

		if ( $this->hasExceededNotificationLimit( $user ) ) {
			return true;
		}

		return false;
	}

	private function hasExceededNotificationLimit( User $user ) {
		$count = $this->getUserNotificationCount( $user );
		if ( $count > self::DAILY_NOTIFICATION_LIMIT ) {
			return true;
		}
	}

	private function hasHitNotificationLimit( User $user ) {
		$count = $this->getUserNotificationCount( $user );
		if ( $count == self::DAILY_NOTIFICATION_LIMIT ) {
			return true;
		}
	}

	private function getUserNotificationCount( User $user ) {
		$counter = $this->getNotificationCounter( $user );
		return $counter[F::app()->wg->CityId]['count'];
	}

	/**
	 * Keeps a pre request cache of the 'founderemails-counter' user option
	 *
	 * @param User $user
	 *
	 * @return mixed
	 */
	private function getNotificationCounter( User $user ) {
		static $counter = null;

		if ( empty( $counter[$user->getId()] ) ) {
			$allCounter = unserialize( $user->getOption( 'founderemails-counter' ) );
			if ( $this->userCounterNeedsReset( $allCounter ) ) {
				$allCounter[F::app()->wg->CityId] = [
					'date'  => date( 'Y-m-d' ),
					'count' => 0,
				];
			}

			$counter[$user->getId()] = $allCounter;
		}

		return $counter[$user->getId()];
	}

	private function userCounterNeedsReset( array $counter ) {
		if ( empty( $counter[F::app()->wg->CityId] ) ) {
			return true;
		}

		$today = date( 'Y-m-d' );
		$wikiCounter = $counter[F::app()->wg->CityId];
		return empty( $wikiCounter['date'] ) || $wikiCounter['date'] !== $today;
	}

	private function updateUserNotificationCount( User $user ) {
		$counter = $this->getNotificationCounter( $user );
		$counter[F::app()->wg->CityId]['count']++;

		$user->setOption( 'founderemails-counter', serialize( $counter ) );
		$user->saveSettings();
	}

	private function sendUsingEmailExtension( $controller, User $user, array $emailParams ) {
		$params = [
			'targetUser' => $user->getName(),
			'currentUser' => $emailParams['$EDITORNAME'],
			'pageTitle' => $emailParams['$PAGETITLE'],
			'pageNs' => $emailParams['$PAGENS'],
		];

		F::app()->sendRequest( $controller, 'handle', $params );
	}

	private function sendEmailDirectly( User $user, $mailCategory, array $emailParams, array $msgKeys, $mailKey ) {
		$langCode = $user->getOption( 'language' );
		$mailCategory .= ( !empty( $langCode ) && $langCode == 'en' ? 'EN' : 'INT' );
		$mailSubject = strtr( wfMsgExt( $msgKeys['subject'], array( 'content' ) ), $emailParams );
		$mailBody = strtr( wfMsgExt( $msgKeys['body'], array( 'content' ) ), $emailParams );

		if ( empty( F::app()->wg->EnableAnswers ) ) { // FounderEmailv2.1
			$links = array(
				'$EDITORNAME' => $emailParams['$EDITORPAGEURL'],
				'$PAGETITLE' => $emailParams['$PAGEURL'],
				'$WIKINAME' => $emailParams['$WIKIURL'],
			);
			$mailBodyHTML = F::app()->renderView(
				'FounderEmails',
				'GeneralUpdate',
				array_merge( $emailParams, [ 'language' => 'en', 'type' => $mailKey ] )
			);
			$mailBodyHTML = strtr( $mailBodyHTML, FounderEmails::addLink( $emailParams, $links ) );
		} else {	// old emails
			$mailBodyHTML = $this->getLocalizedMsg( $msgKeys['body-html'], $emailParams );
		}

		FounderEmails::getInstance()->notifyFounder(
			$user,
			$this,
			$mailSubject,
			$mailBody,
			$mailBodyHTML,
			F::app()->wg->CityId,
			$mailCategory
		);
	}

	/**
	 * Returns whether the user made no edits, first edit
	 * or multiple edits (excluding profile page edits)
	 *
	 * @param User $user
	 * @param bool $useMasterDb
	 * @returns int one of:
	 * 		FounderEmailsEditEvent::NO_EDITS
	 * 		FounderEmailsEditEvent::FIRST_EDIT
	 * 		FounderEmailsEditEvent::MULTIPLE_EDITS
	 */
	static public function getUserEditsStatus( $user, $useMasterDb = false ) {
		wfProfileIn( __METHOD__ );

		$recentEditsCount = 0;
		$dbr = wfGetDB( $useMasterDb ? DB_MASTER : DB_SLAVE );

		$conditions = [
			'rev_user' => $user->getId(),
		];

		$userPageId = $user->getUserPage()->getArticleID();

		if ( $userPageId ) {
			$conditions[] = "rev_page != $userPageId";
		}

		$dbResult = $dbr->select(
			[ 'revision' ],
			[ 'rev_id' ],
			$conditions,
			__METHOD__,
			[
				'LIMIT' => self::FIRST_EDIT_REVISION_THRESHOLD,
				'ORDER BY' => 'rev_timestamp DESC'
			]
		);

		while ( $row = $dbr->FetchObject( $dbResult ) ) {
			$recentEditsCount++;
		}

		wfProfileOut( __METHOD__ );

		return $recentEditsCount;
	}

	/**
	 * @param RecentChange|null $oRecentChange we allow it to be null because of compatibility with FounderEmailsEvent::register()
	 *
	 * @return bool
	 *
	 * @throws Exception
	 */
	public static function register( $oRecentChange = null ) {
		global $wgUser;
		wfProfileIn( __METHOD__ );

		if ( is_null( $oRecentChange ) ) {
			throw new \Exception( 'Invalid $oRecentChange value.' );
		}

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

			// if first edit email was already sent this is an additional edit
			$wasNotificationSent = ( static::getFirstEmailSentFlag( $editor->getName() ) === '1' ) ;

			if ( !$wasNotificationSent ) {
				$userEditStatus = static::getUserEditsStatus( $editor, true );
				/*
					If there is at least one edit, flag that we should not send this email anymore;
					either first email is sent out as a result of this request,
					or there was more than 1 edit so we will never need to send it again
				 */
				switch ( $userEditStatus ) {
					case self::NO_EDITS:
						wfProfileOut( __METHOD__ );
						return true;
						break;
					case self::FIRST_EDIT:
						$isRegisteredUserFirstEdit = true;
						static::setFirstEmailSentFlag( $editor->getName() );
						break;
					case self::MULTIPLE_EDITS:
						static::setFirstEmailSentFlag( $editor->getName() );
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

		$eventData = static::getEventData( $editor, $oRecentChange, $isRegisteredUser, $isRegisteredUserFirstEdit );
		FounderEmails::getInstance()->registerEvent( new FounderEmailsEditEvent( $eventData ) );

		wfProfileOut( __METHOD__ );
		return true;
	}

	/**
	 * @desc Sets flag that founder received first edit notification for a given user
	 *
	 * @param $userName
	 */
	public static function setFirstEmailSentFlag( $userName ) {
		global $wgMemc;
		$wgMemc->set( static::getFirstEmailSentFlagMemcKey( $userName ), '1' );
	}

	public static function getFirstEmailSentFlag( $userName ) {
		global $wgMemc;
		return $wgMemc->get( static::getFirstEmailSentFlagMemcKey( $userName ) );
	}

	/**
	 * @desc Returns memecache key for storing email sent flag
	 *
	 * @param $userName
	 * @return String
	 */
	public static function getFirstEmailSentFlagMemcKey( $userName ) {
		return wfMemcKey( self::FIRST_EDIT_NOTIFICATION_SENT_MEMC_PREFIX, $userName );
	}

	/**
	 * Generates and returns data for edit event to be processed
	 *
	 * @param $editor User
	 * @param $oRecentChange RecentChange
	 * @param $isRegisteredUser boolean
	 * @param $isRegisteredUserFirstEdit boolean
	 * @return array
	 */
	public static function getEventData( $editor, $oRecentChange, $isRegisteredUser, $isRegisteredUserFirstEdit ) {
		wfProfileIn( __METHOD__ );

		$oTitle = Title::makeTitle( $oRecentChange->getAttribute( 'rc_namespace' ), $oRecentChange->getAttribute( 'rc_title' ) );
		$eventData = array(
			'titleText' => $oTitle->getText(),
			'titleNs' => $oRecentChange->getAttribute( 'rc_namespace' ),
			'titleUrl' => $oTitle->getFullUrl(),
			'editorName' => $editor->getName(),
			'editorPageUrl' => $editor->getUserPage()->getFullUrl(),
			'editorTalkPageUrl' => $editor->getTalkPage()->getFullUrl(),
			'registeredUser' => $isRegisteredUser,
			'registeredUserFirstEdit' => $isRegisteredUserFirstEdit,
			'myHomeUrl' => Title::newFromText( 'WikiActivity', NS_SPECIAL )->getFullUrl()
		);

		wfProfileOut( __METHOD__ );
		return $eventData;
	}
}
