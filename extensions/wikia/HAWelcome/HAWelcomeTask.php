<?php

use Wikia\Tasks\Tasks\BaseTask;
use Wikia\Logger\Loggable;

class HAWelcomeTask extends BaseTask {
	use Loggable;

	/** @type String The default user to send welcome messages. */
	const DEFAULT_WELCOMER = 'Wikia';


	/**
	 * Default switches to enable features, explained below.
	 *
	 * message-anon - if enabled, anonymous users will get a welcome message
	 * message-user - if enabled, registered users will get a welcome message
	 * page-user    - if enabled, a user profile page will be created, too (if not exists)
	 *
	 * @type Array
	 */
	private $featureFlags = array( 'message-anon' => false, 'message-user' => false, 'page-user' => false );

	/** @type Integer The id of the recipient. */
	private $recipientId;

	/** @type String The name of the recipient. */
	private $recipientName;

	/** @type Object User The recipient object. */
	private $recipientObject;

	/** @type Object User The sender object. */
	private $senderObject;

	/** @type string timestamp */
	private $timestamp;

	/** @type Integer Flags for WikiPage::doEdit(). */
	private $integerFlags = 0;

	/** @type boolean */
	private $bMessageWallExt  = null;

	/** @type string */
	private $welcomeMessage = null;

	public function getRecipientId() {
		return $this->recipientId;
	}

	public function getRecipientUserName() {
		return $this->recipientName;
	}

	public function getTimestamp() {
		return $this->timestamp;
	}

	protected function getLoggerContext() {
		return ['task' => __CLASS__];
	}

	function __construct() {
		$this->mergeFeatureFlagsFromUserSettings();
	}

	/**
	 *
	 * @param $oTitle Object The Title associated with the Job.
	 * @param $aParams Array The Job parameters.
	 * @param $iId Integer The Job identifier.
	 */

	/**
	 * The main method called by the job executor.
	 *
	 * The heavy code goes here.
	 *
	 * @param array params
	 * @return Boolean Indicated whether the job has been completed successfully.
	 * @internal
	 */
	public function sendWelcomeMessage( $params ) {
		$this->normalizeInstanceParameters( $params );

		// Complete the job if the feature has been disabled by the admin of the wiki.
		if ( $this->welcomeMessageDisabled() ) {
			$this->debug( "The HAWelcome extension is disabled." );
			return true;
		}

		$this->captureAndReplaceGlobalWgUserWithWelcomeUser();

		// Create objects related to the recipient of the welcome message.
		$this->recipientObject = User::newFromId( $this->recipientId );

		// User objects for anonymous contributors don't have the name set.
		if ( ! $this->recipientId ) {
			$this->recipientObject->setName( $this->recipientName );
		}

		// Refresh the sender data.
		$this->setSender();

		// If possible, mark edits as if they were made by a bot.
		if ( $this->senderObject->isAllowed( 'bot' ) || '@bot' == trim( wfMessage( 'welcome-bot' )->inContentLanguage()->text() ) ) {
			$this->integerFlags = EDIT_FORCE_BOT;
		}

		// anonymous users block
		if ( ! $this->recipientId && $this->isFeatureFlagEnabled( 'message-anon' ) ) {

			if (
				// The Message Wall extension is enabled and user's wall is empty or ...
				( $this->getMessageWallExtensionEnabled() && ! WallHelper::haveMsg( $this->recipientObject ) )
				// ... or the Message Wall extension is disabled and recipient's Talk Page does not exist
				|| ( !$this->getMessageWallExtensionEnabled() && !$this->getRecipientTalkPage()->exists() )
			) {
				$this->info( "sending HAWelcome message for an anonymous contributor" );
				$this->setMessage();
				$this->sendMessage();
			}

		// registered users block
		} else if ( $this->recipientId ) {
			// If configured so, send a welcome message.
			if ( $this->isFeatureFlagEnabled( 'message-user' ) ) {
				$this->info( "sending HAWelcome message for registered contributor" );
				$this->setMessage();
				$this->sendMessage();
			}

			// If configured so, create a user profile page, if not exists.
			if ( $this->isFeatureFlagEnabled( 'page-user' ) ) {
				$this->info( "attempting to create welcome user page" );
				$recipientProfile = new Article( $this->recipientObject->getUserPage() );
				if ( ! $recipientProfile->exists() ) {
					$recipientProfile->doEdit( wfMessage( 'welcome-user-page', $this->recipientName )->inContentLanguage()->plain(), false, $this->integerFlags );
				}
			}

		}

		$this->restoreGlobalWgUser();

		return true;
	}

	private function captureAndReplaceGlobalWgUserWithWelcomeUser() {
		/**
		 * FIXME: why are we doing this? Is it for the references in this->sendMessage or somewhere else?
		 */
		global $wgUser;
		$this->temporaryWgUser = $wgUser;
		$wgUser = User::newFromName( self::DEFAULT_WELCOMER );
	}

	private function restoreGlobalWgUser() {
		global $wgUser;
		$wgUser = $this->temporaryWgUser;
	}

	public function getUserFeatureFlags() {
		return wfMessage( 'welcome-enabled' )->inContentLanguage()->text();
	}

	public function mergeFeatureFlagsFromUserSettings() {
		$sSwitches = $this->getUserFeatureFlags();

		// Override the default switches with user's values.
		foreach ( $this->featureFlags as $sSwitch => $bValue ) {
			if ( false !== strpos( $sSwitches, $sSwitch ) ) {
				$this->featureFlags[$sSwitch] = true;
			}
		}
	}

	/**
	 * Determine if a feature flag is enabled.
	 *
	 * @param string $flag the feature flag
	 * @return bool
	 */
	public function isFeatureFlagEnabled( $flag ) {
		return array_key_exists( $flag, $this->featureFlags ) && $this->featureFlags[$flag];
	}

	protected function getMessageWallExtensionEnabled() {
		if ( is_null($this->bMessageWallExt) ) {
			/**
			 * @global Boolean Indicated whether the Message Wall extension is enabled.
			 */
			global $wgEnableWallExt;
			$this->bMessageWallExt = ! empty( $wgEnableWallExt );
		}

		return $this->bMessageWallExt;
	}


	/**
	 * Determines the sender of the welcome message.
	 *
	 * @since MediaWiki 1.19.4
	 * @internal
	 */
	public function setSender() {
		$sSender = trim( wfMessage( 'welcome-user' )->inContentLanguage()->text() );

		// Check for known values indicating that the most recently active admin has to be the sender.
		if ( in_array( $sSender, array( '@latest', '@sysop' ) ) ) {
			/**
			 * @global Object MemcachedPhpBagOStuff A pure-PHP memcached client instance.
			 * @see https://doc.wikimedia.org/mediawiki-core/master/php/html/classMemcachedPhpBagOStuff.html
			 */
			global $wgMemc;
			$iSender = (int) $wgMemc->get( wfMemcKey( 'last-sysop-id' ) );

			if ( ! $iSender ) {
				// Fetch the list of users who are sysops and/or bots.
				$oDB = wfGetDB( DB_SLAVE );
				$oResult = $oDB->select(
					array( 'user_groups' ),
					array( 'ug_user', 'ug_group' ),
					$oDB->makeList( array( 'ug_group' => array( 'sysop', 'bot' ) ), LIST_OR ),
					__METHOD__
				);

				/** @type Array Placeholder, helps to separate bots from sysops. */
				$aUsers = array( 'bot' => array(), 'sysop' => array() );

				// Classify the users as sysops or bots.
				while( $oRow = $oDB->fetchObject( $oResult ) ) {
					array_push( $aUsers[$oRow->ug_group], $oRow->ug_user );
				}

				$oDB->freeResult( $oResult );

				// Separate bots from sysops.
				/** @type Array Welcomer candidates. */
				$aAdmins = array( 'rev_user' => array_unique( array_diff( $aUsers['sysop'], $aUsers['bot'] ) ) );

				// Fetch the id of the latest active sysop (within the last 60 days) or 0.
				$iSender = (int) $oDB->selectField(
					'revision',
					'rev_user',
					array(
						$oDB->makeList( $aAdmins, LIST_OR ),
						'rev_timestamp > ' . $oDB->addQuotes( $oDB->timestamp( time() - 5184000 ) ) // 60 days ago (24*60*60*60)
					),
					__METHOD__,
					array(
						'ORDER BY' => 'rev_timestamp DESC',
						'DISTINCT'
					)
				);

				// Cache the fetched value if non-zero.
				if ( $iSender ) {
					$wgMemc->set( wfMemcKey( 'last-sysop-id' ), $iSender );
				}
			}

			$senderObject = User::newFromId( $iSender );

		// If another value has been set, assume it is meant to be the name of the sender.
		} else {
			// Create a User object.
			/** @type Object User The sender for the welcome message. */
			$senderObject = User::newFromName( $sSender );
		}

		// Terminate, if a valid user object has been created.
		if( $senderObject instanceof User && $senderObject->getId() ) {
			$this->senderObject = $senderObject;
			return;
		}

		// If no recently active admin has been found, fall back to a relevant staff member.
		/**
		 * @global String The language of the wiki.
		 * @see http://www.mediawiki.org/wiki/Manual:$wgLanguageCode
		 */
		global $wgLanguageCode;

		// Create a User object.
		$senderObject = Wikia::staffForLang( $wgLanguageCode );

		// Terminate, if a valid user object has been created.
		if( $senderObject instanceof User && $senderObject->getId() ) {
			$this->senderObject = $senderObject;
			return;
		}

		// This should not happen. Fall back to the default welcomer.
		$this->senderObject = User::newFromName( HAWelcomeTask::DEFAULT_WELCOMER );
		return;
	}


	protected function getRecipientTalkPage() {
		if ( !isset( $this->recipientTalkPage ) ) {
			$this->recipientTalkPage = new Article( $this->recipientObject->getUserPage()->getTalkPage() );
		}

		return $this->recipientTalkPage;
	}



	/**
	 * Sends the message to the recipient.
	 *
	 * @since MediaWiki 1.19.4
	 * @internal
	 */
	public function sendMessage() {
		if ( $this->getMessageWallExtensionEnabled() ) {
			$this->postWallMessageToRecipient();
		} else {
			$this->postTalkPageMessageToRecipient();
		}
	}

	protected function postWallMessageToRecipient() {
		$this->info( "creating a welcome wall message" );
		$mWallMessage = WallMessage::buildNewMessageAndPost(
			$this->welcomeMessage, $this->recipientName, $this->getMessageWallSender(),
			wfMessage( 'welcome-message-log' )->inContentLanguage()->text(), false, array(), false, false
		);

		// Sets the sender of the message when the actual message
		// was posted by the welcome bot
		if ( $mWallMessage ) {
			$mWallMessage->setPostedAsBot( $this->senderObject );
			$mWallMessage->sendNotificationAboutLastRev();
		}
	}

	public function postTalkPageMessageToRecipient() {
		$this->info( "posting a message to the talk page" );
		if ( $this->getRecipientTalkPage()->exists() ) {
			$welcomeMessage = $this->getRecipientTalkPage()->getContent() . PHP_EOL . $this->welcomeMessage;
		} else {
			$welcomeMessage = $this->welcomeMessage;
		}

		$this->getRecipientTalkPage()->doEdit( $welcomeMessage, wfMessage( 'welcome-message-log' )->inContentLanguage()->text(), $this->integerFlags );
	}

	protected function getMessageWallSender() {
		/*
		 * FIXME: can this be replaced with
		 *	$wgUser = User::newFromName( self::DEFAULT_WELCOMER );
		 *
		 * If so, then we can remove the captureAndReplaceGlobalWgUserWithWelcomeUser/restore methods.
		 *
		 */
		global $wgUser;
		return $wgUser;
	}

	/**
	 * Determines the contents of the welcome message.
	 *
	 * @since MediaWiki 1.19.4
	 * @internal
	 */
	public function setMessage() {
		$welcomeMessageKey = 'welcome-message-';

		//Determine the proper key
		//
		// Is Message Wall enabled?
		$welcomeMessageKey  .= $this->getMessageWallExtensionEnabled() ? 'wall-'  : '';

		// Is recipient a registered user?
		$welcomeMessageKey .= $this->recipientId
			? 'user'  : 'anon';

		// Is sender a staff member and not a local admin?
		$senderGroups = $this->senderObject->getEffectiveGroups();

		$welcomeMessageKey .= ( in_array( 'staff', $senderGroups ) && !in_array( 'sysop', $senderGroups ) )
			? '-staff' : '';

		$sPrefixedText = $this->title->getPrefixedText();

		// Article Comments and Message Wall hook up to this event.
		wfRunHooks( 'HAWelcomeGetPrefixText' , array( &$sPrefixedText, $this->title ) );

		// Determine the key for the signature.
		$sSignatureKey = ( in_array( 'staff', $senderGroups ) && !in_array( 'sysop', $senderGroups ) )
			? 'staffsig-text' : 'signature';

		// Determine the full signature.
		$sFullSignature = wfMessage(
			$sSignatureKey,
			$this->senderObject->getName(),
			Parser::cleanSigInSig( $this->senderObject->getName() )
		)->inContentLanguage()->text();

		// Append the timestamp to the signature.
		$sFullSignature .= ' ~~~~~';

		// Put the contents of the welcome message together.
		// Messages that can be used here:
		// * welcome-message-user
		// * welcome-message-user-staff
		// * welcome-message-anon
		// * welcome-message-anon-staff
		// * welcome-message-wall-user
		// * welcome-message-wall-user-staff
		// * welcome-message-wall-anon
		// * welcome-message-wall-anon-staff
		$this->welcomeMessage = wfMessage( $welcomeMessageKey,
			$sPrefixedText,
			$this->senderObject->getUserPage()->getTalkPage()->getPrefixedText(),
			$sFullSignature,
			wfEscapeWikiText( $this->recipientName )
		)->inContentLanguage()->plain();
	}

	public function normalizeInstanceParameters( $params ) {
		$this->recipientId   = isset( $params['iUserId'] ) ? $params['iUserId'] : null;
		$this->recipientName = isset( $params['sUserName'] ) ? $params['sUserName'] : null;
		$this->timestamp     = ( isset( $params['iTimestamp'] ) ) ? $params['iTimestamp'] : 0;
	}

	public function welcomeMessageDisabled() {
		if ( in_array( trim( wfMessage( 'welcome-user' )->inContentLanguage()->text() ), array( '@disabled', '-' ) ) ) {
			return true;
		}
	}

}
