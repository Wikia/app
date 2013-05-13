<?php
/**
 * Created by adam
 * Date: 10.05.13
 */

class RevisionService implements IRevisionService {
	private $databaseConnection;

	function __construct( $databaseConnection = null ) {
		if( $databaseConnection == null ) {
			$databaseConnection = wfGetDB( DB_SLAVE );
		}
		$this->databaseConnection = $databaseConnection;
	}

	public function getLatestRevisions() {
		$result = $this->databaseConnection->select( 'revision', 'rev_id, rev_page, rev_user, rev_timestamp', '', __METHOD__, array( 'LIMIT' => 3, 'ORDER BY' => 'rev_timestamp DESC' ) );
		$items = array();
		while( ( $row = $result->fetchObject() ) !== false ) {
			$dateTime = date_create_from_format( 'YmdHis', $row->rev_timestamp );
			$items[ $row->rev_id ] = array(
				'id' => $row->rev_id,
				'article' => $row->rev_id,
				'user' => $row->rev_user,
				'timestamp' => $dateTime->getTimestamp()
			);
		}
		return $items;
	}
}
