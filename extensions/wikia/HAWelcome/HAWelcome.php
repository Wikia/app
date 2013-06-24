<?php
/**
 * Sends a welcome message to users after their first edits.
 *
 * @package Wikia\extensions\HAWelcome
 *
 * @version 1009
 *
 * @author Krzysztof 'Eloy' Krzyżaniak <eloy@wikia-inc.com>
 * @author Maciej 'Marooned' Błaszkowski <marooned@wikia-inc.com>
 * @author Michał 'Mix' Roszka <mix@wikia-inc.com>
 *
 * @see https://github.com/Wikia/app/tree/dev/extensions/wikia/HAWelcome/
 */
// Terminate the script when called out of MediaWiki context.
if ( !defined( 'MEDIAWIKI' ) ) {
	echo  'Invalid entry point. '
		. 'This code is a MediaWiki extension and is not meant to be executed standalone. '
		. 'Try vising the main page: /index.php or running a different script.';
	exit( 1 );
}
/**
 * @global Array The list of extension credits.
 * @see http://www.mediawiki.org/wiki/Manual:$wgExtensionCredits
 */
$wgExtensionCredits['other'][] = array(
	'path'              => __FILE__,
	'name'              => 'HAWelcome',
	'description'       => 'Sends a welcome message to users after their first edits.',
	'descriptionmsg'    => 'welcome-description',
	'version'           => 1009,
	'author'            => array(
		"Krzysztof 'Eloy' Krzyżaniak <eloy@wikia-inc.com>",
		"Maciej 'Marooned' Błaszkowski <marooned@wikia-inc.com>",
		"Michał 'Mix' Roszka <mix@wikia-inc.com>"
	),
	'url'               => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/HAWelcome/'
);

$wgAvailableRights[] = 'welcomeexempt';
$wgGroupPermissions['bot']['welcomeexempt'] = true;

/**
 * @global Array The list of message files.
 * @see http://www.mediawiki.org/wiki/Manual:$wgExtensionMessagesFiles
 */
$wgExtensionMessagesFiles[ 'HAWelcome' ] = __DIR__ . '/HAWelcome.i18n.php';
/**
 * @global Array The list of hooks.
 * @see http://www.mediawiki.org/wiki/Manual:$wgHooks
 * @see http://www.mediawiki.org/wiki/Manual:Hooks/ArticleSaveComplete
 */
$wgHooks['ArticleSaveComplete'][] = 'HAWelcomeJob::onArticleSaveComplete';
/**
 * @type String Command name for the job aka type of the job.
 * @see http://www.mediawiki.org/wiki/Manual:RunJobs.php
 */
define( 'HAWELCOME_JOB_IDENTIFIER', 'HAWelcome' );
/**
 * @global Array Map jobs to their handling classes.
 * @see http://www.mediawiki.org/wiki/Manual:$wgJobClasses
 */
$wgJobClasses[HAWELCOME_JOB_IDENTIFIER] = 'HAWelcomeJob';
/**
 * The class implementing the feature and handling its job.
 *
 * @see http://www.mediawiki.org/wiki/Manual:Job_queue/For_developers
 * @since MediaWiki 1.19.4
 * @internal
 */
class HAWelcomeJob extends Job {
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
	public $aSwitches = array( 'message-anon' => false, 'message-user' => false, 'page-user' => false );
	/** @type Integer The id of the recipient. */
	public $iRecipientId;
	/** @type String The name of the recipient. */
	public $sRecipientName;
	/** @type Object User The recipient object. */
	public $oRecipient;
	/** @type Object User The sender object. */
	public $oSender;
	/** @type Integer Flags for WikiPage::doEdit(). */
	public $iFlags = 0;
	/** @type Boolean Show PHP Notices. */
	public $bShowNotices = false;
	/**
	 * Enqueues a job based on a few simple preliminary checks.
	 *
	 * Called once an article has been saved.
	 *
	 * @param $oArticle Object The WikiPage object for the contribution.
	 * @param $oUser Object The User object for the contribution.
	 * @param $sText String The contributed text.
	 * @param $sSummary String The summary for the contribution.
	 * @param $iMinorEdit Integer Indicates whether a contribution has been marked as a minor one.
	 * @param $nWatchThis Null Not used as of MW 1.8
	 * @param $nSectionAnchor Null Not used as of MW 1.8
	 * @param $iFlags Integer Bitmask flags for the edit.
	 * @param $oRevision Object The Revision object.
	 * @param $oStatus Object The Status object returned by Article::doEdit().
	 * @param $iBaseRevId Integer The ID of the revision, the current edit is based on (or Boolean False).
	 * @return Boolean True so the calling method would continue.
	 * @see http://www.mediawiki.org/wiki/Manual:$wgHooks
	 * @see http://www.mediawiki.org/wiki/Manual:Hooks/ArticleSaveComplete
	 * @since MediaWiki 1.19.4
	 * @internal
	 */
	public static function onArticleSaveComplete( &$oArticle, &$oUser, $sText, $sSummary, $iMinorEdit, $nWatchThis, $nSectionAnchor, &$iFlags, $oRevision, $oStatus, $iBaseRevId ) {
		wfProfileIn( __METHOD__ );

		if ( is_null( $oRevision ) ) {
			// if oRevision is null, that means we're dealing with a null edit (no content change)
			// and therefore we don't have to welcome anybody
			wfProfileOut( __METHOD__ );
			return true;
		}

		/** @global Boolean Show PHP Notices. Set via WikiFactory. */
		global $wgHAWelcomeNotices;
		/** @type Interget Store the original error reporting level. */
		$iErrorReporting = error_reporting();
		error_reporting( E_ALL );
		// Abort if the feature has been disabled by the admin of the wiki.
		if ( in_array( trim( wfMessage( 'welcome-user' )->inContentLanguage()->text() ), array( '@disabled', '-' ) ) ) {
			if ( !empty( $wgHAWelcomeNotices ) ) {
				trigger_error( sprintf( '%s Terminated. The feature has been disabled.', __METHOD__ ) , E_USER_NOTICE );
			}
			// Restore the original error reporting level.
			error_reporting( $iErrorReporting );
			wfProfileOut( __METHOD__ );
			return true;
		}
		/**
		 * @global Boolean True in scripts that may be run from the command line.
		 * @see http://www.mediawiki.org/wiki/Manual:$wgCommandLineMode
		 */
		global $wgCommandLineMode;
		// Ignore revisions created in the command-line mode. Otherwise HAWelcome::run() could
		// invoke HAWelcome::onRevisionInsertComplete(), too which may cause an infinite loop
		// and serious performance problems.
		if ( !$wgCommandLineMode ) {
			/**
			 * @global Object MemcachedPhpBagOStuff A pure-PHP memcached client instance.
			 * @see https://doc.wikimedia.org/mediawiki-core/master/php/html/classMemcachedPhpBagOStuff.html
			 */
			global $wgMemc;
			// Abort if the contributor has been welcomed recently.
			if ( $wgMemc->get( wfMemcKey( 'HAWelcome-isPosted', $oRevision->getRawUserText() ) ) ) {
				if ( !empty( $wgHAWelcomeNotices ) ) {
					trigger_error( sprintf( '%s Done. The contributor has been welcomed recently.', __METHOD__ ) , E_USER_NOTICE );
				}
				// Restore the original error reporting level.
				error_reporting( $iErrorReporting );
				wfProfileOut( __METHOD__ );
				return true;
			}
			// Handle an edit made by an anonymous contributor.
			if ( ! $oRevision->getRawUser() ) {
				if ( !empty( $wgHAWelcomeNotices ) ) {
					trigger_error( sprintf( '%s An edit made by an anonymous contributor.', __METHOD__ ) , E_USER_NOTICE );
				}
			// Handle an edit made by a registered contributor.
			} else {
				if ( !empty( $wgHAWelcomeNotices ) ) {
					trigger_error( sprintf( '%s An edit made by a registered contributor.', __METHOD__ ) , E_USER_NOTICE );
				}
				/**
				 * @global Object User The state of the user viewing/using the site
				 * @see http://www.mediawiki.org/wiki/Manual:$wgUser
				 */
				global $wgUser;
				// Abort if the contributor is a member of a group that should not be welcomed or the default welcomer
				if ( $wgUser->isAllowed( 'welcomeexempt' ) || $wgUser->getName() == self::DEFAULT_WELCOMER ) {
					if ( !empty( $wgHAWelcomeNotices ) ) {
						trigger_error( sprintf( '%s Done. The registered contributor is a bot, a staff member or the default welcomer.', __METHOD__ ) , E_USER_NOTICE );
					}
					// Restore the original error reporting level.
					error_reporting( $iErrorReporting );
					wfProfileOut( __METHOD__ );
					return true;
				}
				// Abort if the registered contributor has made edits before this one.
				if ( 1 < $wgUser->getEditCountLocal() ) {
					// Check the extension settings...
					/** @type String The user to become the welcomer. */
					$sSender = trim( wfMessage( 'welcome-user' )->inContentLanguage()->text() );
					if ( in_array( $sSender, array( '@latest', '@sysop' ) ) ) {
						if ( !empty( $wgHAWelcomeNotices ) ) {
							trigger_error( sprintf( '%s Taking the chance to update admin activity.', __METHOD__ ) , E_USER_NOTICE );
						}
						// ... and take the opportunity to update admin activity variable.
						/** @type Array Implicit group memberships the user has. */
						$aGroups =  $wgUser->getEffectiveGroups();
						if ( in_array( 'sysop', $aGroups ) && ! in_array( 'bot' , $aGroups ) ) {
							if ( !empty( $wgHAWelcomeNotices ) ) {
								trigger_error( sprintf( '%s Updating admin activity.', __METHOD__ ) , E_USER_NOTICE );
							}
							$wgMemc->set( wfMemcKey( 'last-sysop-id' ),  $wgUser->getId() );
						}
					}
					if ( !empty( $wgHAWelcomeNotices ) ) {
						trigger_error( sprintf( '%s Done. The registered contributor has already made edits.', __METHOD__ ) , E_USER_NOTICE );
					}
					// Restore the original error reporting level.
					error_reporting( $iErrorReporting );
					wfProfileOut( __METHOD__ );
					return true;
				}
			}
			// Mark that we have handled this particular contributor to prevent
			// creating more jobs. Improves performance if the contributor is editing massively.
			$wgMemc->set( wfMemcKey( 'HAWelcome-isPosted', $oRevision->getRawUserText() ), true );
			/** @type Object Title Title associated with the revision */
			$oTitle = $oRevision->getTitle();
			// Sometimes, for some reason or other, the Revision object
			// does not contain the associated Title object. It has to be
			// recreated based on the associated Page object.
			if ( !$oTitle ) {
				$oTitle = Title::newFromId( $oRevision->getPage(), Title::GAID_FOR_UPDATE );
				if ( !empty( $wgHAWelcomeNotices ) ) {
					trigger_error( sprintf(
						'%s Recreated Title for page %d, revision %d, URL %s',
						__METHOD__, $oRevision->getPage(), $oRevision->getId(), $oTitle->getFullURL()
					), E_USER_NOTICE );
				}
			}
			/** @type Array Parameters for the job */
			$aParams = array(
				// The id of the user to be welcome (0 if anon).
				'iUserId' => $oRevision->getRawUser(),
				// The name of the user to be welcome (IP if anon).
				'sUserName' => $oRevision->getRawUserText()
			);
			if ( !empty( $wgHAWelcomeNotices ) ) {
				trigger_error( sprintf( '%s Scheduling a job.', __METHOD__ ) , E_USER_NOTICE );
			}
			/** @type Object HAWelcomeJob The job to be enqueued. */
			$oJob = new self( $oTitle, $aParams );
			// Enqueue the job.
			$oJob->insert();
		}
		if ( !empty( $wgHAWelcomeNotices ) ) {
			trigger_error( sprintf( '%s Done.', __METHOD__ ) , E_USER_NOTICE );
		}
		// Restore the original error reporting level.
		error_reporting( $iErrorReporting );
		wfProfileOut( __METHOD__ );
		return true;
	}

	/**
	 * The constructor.
	 *
	 * Remember, that the constructor is called while scheduling the
	 * job in an HTTP request. For performance reasons it should do
	 * as little as possible. Heavy code goes to the run() method.
	 *
	 * @param $oTitle Object The Title associated with the Job.
	 * @param $aParams Array The Job parameters.
	 * @param $iId Integer The Job identifier.
	 * @since MediaWiki 1.19.4
	 * @internal
	 */
	public function __construct( $oTitle, $aParams, $iId = 0 ) {
		wfProfileIn( __METHOD__ );
		// Convert params to object properties (easier access).
		$this->iRecipientId = $aParams['iUserId'];
		$this->sRecipientName = $aParams['sUserName'];
		/** @global Boolean Show PHP Notices. Set via WikiFactory. */
		global $wgHAWelcomeNotices;
		$this->bShowNotices = !empty( $wgHAWelcomeNotices );
		parent::__construct( HAWELCOME_JOB_IDENTIFIER, $oTitle, $aParams, $iId );
		wfProfileOut( __METHOD__ );
	}

	/**
	 * The main method called by the job executor.
	 *
	 * The heavy code goes here.
	 *
	 * @return Boolean Indicated whether the job has been completed successfully.
	 * @since MediaWiki 1.19.4
	 * @internal
	 */
	public function run() {
		wfProfileIn( __METHOD__ );
		/** @type Interget Store the original error reporting level. */
		$iErrorReporting = error_reporting();
		error_reporting( E_ALL );
		// Complete the job if the feature has been disabled by the admin of the wiki.
		if ( in_array( trim( wfMessage( 'welcome-user' )->inContentLanguage()->text() ), array( '@disabled', '-' ) ) ) {
			if ( $this->bShowNotices ) {
				trigger_error( sprintf( '%s Terminated. The feature has been disabled.', __METHOD__ ) , E_USER_NOTICE );
			}
			error_reporting( $iErrorReporting );
			wfProfileOut( __METHOD__ );
			return true;
		}
		/** @global Object User The user who runs the script. */
		global $wgUser;
		/** @type Object User Store the original $wgUser for a moment. */
		$tmp = $wgUser;
		// Replace the current active user object with the DEFAULT_WELCOMER object for the job.
		$wgUser = User::newFromName( self::DEFAULT_WELCOMER );
		// Create objects related to the recipient of the welcome message.
		//
		// A User object.
		$this->oRecipient = User::newFromId( $this->iRecipientId );
		// User objects for anonymous contributors don't have the name set.
		if ( ! $this->iRecipientId ) {
			$this->oRecipient->setName( $this->sRecipientName );
		}
		// A TalkPage object.
		$this->oRecipientTalkPage = new Article( $this->oRecipient->getUserPage()->getTalkPage() );
		/**
		 * @global Boolean Indicated whether the Message Wall extension is enabled.
		 */
		global $wgEnableWallExt;
		$this->bMessageWallExt = ! empty( $wgEnableWallExt );
		/** @type String The user-level configuration of the feature. */
		$sSwitches = wfMessage( 'welcome-enabled' )->inContentLanguage()->text();
		// Override the default switches with user's values.
		foreach ( $this->aSwitches as $sSwitch => $bValue ) {
			if ( false !== strpos( $sSwitches, $sSwitch ) ) {
				$this->aSwitches[$sSwitch] = true;
			}
		}
		// Refresh the sender data.
		$this->setSender();
		// If possible, mark edits as if they were made by a bot.
		if ( $this->oSender->isAllowed( 'bot' ) || '@bot' == trim( wfMessage( 'welcome-bot' )->inContentLanguage()->text() ) ) {
			if ( $this->bShowNotices ) {
				trigger_error( sprintf( '%s All edits will be marked as if they were made by a bot.', __METHOD__ ) , E_USER_NOTICE );
			}
			$this->iFlags = EDIT_FORCE_BOT;
		}
		// Start: anonymous users block
		if ( ! $this->iRecipientId && $this->aSwitches['message-anon'] ) {
			if ( $this->bShowNotices ) {
				trigger_error( sprintf( '%s Block of code for an anonymous contributor.', __METHOD__ ) , E_USER_NOTICE );
			}
			if (
				// The Message Wall extension is enabled and user's wall is empty or ...
				( $this->bMessageWallExt && ! WallHelper::haveMsg( $this->oRecipient ) )
				// ... or the Message Wall extension is disabled and recipient's Talk Page does not exist
				|| ( !$this->bMessageWallExt && !$this->oRecipientTalkPage->exists() )
			) {
				$this->setMessage();
				$this->sendMessage();
			}
		// End: anonymous users block
		// Start: registered users block
		} else if ( $this->iRecipientId ) {
			if ( $this->bShowNotices ) {
				trigger_error( sprintf( '%s Block of code for a registered contributor.', __METHOD__ ) , E_USER_NOTICE );
			}
			// If configured so, send a welcome message.
			if ( $this->aSwitches['message-user'] ) {
				$this->setMessage();
				$this->sendMessage();
			}
			// If configured so, create a user profile page, if not exists.
			if ( $this->aSwitches['page-user'] ) {
				if ( $this->bShowNotices ) {
					trigger_error( sprintf( '%s Attempting to create a user profile page.', __METHOD__ ) , E_USER_NOTICE );
				}
				/** @type Object Article Recipient's profile page. */
				$oRecipientProfile = new Article( $this->oRecipient->getUserPage() );
				if ( ! $oRecipientProfile->exists() ) {
					if ( $this->bShowNotices ) {
						trigger_error( sprintf( '%s The user profile page already exists.', __METHOD__ ) , E_USER_NOTICE );
					}
					$oRecipientProfile->doEdit( wfMessage( 'welcome-user-page', $this->sRecipientName )->inContentLanguage()->plain(), false, $this->iFlags );
				}
			}
		// End: registered users block
		}
		if ( $this->bShowNotices ) {
			trigger_error( sprintf( '%s Done.', __METHOD__ ) , E_USER_NOTICE );
		}
		// Restore the original active user object.
		$wgUser = $tmp;
		// Restore the original error reporting level.
		error_reporting( $iErrorReporting );
		wfProfileOut( __METHOD__ );
		return true;
	}

	/**
	 * Sends the message to the recipient.
	 *
	 * @since MediaWiki 1.19.4
	 * @internal
	 */
	public function sendMessage() {
		global $wgUser;
		wfProfileIn( __METHOD__ );
		if ( $this->bShowNotices ) {
			trigger_error( sprintf( '%s Start.', __METHOD__ ) , E_USER_NOTICE );
		}
		// Post a message onto a message wall if enabled.
		if ( $this->bMessageWallExt ) {
			if ( $this->bShowNotices ) {
				trigger_error( sprintf( '%s Message Wall enabled.', __METHOD__ ) , E_USER_NOTICE );
			}
			// See: extensions/wikia/Wall/WallMessage.class.php
			/** @type Mixed|Boolean The WallMessage object or logical false. */
			$mWallMessage = WallMessage::buildNewMessageAndPost(
                $this->sMessage, $this->sRecipientName, $wgUser,
                wfMessage( 'welcome-message-log' )->inContentLanguage()->text(), false, array(), false, false
			);
			// Sets the sender of the message when the actual message
			// was posted by the welcome bot
			if ( $mWallMessage ) {
				$mWallMessage->setPostedAsBot( $this->oSender );
				$mWallMessage->sendNotificationAboutLastRev();
			}
		// Post a message onto a regular talk page.
		} else {
			if ( $this->bShowNotices ) {
				trigger_error( sprintf( '%s Message Wall disabled.', __METHOD__ ) , E_USER_NOTICE );
			}
			// Prepend the message with the existing content of the talk page.
			/** @type String The contents for the edit. */
			$sMessage = ( $this->oRecipientTalkPage->exists() )
				? $this->oRecipientTalkPage->getContent() . PHP_EOL . $this->sMessage
				: $this->sMessage;
			// Do the edit.
			$this->oRecipientTalkPage->doEdit( $sMessage, wfMessage( 'welcome-message-log' )->inContentLanguage()->text(), $this->iFlags );
		}
		if ( $this->bShowNotices ) {
			trigger_error( sprintf( '%s Done.', __METHOD__ ) , E_USER_NOTICE );
		}
		wfProfileOut( __METHOD__ );
	}

	/**
	 * Determines the contents of the welcome message.
	 *
	 * @since MediaWiki 1.19.4
	 * @internal
	 */
	public function setMessage() {
		wfProfileIn( __METHOD__ );
		if ( $this->bShowNotices ) {
			trigger_error( sprintf( '%s Start.', __METHOD__ ) , E_USER_NOTICE );
		}
		/** @type String The key for the welcome message. */
		$sMessageKey = 'welcome-message-';
		//Determine the proper key
		//
		// Is Message Wall enabled?
		$sMessageKey  .= $this->bMessageWallExt
			? 'wall-'  : '';
		// Is recipient a registered user?
		$sMessageKey .= $this->iRecipientId
			? 'user'  : 'anon';
		// Is sender a staff member and not a local admin?
		$senderGroups = $this->oSender->getEffectiveGroups();
		$sMessageKey .= ( in_array( 'staff', $senderGroups ) && !in_array( 'sysop', $senderGroups ) )
			? '-staff' : '';
		if ( $this->bShowNotices ) {
			trigger_error( sprintf( '%s Message key is %s.', __METHOD__, $sMessageKey ) , E_USER_NOTICE );
		}
		/** @type String The title of the page the recipient contributed to, for display. */
		$sPrefixedText = $this->title->getPrefixedText();
		// Article Comments and Message Wall hook up to this event.
		wfRunHooks( 'HAWelcomeGetPrefixText' , array( &$sPrefixedText, $this->title ) );
		// Determine the key for the signature.
		$sSignatureKey = ( in_array( 'staff', $senderGroups ) && !in_array( 'sysop', $senderGroups ) )
			? 'staffsig-text' : 'signature';
		// Determine the full signature.
		$sFullSignature = wfMessage(
			$sSignatureKey,
			$this->oSender->getName(),
			Parser::cleanSigInSig( $this->oSender->getName() )
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
		$this->sMessage = wfMessage( $sMessageKey,
			$sPrefixedText,
			$this->oSender->getUserPage()->getTalkPage()->getPrefixedText(),
			$sFullSignature,
			wfEscapeWikiText( $this->sRecipientName )
		)->inContentLanguage()->plain();
		if ( $this->bShowNotices ) {
			trigger_error( sprintf( '%s Done.', __METHOD__ ) , E_USER_NOTICE );
		}
		wfProfileOut( __METHOD__ );
	}

	/**
	 * Determines the sender of the welcome message.
	 *
	 * @since MediaWiki 1.19.4
	 * @internal
	 */
	public function setSender() {
		wfProfileIn( __METHOD__ );
		if ( $this->bShowNotices ) {
			trigger_error( sprintf( '%s Start.', __METHOD__ ) , E_USER_NOTICE );
		}
		/** @type String Get the user-level setting. */
		$sSender = trim( wfMessage( 'welcome-user' )->inContentLanguage()->text() );
		if ( $this->bShowNotices ) {
			trigger_error( sprintf( '%s The user level setting is: %s.', __METHOD__, $sSender ) , E_USER_NOTICE );
		}
		// Check for known values indicating that the most recently active admin has to be the sender.
		if ( in_array( $sSender, array( '@latest', '@sysop' ) ) ) {
			/**
			 * @global Object MemcachedPhpBagOStuff A pure-PHP memcached client instance.
			 * @see https://doc.wikimedia.org/mediawiki-core/master/php/html/classMemcachedPhpBagOStuff.html
			 */
			global $wgMemc;
			/** @type Integer The cached user id of the most recently active admin. */
			$iSender = (int) $wgMemc->get( wfMemcKey( 'last-sysop-id' ) );
			// No cached value.
			if ( ! $iSender ) {
				if ( $this->bShowNotices ) {
					trigger_error( sprintf( '%s No cached value. Querying the database.', __METHOD__ ) , E_USER_NOTICE );
				}
				// Fetch the list of users who are sysops and/or bots.
				/** @type Object DatabaseBase The database object. */
				$oDB = wfGetDB( DB_SLAVE );
				/** @type Object ResultWrapper */
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
				/** @type Integer The user id of the most recently active candidate. */
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
					if ( $this->bShowNotices ) {
						trigger_error( sprintf( '%s Caching a non-zero value from the db: %d.', __METHOD__, $iSender ) , E_USER_NOTICE );
					}
					$wgMemc->set( wfMemcKey( 'last-sysop-id' ), $iSender );
				}
			}
			if ( $this->bShowNotices ) {
				trigger_error( sprintf( '%s Attempting to create a user object from id %d.', __METHOD__, $iSender ) , E_USER_NOTICE );
			}
			// Create a User object.
			/** @type Object User The sender for the welcome message. */
			$oSender = User::newFromId( $iSender );
		// If another value has been set, assume it is meant to be the name of the sender.
		} else {
			if ( $this->bShowNotices ) {
				trigger_error( sprintf( '%s Attempting to create a user object from name %s.', __METHOD__, $sSender ) , E_USER_NOTICE );
			}
			// Create a User object.
			/** @type Object User The sender for the welcome message. */
			$oSender = User::newFromName( $sSender );
		}
		// Terminate, if a valid user object has been created.
		if( $oSender instanceof User && $oSender->getId() ) {
			if ( $this->bShowNotices ) {
				trigger_error( sprintf( '%s Done. The selected user was %s.', __METHOD__, $oSender->getName() ) , E_USER_NOTICE );
			}
			$this->oSender = $oSender;
			wfProfileOut( __METHOD__ );
			return;
		}
		// If no recently active admin has been found, fall back to a relevant staff member.
		/**
		 * @global String The language of the wiki.
		 * @see http://www.mediawiki.org/wiki/Manual:$wgLanguageCode
		 */
		global $wgLanguageCode;
		// Create a User object.
		/** @type Object User The sender for the welcome message. */
		$oSender = Wikia::staffForLang( $wgLanguageCode );
		// Terminate, if a valid user object has been created.
		if( $oSender instanceof User && $oSender->getId() ) {
			if ( $this->bShowNotices ) {
				trigger_error( sprintf( '%s No active admin. Used a staff member %s.', __METHOD__, $oSender->getName() ) , E_USER_NOTICE );
			}
			$this->oSender = $oSender;
			wfProfileOut( __METHOD__ );
			return;
		}
		// This should not happen. Fall back to the default welcomer and terminate.
		$this->oSender = User::newFromName( self::DEFAULT_WELCOMER );
		trigger_error( sprintf(
			'%s fell back to the default sender while trying to send a welcome message to %s (%d).',
			__METHOD__, $this->sRecipientName, $this->iRecipientId
		), E_USER_WARNING );
		wfProfileOut( __METHOD__ );
		return;
	}
}
