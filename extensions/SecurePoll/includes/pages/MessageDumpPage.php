<?php

class SecurePoll_MessageDumpPage extends SecurePoll_Page {
	function execute( $params ) {
		global $wgOut;

		if ( !count( $params ) ) {
			$wgOut->addWikiMsg( 'securepoll-too-few-params' );
			return;
		}
		
		$electionId = intval( $params[0] );
		$this->election = $this->context->getElection( $electionId );
		if ( !$this->election ) {
			$wgOut->addWikiMsg( 'securepoll-invalid-election', $electionId );
			return;
		}

		$wgOut->disable();
		header( 'Content-Type: application/x-sql; charset=utf-8' );
		$filename = urlencode( "sp-msgs-$electionId-" . wfTimestampNow() . '.sql' );
		header( "Content-Disposition: attachment; filename=$filename" );
		$dbr = $this->context->getDB();

		$entities = array_merge( array( $this->election ), $this->election->getDescendants() );
		$ids = array();
		foreach ( $entities as $entity ) {
			$ids[] = $entity->getId();
		}
		$res = $dbr->select(
			'securepoll_msgs',
			'*',
			array( 'msg_entity' => $ids ),
			__METHOD__ );
		if ( !$res->numRows() ) {
			return;
		}
		echo "INSERT INTO securepoll_msgs (msg_entity,msg_lang, msg_key, msg_text) VALUES\n";
		$first = true;
		foreach ( $res as $row ) {
			$values = array(
				$row->msg_entity, 
				$row->msg_lang,
				$row->msg_key,
				$row->msg_text
			);
			if ( $first ) {
				$first = false;
			} else {
				echo ",\n";
			}
			echo '(' . implode( ', ', array_map( array( $dbr, 'addQuotes' ), $values ) ) . ')';
		}
		echo ";\n";
	}
}
