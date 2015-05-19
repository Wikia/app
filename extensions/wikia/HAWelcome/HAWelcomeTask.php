<?php

use Wikia\Tasks\Tasks\BaseTask;
use Wikia\Util\GlobalStateWrapper;

class HAWelcomeTask extends BaseTask {
	use IncludeMessagesTrait;

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


	protected function getLoggerContext() {
		return ['task' => __CLASS__];
	}

	/**
	 *
	 * @param $oTitle Object The Title associated with the Job.
	 * @param $aParams Array The Job parameters.
	 * @param $iId Integer The Job identifier.
	 */

	/**
	 * Send the welcome message
	 *
	 *
	 * @param array params
	 * @return Boolean Indicated whether the job has been completed successfully.
	 * @internal
	 */
	public function sendWelcomeMessage( $params ) {
		$this->info( "HAWelcome sendWelcomeMessage" );
		$this->normalizeInstanceParameters( $params );
		$this->mergeFeatureFlagsFromUserSettings();

		$this->setRecipient();

		$this->setSender();

		if ( $this->senderIsBotAllowed() ) {
			$this->integerFlags = EDIT_FORCE_BOT;
		}

		$anonymousUserEdit  = !$this->recipientId && $this->isFeatureFlagEnabled( 'message-anon' );
		$registeredUserEdit = $this->recipientId;
		if ( $anonymousUserEdit ) {
			$wallExtensionEnableAndEmptyUserWall = $this->getMessageWallExtensionEnabled() && $this->recipientWallIsEmpty();
			$wallExtensionDisabledAndNoTalkPage  = !$this->getMessageWallExtensionEnabled() && !$this->getRecipientTalkPage()->exists();

			if ( $wallExtensionEnableAndEmptyUserWall || $wallExtensionDisabledAndNoTalkPage ) {
				$this->info( "sending HAWelcome message for an anonymous contributor" );
				$this->sendMessage();
			}
		} else if ( $registeredUserEdit ) {
			if ( $this->isFeatureFlagEnabled( 'message-user' ) ) {
				$this->info( "sending HAWelcome message for registered contributor" );
				$this->sendMessage();
			}

			if ( $this->isFeatureFlagEnabled( 'page-user' ) ) {
				$this->createUserProfilePage();
			}
		}

		return true;
	}

	protected function getDefaultWelcomerUser() {
		return User::newFromName( self::DEFAULT_WELCOMER );
	}

	public function getUserFeatureFlags() {
		return $this->getTextVersionOfMessage( 'welcome-enabled' );
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
		if ( is_null( $this->bMessageWallExt ) ) {
			/**
			 * @global Boolean Indicated whether the Message Wall extension is enabled.
			 */
			global $wgEnableWallExt;
			$this->bMessageWallExt = ! empty( $wgEnableWallExt );
		}

		return $this->bMessageWallExt;
	}

	public function createUserProfilePage() {
		$this->info( "attempting to create welcome user page" );
		$recipientProfile = $this->getRecipientProfilePage();
		if ( ! $recipientProfile->exists() ) {
			$this->info( sprintf( "creating welcome user page for %s",
				$this->recipientObject->getName() ) );
			$recipientProfile->doEdit(
				$this->getWelcomePageTemplateForRecipient(),
				false,
				$this->integerFlags,
				false,
				$this->getDefaultWelcomerUser()
			);
		}
	}

	protected function getRecipientProfilePage() {
		return new Article( $this->recipientObject->getUserPage() );
	}

	protected function getWelcomePageTemplateForRecipient() {
		return $this->getPlainVersionOfMessage( 'welcome-user-page', [$this->recipientName] );
	}

	/**
	 * Determines the sender of the welcome message.
	 *
	 * @since MediaWiki 1.19.4
	 * @internal
	 */
	public function setSender() {
		$sSender = trim( $this->getTextVersionOfMessage( 'welcome-user' ) );

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
				while ( $oRow = $oDB->fetchObject( $oResult ) ) {
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
		if ( $senderObject instanceof User && $senderObject->getId() ) {
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
		if ( $senderObject instanceof User && $senderObject->getId() ) {
			$this->senderObject = $senderObject;
			return;
		}

		// This should not happen. Fall back to the default welcomer.
		$this->senderObject = User::newFromName( HAWelcomeTask::DEFAULT_WELCOMER );
		return;
	}


	public function setRecipient() {
		// Create objects related to the recipient of the welcome message.
		$this->recipientObject = User::newFromId( $this->recipientId );

		// User objects for anonymous contributors don't have the name set.
		if ( ! $this->recipientId ) {
			$this->recipientObject->setName( $this->recipientName );
		}
	}

	protected function senderIsBotAllowed() {
		if ( $this->senderObject->isAllowed( 'bot' ) || '@bot' == trim( $this->getTextVersionOfMessage( 'welcome-bot' ) ) ) {
			return true;
		}
	}

	protected function recipientWallIsEmpty() {
		return !WallHelper::haveMsg( $this->recipientObject );
	}


	/**
	 * Get the recipients talk page.
	 * @return \Article
	 */
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
		$this->setMessage();
		if ( $this->getMessageWallExtensionEnabled() ) {
			$this->postWallMessageToRecipient();
		} else {
			$this->postTalkPageMessageToRecipient();
		}
	}

	public function postWallMessageToRecipient() {
		$defaultWelcomeUser = $this->getDefaultWelcomerUser();

		// some of the lower level methods used in buildNewMessageAndPost do not pass the
		// $user object down the call stack and instead rely on the $wgUser which is
		// not set in a Task environment
		$wrapper = new GlobalStateWrapper( array(
			'wgUser' => $defaultWelcomeUser
		) );

		$this->info( "creating a welcome wall message" );
		$welcomeMessage = $this->welcomeMessage;
		$recipientName  = $this->recipientName;
		$textMessage    = $this->getTextVersionOfMessage( 'welcome-message-log' );

		$message = $wrapper->wrap( function () use ( $defaultWelcomeUser, $welcomeMessage, $recipientName, $textMessage ) {
			return $this->executeBuildAndPostWallMessage( $defaultWelcomeUser, $welcomeMessage, $recipientName, $textMessage );
		} );

		$message = $this->setWallMessagePostedAsBot( $message );

		return $message;
	}

	protected function executeBuildAndPostWallMessage( $defaultWelcomeUser, $welcomeMessage, $recipientName, $textMessage ) {
		$wallMessage = WallMessage::buildNewMessageAndPost(
			$welcomeMessage, $recipientName, $defaultWelcomeUser, $textMessage, false, array(), false, false
		);

		return $wallMessage;
	}

	protected function setWallMessagePostedAsBot( $wallMessage ) {
		// Sets the sender of the message when the actual message
		// was posted by the welcome bot
		if ( $wallMessage ) {
			$wallMessage->setPostedAsBot( $this->senderObject );
			$wallMessage->sendNotificationAboutLastRev();
		}

		return $wallMessage;
	}

	public function postTalkPageMessageToRecipient() {
		$this->info( "posting a message to the talk page" );
		if ( $this->getRecipientTalkPage()->exists() ) {
			$welcomeMessage = $this->getRecipientTalkPage()->getContent() . PHP_EOL . $this->welcomeMessage;
		} else {
			$welcomeMessage = $this->welcomeMessage;
		}

		$this->info( sprintf( "posting talkpage message to %s from %s",
			$this->recipientObject->getName(), $this->senderObject->getName() ) );

		$this->getRecipientTalkPage()->doEdit(
			$welcomeMessage,
			$this->getTextVersionOfMessage( 'welcome-message-log' ),
			$this->integerFlags,
			false,
			$this->getDefaultWelcomerUser()
		);
	}

	/**
	 * Determines the contents of the welcome message.
	 *
	 * @since MediaWiki 1.19.4
	 * @internal
	 */
	public function setMessage() {
		$welcomeMessageKey = 'welcome-message-';

		// Determine the proper key
		//
		// Is Message Wall enabled?
		$welcomeMessageKey  .= $this->getMessageWallExtensionEnabled() ? 'wall-'  : '';

		// Is recipient a registered user?
		$welcomeMessageKey .= $this->recipientId
			? 'user'  : 'anon';

		// Is sender a staff member and not a local admin?
		$senderGroups = $this->senderObject->getEffectiveGroups();

		if ( ( in_array( 'staff', $senderGroups ) || in_array( 'helper', $senderGroups ) )
			&& !in_array( 'sysop', $senderGroups )
		) {
			$welcomeMessageKey .= '-staff';
		}

		$sPrefixedText = $this->title->getPrefixedText();

		// Article Comments and Message Wall hook up to this event.
		wfRunHooks( 'HAWelcomeGetPrefixText' , array( &$sPrefixedText, $this->title ) );

		// Determine the key for the signature.
		$sSignatureKey = ( in_array( 'staff', $senderGroups ) && !in_array( 'sysop', $senderGroups ) )
			? 'staffsig-text' : 'signature';

		// Determine the full signature.
		$sFullSignature = $this->getTextVersionOfMessage(
			$sSignatureKey,
			[$this->senderObject->getName(), Parser::cleanSigInSig( $this->senderObject->getName() )]
		);

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
		$this->welcomeMessage = $this->getPlainVersionOfMessage( $welcomeMessageKey, [
			$sPrefixedText,
			$this->senderObject->getUserPage()->getTalkPage()->getPrefixedText(),
			$sFullSignature,
			wfEscapeWikiText( $this->recipientName )
		] );
	}

	public function normalizeInstanceParameters( $params ) {
		$this->recipientId   = isset( $params['iUserId'] ) ? $params['iUserId'] : null;
		$this->recipientName = isset( $params['sUserName'] ) ? $params['sUserName'] : null;
		$this->timestamp     = ( isset( $params['iTimestamp'] ) ) ? $params['iTimestamp'] : 0;
	}

	public function setSenderObject( \User $sender ) {
		$this->senderObject = $sender;
		return $this;
	}

	public function setRecipientObject( \User $recipient ) {
		$this->recipientObject = $recipient;
		return $this;
	}

	public function getRecipientId() {
		return $this->recipientId;
	}

	public function getRecipientUserName() {
		return $this->recipientName;
	}

	public function setRecipientUserName( $name ) {
		$this->recipientName = $name;
	}

	public function getTimestamp() {
		return $this->timestamp;
	}

	public function setWelcomeMessage( $message ) {
		$this->welcomeMessage = $message;
	}


}
