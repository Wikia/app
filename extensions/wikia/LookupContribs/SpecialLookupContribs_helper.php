<?php

class LookupContribsCore {
	const CONTRIB_CACHE_TTL = 900; // 900 == 15min
	const ACTIVITY_CACHE_TTL = 600; // 600 == 10min

	const SORT_BY_TITLE = 'title';
	const SORT_BY_URL = 'url';
	const SORT_BY_LAST_EDIT = 'lastedit';
	const SORT_BY_EDITS = 'edits';

	const DEFAULT_LIMIT = 25;
	const DEFAULT_SORT = self::SORT_BY_LAST_EDIT;
	const DEFAULT_SORT_DIRECTION = 'asc';

	private $mUsername;
	private $mUserId;
	private $mMode;
	private $mDBname;

	private $mLimit = self::DEFAULT_LIMIT;
	private $mOffset = 0;
	private $mOrder = self::DEFAULT_SORT;
	private $mOrderDirection = self::DEFAULT_SORT_DIRECTION;

	private $mWikiID;
	private $mWikia;
	private $mNamespaces;
	private $mNumRecords = 0;

	/** @var User */
	private $oUser;

	public function __construct( $username, $mode = 0, $dbName = '', $ns = false ) {
		$this->mUsername = $username;
		$this->oUser = User::newFromName( $this->mUsername );
		if ( $this->oUser instanceof User ) {
			$this->mUserId = $this->oUser->getId();
		}
		$this->setMode( $mode );
		$this->setDBname( $dbName );
		$this->setNamespaces( $ns );
	}

	public function setDBname( $dbname = '' ) {
		if ( $dbname ) {
			$this->mDBname = $dbname;
			$this->mWikiID = WikiFactory::DBtoID( $this->mDBname );
			$this->mWikia = WikiFactory::getWikiByID( $this->mWikiID );
		}
	}

	public function getDBname() {
		return $this->mDBname;
	}

	public function setMode( $mode = 0 ) {
		$this->mMode = $mode;
	}

	public function setLimit( $limit = self::DEFAULT_LIMIT ) {
		$this->mLimit = $limit;
	}

	public function setOffset( $offset = 0 ) {
		$this->mOffset = $offset;
	}

	public function setOrder( $order ) {
		if ( empty( $order ) ) {
			return;
		}

		list( $orderType, $orderDirection ) = explode( ':', $order );

		$this->mOrder = $orderType;
		$this->mOrderDirection = $orderDirection;
	}

	public function setNamespaces( $ns = false ) {
		if ( $ns !== false ) {
			$this->mNamespaces = $ns;
		}
	}

	public function getNamespaces() {
		global $wgContentNamespaces;

		$res = [];
		$ns = $this->mNamespaces;
		switch( $ns ) {
			case -1: break; # all namespaces
			case -2: # contentNamespaces
				if ( !empty( $wgContentNamespaces ) && is_array( $wgContentNamespaces ) ) {
					$res = $wgContentNamespaces;
				} else {
					$res = [ NS_MAIN ];
				}
				break;
			default: $res = [ $ns ];
		}

		return $res;
	}

	public function setNumRecords( $num = 0 ) {
		$this->mNumRecords = $num;
	}

	public function getNumRecords() {
		return $this->mNumRecords;
	}

	/**
	 * Return if such user exists
	 *
	 * @return bool
	 */
	public function checkUser() {
		if ( empty( $this->mUsername ) ) {
			return false;
		}

		if ( !$this->oUser instanceof User ) {
			return false;
		}

		if ( empty( $this->mUserId ) ) {
			return false;
		}

		// For all those anonymous users out there
		if ( F::app()->wg->User->isIP( $this->mUsername ) ) {
			return true;
		}

		return true;
	}

	/**
	 * Gets data for AJAX request for data to user contribution table
	 *
	 * @return array
	 *
	 * @throws DBUnexpectedError
	 * @throws MWException
	 */
	public function getUserActivity() {
		global $wgMemc, $wgStatsDB, $wgStatsDBEnabled;

		$memKey = $this->getUserActivityMemKey();
		$data = $wgMemc->get( $memKey );

		if ( !empty( $data ) && is_array( $data ) ) {
			return $this->orderData( $data );
		}

		$userActivity = [
			'data' => [],
			'cnt' => 0
		];

		if ( empty( $wgStatsDBEnabled ) ) {
			return $userActivity;
		}

		$dbr = wfGetDB( DB_SLAVE, 'stats', $wgStatsDB );
		if ( is_null( $dbr ) ) {
			return $userActivity;
		}

		// bugId:6196
		$excludedWikis = $this->getExclusionList();

		$where = [
			'user_id' => $this->mUserId,
			'event_type' => [ 1, 2 ],
		];

		if ( !empty( $excludedWikis ) && is_array( $excludedWikis ) ) {
			$where[] = 'wiki_id NOT IN (' . $dbr->makeList( $excludedWikis ) . ')';
		}

		$options = [
			'GROUP BY' => 'wiki_id',
			'ORDER BY' => 'last_edit DESC',
		];

		$res = $dbr->select(
			'events',
			[
				'wiki_id',
				'count(*) as edits',
				'max(unix_timestamp(rev_timestamp)) as last_edit'
			],
			$where,
			__METHOD__,
			$options
		);

		$wikiaIds = [];
		while ( $row = $dbr->fetchObject( $res ) ) {
			$aItem = [
				'id' => $row->wiki_id,
				'lastedit' => $row->last_edit,
				'edits' => $row->edits,
			];
			$wikiaIds[] = $row->wiki_id;

			$userActivity['data'][] = $aItem;
		}

		$this->addWikiaInfo( $wikiaIds, $userActivity );

		$dbr->freeResult( $res );

		$wgMemc->set( $memKey, $userActivity, self::ACTIVITY_CACHE_TTL );

		return $this->orderData( $userActivity );
	}

	private function addWikiaInfo( $wikiaIds, &$userActivity ) {
		$wikiaInfo = WikiFactory::getWikisByID( $wikiaIds );
		foreach ( $userActivity['data'] as &$item ) {
			$wikiaId = $item['id'];

			if ( empty( $wikiaInfo[$wikiaId] ) ) {
				$item['url'] = '';
				$item['dbname'] = '';
				$item['title'] = '';
				$item['active'] = null;
			} else {
				$info = $wikiaInfo[$wikiaId];
				$item[ 'url' ] = $info->city_url;
				$item['dbname'] = $info->city_dbname;
				$item['title'] = $info->city_title;
				$item['active'] = $info->city_public;
			}
		}
	}

	/**
	 * Clear the data cached by method getUserActivity
	 */
	public function clearUserActivityCache() {
		$memKey = $this->getUserActivityMemKey();
		F::app()->wg->Memc->delete( $memKey );
	}

	private function getUserActivityMemKey() {
		return wfSharedMemcKey( $this->mUserId, 'data' );
	}

	private function orderData( $userActivity ) {
		\Wikia\Logger\WikiaLogger::instance()->info( 'SpecialLookupContribs debug', [
			'mLimit' => $this->mLimit,
			'mOffset' => $this->mOffset,
			'mOrder' => $this->mOrder,
			'mOrderDirection' => $this->mOrderDirection,
		] );

		$data = $userActivity['data'];

		if ( empty( $data ) || !is_array( $data ) ) {
			return $userActivity;
		}

		usort( $data, [ $this, 'sortUserActivity' ] );

		return [
			'cnt' => count( $data ),
			'data' => array_slice( $data, $this->mOffset, $this->mLimit ),
		];
	}

	private function sortUserActivity( $a, $b ) {
		$key = $this->mOrder;

		if ( $a[$key] === $b[$key] ) {
			return 0;
		}

		if ( $this->mOrderDirection === 'asc' ) {
			return $a[$key] > $b[$key];
		} else {
			return $a[$key] < $b[$key];
		}
	}

	function getExclusionList() {
		global $wgLookupContribsExcluded;

		// Make sure there are exclusions defined
		if ( empty( $wgLookupContribsExcluded ) || !is_array( $wgLookupContribsExcluded ) ) {
			return [];
		}

		// Start off by ignoring rows that have the undefined wiki ID of zero
		$result = [ 0 ];

		// Add any other wikis we want to exclude
		foreach ( $wgLookupContribsExcluded as $excluded ) {
			$result[] = intval( WikiFactory::DBtoID( $excluded ) );
		}

		return $result;
	}

	private function normalMode( DatabaseBase $dbr ) {
		$data = [
			'cnt' => 0,
			'res' => false
		];

		$conditions = [
			'rev_user' => $this->mUserId,
			'rc_timestamp = rev_timestamp'
		];
		$namespaces = $this->getNamespaces();
		if ( !empty( $namespaces ) ) {
			$conditions['rc_namespace'] = $namespaces;
		}

		/* number of records */
		$oRow = $dbr->selectRow(
			[ 'recentchanges', 'revision' ],
			[ 'count(0) as cnt' ],
			$conditions,
			__METHOD__
		);
		if ( is_object( $oRow ) ) {
			$data['cnt'] = $oRow->cnt;
		}

		$res = $dbr->select(
			[ 'recentchanges', 'revision' ],
			[
				'rc_title',
				'rev_id',
				'rev_page as page_id',
				'rev_timestamp as timestamp',
				'rc_namespace',
				'rc_new',
				'0 as page_remove'
			],
			$conditions,
			__METHOD__,
			[
				'ORDER BY'  => 'rev_timestamp DESC',
				'LIMIT' 	=> $this->mLimit,
				'OFFSET'	=> $this->mOffset
			]
		);

		$data['res'] = $res;
		return $data;
	}

	private function finalMode( DatabaseBase $dbr ) {
		$data = [
			'cnt' => 0,
			'res' => false
		];

		$conditions = [
			'rev_user' => $this->mUserId,
			'rev_id = page_latest'
		];
		$namespaces = $this->getNamespaces();
		if ( !empty( $namespaces ) ) {
			$conditions['page_namespace'] = $namespaces;
		}

		/* number of records */
		$oRow = $dbr->selectRow(
			[ 'revision', 'page' ],
			[ 'count(0) as cnt' ],
			$conditions,
			__METHOD__
		);
		if ( is_object( $oRow ) ) {
			$data['cnt'] = $oRow->cnt;
		}

		$res = $dbr->select(
			[ 'revision', 'page' ],
			[
				'page_title as rc_title',
				'rev_id',
				'page_id',
				'rev_timestamp as timestamp',
				'page_namespace as rc_namespace',
				'0 as rc_new',
				'0 as page_remove'
			],
			$conditions,
			__METHOD__,
			[
				'ORDER BY'	=> 'rev_timestamp DESC',
				'LIMIT'		=> $this->mLimit,
				'OFFSET'	=> $this->mOffset
			]
		);

		$data['res'] = $res;
		return $data;
	}

	private function allMode( DatabaseBase $dbr ) {
		$data = [
			'cnt' => 0,
			'res' => false
		];

		$conditions = [
			'rev_user' => $this->mUserId,
			'page_id = rev_page'
		];
		$namespaces = $this->getNamespaces();
		if ( !empty( $namespaces ) ) {
			$conditions['page_namespace'] = $namespaces;
		}

		/* number of records */
		$oRow = $dbr->selectRow(
			[ 'revision', 'page' ],
			[ 'count(0) as cnt' ],
			$conditions,
			__METHOD__
		);
		if ( is_object( $oRow ) ) {
			$data['cnt'] = $oRow->cnt;
		}

		$res = $dbr->select(
			[ 'revision', 'page' ],
			[
				'page_title as rc_title',
				'rev_id',
				'page_id',
				'rev_timestamp as timestamp',
				'page_namespace as rc_namespace',
				'0 as rc_new',
				'0 as page_remove'
			],
			$conditions,
			__METHOD__,
			[
				'ORDER BY'	=> 'rev_timestamp DESC',
				'LIMIT'		=> $this->mLimit,
				'OFFSET'	=> $this->mOffset
			]
		);

		$data['res'] = $res;
		return $data;
	}

	private function getLogs( DatabaseBase $dbr ) {
		$data = [
			'cnt' => 0,
			'res' => false
		];

		$conditions = [
			'log_action' => "tag",
			'log_user' => $this->mUserId,
		];
		$namespaces = $this->getNamespaces();
		if ( !empty( $namespaces ) ) {
			$conditions['log_namespace'] = $namespaces;
		}

		/* number of records */
		$oRow = $dbr->selectRow(
			[ 'logging' ],
			[ 'count(0) as cnt' ],
			$conditions,
			__METHOD__
		);
		if ( is_object( $oRow ) ) {
			$data['cnt'] = $oRow->cnt;
		}

		$res = $dbr->select(
			'logging',
			[
				'log_timestamp as timestamp',
				'log_namespace as rc_namespace',
				'log_title as rc_title',
				'log_comment',
				'0 as page_id',
				'0 as rev_id',
				'0 as rc_new',
				'0 as page_remove'
			],
			$conditions,
			__METHOD__,
			[
				'LIMIT' => $this->mLimit,
				'OFFSET' => $this->mOffset
			]
		);

		$data['res'] = $res;
		return $data;
	}

	private function getArchive( DatabaseBase $dbr ) {
		$data = [
			'cnt' => 0,
			'res' => false
		];

		$conditions = [
			'ar_user' => $this->mUserId,
		];
		$namespaces = $this->getNamespaces();
		if ( !empty( $namespaces ) ) {
			$conditions['ar_namespace'] = $namespaces;
		}

		/* number of records */
		$oRow = $dbr->selectRow(
			[ 'archive' ],
			[ 'count(0) as cnt' ],
			$conditions,
			__METHOD__
		);
		if ( is_object( $oRow ) ) {
			$data['cnt'] = $oRow->cnt;
		}

		$res = $dbr->select(
			'archive',
			[
				'ar_timestamp as timestamp',
				'ar_namespace as rc_namespace',
				'ar_title as rc_title',
				'ar_comment',
				'ar_page_id as page_id',
				'ar_rev_id as rev_id',
				'0 as rc_new',
				'1 as page_remove'
			],
			$conditions,
			__METHOD__,
			[
				'LIMIT' => $this->mLimit,
				'OFFSET' => $this->mOffset
			]
		);

		$data['res'] = $res;
		return $data;
	}

	/**
	 * Fetch all contributions from that given database
	 *
	 * @return array
	 */
	public function fetchContribs() {
		$memc = F::app()->wg->Memc;

		$fetched_data = [
			'cnt' => 0,
			'data' => []
		];

		/* todo since there are now TWO modes, we need TWO keys to rule them all */
		$memKey = $this->getContribsMemKey();
		$data = $memc->get( $memKey );

		if ( is_array( $data ) ) {
			/* get that data from memcache */
			$this->mNumRecords = count( $data );
			return $data;
		}

		$dbr = wfGetDB( DB_SLAVE, 'stats', $this->getDBname() );

		// Determine what type of data to retrieve and get it
		switch ( $this->mMode ) {
			case "normal"	: $data = $this->normalMode( $dbr ); break;
			case "final"	: $data = $this->finalMode( $dbr ); break;
			case "all"		: $data = $this->allMode( $dbr ); break;
			default			: $data = false;
		}

		if ( $data == false ) {
			return false;
		}

		$res = $data['res'];
		$fetched_data['cnt'] = $data['cnt'];
		$this->mNumRecords = 0;
		if ( empty( $res ) || empty( $this->mWikia ) ) {
			return $fetched_data;
		}

		/* rows */
		while ( $row = $dbr->fetchObject( $res ) ) {
			$row->rc_database 	= $this->mDBname;
			$row->rc_url 		= $this->mWikia->city_url;
			$row->rc_city_title = $this->mWikia->city_title;
			$row->log_comment 	= false;
			/* array */
			$fetched_data['data'][] = $row;
			/* inc */
			$this->mNumRecords++;
		}
		$dbr->freeResult( $res );
		unset( $res ) ;

		// this produces additional results...
		// don't do that if we are in links mode and result was found already
		if ( $this->mNumRecords == 0 && $this->mOffset == 0 ) {
			$data = $this->getLogs( $dbr );
			$res = $data['res'];

			/* num records */
			$num_res = $dbr->numRows( $res );
			if ( !empty( $res ) && !empty( $num_res ) ) {
				/* rows */
				while ( $row = $dbr->fetchObject( $res ) ) {
					$row->rc_database 	= $this->mDBname;
					$row->rc_url 		= $this->mWikia->city_url;
					$row->rc_city_title = $this->mWikia->city_title;
					/* array */
					$fetched_data['data'][] = $row;
					$this->mNumRecords++;
				}
				$dbr->freeResult( $res );
				unset( $res );
			}
		}

		// Get data from archive (remove articles) and display what articles was edited by user
		if ( ( $this->mNumRecords == 0 ) && ( $this->mOffset == 0 ) && ( $this->mMode == 'all' ) ) {
			$data = $this->getArchive( $dbr );
			$res = $data['res'];

			/* num records */
			$num_res = $dbr->numRows( $res );
			if ( !empty( $res ) && !empty( $num_res ) ) {
				/* rows */
				$this->mNumRecords = 0;
				while ( $row = $dbr->fetchObject( $res ) ) {
					$row->rc_database 	= $this->mDBname;
					$row->rc_url 		= $this->mWikia->city_url;
					$row->rc_city_title = $this->mWikia->city_title;
					/* array */
					$fetched_data['data'][] = $row;
					$this->mNumRecords++;
				}
				$dbr->freeResult( $res );
				unset( $res );
			}
		}

		$memc->set( $memKey, $fetched_data, self::CONTRIB_CACHE_TTL );

		return $fetched_data;
	}

	private function getContribsMemKey() {
		return wfSharedMemcKey(
			$this->mMode,
			$this->mDBname,
			$this->mNamespaces,
			$this->mUserId,
			$this->mLimit,
			$this->mOffset
		);
	}

	/* a customized version of makeKnownLinkObj - hardened'n'modified for all those non-standard wikia out there */
	private function produceLink ( Title $nt, $text, $query, $url, $namespace, $article_id ) {
		global $wgMetaNamespace;

		$str = htmlspecialchars( $nt->getLocalURL( $query ) );

		/* replace empty namespaces, namely: "/:Something" of "title=:Something" stuff it's ugly, it's brutal, it doesn't lead anywhere */
		$old_str = $str;
		$str = preg_replace ( '/title=:/i', "title=ns-" . $namespace . ":", $str );
		$append = '';
		/* if found and replaced, we need that curid */
		if ( $str != $old_str ) {
			$append = "&curid=" . $article_id;
		}
		$old_str = $str;
		$str = preg_replace ( '/\/:/i', "/ns-" . $namespace . ":", $str );
		if ( $str != $old_str ) {
			$append = "?curid=" . $article_id;
		}

		/* replace NS_PROJECT space - it gets it from $wgMetaNamespace, which is completely wrong in this case  */
		if ( NS_PROJECT == $nt->getNamespace() ) {
			$str = preg_replace ( "/$wgMetaNamespace/", "Project", $str );
		}

		$part = explode ( "php", $str );
		if ( $part[0] == $str ) {
			$part = explode ( "wiki/", $str );
			$u = $url . "wiki/" . $part[1];
		} else {
			$u = $url . "index.php" . $part[1];
		}

		if ( $nt->getFragment() != '' ) {
			if ( $nt->getPrefixedDbkey() == '' ) {
				$u = '';
				if ( '' == $text ) {
					$text = htmlspecialchars( $nt->getFragment() );
				}
			}

			$anchor = urlencode( Sanitizer::decodeCharReferences( str_replace( ' ', '_', $nt->getFragment() ) ) );
			$replaceArray = [
 				'%3A' => ':',
				 '%' => '.'
		 	];
			$u .= '#' . str_replace( array_keys( $replaceArray ), array_values( $replaceArray ), $anchor );
		}
		if ( $text != '' ) {
			$r = "<a href=\"{$u}{$append}\">{$text}</a>";
		} else {
			$r = "<a href=\"{$u}{$append}\">" . urldecode( $u ) . "</a>";
		}

		return $r;
	}

	public function produceLine( $row ) {
		if ( $row->page_remove == 1 ) {
			$pageContribs = Title::makeTitle ( NS_SPECIAL, "Log" );
		} else {
			$pageContribs = Title::makeTitle ( NS_SPECIAL, "Contributions/{$this->mUsername}" );
		}

		$page = Title::makeTitle ( $row->rc_namespace, $row->rc_title );

		if ( $row->page_remove == 1 ) {
			$contrib = '(' . $this->produceLink ( $pageContribs, wfMsg( 'lookupcontribslog' ), "page=$page", $row->rc_url, $row->rc_namespace, $row->page_id ) . ')';
		} else {
			$contrib = '(' . $this->produceLink ( $pageContribs, wfMsg( 'lookupcontribscontribs' ), '', $row->rc_url, $row->rc_namespace, $row->page_id ) . ')';
		}

		$link = $this->produceLink ( $page, $page->getFullText(), '', $row->rc_url, $row->rc_namespace, $row->page_id ) . ( $row->log_comment ? " <small>($row->log_comment)</small>" : "" );
		if ( $row->page_remove == 1 ) {
			$link = wfMsg( 'lookupcontribspageremoved' ) . wfMsg( 'word-separator' ) . $link;
		}
		$time = F::app()->wg->Lang->timeanddate( wfTimestamp( TS_MW, $row->timestamp ), true );
		if ( $row->page_remove == 1 ) {
			$pageUndelete = Title::makeTitle( NS_SPECIAL, "Undelete" );
			$diff = '(' . $this->produceLink ( $pageUndelete, wfMsg( 'lookupcontribsrestore' ), "target={$page}&diff=prev&timestamp={$row->timestamp}", $row->rc_url, $row->rc_namespace, $row->page_id ) . ')';
			$hist = '';
		} else {
			$diff = '(' . $this->produceLink ( $page, wfMsg( 'lookupcontribsdiff' ), 'diff=prev&oldid=' . $row->rev_id, $row->rc_url, $row->rc_namespace, $row->page_id ) . ')';
			$hist = '(' . $this->produceLink ( $page, wfMsg( 'lookupcontribshist' ), 'action=history', $row->rc_url, $row->rc_namespace, $row->page_id ) . ')';
		}

		$result = [
			"link" => $link,
			"diff" => $diff,
			"hist" => $hist,
			"contrib" => $contrib,
			"time" => $time,
			"removed" => $row->page_remove
		];

		return $result;
	}
}
