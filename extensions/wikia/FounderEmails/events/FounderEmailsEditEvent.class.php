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
	 * Constants for describing Users edit status for purpose of sending founder notification
	 * on first edit
	 */
	const NO_EDITS = 0;
	const FIRST_EDIT = 1;
	const MULTIPLE_EDITS = 2;


	public function __construct( Array $data = array() ) {
		parent::__construct( 'edit' );
		$this->setData( $data );
	}

	/**
	 * @param array $events
	 *
	 * @return bool
	 */
	public function process( Array $events ) {
		// Make sure we have some events
		if ( count( $events ) == 0 ) {
			return false;
		}

		// get just one event when we have more... for now, just randomly
		$event = $events[ rand( 0, count( $events ) - 1 ) ];
		$eventData = $event['data'];

		if ( $this->isEditorThrottled( $eventData ) ) {
			return true;
		}

		$wikiService = new WikiService();
		$adminUserIds = $wikiService->getWikiAdminIds();
		foreach ( $adminUserIds as $adminId ) {
			$this->processForUser( $adminId, $eventData );
		}

		return true;
	}

	/**
	 * Skip if the author of this event has generated an edit email in the
	 * last USER_EMAILS_THROTTLE_EXPIRY_TIME seconds
	 *
	 * @param array $eventData
	 *
	 * @return bool
	 */
	private function isEditorThrottled( array $eventData ) {
		$memcKey = wfMemcKey( 'FounderEmail', 'EditEvent', $eventData['editorName'] );
		if ( F::app()->wg->Memc->get( $memcKey ) == '1' ) {
			return true;
		}

		// Set flag so this user won't generate edit notifications for given period of time
		F::app()->wg->Memc->set( $memcKey, '1', self::USER_EMAILS_THROTTLE_EXPIRY_TIME );

		return false;
	}

	private function processForUser( $adminId, $eventData ) {
		$admin = User::newFromId( $adminId );
		if ( $this->shouldSkipUser( $admin, $eventData ) ) {
			return;
		}

		$this->sendEmail( $admin, $eventData );

		// Increase the count of notifications sent to this admin on this wiki
		$this->updateUserNotificationCount( $admin );
	}

	private function shouldSkipUser( User $admin, array $eventData ) {
		// Skip if FounderEmails not enabled on this wiki
		if ( !$this->enabled( $admin ) ) {
			return true;
		}

		// skip if receiver is the editor
		if ( $admin->getName() == $eventData['editorName'] ) {
			return true;
		}

		// FogBugz ID 1961 Quit if the founder email is not confirmed
		if ( !$admin->isEmailConfirmed() ) {
			return true;
		}

		if ( $this->hasExceededNotificationLimit( $admin ) ) {
			return true;
		}

		return false;
	}

	/**
	 * Returns whether founder emails are available for this user
	 *
	 * @param User $admin
	 *
	 * @param int $wikiId
	 *
	 * @return bool
	 */
	public function enabled( User $admin, $wikiId = null ) {
		$wikiId = empty( $wikiId ) ? F::app()->wg->CityId : $wikiId;

		if ( self::isAnswersWiki( $wikiId ) ) {
			return false;
		}

		// disable if all Wikia email disabled
		if ( (bool)$admin->getGlobalPreference( 'unsubscribed' ) ) {
			return false;
		}

		// If digest mode is enabled, do not create edit event notifications
		if ( $admin->getLocalPreference( "founderemails-complete-digest", $wikiId ) ) {
			return false;
		}

		if ( $admin->getLocalPreference( "founderemails-edits", $wikiId ) ) {
			return true;
		}

		return false;
	}

	private function hasExceededNotificationLimit( User $admin ) {
		$count = $this->getUserNotificationCount( $admin );
		return $count > self::DAILY_NOTIFICATION_LIMIT;
	}

	private function hasHitNotificationLimit( User $admin ) {
		$count = $this->getUserNotificationCount( $admin );
		return $count == self::DAILY_NOTIFICATION_LIMIT;
	}

	private function getUserNotificationCount( User $admin ) {
		$counter = $this->getNotificationCounter( $admin );
		return $counter[F::app()->wg->CityId]['count'];
	}

	/**
	 * Keeps a per request cache of the 'founderemails-counter' user option
	 *
	 * @param User $admin
	 *
	 * @return mixed
	 */
	private function getNotificationCounter( User $admin ) {
		static $counter = null;

		if ( empty( $counter[$admin->getId()] ) ) {
			$allCounter = unserialize( $admin->getGlobalAttribute( 'founderemails-counter' ), [ 'allowed_classes' => false ] );
			$allCounter = is_array( $allCounter ) ? $allCounter : [];

			if ( $this->userCounterNeedsReset( $allCounter ) ) {
				$allCounter[F::app()->wg->CityId] = [
					'date'  => date( 'Y-m-d' ),
					'count' => 0,
				];
			}

			$counter[$admin->getId()] = $allCounter;
		}

		return $counter[$admin->getId()];
	}

	private function userCounterNeedsReset( array $counter ) {
		if ( empty( $counter[F::app()->wg->CityId] ) ) {
			return true;
		}

		$today = date( 'Y-m-d' );
		$wikiCounter = $counter[F::app()->wg->CityId];
		return $wikiCounter['date'] !== $today;
	}

	private function updateUserNotificationCount( User $admin ) {
		$counter = $this->getNotificationCounter( $admin );
		$counter[F::app()->wg->CityId]['count']++;

		$admin->setGlobalAttribute( 'founderemails-counter', serialize( $counter ) );
		$admin->saveSettings();
	}

	private function sendEmail( User $admin, array $eventData ) {
		$controller = $this->getEmailController( $admin, $eventData );

		$params = [
			'targetUser' => $admin->getName(),
			'currentUser' => $eventData['editorName'],
			'pageTitle' => $eventData['titleText'],
			'pageNs' => $eventData['titleNs'],
			'previousRevId' => $eventData['previousRevId'],
			'currentRevId' => $eventData['currentRevId'],
			// TODO: Remove the next two lines when SOC-530 has been merged (these will then be default)
			'fromAddress' => \F::app()->wg->PasswordSender,
			'fromName' => \F::app()->wg->PasswordSenderName,
		];

		F::app()->sendRequest( $controller, 'handle', $params );
	}

	private function getEmailController( User $admin, array $eventData ) {
		if ( $this->hasHitNotificationLimit( $admin ) ) {
			return Email\Controller\FounderActiveController::class;
		}

		if ( $eventData['registeredUserFirstEdit'] ) {
			return Email\Controller\FounderEditController::class;
		}

		if ( $eventData['registeredUser'] ) {
			return Email\Controller\FounderMultiEditController::class;
		}

		return Email\Controller\FounderAnonEditController::class;
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

		return $recentEditsCount;
	}

	/**
	 * @param RecentChange|null $oRecentChange This is allowed to be null to stay compatible
	 *                                         with FounderEmailsEvent::register()
	 *
	 * @return bool
	 *
	 * @throws Exception
	 */
	public static function register( $oRecentChange = null ) {
		$currentUser = F::app()->wg->User;

		if ( is_null( $oRecentChange ) ) {
			throw new \Exception( 'Invalid $oRecentChange value.' );
		}

		if ( FounderEmails::getInstance()->getLastEventType() == 'register' ) {
			// special case: creating user page after user registration, ignore event
			return true;
		}

		$isRegisteredUser = false;
		$isRegisteredUserFirstEdit = false;

		if ( $oRecentChange->getAttribute( 'rc_user' ) ) {
			$editorId = $oRecentChange->getAttribute( 'rc_user' );
			$editor = $currentUser->getId() == $editorId ? $currentUser : User::newFromID( $editorId );
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
			$editorName = $oRecentChange->getAttribute( 'rc_user_text' );
			$editor = $currentUser->getName() == $editorName ? $currentUser : User::newFromName( $editorName, false );
		}

		$config = FounderEmailsEvent::getConfig( 'edit' );
		if ( in_array( 'staff', $editor->getGroups() ) || in_array( $editor->getId(), $config['skipUsers'] ) ) {
			// page edited by founder, staff member or excluded user, skipping..
			return true;
		}

		if ( $editor->isAllowed( 'bot' ) ) {
			// skip bots
			return true;
		}

		$eventData = static::getEventData( $editor, $oRecentChange, $isRegisteredUser, $isRegisteredUserFirstEdit );
		FounderEmails::getInstance()->registerEvent( new FounderEmailsEditEvent( $eventData ) );

		return true;
	}

	/**
	 * Sets flag that founder received first edit notification for a given user
	 *
	 * @param string $userName
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
	 * Returns memcache key for storing email sent flag
	 *
	 * @param string $userName
	 *
	 * @return string
	 */
	public static function getFirstEmailSentFlagMemcKey( $userName ) {
		return wfMemcKey( self::FIRST_EDIT_NOTIFICATION_SENT_MEMC_PREFIX, $userName );
	}

	/**
	 * Generates and returns data for edit event to be processed
	 *
	 * @param User $editor
	 * @param RecentChange $oRecentChange
	 * @param boolean $isRegisteredUser
	 * @param boolean $isRegisteredUserFirstEdit
	 * @return array
	 */
	public static function getEventData( $editor, $oRecentChange, $isRegisteredUser, $isRegisteredUserFirstEdit ) {
		$oTitle = Title::makeTitle(
			$oRecentChange->getAttribute( 'rc_namespace' ),
			$oRecentChange->getAttribute( 'rc_title' )
		);

		$eventData = [
			'titleText' => $oTitle->getText(),
			'titleNs' => $oRecentChange->getAttribute( 'rc_namespace' ),
			'titleUrl' => $oTitle->getFullUrl(),
			'currentRevId' => $oRecentChange->getAttribute( 'rc_this_oldid' ),
			'previousRevId' => $oRecentChange->getAttribute( 'rc_last_oldid' ),
			'editorName' => $editor->getName(),
			'editorPageUrl' => $editor->getUserPage()->getFullUrl(),
			'editorTalkPageUrl' => $editor->getTalkPage()->getFullUrl(),
			'registeredUser' => $isRegisteredUser,
			'registeredUserFirstEdit' => $isRegisteredUserFirstEdit,
			'myHomeUrl' => Title::newFromText( 'WikiActivity', NS_SPECIAL )->getFullUrl()
		];

		return $eventData;
	}
}
