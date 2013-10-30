<?php

/**
 * Forum
 * @author Kyle Florence, Saipetch Kongkatong, Tomasz Odrobny
 */
class Forum extends Walls {

	const ACTIVE_DAYS = 7;
	const BOARD_MAX_NUMBER = 50;
	const AUTOCREATE_USER = 'Wikia';
	//controlling from outside if use can edit/create/delete board page
	static $allowToEditBoard = false;


	public function getBoardList($db = DB_SLAVE) {
		$boardTitles = $this->getListTitles( $db, NS_WIKIA_FORUM_BOARD );
		$titlesBatch = new TitleBatch($boardTitles);
		$orderIndexes = $titlesBatch->getWikiaProperties(WPP_WALL_ORDER_INDEX,$db);

		$boards = array();
		/** @var $title Title */
		foreach($boardTitles as $title) {
			/** @var $board ForumBoard */
			$board = ForumBoard::newFromTitle($title);
			$title = $board->getTitle();
			$id = $title->getArticleID();

			$boardInfo = $board->getBoardInfo();
			$boardInfo['id'] = $title->getArticleID();
			$boardInfo['name'] = $title->getText();
			$boardInfo['description'] = $board->getDescriptionWithoutTemplates();
			$boardInfo['url'] = $title->getFullURL();
			$orderIndex = $orderIndexes[$id];
			$boards[$orderIndex] = $boardInfo;
		}

		krsort($boards);

		return $boards;
	}

	/**
	 * get count of boards
	 * @return int board count
	 */
	public function getBoardCount( $db = DB_SLAVE ) {
		wfProfileIn( __METHOD__ );

		$dbw = wfGetDB( $db );

		// get board list
		$result = (int)$dbw->selectField(
			array( 'page' ),
			array( 'count(*) as cnt' ),
			array( 'page_namespace' => NS_WIKIA_FORUM_BOARD ),
			__METHOD__,
			array()
		);

		wfProfileOut(__METHOD__);
		return $result['cnt'];
	}

	/**
	 * get total threads excluding deleted and removed threads
	 * @param integer $days
	 * @return integer $totalThreads
	 */
	public function getTotalThreads( $days = 0 ) {
		wfProfileIn( __METHOD__ );

		$memKey = $this->getMemKeyTotalThreads( $days );
		$totalThreads = $this->wg->Memc->get( $memKey );
		if ( $totalThreads === false ) {
			$db = wfGetDB( DB_SLAVE );

			$sqlWhere = array(
				'parent_comment_id' => 0,
				'deleted' => 0,
				'removed' => 0,
				'page_namespace' => NS_WIKIA_FORUM_BOARD_THREAD
			);

			// active threads
			if ( !empty( $days ) ) {
				$sqlWhere[] = "last_touched > curdate() - interval $days day";
			}

			$row = $db->selectRow(
				array( 'comments_index', 'page' ),
				array( 'count(*) cnt' ),
				$sqlWhere,
				__METHOD__,
				array(),
				array( 'page' => array( 'LEFT JOIN', array( 'page_id=comment_id' ) ) )
			);

			$totalThreads = 0;
			if ( $row ) {
				$totalThreads = intval( $row->cnt );
			}
			$this->wg->Memc->set( $memKey, $totalThreads, 60 * 60 * 12 );
		}

		wfProfileOut( __METHOD__ );

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
		return wfMemcKey( 'forum_total_threads_' . $days );
	}

	// clear cache for total threads
	public function clearCacheTotalThreads( $days = 0 ) {
		$memKey = $this->getMemKeyTotalThreads( $days );
		$this->wg->Memc->delete( $memKey );
	}

	// clear cache for total active threads
	public function clearCacheTotalActiveThreads() {
		$this->clearCacheTotalThreads( self::ACTIVE_DAYS );
	}

	public function hasAtLeast( $ns, $count ) {
		wfProfileIn( __METHOD__ );

		$out = WikiaDataAccess::cache( wfMemcKey( 'Forum_hasAtLeast', $ns, $count ), 24 * 60 * 60/* one day */, function() use ( $ns, $count ) {
			$db = wfGetDB( DB_MASTER );
			// check if there is more then 5 forum pages (5 is number of forum pages from starter)
			// limit 6 is faster solution then count(*) and the compare in php
			$result = $db->select( array( 'page' ), array( 'page_id' ), array( 'page_namespace' => $ns ), __METHOD__, array( 'LIMIT' => $count + 1 ) );

			$rowCount = $db->numRows( $result );
			//string value is a work around for false value problem in memc
			if ( $rowCount > $count ) {
				return "YES";
			} else {
				return "NO";
			}
		} );

		wfProfileOut( __METHOD__ );
		return $out == "YES";
	}

	public function haveOldForums() {
		return $this->hasAtLeast( NS_FORUM, 5 );
	}

	public function swapBoards( $boardId1, $boardId2 ) {
		$orderId1 = wfGetWikiaPageProp( WPP_WALL_ORDER_INDEX, $boardId1 );
		$orderId2 = wfGetWikiaPageProp( WPP_WALL_ORDER_INDEX, $boardId2 );

		if ( empty( $orderId1 ) || empty( $orderId2 ) ) {
			return false;
		}

		wfSetWikiaPageProp( WPP_WALL_ORDER_INDEX, $boardId1, $orderId2 );
		wfSetWikiaPageProp( WPP_WALL_ORDER_INDEX, $boardId2, $orderId1 );
	}

	/**
	 * Backward compatibility for forums created before the order functionality
	 */

	public function createOrders() {
		wfProfileIn( __METHOD__ );

		$dbw = wfGetDB( DB_MASTER );

		// get board list
		$result = $dbw->select(
			array( 'page' ),
			array( 'page_id, page_title' ),
			array( 'page_namespace' => NS_WIKIA_FORUM_BOARD ),
			__METHOD__, array( 'ORDER BY' => 'page_title' )
		);

		while ( $row = $dbw->fetchObject( $result ) ) {
			wfSetWikiaPageProp( WPP_WALL_ORDER_INDEX, $row->page_id, $row->page_id );
		}

		wfProfileOut( __METHOD__ );
	}

	/**
	 *  createBoard
	 */

	public function createBoard( $titletext, $body, $bot = false ) {
		wfProfileIn( __METHOD__ );

		$this->createOrEditBoard( null, $titletext, $body, $bot );

		wfProfileOut( __METHOD__ );
	}

	public function editBoard( $id, $titletext, $body, $bot = false ) {
		wfProfileIn( __METHOD__ );

		$this->createOrEditBoard( $id, $titletext, $body, $bot );

		wfProfileOut( __METHOD__ );
	}

	/**
	 *  create or edit board, if $board = null then we are creating new one
	 */
	protected function createOrEditBoard( $board, $titletext, $body, $bot = false ) {
		wfProfileIn( __METHOD__ );
		$id = null;
		if ( !empty( $board ) ) {
			$id = $board->getId();
		}

		if ( strlen( $titletext ) < 4 || strlen( $body ) < 4 ) {
			wfProfileOut( __METHOD__ );
			return false;
		}

		if ( strlen( $body ) > 255 || strlen( $titletext ) > 40 ) {
			wfProfileOut( __METHOD__ );
			return false;
		}

		Forum::$allowToEditBoard = true;

		if ( $id == null ) {
			$title = Title::newFromText( $titletext, NS_WIKIA_FORUM_BOARD );
		} else {
			$title = Title::newFromId( $id, Title::GAID_FOR_UPDATE );
			$nt = Title::newFromText( $titletext, NS_WIKIA_FORUM_BOARD );
			$title->moveTo( $nt, true, '', false );
			$title = $nt;
		}

		$article = new Article( $title );
		$editPage = new EditPage( $article );

		$editPage->edittime = $article->getTimestamp();
		$editPage->textbox1 = $body;

		$result = array();
		$retval = $editPage->internalAttemptSave( $result, $bot );

		if ( $id == null ) {
			$title = Title::newFromText( $titletext, NS_WIKIA_FORUM_BOARD );
			if ( !empty( $title ) ) {
				wfSetWikiaPageProp( WPP_WALL_ORDER_INDEX, $title->getArticleId(), $title->getArticleId() );
			}
		}

		Forum::$allowToEditBoard = false;

		wfProfileOut( __METHOD__ );
	}

	/**
	 * delete board
	 */

	public function deleteBoard( $board ) {
		wfProfileIn( __METHOD__ );

		Forum::$allowToEditBoard = true;

		$article = new Article( $board->getTitle() );
		$article->doDeleteArticle( '', true );

		Forum::$allowToEditBoard = false;

		wfProfileOut( __METHOD__ );
	}

	public function createDefaultBoard() {
		wfProfileIn( __METHOD__ );
		$app = F::App();
		if ( !$this->hasAtLeast( NS_WIKIA_FORUM_BOARD, 0 ) ) {
			WikiaDataAccess::cachePurge( wfMemcKey( 'Forum_hasAtLeast', NS_WIKIA_FORUM_BOARD, 0 ) );
			/* the wgUser swap is the only way to create page as other user then current */
			$tmpUser = $app->wg->User;
			$app->wg->User = User::newFromName( Forum::AUTOCREATE_USER );
			for ( $i = 1; $i <= 5; $i++ ) {
				$body = wfMessage( 'forum-autoboard-body-' . $i )->inContentLanguage()->text();
				$title = wfMessage( 'forum-autoboard-title-' . $i )->inContentLanguage()->text();
				//TODO: check with TOR
				$title = str_replace( '$WIKINAME', $app->wg->Sitename, $title );
				$body = str_replace( '$WIKINAME', $app->wg->Sitename, $body );

				$this->createBoard( $title, $body, true );
			}

			$app->wg->User = $tmpUser;

			wfProfileOut( __METHOD__ );
			return true;
		}

		wfProfileOut( __METHOD__ );
		return false;
	}

}
