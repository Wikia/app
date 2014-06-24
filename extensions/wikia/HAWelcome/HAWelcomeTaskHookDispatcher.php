<?php


use Wikia\Logger\Loggable;

class HAWelcomeTaskHookDispatcher {
	use Loggable;

	/** @type \Revision */
	private $revisionObject = null;

	/** @type int */
	private $cityId = null;

	/** @type MemcachedPhpBagOStuff */
	private $memcacheClient = null;

	/** @type \User */
	private $currentUser = null;

	protected function getLoggerContext() {
		return [
			'task' => __CLASS__,
			'hook' => 'onArticleSaveComplete'
			];
	}

	public function dispatch() {
		if ( $this->hasContributorBeenWelcomedRecently() ) {
			// abort if they have contributed recenty
			return true;
		}


		if ( $this->revisionObject->getRawUser() ) {
			// we are working with an edit from a registered contributor

			if ( $this->currentUserIsWelcomeExempt() || $this->currentUserIsDefaultWelcomer() || $this->currentUserIsFounder() ) {
				return true;
			}


			if ( $this->currentUserHasLocalEdits() ) {
				// TODO: update admin activity depending on welcome user settings lines 138-152
				return true;
			}

			$this->markHAWelcomePosted();

			$this->queueWelcomeTask( $this->getTitleObjectFromRevision() );
		}

		return true;
	}

	protected function hasContributorBeenWelcomedRecently() {
		return $this->getMemcacheClient()->get( wfMemcKey( 'HAWelcome-isPosted', $this->revisionObject->getRawUserText() ) );
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

	protected function markHAWelcomePosted() {
		$this->memcacheClient->set( wfMemcKey( 'HAWelcome-isPosted', $oRevision->getRawUserText() ), true );
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
	}

	public function setCityId( $cityId ) {
		$this->cityId = $cityId;
		return $this;
	}

	public function setMemcacheClient( \MemcachedPhpBagOStuff $memcacheClient ) {
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
}
