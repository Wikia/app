<?php
if ( !defined( 'MEDIAWIKI' ) ) die;

class HistoricalThread extends Thread {
	/* Information about what changed in this revision. */
	protected $changeType;
	protected $changeObject;
	protected $changeComment;
	protected $changeUser;
	protected $changeUserText;

	function __construct( $t ) {
		/* SCHEMA changes must be reflected here. */
		$this->rootId = $t->rootId;
		$this->rootRevision = $t->rootRevision;
		$this->articleId = $t->articleId;
		$this->summaryId = $t->summaryId;
		$this->articleNamespace = $t->articleNamespace;
		$this->articleTitle = $t->articleTitle;
		$this->modified = $t->modified;
		$this->created = $t->created;
		$this->ancestorId = $t->ancestorId;
		$this->parentId = $t->parentId;
		$this->id = $t->id;
		$this->revisionNumber = $t->revisionNumber;
		$this->editedness = $t->editedness;

		$this->replies = array();
		foreach ( $t->replies() as $r ) {
			$this->replies[] = new HistoricalThread( $r );
		}
	}

	static function textRepresentation( $t ) {
		$ht = new HistoricalThread( $t );
		return serialize( $ht );
	}

	static function fromTextRepresentation( $r ) {
		return unserialize( $r );
	}

	static function withIdAtRevision( $id, $rev ) {
		$dbr = wfGetDB( DB_SLAVE );
		$line = $dbr->selectRow(
			'historical_thread',
			'hthread_contents',
			array(
				'hthread_id' => $id,
				'hthread_revision' => $rev
			),
			__METHOD__ );
		if ( $line )
			return HistoricalThread::fromTextRepresentation( $line->hthread_contents );
		else
			return null;
	}

	function isHistorical() {
		return true;
	}


	function changeType() {
		return $this->changeType;
	}

	function changeObject() {
		return $this->replyWithId( $this->changeObject );
	}

	function setChangeType( $t ) {
		if ( in_array( $t, Threads::$VALID_CHANGE_TYPES ) ) {
			$this->changeType = $t;
		} else {
			throw new MWException( __METHOD__ . ": invalid changeType $t." );
		}
	}

	function setChangeObject( $o ) {
		# we assume $o to be a Thread.
		if ( $o === null ) {
			$this->changeObject = null;
		} else {
			$this->changeObject = $o->id();
		}
	}

	function changeUser() {
		if ( $this->changeUser == 0 ) {
			return User::newFromName( $this->changeUserText, false /* No validation */ );
		} else {
			return User::newFromId( $this->changeUser );
		}
	}

	function changeComment() {
		return $this->changeComment;
	}

	function setChangeUser( $user ) {
		$this->changeUser = $user->getId();
		$this->changeUserText = $user->getName();
	}
}
