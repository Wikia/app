<?php
use Wikia\Logger\WikiaLogger;

/**
 * Forum
 * @author Kyle Florence, Saipetch Kongkatong, Tomasz Odrobny
 */
class Forum extends Walls {

	const ACTIVE_DAYS = 7;
	const BOARD_MAX_NUMBER = 50;
	const AUTOCREATE_USER = 'Wikia';
	// controlling from outside if use can edit/create/delete board page
	static $allowToEditBoard = false;

	/**
	 * @desc Min and max lengths of fields
	 * @var array
	 */
	private $fieldsLengths = [
		'title' => [ 'min' => 4, 'max' => 40 ],
		'desc' => [ 'min' => 4, 'max' => 255 ],
	];

	const LEN_OK = 0;
	const LEN_TOO_BIG_ERR = -1;
	const LEN_TOO_SMALL_ERR = -2;

	public function getBoardList( $db = DB_SLAVE ) {
		$titlesBatch = TitleBatch::newFromConds( [ ],
			[ 'page.page_namespace' => NS_WIKIA_FORUM_BOARD ],
			__METHOD__,
			[ 'ORDER BY' => 'page_title' ],
			$db
		);

		$orderIndexes = $titlesBatch->getWikiaProperties( WPP_WALL_ORDER_INDEX, $db );
		foreach ( $titlesBatch->getArticleIds() as $id ) {
			if ( !isset( $orderIndexes[ $id ] ) ) {
				$orderIndexes[ $id ] = $id;
			}
		}

		$boards = [ ];
		arsort( $orderIndexes );
		foreach ( array_keys( $orderIndexes ) as $pageId ) {
			/** @var Title $title */
			$title = $titlesBatch->getById( $pageId );

			if ( empty( $title ) ) {
				WikiaLogger::instance()->error( "Expecting title got null", [ "pageId" => $pageId ] );
				continue;
			}

			/** @var $board ForumBoard */
			$board = ForumBoard::newFromTitle( $title );

			$boardInfo = $board->getBoardInfo();
			$boardInfo['id'] = $title->getArticleID();
			$boardInfo['name'] = $title->getText();
			$boardInfo['description'] = $board->getDescriptionWithoutTemplates();
			$boardInfo['url'] = $title->getFullURL();
			$boards[] = $boardInfo;
		}

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
			[ 'page' ],
			[ 'count(*) as cnt' ],
			[ 'page_namespace' => NS_WIKIA_FORUM_BOARD ],
			__METHOD__,
			[ ]
		);

		wfProfileOut( __METHOD__ );
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

			$sqlWhere = [
				'parent_comment_id' => 0,
				'archived' => 0,
				'deleted' => 0,
				'removed' => 0,
				'page_namespace' => NS_WIKIA_FORUM_BOARD_THREAD
			];

			// active threads
			if ( !empty( $days ) ) {
				$sqlWhere[] = "last_touched > curdate() - interval $days day";
			}

			$row = $db->selectRow(
				[ 'comments_index', 'page' ],
				[ 'count(*) cnt' ],
				$sqlWhere,
				__METHOD__,
				[ ],
				[ 'page' => [ 'LEFT JOIN', [ 'page_id=comment_id' ] ] ]
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

	public function hasMoreThan( $ns, $count ) {
		wfProfileIn( __METHOD__ );

		$out = WikiaDataAccess::cache( wfMemcKey( 'Forum_hasMoreThan', $ns, $count ), 24 * 60 * 60/* one day */, function() use ( $ns, $count ) {
			$db = wfGetDB( DB_MASTER );
			// check if there is more then 5 forum pages (5 is number of forum pages from starter)
			// limit 6 is faster solution then count(*) and the compare in php
			$result = $db->select( [ 'page' ], [ 'page_id' ], [ 'page_namespace' => $ns ], __METHOD__, [ 'LIMIT' => $count + 1 ] );

			$rowCount = $db->numRows( $result );
			// string value is a work around for false value problem in memc
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
		return $this->hasMoreThan( NS_FORUM, 5 );
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
			[ 'page' ],
			[ 'page_id, page_title' ],
			[ 'page_namespace' => NS_WIKIA_FORUM_BOARD ],
			__METHOD__, [ 'ORDER BY' => 'page_title' ]
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
		return $this->createOrEditBoard( null, $titletext, $body, $bot );
	}

	public function editBoard( $id, $titletext, $body, $bot = false ) {
		return $this->createOrEditBoard( $id, $titletext, $body, $bot );
	}

	/**
	 *  create or edit board, if $board = null then we are creating new one
	 * @param ForumBoard $board
	 * @param $titletext
	 * @param $body
	 * @param bool $bot
	 * @return Status
	 * @throws MWException
	 */
	protected function createOrEditBoard( $board, $titletext, $body, $bot = false ) {
		$id = null;
		if ( !empty( $board ) ) {
			$id = $board->getId();
		}

		if (
			self::LEN_OK !== $this->validateLength( $titletext, 'title' ) ||
			self::LEN_OK !== $this->validateLength( $body, 'desc' )
		) {
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

		$editPage->edittime = $article->getPage()->getTimestamp();
		$editPage->textbox1 = $body;
		// Maintain the "watch" status for the page after the edit
		$editPage->watchthis = $article->getTitle()->userIsWatching();

		$result = [ ];
		$retval = $editPage->internalAttemptSave( $result, $bot );

		if ( $id == null ) {
			$title = Title::newFromText( $titletext, NS_WIKIA_FORUM_BOARD );
			if ( !empty( $title ) ) {
				wfSetWikiaPageProp( WPP_WALL_ORDER_INDEX, $title->getArticleId(), $title->getArticleId() );
			}
		}

		Forum::$allowToEditBoard = false;

		return $retval;
	}

	/**
	 * @desc Returns length limit of a field; if not set in Forum::$fieldsLengths returns 0
	 *
	 * @param String $type one of: 'min' or 'max'
	 * @param String $field fields defined in Forum::$fieldsLengths
	 *
	 * @return int
	 */
	public function getLengthLimits( $type, $field ) {
		return ( isset( $this->fieldsLengths[$field] ) && isset( $this->fieldsLengths[$field][$type] ) ) ?
			(int) $this->fieldsLengths[$field][$type] :
			0;
	}

	/**
	 * @desc Returns Forum::LEN_OK, Forum::LEN_TOO_SMALL_ERR or Forum::LEN_TOO_BIG_ERR depends if the length is valid
	 *
	 * @param String $input data to be validated
	 * @param String $field field with defined length's limits in Forum::$fieldsLengths array
	 *
	 * @return string
	 */
	public function validateLength( $input, $field ) {
		$min = $this->getLengthLimits( 'min', $field );
		$max = $this->getLengthLimits( 'max', $field );
		$out = self::LEN_OK;

		if ( mb_strlen( $input ) < $min ) {
			$out = self::LEN_TOO_SMALL_ERR;
		} else if ( mb_strlen( $input ) > $max ) {
			$out = self::LEN_TOO_BIG_ERR;
		}

		return $out;
	}

	/**
	 * delete board
	 * @param ForumBoard $board
	 */

	public function deleteBoard( $board ) {
		wfProfileIn( __METHOD__ );

		Forum::$allowToEditBoard = true;

		$article = new Article( $board->getTitle() );
		$article->doDeleteArticle( '', true );

		Forum::$allowToEditBoard = false;

		wfProfileOut( __METHOD__ );
	}

	/**
	 * @deprecated Remove as soon as SUS-302 and SUS-303 are completed
	 */
	public function createDefaultBoard() {
		wfProfileIn( __METHOD__ );
		$app = F::App();
		if ( !$this->hasMoreThan( NS_WIKIA_FORUM_BOARD, 0 ) ) {
			WikiaDataAccess::cachePurge( wfMemcKey( 'Forum_hasMoreThan', NS_WIKIA_FORUM_BOARD, 0 ) );
			/* the wgUser swap is the only way to create page as other user then current */
			$tmpUser = $app->wg->User;
			$app->wg->User = User::newFromName( Forum::AUTOCREATE_USER );
			for ( $i = 1; $i <= 5; $i++ ) {
				$body = wfMessage( 'forum-autoboard-body-' . $i, $app->wg->Sitename )->inContentLanguage()->text();
				$title = wfMessage( 'forum-autoboard-title-' . $i, $app->wg->Sitename )->inContentLanguage()->text();

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
