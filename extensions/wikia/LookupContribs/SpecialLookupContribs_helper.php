<?php

/**
 * @package MediaWiki
 * @subpackage LookupContribs
 * @author Bartek Lapinski <bartek@wikia.com>, Piotr Molski <moli@wikia.com> for Wikia.com
 *
 * helper classes & functions
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	echo "This is MediaWiki extension named LookupContribs.\n";
	exit( 1 ) ;
}

class LookupContribsCore {
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

	public function __construct($username, $mode = 0, $dbname = '', $nspace = false) {
		$this->mUsername = $username;
		$this->oUser = User::newFromName($this->mUsername);
		if ( $this->oUser instanceof User ) {
			$this->mUserId = $this->oUser->getId();
		}
		$this->setMode( $mode );
		$this->setDBname( $dbname );
		$this->setNamespaces( $nspace );
		$this->setNumRecords();
	}

	public function setDBname ( $dbname = '' ) {
		if ( $dbname ) {
			$this->mDBname = $dbname;
			$this->mWikiID = WikiFactory::DBtoID($this->mDBname);
			$this->mWikia = WikiFactory::getWikiByID($this->mWikiID);
		}
	}
	public function getDBname () { global $wgDBname; return (LC_TEST) ? $wgDBname : $this->mDBname; }
	public function setMode ( $mode = 0 ) { $this->mMode = $mode; }
	public function setLimit ( $limit = LC_LIMIT ) { $this->mLimit = $limit; }
	public function setOffset ( $offset = 0 ) { $this->mOffset = $offset; }
	public function setNamespaces ( $nspace = false ) { if ( $nspace !== false ) $this->mNamespaces = $nspace; }
	public function getNamespaces() {
		global $wgContentNamespaces;
		wfProfileIn( __METHOD__ );

		$res = array();
		$nspace = intval($this->mNamespaces);
		switch($nspace) {
			case -1: break; #all namespaces
			case -2: # contentNamespaces
				if ( !empty($wgContentNamespaces) && is_array($wgContentNamespaces) ) {
					$res = $wgContentNamespaces;
				} else {
					$res = array(NS_MAIN);
				}
				break;
			default: $res = array($nspace);
		}

		wfProfileOut( __METHOD__ );
		return $res;
	}
	public function setNumRecords( $num = 0 ) { $this->mNumRecords = $num; }
	public function getNumRecords() { return $this->mNumRecords; }

	/* return if such user exists */
	public function checkUser() {
		global $wgUser;
		wfProfileIn( __METHOD__ );

		if ( empty($this->mUsername) ) {
			wfDebug( "Empty username\n" );
			wfProfileOut( __METHOD__ );
			return false;
		}

		if ( !$this->oUser instanceof User ) {
			wfDebug( "User {$this->mUsername} not found\n" );
			wfProfileOut( __METHOD__ );
			return false;
		}

		if ( empty($this->mUserId) ) {
			wfDebug( "User {$this->mUsername} not found\n" );
			wfProfileOut( __METHOD__ );
			return false;
		}

		/* for all those anonymous users out there */
		if ( $wgUser->isIP($this->mUsername) ) {
			wfProfileOut( __METHOD__ );
			return true;
		}

		wfProfileOut( __METHOD__ );
		return true;
	}

	/**
	 * @brief Gets data for AJAX request for data to user contribution table
	 *
	 * @param boolean $addEditCount added in 20.07.2011 during SSW is a flag; will add additional array element with user's edits on a wiki plus will sort whole array by this value
	 *
	 * @author Bartek Lapinski <bartek@wikia.com>
	 * @author Piotr Molski <moli@wikia.com>
	 * @author Andrzej 'nAndy' Łukaszewski <nandy (at) wikia-inc.com>
	 */
	public function checkUserActivity($addEditCount = false, $order = null) {
		global $wgMemc, $wgContLang, $wgStatsDB, $wgStatsDBEnabled;
		wfProfileIn( __METHOD__ );

		$userActivity = array(
			'data' => array(),
			'cnt' => 0
		);

		if ( $addEditCount ) {
			$sMemKey = __METHOD__ . ":{$this->mUserId}:dataWithEdits";
		} else {
			$sMemKey = __METHOD__ . ":{$this->mUserId}:data";
		}

		$data = $wgMemc->get( $sMemKey );

		if ( ( !is_array( $data ) || LOOKUPCONTRIBS_NO_CACHE ) && !empty( $wgStatsDBEnabled ) ) {

			$dbr = wfGetDB( DB_SLAVE, "stats", $wgStatsDB );
			if ( !is_null( $dbr ) ) {
				//bugId:6196
				$excludedWikis = $this->getExclusionList();

				$where = array (
					'user_id'    => $this->mUserId,
					'event_type' => array(1,2)
				);

				if ( !empty( $excludedWikis ) && is_array( $excludedWikis ) ) {
					$where[] = 'wiki_id NOT IN (' . $dbr->makeList( $excludedWikis ) . ')';
				}

				$options = array( 'GROUP BY' => 'wiki_id' );

				if ( $addEditCount === true ) {
					$wikisIds = array();
					$wikiEdits = $this->getEditCount( $wikisIds );
					if ( !empty( $wikisIds ) ) {
						$where['wiki_id'] = $wikisIds;
					}
				}

				/* rows */
				$res = $dbr->select(
					array('events'),
					array(
						'wiki_id',
						'max(unix_timestamp(rev_timestamp)) as last_edit'
					),
					$where,
					__METHOD__,
					$options
				);

				if ( empty( $wikisIds ) ) {
					$wikisIds = array();
					while ( $row = $dbr->fetchObject( $res ) ) {
						$wikisIds[] = $row->wiki_id;
					}
					$dbr->dataSeek( $res, 0 );
				}

				$wData = WikiFactory::getWikisByID( $wikisIds );
				$i = 0;
				while ( $row = $dbr->fetchObject( $res ) ) {
					if ( !isset( $wData[$row->wiki_id] ) ) {
						continue;
					}

					$aItem = array(
						'id'         =>  $row->wiki_id,
						'url'        =>  $wData[$row->wiki_id]->city_url,
						'dbname'     =>  $wData[$row->wiki_id]->city_dbname,
						'title'      =>  $wData[$row->wiki_id]->city_title,
						'active'     =>  $wData[$row->wiki_id]->city_public,
						'last_edit'  =>  $row->last_edit,
						'edit_count' => 0
					);

					if ( isset( $wikiEdits[$row->wiki_id]->edits ) ) {
						$aItem['editcount'] = $wikiEdits[$row->wiki_id]->edits;
					}

					$userActivity['data'][] = $aItem;
				}

				$dbr->freeResult( $res );
				if ( !LOOKUPCONTRIBS_NO_CACHE ) {
					$wgMemc->set( $sMemKey, $userActivity, 60*10 );
				}
			}
		} else {
			$userActivity = $data;
		}

		wfProfileOut( __METHOD__ );
		return $this->orderData( $userActivity, $order, $addEditCount );
	}

	private function orderData( &$data, $order, $edits ) {
		wfProfileIn( __METHOD__ );
		$aTemp = array();
		$aMatches = array();
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
			elseif ( preg_match( '/^edits:(asc|desc)$/', $order, $aMatches ) && $edits) {
				foreach ( $data['data'] as $aItem ) {
					// added leading zeros and URL part since edits are ints and might not be unique
					$aTemp[ sprintf( '%010d-%s', $aItem['editcount'], $aItem['url']) ] = $aItem;
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
		wfProfileOut( __METHOD__ );
		return $data;
	}

	/**
	 * @brief Gets an array with wikis' ids and user's editcount on those wikis
	 *
	 * @param array $wikisIds reference to a string variable which will be overwritten with an array of wikis' ids
	 *
	 * @return array
	 *
	 * @author Andrzej 'nAndy' Łukaszewski
	 * @FIXME Why does this use a pass by reference, never uses it and then !@#!$%^ sets it to array()? Confusing as hell. --love, TOR
	 */
	function getEditCount(&$wikisIds) {
		global $wgSpecialsDB;
		wfProfileIn( __METHOD__ );

		$dbr = wfGetDB(DB_SLAVE, 'stats', $wgSpecialsDB);

		$res = $dbr->select(
			array('events_local_users'),
			array('wiki_id', 'edits'),
			array( 'user_id' => $this->mUserId, 'edits <> 0' ),
			__METHOD__,
			array(
				'ORDER BY' => 'edits DESC'
			)
		);

		$wikiEdits = array();
		$wikisIds = array();
		while($row = $dbr->fetchObject($res)) {
			//second condition !in_array() added because of bugId:6196
			if( !isset($wikiEdits[$row->wiki_id]) && !in_array($row->wiki_id, $this->getExclusionList()) ) {
				$wikiEdits[$row->wiki_id] = $row;
				$wikisIds[] = $row->wiki_id;
			}
		}

		$dbr->freeResult($res);

		wfProfileOut( __METHOD__ );
		return $wikiEdits;
	}

	/* array */
	function getExclusionList() {
		global $wgLookupContribsExcluded;

		wfProfileIn( __METHOD__ );
		$result = array();

		/* grumble grumble _precautions_ cough */
		if (!isset($wgLookupContribsExcluded) || (!is_array($wgLookupContribsExcluded)) || (empty($wgLookupContribsExcluded))  ) {
			wfProfileOut( __METHOD__ );
			return array();
		}

		$result[] = 0;
		foreach($wgLookupContribsExcluded as $excluded) {
			$result[] = intval(WikiFactory::DBtoID($excluded));
		}

		wfProfileOut( __METHOD__ );
		return $result ;
	}

	private function getWikiData($city_id) {
		$res = array();
		$oRow = WikiFactory::getWikiByID($city_id);
		if ( is_object($oRow) ) {
			$res = array(
				"id"		=> $oRow->city_id,
				"url" 		=> $oRow->city_url,
				"dbname"	=> $oRow->city_dbname,
				"title"		=> $oRow->city_title,
				"active"	=> $oRow->city_public
			);
		}
		return $res;
	}

	private function normalMode( $dbr ) {
		wfProfileIn( __METHOD__ );

		$data = array(
			'cnt' => 0,
			'res' => false
		);

		$conditions = array (
			'rev_user' => $this->mUserId,
			' rc_timestamp = rev_timestamp '
		);
		$namespaces = $this->getNamespaces();
		if ( !empty($namespaces) ) {
			$conditions['rc_namespace'] = $namespaces;
		}

		/* number of records */
		$oRow = $dbr->selectRow(
			array ('recentchanges', 'revision'),
			array ( 'count(0) as cnt' ),
			$conditions,
			__METHOD__
		);
		if ( is_object($oRow) ) {
			$data['cnt'] = $oRow->cnt;
		}

		$res = $dbr->select(
			array ('recentchanges', 'revision'),
			array (
				'rc_title',
				'rev_id',
				'rev_page as page_id',
				'rev_timestamp as timestamp',
				'rc_namespace',
				'rc_new',
				'0 as page_remove'
			),
			$conditions,
			__METHOD__,
			array (
				'ORDER BY'  => 'rev_timestamp DESC',
				'LIMIT' 	=> $this->mLimit,
				'OFFSET'	=> $this->mOffset
			)
		);

		$data['res'] = $res;

		wfProfileOut( __METHOD__ );
		return $data;
	}

	private function finalMode( $dbr ) {
		wfProfileIn( __METHOD__ );

		$data = array(
			'cnt' => 0,
			'res' => false
		);

		$conditions = array (
			'rev_user' => $this->mUserId,
			' rev_id = page_latest '
		);
		$namespaces = $this->getNamespaces();
		if ( !empty($namespaces) ) {
			$conditions['page_namespace'] = $namespaces;
		}

		/* number of records */
		$oRow = $dbr->selectRow(
			array ( 'revision', 'page' ),
			array ( 'count(0) as cnt' ),
			$conditions,
			__METHOD__
		);
		if ( is_object($oRow) ) {
			$data['cnt'] = $oRow->cnt;
		}

		$res = $dbr->select(
			array ( 'revision', 'page' ),
			array (
				'page_title as rc_title',
				'rev_id',
				'page_id',
				'rev_timestamp as timestamp',
				'page_namespace as rc_namespace',
				'0 as rc_new',
				'0 as page_remove'
			),
			$conditions,
			__METHOD__,
			array (
				'ORDER BY'	=> 'rev_timestamp DESC',
				'LIMIT'		=> $this->mLimit,
				'OFFSET'	=> $this->mOffset
			)
		);

		$data['res'] = $res;

		wfProfileOut( __METHOD__ );
		return $data;
	}

	private function allMode( $dbr ) {
		wfProfileIn( __METHOD__ );

		$data = array(
			'cnt' => 0,
			'res' => false
		);

		$conditions = array (
			'rev_user' => $this->mUserId,
			' page_id = rev_page '
		);
		$namespaces = $this->getNamespaces();
		if ( !empty($namespaces) ) {
			$conditions['page_namespace'] = $namespaces;
		}

		/* number of records */
		$oRow = $dbr->selectRow(
			array ( 'revision', 'page' ),
			array ( 'count(0) as cnt' ),
			$conditions,
			__METHOD__
		);
		if ( is_object($oRow) ) {
			$data['cnt'] = $oRow->cnt;
		}

		$res = $dbr->select(
			array ( 'revision', 'page' ),
			array (
				'page_title as rc_title',
				'rev_id',
				'page_id',
				'rev_timestamp as timestamp',
				'page_namespace as rc_namespace',
				'0 as rc_new',
				'0 as page_remove'
			),
			$conditions,
			__METHOD__,
			array (
				'ORDER BY'	=> 'rev_timestamp DESC',
				'LIMIT'		=> $this->mLimit,
				'OFFSET'	=> $this->mOffset
			)
		);

		$data['res'] = $res;

		wfProfileOut( __METHOD__ );
		return $data;
	}

	private function getLogs( $dbr ) {
		wfProfileIn( __METHOD__ );

		$data = array(
			'cnt' => 0,
			'res' => false
		);

		$conditions = array (
			'log_action'	=> "tag",
			'log_user'		=> $this->mUserId,
		);
		$namespaces = $this->getNamespaces();
		if ( !empty($namespaces) ) {
			$conditions['log_namespace'] = $namespaces;
		}

		/* number of records */
		$oRow = $dbr->selectRow(
			array ('logging'),
			array ( 'count(0) as cnt' ),
			$conditions,
			__METHOD__
		);
		if ( is_object($oRow) ) {
			$data['cnt'] = $oRow->cnt;
		}

		$res = $dbr->select (
			'logging',
			array (
				'log_timestamp as timestamp',
				'log_namespace as rc_namespace',
				'log_title as rc_title',
				'log_comment',
				'0 as page_id',
				'0 as rev_id',
				'0 as rc_new',
				'0 as page_remove'
			),
			$conditions,
			__METHOD__,
			array(
				'LIMIT' => $this->mLimit,
				'OFFSET' => $this->mOffset
			)
		);

		$data['res'] = $res;

		wfProfileOut( __METHOD__ );
		return $data;
	}

	private function getArchive( $dbr ) {
		wfProfileIn( __METHOD__ );

		$data = array(
			'cnt' => 0,
			'res' => false
		);

		$conditions = array (
			'ar_user' => $this->mUserId,
		);
		$namespaces = $this->getNamespaces();
		if ( !empty($namespaces) ) {
			$conditions['ar_namespace'] = $namespaces;
		}

		/* number of records */
		$oRow = $dbr->selectRow(
			array ('archive'),
			array ( 'count(0) as cnt' ),
			$conditions,
			__METHOD__
		);
		if ( is_object($oRow) ) {
			$data['cnt'] = $oRow->cnt;
		}

		$res = $dbr->select(
			'archive',
			array (
				'ar_timestamp as timestamp',
				'ar_namespace as rc_namespace',
				'ar_title as rc_title',
				'ar_comment',
				'ar_page_id as page_id',
				'ar_rev_id as rev_id',
				'0 as rc_new',
				'1 as page_remove'
			),
			$conditions,
			__METHOD__,
			array(
				'LIMIT' => $this->mLimit,
				'OFFSET' => $this->mOffset
			)
		);

		$data['res'] = $res;

		wfProfileOut( __METHOD__ );
		return $data;
	}

	/* fetch all contributions from that given database */
	public function fetchContribs ( ) {
		global $wgOut, $wgRequest, $wgLang, $wgMemc, $wgContLang;
		wfProfileIn( __METHOD__ );

		$fetched_data = array(
			'cnt' => 0,
			'data' => array()
		);
		$dbr = wfGetDB( DB_SLAVE, 'stats', $this->getDBname() );

		$cnt = 0;
		$res = false;

		/* todo since there are now TWO modes, we need TWO keys to rule them all */
		$memkey = __METHOD__ . ":{$this->mMode}:{$this->mDBname}:{$this->mNamespaces}:{$this->mUserId}:{$this->mLimit}:{$this->mOffset}";
		$data = $wgMemc->get($memkey);

		if ( !is_array($data) || LOOKUPCONTRIBS_NO_CACHE) {
			/* get that data from database */
			switch ($this->mMode) {
				case "normal"	: $data = $this->normalMode( $dbr ); break;
				case "final"	: $data = $this->finalMode( $dbr ); break;
				case "all"		: $data = $this->allMode( $dbr ); break;
				default			: $data = false;
			}

			if ( $data == false ) {
				wfProfileOut( __METHOD__ );
				return false;
			}

			$res = $data['res'];
			$fetched_data['cnt'] = $data['cnt'];
			$this->mNumRecords = 0;
			if ( !empty($res) && !empty($this->mWikia) ) {
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
				unset($res) ;

				// this produces additional results...
				// don't do that if we are in links mode and result was found already
				if ( $this->mNumRecords == 0 && $this->mOffset == 0 ) {
					$res = $this->getLogs( $dbr );
					/* num records */
					$num_res = $dbr->numRows( $res );
					if ( !empty($res) && !empty($num_res) ) {
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
						unset($res);
					}
				}

				/*
				 *  get data from archive (remove articles)
				 * and display what articles was edited by user
				 *
				 */
				if ( ( $this->mNumRecords == 0 ) && ( $this->mOffset == 0 ) && ($this->mMode == 'all') ) {
					$res = $this->getArchive( $dbr );
					/* num records */
					$num_res = $dbr->numRows( $res );
					if ( !empty($res) && !empty($num_res) ) {
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
						unset($res);
					}
				}
				if (!LOOKUPCONTRIBS_NO_CACHE) $wgMemc->set($memkey, $fetched_data, 60*15);
			}
		} else {
			/* get that data from memcache */
			$this->mNumRecords = count($data);
			$fetched_data = $data;
		}

		wfProfileOut( __METHOD__ );
		return $fetched_data;
	}

	/* a customized version of makeKnownLinkObj - hardened'n'modified for all those non-standard wikia out there */
	private function produceLink ($nt, $text, $query, $url, $sk, $wiki_meta, $namespace, $article_id) {
		global $wgContLang, $wgOut, $wgMetaNamespace ;

		$str = htmlspecialchars($nt->getLocalURL($query));

		/* replace empty namespaces, namely: "/:Something" of "title=:Something" stuff it's ugly, it's brutal, it doesn't lead anywhere */
		$old_str = $str ;
		$str = preg_replace ('/title=:/i', "title=ns-".$namespace.":", $str) ;
		$append = '' ;
		/* if found and replaced, we need that curid */
		if ($str != $old_str) {
			$append = "&curid=".$article_id ;
		}
		$old_str = $str ;
		$str = preg_replace ('/\/:/i', "/ns-".$namespace.":", $str) ;
		if ($str != $old_str) {
			$append = "?curid=".$article_id ;
		}

		/* replace NS_PROJECT space - it gets it from $wgMetaNamespace, which is completely wrong in this case  */
		if (NS_PROJECT == $nt->getNamespace()) {
			$str = preg_replace ("/$wgMetaNamespace/", "Project", $str) ;
		}

		$part = explode ("php", $str ) ;
		if ($part[0] == $str) {
			$part = explode ("wiki/", $str ) ;
			$u = $url. "wiki/". $part[1] ;
		} else {
			$u = $url ."index.php". $part[1] ;
		}

		if ( $nt->getFragment() != '' ) {
			if( $nt->getPrefixedDbkey() == '' ) {
				$u = '';
				if ( '' == $text ) {
					$text = htmlspecialchars( $nt->getFragment() );
				}
			}

			$anchor = urlencode( Sanitizer::decodeCharReferences( str_replace( ' ', '_', $nt->getFragment() ) ) );
			$replacearray = array(
 				'%3A' => ':',
				 '%' => '.'
		 	);
			$u .= '#' . str_replace(array_keys($replacearray),array_values($replacearray),$anchor);
		}
		if ($text != '') {
			$r = "<a href=\"{$u}{$append}\">{$text}</a>";
		} else {
			$r = "<a href=\"{$u}{$append}\">".urldecode($u)."</a>";
		}

		return $r;
	}

	public function produceLine($row) {
		global $wgLang;

		$result = array();
		$sk = RequestContext::getMain()->getSkin();
		$page_user = Title::makeTitle (NS_USER, $this->mUsername);
		#---
		$page_contribs = "";
		if ($row->page_remove == 1) {
			$page_contribs = Title::makeTitle (NS_SPECIAL, "Log");
		} else {
			$page_contribs = Title::makeTitle (NS_SPECIAL, "Contributions/{$this->mUsername}");
		}
		$meta = strtr($row->rc_city_title,' ','_');
		$page = Title::makeTitle ($row->rc_namespace, $row->rc_title);
		$user = $sk->makeKnownLinkObj ($page_user, $this->mUsername);
		#---
		$contrib = "";
		if ($row->page_remove == 1) {
			$contrib = '('.$this->produceLink ($page_contribs, wfMsg('lookupcontribslog'), "page=$page", $row->rc_url, $sk, $meta, $row->rc_namespace, $row->page_id ) .')';
		} else {
			$contrib = '('.$this->produceLink ($page_contribs, wfMsg('lookupcontribscontribs'), '', $row->rc_url, $sk, $meta, $row->rc_namespace, $row->page_id ) .')';
		}

		$link = $this->produceLink ($page, $page->getFullText(), '', $row->rc_url, $sk, $meta, $row->rc_namespace, $row->page_id) . ( $row->log_comment ? " <small>($row->log_comment)</small>" : "" );
		if ($row->page_remove == 1) {
			$link = wfMsg('lookupcontribspageremoved') . wfMsg( 'word-separator' ) . $link;
		}
		$time = $wgLang->timeanddate( wfTimestamp( TS_MW, $row->timestamp ), true );
		if ($row->page_remove == 1) {
			$page_undelete = Title::makeTitle(NS_SPECIAL, "Undelete");
			$diff = '('.$this->produceLink ($page_undelete, wfMsg('lookupcontribsrestore'), "target={$page}&diff=prev&timestamp={$row->timestamp}", $row->rc_url, $sk, $meta, $row->rc_namespace, $row->page_id ).')';
			$hist = '';
		} else {
			$diff = '('.$this->produceLink ($page, wfMsg('lookupcontribsdiff'), 'diff=prev&oldid='.$row->rev_id, $row->rc_url, $sk, $meta, $row->rc_namespace, $row->page_id ).')';
			$hist = '('.$this->produceLink ($page, wfMsg('lookupcontribshist'), 'action=history', $row->rc_url, $sk, $meta, $row->rc_namespace, $row->page_id) . ')';
		}
		#---
		$result = array("link" => $link, "diff" => $diff, "hist" => $hist, "contrib" => $contrib, "time" => $time, "removed" => $row->page_remove);

		return $result;
	}
}

