<?php

/**
 * Forum
 * @author Kyle Florence, Saipetch Kongkatong, Tomasz Odrobny
 */
class Forum extends WikiaModel {

	const ACTIVE_DAYS = 7;

	/**
	 * get list of board
	 * @return array boards
	 */
	public function getBoardList() {
		$this->wf->profileIn( __METHOD__ );

		$db = $this->wf->GetDB( DB_SLAVE );

		// get board list
		$result = $db->select(
			array( 'page' ),
			array( 'page_id, page_title' ),
			array( 'page_namespace' => NS_WIKIA_FORUM_BOARD ),
			__METHOD__,
			array( 'ORDER BY' => 'page_title' )
		);

		$boards = array();
		while ( $row = $db->fetchObject($result) ) {
			$boardId = $row->page_id;
			$title = F::build( 'Title', array( $boardId ), 'newFromID' );
			if( $title instanceof Title ) {
				$board = F::build( 'ForumBoard', array( $boardId ), 'newFromId' );
				$boardInfo = $board->getBoardInfo();
				$boardInfo['id'] = $boardId;
				$boardInfo['name'] = $title->getText();
				$boardInfo['url'] = $title->getFullURL();

				$boards[$boardId] = $boardInfo;
			}
		}

		$this->wf->profileOut( __METHOD__ );

		return $boards;
	}

	public function getRecentUsers() {
		$this->wf->profileIn( __METHOD__ );
		
		
		$this->wf->profileOut( __METHOD__ );		
	}
	
	/**
	 * get total threads excluding deleted and removed threads
	 * @param integer $days
	 * @return integer $totalThreads
	 */
	public function getTotalThreads( $days = 0 ) {
		$this->wf->ProfileIn( __METHOD__ );

		$memKey = $this->getMemKeyTotalThreads( $days );
		$totalThreads = $this->wg->Memc->get( $memKey );
		if ( $totalThreads === false ) {
			$db = $this->wf->GetDB( DB_SLAVE );

			$sqlWhere = array(
				'parent_comment_id' => 0,
				'deleted' => 0,
				'removed' => 0,
				'page_namespace' => NS_WIKIA_FORUM_BOARD_THREAD
			);

			// active threads
			if ( !empty($days) ) {
				$sqlWhere[] = "last_touched > curdate() - interval $days day";
			}

			$row = $db->selectRow(
				array( 'comments_index', 'page' ),
				array( 'count(*) cnt' ),
				$sqlWhere,
				__METHOD__,
				array(),
				array(
					'page' => array(
						'LEFT JOIN',
						array( 'page_id=comment_id' )
					)
				)
			);

			$totalThreads = 0;
			if ( $row ) {
				$totalThreads = intval( $row->cnt );
			}
			$this->wg->Memc->set( $memKey, $totalThreads, 60*60*12 );
		}

		$this->wf->ProfileOut( __METHOD__ );

		return $totalThreads;
	}

	// get the number of threads that have had a new post/reply in the last 7 days
	public function getTotalActiveThreads() {
		return $this->getTotalThreads( self::ACTIVE_DAYS );
	}

	/**
	 * get memcache key for total threads
	 * @param integer $days
	 * @return string 
	 */
	protected function getMemKeyTotalThreads( $days ) {
		return $this->wf->MemcKey( 'forum_total_threads_'.$days );
	}

	// clear cache for total threads
	public function clearCacheTotalThreads( $days = 0 ) {
		$memKey = $this->getMemKeyTotalThreads( $days );
		$this->wg->Memc->delete($memKey);
	}

	// clear cache for total active threads
	public function clearCacheTotalActiveThreads() {
		$this->clearCacheTotalThreads( self::ACTIVE_DAYS );
	}

}
