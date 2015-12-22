<?php

/**
 * @package MediaWiki
 * @subpackage LookupContribs
 * @author Bartek Lapinski <bartek@wikia.com>
 * @author Piotr Molski <moli@wikia.com> for Wikia.com
 * @author Andrzej 'nAndy' Łukaszewski <nandy (at) wikia-inc.com>
 *
 * helper classes & functions
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	echo "This is MediaWiki extension named LookupContribs.\n";
	exit( 1 );
}

class LookupContribsCore {
	const CONTRIB_CACHE_TTL = 15 * 60;
	const ACTIVITY_CACHE_TTL = 10 * 60;

	var $mUsername;
	var $mUserId;
	var $mMode;
	var $mDBname;
	var $mLimit;
	var $mOffset;
	var $mWikiID;
	var $mWikia;
	var $mNamespaces;
	var $mNumRecords;
	var $oUser;

	public function __construct( $username, $mode = 0, $dbName = '', $ns = false ) {
		$this->mUsername = $username;
		$this->oUser = User::newFromName( $this->mUsername );
		if ( $this->oUser instanceof User ) {
			$this->mUserId = $this->oUser->getId();
//			$this->mUserId = 22224;
		}
		$this->setMode( $mode );
		$this->setDBname( $dbName );
		$this->setNamespaces( $ns );
		$this->setNumRecords();
	}

	public function setDBname( $dbname = '' ) {
		if ( $dbname ) {
			$this->mDBname = $dbname;
			$this->mWikiID = WikiFactory::DBtoID( $this->mDBname );
			$this->mWikia = WikiFactory::getWikiByID( $this->mWikiID );
		}
	}

	public function getDBname() {
		return LC_TEST ? F::app()->wg->DBname : $this->mDBname;
	}

	public function setMode( $mode = 0 ) {
		$this->mMode = $mode;
	}

	public function setLimit( $limit = LC_LIMIT ) {
		$this->mLimit = $limit;
	}

	public function setOffset( $offset = 0 ) {
		$this->mOffset = $offset;
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
	 * @param boolean $addEditCount added in 20.07.2011 during SSW is a flag; will add additional array element
	 * with user's edits on a wiki plus will sort whole array by this value
	 * @param string $order
	 *
	 * @param int $limit
	 * @param int $offset
	 *
	 * @return array
	 * @throws DBUnexpectedError
	 * @throws MWException
	 */
	public function checkUserActivity( $addEditCount = false, $order = null, $limit = null, $offset = null ) {
		global $wgMemc, $wgStatsDB, $wgStatsDBEnabled;

		$userActivity = [
			'data' => [],
			'cnt' => 0
		];

		$memKey = $this->getUserActivityMemKey( $addEditCount );
		$data = $wgMemc->get( $memKey );

		if ( ( !is_array( $data ) || LOOKUPCONTRIBS_NO_CACHE ) && !empty( $wgStatsDBEnabled ) ) {
			$dbr = wfGetDB( DB_SLAVE, "stats", $wgStatsDB );
			if ( !is_null( $dbr ) ) {
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

				if ( $limit ) {
					// If we have a limit/offset, make sure we get the total count another way
					$userActivity['cnt'] = $this->getActivityCount( $dbr, $where );
					$options['LIMIT'] = $limit;
					$options['OFFSET'] = $offset;
				}

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
						'id'        => $row->wiki_id,
						'last_edit' => $row->last_edit,
						'editcount' => $row->edits,
					];
					$wikiaIds[] = $row->wiki_id;

					$userActivity['data'][] = $aItem;
				}

//				// Commented out because its slow if the user has a lot of edits.  Leaving in as
//				// a starting point if we want to make this performant and add this in
//				if ( $addEditCount ) {
//					$this->addEditCounts( $wikiaIds, $userActivity );
//				}
				$this->addWikiaInfo( $wikiaIds, $userActivity );

				$dbr->freeResult( $res );
				if ( !LOOKUPCONTRIBS_NO_CACHE ) {
					$wgMemc->set( $memKey, $userActivity, self::ACTIVITY_CACHE_TTL );
				}
			}
		} else {
			$userActivity = $data;
		}

		if ( $limit ) {
			return $userActivity;
		} else {
			return $this->orderData( $userActivity, $order, $addEditCount );
		}
	}

	private function addEditCounts( $wikiaIds, &$userActivity ) {
		$wikiaEdits = $this->getEditCount( $wikiaIds );
		foreach ( $userActivity['data'] as &$item ) {
			$wikiaId = $item['id'];
			if ( empty( $wikiaEdits[$wikiaId] ) ) {
				$item[ 'editcount' ] = 0;
			} else {
				$item[ 'editcount' ] = $wikiaEdits[ $wikiaId ]->edits;
			}
		}
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

	private function getActivityCount( DatabaseBase $dbr, Array $where ) {
		$res = $dbr->select(
			'events',
			[ 'count(distinct wiki_id) as num' ],
			$where,
			__METHOD__
		);

		$row = $dbr->fetchObject( $res );
		return $row->num;
	}

	private function getUserActivityMemKey( $addEditCount ) {
		return wfSharedMemcKey( $this->mUserId, ( $addEditCount ? 'dataWithEdits' : 'data' ) );
	}

	private function orderData( &$data, $order, $edits ) {
		$aTemp = [];
		$aMatches = [];
		if ( !$order ) {
			$order = ( $edits ? 'edits:desc' : 'lastedit:desc' );
		}
		if ( isset( $data['data'] ) && is_array( $data['data'] ) ) {

			// order by title
			if ( preg_match( '/^title:(asc|desc)$/', $order, $aMatches ) ) {
				foreach ( $data['data'] as $aItem ) {
					$aTemp[$aItem['title']] = $aItem;
				}
			}

			// order by url
			elseif ( preg_match( '/^url:(asc|desc)$/', $order, $aMatches ) ) {
				foreach ( $data['data'] as $aItem ) {
					$aTemp[$aItem['url']] = $aItem;
				}
			}

			// order by last edit
			elseif ( preg_match( '/^lastedit:(asc|desc)$/', $order, $aMatches ) ) {
				foreach ( $data['data'] as $aItem ) {
					// added URL part since last edits are ints and might not be unique
					$aTemp["{$aItem['last_edit']}-{$aItem['url']}"] = $aItem;
				}
			}

			// order by edits
			elseif ( preg_match( '/^edits:(asc|desc)$/', $order, $aMatches ) && $edits ) {
				foreach ( $data['data'] as $aItem ) {
					// added leading zeros and URL part since edits are ints and might not be unique
					$aTemp[ sprintf( '%010d-%s', $aItem['editcount'], $aItem['url'] ) ] = $aItem;
				}
			}

			// order if necessary
			if ( !empty( $aTemp ) ) {

				// descending order
				if ( isset( $aMatches[1] ) && 'desc' == $aMatches[1] ) {
					krsort( $aTemp );

				// ascending order
				} else {
					ksort( $aTemp );
				}

				// records count
				$data['cnt'] = count( $aTemp );
				// reindex and apply offset and limit
				$data['data'] = array_slice( $aTemp, $this->mOffset, $this->mLimit, false );
			}
		}
		return $data;
	}

	/**
	 * Gets an array with wikis' ids and user's editcount on those wikis
	 *
	 * @param array $wikisIds reference to a string variable which will be overwritten with an array of wikis' ids
	 *
	 * @return array
	 */
	function getEditCount( &$wikisIds ) {
		global $wgSpecialsDB;

		$dbr = wfGetDB( DB_SLAVE, 'stats', $wgSpecialsDB );

		$res = $dbr->select(
			[ 'events_local_users' ],
			[ 'wiki_id', 'edits' ],
			[ 'user_id' => $this->mUserId, 'edits <> 0' ],
			__METHOD__,
			[
				'ORDER BY' => 'edits DESC'
			]
		);

		$wikiEdits = [];
		$wikisIds = [];
		while ( $row = $dbr->fetchObject( $res ) ) {
			// second condition !in_array() added because of bugId:6196
			if ( !isset( $wikiEdits[$row->wiki_id] ) && !in_array( $row->wiki_id, $this->getExclusionList() ) ) {
				$wikiEdits[$row->wiki_id] = $row;
				$wikisIds[] = $row->wiki_id;
			}
		}

		$dbr->freeResult( $res );

		return $wikiEdits;
	}

	function getExclusionList() {
		global $wgLookupContribsExcluded;

		$result = [];

		/* grumble grumble _precautions_ cough */
		if ( !isset( $wgLookupContribsExcluded ) || ( !is_array( $wgLookupContribsExcluded ) ) || ( empty( $wgLookupContribsExcluded ) )  ) {
						return [];
		}

		$result[] = 0;
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

		if ( is_array( $data ) && !LOOKUPCONTRIBS_NO_CACHE ) {
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
		if ( !LOOKUPCONTRIBS_NO_CACHE ) {
			$memc->set( $memKey, $fetched_data, self::CONTRIB_CACHE_TTL );
		}

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
	private function produceLink ( Title $nt, $text, $query, $url, $sk, $wiki_meta, $namespace, $article_id ) {
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
		$sk = RequestContext::getMain()->getSkin();

		if ( $row->page_remove == 1 ) {
			$pageContribs = Title::makeTitle ( NS_SPECIAL, "Log" );
		} else {
			$pageContribs = Title::makeTitle ( NS_SPECIAL, "Contributions/{$this->mUsername}" );
		}
		$meta = strtr( $row->rc_city_title, ' ', '_' );
		$page = Title::makeTitle ( $row->rc_namespace, $row->rc_title );

		if ( $row->page_remove == 1 ) {
			$contrib = '(' . $this->produceLink ( $pageContribs, wfMsg( 'lookupcontribslog' ), "page=$page", $row->rc_url, $sk, $meta, $row->rc_namespace, $row->page_id ) . ')';
		} else {
			$contrib = '(' . $this->produceLink ( $pageContribs, wfMsg( 'lookupcontribscontribs' ), '', $row->rc_url, $sk, $meta, $row->rc_namespace, $row->page_id ) . ')';
		}

		$link = $this->produceLink ( $page, $page->getFullText(), '', $row->rc_url, $sk, $meta, $row->rc_namespace, $row->page_id ) . ( $row->log_comment ? " <small>($row->log_comment)</small>" : "" );
		if ( $row->page_remove == 1 ) {
			$link = wfMsg( 'lookupcontribspageremoved' ) . wfMsg( 'word-separator' ) . $link;
		}
		$time = F::app()->wg->Lang->timeanddate( wfTimestamp( TS_MW, $row->timestamp ), true );
		if ( $row->page_remove == 1 ) {
			$pageUndelete = Title::makeTitle( NS_SPECIAL, "Undelete" );
			$diff = '(' . $this->produceLink ( $pageUndelete, wfMsg( 'lookupcontribsrestore' ), "target={$page}&diff=prev&timestamp={$row->timestamp}", $row->rc_url, $sk, $meta, $row->rc_namespace, $row->page_id ) . ')';
			$hist = '';
		} else {
			$diff = '(' . $this->produceLink ( $page, wfMsg( 'lookupcontribsdiff' ), 'diff=prev&oldid=' . $row->rev_id, $row->rc_url, $sk, $meta, $row->rc_namespace, $row->page_id ) . ')';
			$hist = '(' . $this->produceLink ( $page, wfMsg( 'lookupcontribshist' ), 'action=history', $row->rc_url, $sk, $meta, $row->rc_namespace, $row->page_id ) . ')';
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

