<?php
/**
 * Hook dispatching logic for the HAWelcome task. The dispatching for the
 * task in the hook is not trivial and I think deserves it's own class that
 * encapsulates the logic for sending the welcome message.
 */

use Wikia\Logger\Loggable;

class HAWelcomeTaskHookDispatcher {
	use Loggable;
	use IncludeMessagesTrait;

	const WELCOME_SENT_FLAG = 'ha-welcome-msg-sent';

	/** @type \Revision */
	private $revisionObject = null;

	/** @type int */
	private $cityId = null;

	/** @type MemcachedPhpBagOStuff */
	private $memcacheClient = null;

	/** @type \User */
	private $currentUser = null;

	protected function getLoggerContext() {
		$userId = null;
		$userEmail = null;
		$userName = null;

		if ( !empty( $this->currentUser ) ) {
			$userId = $this->currentUser->getId();
			$userEmail = $this->currentUser->getEmail();
			$userName = $this->currentUser->getName();
		}

		return [
			'task' => __CLASS__,
			'hook' => 'onArticleSaveComplete',
			'wikiId' => $this->cityId,
			'userId' => $userId,
			'userEmail' => $userEmail,
			'userName' => $userName,
		];
	}

	public function dispatch() {
		// abort if the feature has been disabled by the admin of the wiki.
		if ( $this->welcomeMessageDisabled() ) {
			$this->info( "aborting the hook: HAWelcome extension is disabled via the 'welcome-user' message." );
			return true;
		}

		if ( $this->currentUserHasBeenWelcomed() ) {
			$this->info( "aborting the welcome hook: user has already been welcomed" );
			return true;
		}
		$this->markCurrentUserAsWelcomed();

		if ( $this->revisionObject->getRawUser() ) {
			// we are working with an edit from a registered contributor

			if ( $this->currentUserIsWelcomeExempt() || $this->currentUserIsDefaultWelcomer() || $this->currentUserIsFounder() ) {
				$this->info( "aborting the welcome hook for an exempt user, default welcomer, or founder" );
				return true;
			}

			if ( $this->currentUserHasLocalEdits() ) {
				$this->info( "aborting the welcome hook for a user that has local edits" );
				$this->updateAdminActivity();
				return true;
			}

			$this->info( "queueing welcome task for user" );
		} else {
			$this->info( "queueing welcome task for an anonymous user" );
		}

		$this->markHAWelcomePosted();
		$this->queueWelcomeTask( $this->getTitleObjectFromRevision() );
		$this->info( "queued welcome task" );

		return true;
	}

	protected function currentUserHasBeenWelcomed() {
		return $this->currentUser->getLocalFlag( self::WELCOME_SENT_FLAG );
	}

	protected function markCurrentUserAsWelcomed() {
		$this->currentUser->setLocalFlag( self::WELCOME_SENT_FLAG, true );
	}

	protected function currentUserIsWelcomeExempt() {
		return $this->currentUser->isAllowed( 'welcomeexempt' );
	}

	protected function currentUserIsDefaultWelcomer() {
		return $this->currentUser->getName() == HAWelcomeTask::DEFAULT_WELCOMER;
	}

	protected function currentUserIsFounder() {
		$wiki = $this->getWiki();
		$founderId = isset( $wiki->city_founding_user ) ? intval( $wiki->city_founding_user ) : false;
		return $founderId === intval( $this->revisionObject->getRawUser() );
	}

	protected function currentUserHasLocalEdits() {
		return $this->currentUser->getEditCountLocal() > 1;
	}

	public function updateAdminActivity() {
		// FIXME: @michalroszka (from 368101b9) the intent here is not very clear. Can we
		// use better names or comments?
		$sender = $this->getWelcomeUserFromMessages();
		if ( in_array( $sender, array( '@latest', '@sysop' ) ) ) {
			// ... and take the opportunity to update admin activity variable.
			$groupsArray = $this->currentUser->getEffectiveGroups();

			$currentUserIsInSysop = in_array( 'sysop', $groupsArray );
			$currentUserIsNotInBot = !in_array( 'bot' , $groupsArray );
			if ( $currentUserIsInSysop && $currentUserIsNotInBot ) {
				$this->memcacheClient->set( wfMemcKey( 'last-sysop-id' ), $this->currentUser->getId() );
			}
		}
	}

	public function getWelcomeUserFromMessages() {
		return trim( $this->getTextVersionOfMessage( 'welcome-user' ) );
	}

	protected function markHAWelcomePosted() {
		$this->memcacheClient->set( wfMemcKey( 'HAWelcome-isPosted', $this->revisionObject->getRawUserText() ), true );
	}


	protected function getTitleObjectFromRevision() {
		$titleObject = $this->revisionObject->getTitle();
		if ( !$titleObject ) {
			// Sometimes, for some reason or other, the Revision object
			// does not contain the associated Title object. It has to be
			// recreated based on the associated Page object.
			$titleObject = Title::newFromId( $this->revisionObject->getPage(), Title::GAID_FOR_UPDATE );
			$this->error( sprintf( 'recreated Title for page %d, revision %d, URL %s',
			 	$this->revisionObject->getPage(), $this->revisionObject->getId(), $titleObject->getFullURL() ) );
		}

		return $titleObject;
	}

	protected function queueWelcomeTask( \Title $titleObject ) {
		$params = array(
			// The id of the user to be welcome (0 if anon).
			'iUserId' => $this->revisionObject->getRawUser(),
			// The name of the user to be welcome (IP if anon).
			'sUserName' => $this->revisionObject->getRawUserText(),
			// The time when the job has been scheduled (as UNIX timestamp).
			'iTimestamp' => time()
		);

		// FIXME: create and queue a new HAWelcomeTask once the job is depricated
		HAWelcomeHooks::queueHAWelcomeTask( $this->cityId, $titleObject, $params );
	}

	protected function getWiki() {
		return WikiFactory::getWikiById( $this->cityId );
	}

	public function setRevisionObject( \Revision $revisionObject ) {
		$this->revisionObject = $revisionObject;
		return $this;
	}

	public function setCityId( $cityId ) {
		$this->cityId = $cityId;
		return $this;
	}

	public function setMemcacheClient( \BagOStuff $memcacheClient ) {
		$this->memcacheClient = $memcacheClient;
		return $this;
	}

	protected function getMemcacheClient() {
		return $this->memcacheClient;
	}

	public function setCurrentUser( \User $user ) {
		$this->currentUser = $user;
		return $this;
	}

	public function welcomeMessageDisabled() {
		if ( in_array( trim( $this->getTextVersionOfMessage( 'welcome-user' ) ), array( '@disabled', '-' ) ) ) {
			return true;
		}
	}


}
