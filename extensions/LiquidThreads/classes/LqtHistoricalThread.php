<?php
if ( !defined( 'MEDIAWIKI' ) ) die;

class HistoricalThread extends Thread {
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
		$this->changeType = $t->changeType;
		$this->changeObject = $t->changeObject;
		$this->changeComment = $t->changeComment;
		$this->changeUser = $t->changeUser;
		$this->changeUserText = $t->changeUserText;
		$this->editedness = $t->editedness;

		$this->replies = array();
		foreach ( $t->replies as $r ) {
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

	static function create( $t, $change_type, $change_object ) {
		$tmt = $t->topmostThread();
		$contents = HistoricalThread::textRepresentation( $tmt );
		$dbr =& wfGetDB( DB_MASTER );
		$res = $dbr->insert( 'historical_thread', array(
			'hthread_id' => $tmt->id(),
			'hthread_revision' => $tmt->revisionNumber(),
			'hthread_contents' => $contents,
			'hthread_change_type' => $tmt->changeType(),
			'hthread_change_object' => $tmt->changeObject() ? $tmt->changeObject()->id() : null ),
			__METHOD__ );
	}

	static function withIdAtRevision( $id, $rev ) {
		$dbr =& wfGetDB( DB_SLAVE );
		$line = $dbr->selectRow(
			'historical_thread',
			'hthread_contents',
			array( 'hthread_id' => $id, 'hthread_revision' => $rev ),
			__METHOD__ );
		if ( $line )
			return HistoricalThread::fromTextRepresentation( $line->hthread_contents );
		else
			return null;
	}

	function isHistorical() {
		return true;
	}
}
