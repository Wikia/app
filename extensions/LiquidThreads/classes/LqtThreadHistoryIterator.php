<?php
if ( !defined( 'MEDIAWIKI' ) ) die;

class ThreadHistoryIterator extends ArrayIterator {

	function __construct( $thread, $limit, $offset ) {
		$this->thread = $thread;
		$this->limit = $limit;
		$this->offset = $offset;
		$this->loadRows();
	}

	private function loadRows() {
		if ( $this->offset == 0 ) {
			$this->append( $this->thread );
			$this->limit -= 1;
		} else {
			$this->offset -= 1;
		}

		$dbr =& wfGetDB( DB_SLAVE );
		$res = $dbr->select(
			'historical_thread',
			'hthread_contents, hthread_revision',
			array( 'hthread_id' => $this->thread->id() ),
			__METHOD__,
			array( 'ORDER BY' => 'hthread_revision DESC',
			      'LIMIT' =>  $this->limit,
			      'OFFSET' => $this->offset ) );
		while ( $l = $dbr->fetchObject( $res ) ) {
			$this->append( HistoricalThread::fromTextRepresentation( $l->hthread_contents ) );
		}
	}
}
