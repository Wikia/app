<?php

/**
 * this class provieds basic information about all the walls existing in system
 */

class Walls extends WikiaModel {
	/**
	 * get list of board
	 * @return array boards
	 */
	public function getList( $db = DB_SLAVE, $namespace = NS_USER_WALL ) {
		$this->wf->profileIn( __METHOD__ );

		$dbw = $this->wf->GetDB( $db );

		// get board list
		$result = $dbw->select(
			array( 'page', 'page_wikia_props' ),
			array( 'page.page_id as page_id, page.page_title as page_title' ),
			array(
				'page.page_namespace' => $namespace,
				'page_wikia_props.page_id = page.page_id'
			),
			__METHOD__,
			array( 'ORDER BY' => 'page_title' )
		);

		$boards = array();
		while ( $row = $dbw->fetchObject( $result ) ) {
			$boardId = $row->page_id;
			if ( $db == DB_MASTER ) {
				$title = Title::newFromID( $boardId, Title::GAID_FOR_UPDATE );
			} else {
				$title = Title::newFromID( $boardId );
			}

			if ( $title instanceof Title ) { 
				$boards[] = $boardId;				
			}
		}

		$this->wf->profileOut( __METHOD__ );

		return $boards;
	}
}
