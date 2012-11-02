<?php

/**
 * Forum
 * @author Kyle Florence, Saipetch Kongkatong, Tomasz Odrobny
 */
class Forum extends WikiaModel {

	const ACTIVE_DAYS = 7;
	const BOARD_MAX_NUMBER = 50;
	const AUTOCREATE_USER = 'Wikia';
	//controlling from outside if use can edit/create/delete board page
	static  $allowToEditBoard = false;	
	/**
	 * get list of board
	 * @return array boards
	 */
	public function getBoardList($db = DB_SLAVE) {
		$this->wf->profileIn( __METHOD__ );

		$dbw = $this->wf->GetDB( $db );

		// get board list
		$result = $dbw->select(
			array( 'page', 'page_wikia_props' ),
			array( 'page.page_id as page_id, page.page_title as page_title, page_wikia_props.props as order_index'),
			array( 
				'page.page_namespace' => NS_WIKIA_FORUM_BOARD,
				'page_wikia_props.page_id = page.page_id',
				'page_wikia_props.propname' => WPP_FORUM_ORDER_INDEX
			),
			__METHOD__,
			array( 'ORDER BY' => 'page_title' )
		);

		$boards = array();
		while ( $row = $dbw->fetchObject($result) ) {
			$boardId = $row->page_id;
			if($db == DB_MASTER) {
				$title = Title::newFromID( $boardId, Title::GAID_FOR_UPDATE );	
			} else {
				$title = Title::newFromID( $boardId );
			}
			
			if( $title instanceof Title ) {
				$board = ForumBoard::newFromId( $boardId );
				$boardInfo = $board->getBoardInfo();
				$boardInfo['id'] = $boardId;
				$boardInfo['name'] = $title->getText();
				$boardInfo['description'] = $board->getDescription();
				$boardInfo['url'] = $title->getFullURL();
				$boardInfo['order_index'] = wfUnserializeProp($row->order_index);
				$boards[$boardId] = $boardInfo;
			}
		}

		usort($boards, function($a, $b) {
			if ($a['order_index'] == $b['order_index']) {
        		return 0;
    		}
    		return ($a['order_index'] < $b['order_index']) ? -1 : 1;
		});

		$this->wf->profileOut( __METHOD__ );

		return $boards;
	}
	
	/**
	 * get count of boards
	 * @return int board count
	 */
	public function getBoardCount($db = DB_SLAVE) {
		$this->wf->profileIn( __METHOD__ );

		$dbw = $this->wf->GetDB( $db );

		// get board list
		$result = (int) $dbw->selectField(
			array( 'page' ),
			array( 'count(*) as cnt' ),
			array( 'page_namespace' => NS_WIKIA_FORUM_BOARD ),
			__METHOD__,
			array()
		);
		
		return $result['cnt'];
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
	
	public function hasAtLeast( $ns, $count ) {
		$this->wf->ProfileIn( __METHOD__ );

		$out = WikiaDataAccess::cache( wfMemcKey('Forum_hasAtLeast', $ns, $count), 24*60*60 /* one day */, function() use ($ns, $count) {
			$app = F::App();
			$db = $app->wf->GetDB( DB_MASTER );
			// check if there is more then 5 forum pages (5 is number of forum pages from starter)
			// limit 6 is faster solution then count(*) and the compare in php
			$result = $db->select(
				array( 'page' ),
				array( 'page_id' ),
				array( 'page_namespace' => $ns ),
				__METHOD__,
				array( 'LIMIT' => $count + 1 )
			);

			$rowCount = $db->numRows($result);
			//string value is a work around for false value problem in memc
			if($rowCount > $count) {
				return "YES";
			} else {
				return "NO";
			}
		});

		return $out == "YES";
		$this->wf->ProfileOut( __METHOD__ );
	}
	
	public function haveOldForums() {
		return $this->hasAtLeast(NS_FORUM, 5);
	}
	
	public function swapBoards( $boardId1, $boardId2 ) {
		$orderId1 = wfGetWikiaPageProp(WPP_FORUM_ORDER_INDEX, $boardId1 );
		$orderId2 = wfGetWikiaPageProp(WPP_FORUM_ORDER_INDEX, $boardId2 );
		
		if(empty($orderId1) || empty($orderId2)) {
			return false;
		}
		
		wfSetWikiaPageProp(WPP_FORUM_ORDER_INDEX, $boardId1, $orderId2);
		wfSetWikiaPageProp(WPP_FORUM_ORDER_INDEX, $boardId2, $orderId1);	
	}
	
	/**
	 * Backward compatibility for forums created before the order functionality
	 */
	
	public function createOrders() {
		$this->wf->profileIn( __METHOD__ );

		$dbw = $this->wf->GetDB( DB_MASTER );

		// get board list
		$result = $dbw->select(
			array( 'page' ),
			array( 'page_id, page_title' ),
			array( 'page_namespace' => NS_WIKIA_FORUM_BOARD ),
			__METHOD__,
			array( 'ORDER BY' => 'page_title' )
		);
		
		while ( $row = $dbw->fetchObject($result) ) {
			wfSetWikiaPageProp(WPP_FORUM_ORDER_INDEX, $row->page_id, $row->page_id);
		}

		$this->wf->profileOut( __METHOD__ );
	}
	
	/**
	 *  createBoard 
	 */
	 
	public function createBoard($titletext, $body, $bot = false) {
		$this->wf->ProfileIn( __METHOD__ );

		$this->createOrEditBoard(null, $titletext, $body, $bot);
	
		$this->wf->ProfileOut( __METHOD__ );
	}
	
	public function editBoard($id, $titletext, $body, $bot = false) {
		$this->wf->ProfileIn( __METHOD__ );
		
		$this->createOrEditBoard($id, $titletext, $body, $bot);
		
		$this->wf->ProfileOut( __METHOD__ );
	}

	/**
	 *  create or edit board, if $board = null then we are creating new one
	 */	
	protected function createOrEditBoard($board, $titletext, $body, $bot = false) {
		$this->wf->ProfileIn( __METHOD__ );
		$id = null;
		if( !empty($board) ) {
			$id = $board->getId();	
		}

		if( strlen($titletext) < 4 || strlen($body) < 4 ) {
			$this->wf->ProfileOut( __METHOD__ );
			return false;
		}
		
		if( strlen($body) > 255 || strlen($titletext) > 40 ) {
			$this->wf->ProfileOut( __METHOD__ );
			return false;
		}
		
		Forum::$allowToEditBoard = true;	
		
		if($id == null) {
			$title = Title::newFromText($titletext, NS_WIKIA_FORUM_BOARD);
		} else {
			$title = Title::newFromId($id, Title::GAID_FOR_UPDATE);
			$nt = Title::newFromText($titletext, NS_WIKIA_FORUM_BOARD);
			$title->moveTo( $nt, true, '', false );
			$title = $nt;
		}	 
		
		$article  = new Article( $title );
		$editPage = new EditPage( $article );
			
		$editPage->edittime = $article->getTimestamp();
		$editPage->textbox1 = $body;
			
		$result = array();
		$retval = $editPage->internalAttemptSave( $result, $bot );
		
		if($id == null) {
			$title = Title::newFromText( $titletext, NS_WIKIA_FORUM_BOARD );
			if( !empty($title) ) {
				wfSetWikiaPageProp( WPP_FORUM_ORDER_INDEX,  $title->getArticleId(), $title->getArticleId() );
			}
		}
		
		Forum::$allowToEditBoard = false;
		
		$this->wf->ProfileOut( __METHOD__ );
	}

	/**
	 * delete board 
	 */

	public function deleteBoard( $board ) {
		$this->wf->ProfileIn( __METHOD__ );
		
		Forum::$allowToEditBoard = true;

		$article  = new Article( $board->getTitle() );
		$article->doDeleteArticle('', true);

		Forum::$allowToEditBoard = false;
		
		$this->wf->ProfileOut( __METHOD__ );
	}
	
	public function createDefaultBoard() {
		$this->wf->ProfileIn( __METHOD__ );
		$app = F::App();

		if(!$this->hasAtLeast(NS_WIKIA_FORUM_BOARD, 0)) {
			WikiaDataAccess::cachePurge( wfMemcKey('Forum_hasAtLeast', NS_WIKIA_FORUM_BOARD, 0) );
			/* the wgUser swap is the only way to create page as other user then current */	
			$tmpUser = $app->wg->User;
			$app->wg->User = User::newFromName( Forum::AUTOCREATE_USER );
			for($i = 1; $i <=5 ; $i++) {
				$body = wfMsgForContent('forum-autoboard-body-'.$i );
				$title = wfMsgForContent('forum-autoboard-title-'.$i );
				//TODO: check with TOR
				$title = str_replace('$WIKINAME', $app->wg->Sitename, $title);
				$body = str_replace('$WIKINAME', $app->wg->Sitename, $body);

				$this->createBoard($title, $body, true);	
			}
			
			$app->wg->User = $tmpUser; 
	
			return true;
		}
		
		return false;
		
		$this->wf->ProfileOut( __METHOD__ );
	}
}
