<?php
/**
 * @package MediaWiki
 * @subpackage MultiLookup
 * @author Bartek Lapinski <bartek@wikia.com>, Piotr Molski <moli@wikia.com> for Wikia.com
 *
 * helper classes & functions
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	echo "This is MediaWiki extension named MultiLookup.\n";
	exit( 1 ) ;
}

class MultipleLookupCore {
	const DEFAULT_LIMIT = 25;

	var $mUsername;
	var $mUserId;
	var $mDBname;
	var $mLimit;
	var $mOffset;
	var $mWikiID;
	var $mWikia;
	var $mNumRecords;
	var $oUser;

	public function __construct( $username, $dbname = '' ) {
		$this->mUsername = $username;
		$this->oUser = User::newFromName($this->mUsername);
		if ( $this->oUser instanceof User ) {
			$this->mUserId = $this->oUser->getId();
		}
		$this->setDBname( $dbname );
		$this->setNumRecords();
	}

	public function setDBname ( $dbname = '' ) {
		if ( $dbname ) {
			$this->mDBname = $this->__getDBname( $dbname );
			$this->mWikiID = WikiFactory::DBtoID($this->mDBname);
			$this->mWikia = WikiFactory::getWikiByID($this->mWikiID);
		}
	}
	public function getDBname () { return $this->mDBname; }
	public function setLimit ( $limit = self::DEFAULT_LIMIT ) { $this->mLimit = $limit; }
	public function setOffset ( $offset = 0 ) { $this->mOffset = $offset; }
	public function setNumRecords( $num = 0 ) { $this->mNumRecords = $num; }
	public function getNumRecords() { return $this->mNumRecords; }

	/* return if such user exists */
	public function checkIp() {
		global $wgUser;

		if ( empty( $this->mUsername ) ) {
			return false;
		}

		/* for all those anonymous users out there */
		if ( $wgUser->isIP( $this->mUsername ) ) {
			return true ;
		}

		return false;
	}

	public function countUserActivity() {
		global $wgMemc, $wgSpecialsDB;

		$countActivity = 0;
		$ip = ip2long( $this->mUsername );
		$memkey = __METHOD__ . ":all:" . $ip;
		$cached = $wgMemc->get( $memkey );
		if ( ( empty( $cached ) || MULTILOOKUP_NO_CACHE ) ) {

			$dbs = wfGetDB( DB_SLAVE, array(), $wgSpecialsDB );
			$oRow = $dbs->selectRow(
				array( 'multilookup' ),
				array( 'count(ml_city_id) as cnt' ),
				array( 'ml_ip' => $ip ),
				__METHOD__
			);

			if ( isset( $oRow->cnt ) ) {
				$countActivity = $oRow->cnt;
			}

			if ( !MULTILOOKUP_NO_CACHE ) {
				$wgMemc->set( $memkey, $countActivity, 60 * 15 );
			}
		} else {
			$countActivity = $cached;
		}

		return $countActivity;
	}

	function checkUserActivity( $order = null ) {
		global $wgMemc, $wgSpecialsDB, $wgLang;

		$userActivity = array();

		$ip = ip2long( $this->mUsername );
		$memkey = __METHOD__ . ":all:ip:" . $ip . ":limit:" . intval($this->mLimit) . ":offset:" . intval($this->mOffset) . ":order:" . $order;
		$cached = $wgMemc->get( $memkey );
		if ( ( !is_array ( $cached ) || MULTILOOKUP_NO_CACHE ) ) {
			$dbs = wfGetDB( DB_SLAVE, array(), $wgSpecialsDB );

			$qOptions = array( 'ORDER BY' => 'ml_count DESC, ml_ts DESC', 'LIMIT' => $this->mLimit, 'OFFSET' => $this->mOffset );

			if ( preg_match( '/^lastedit:(asc|desc)$/', $order, $aMatches ) ) {
				if ( isset( $aMatches[1] ) ) {
					$qOptions['ORDER BY'] = ( $aMatches[1] == 'desc' ? 'ml_ts DESC' : 'ml_ts' );
				}
			}

			$oRes = $dbs->select(
				array( 'multilookup' ),
				array( 'ml_city_id', 'ml_ts' ),
				array( 'ml_ip' => $ip ),
				__METHOD__,
				$qOptions
			);
			while ( $oRow = $dbs->fetchObject( $oRes ) ) {
				$oWikia = WikiFactory::getWikiByID( $oRow->ml_city_id );
				if ( $oWikia ) {
					$lastEditDate = $wgLang->timeanddate( wfTimestamp( TS_MW, $oRow->ml_ts ) );
					$userActivity[] = array( $oWikia->city_dbname, $oWikia->city_title, $oWikia->city_url, $lastEditDate );
				}
			}
			$dbs->freeResult( $oRes );

			if ( !MULTILOOKUP_NO_CACHE ) {
				$wgMemc->set( $memkey, $userActivity, 60 * 15 );
			}

		} else {
			$userActivity = $cached;
		}

		return $userActivity;
	}

	private function __getDBname( $database ) {
		global $wgDBname;
		return ( ML_TEST ) ? $wgDBname : $database;
	}

	/* fetch all contributions from that given database */
	function fetchContribs( $singleWiki = false ) {
		global $wgOut, $wgRequest, $wgLang, $wgMemc;
		wfProfileIn( __METHOD__ );

		$fetched_data = array ();
		if ( empty( $this->mWikia ) ) {
			wfProfileOut( __METHOD__ );
			return $fetched_data;
		}

		$where = array(
			'rc_ip' => $this->mUsername
		);
		# count of records
		$key = "{$this->mDBname}:MultiLookup:count:" . $this->mUsername;
		$cached = $wgMemc->get( $key );
		$dbr = wfGetDB( DB_SLAVE, 'stats', $this->mDBname );
		if ( !empty($cached) || MULTILOOKUP_NO_CACHE ) {
			/* number of records */
			$oRow = $dbr->selectRow(
				array ( 'recentchanges' ),
				array ( 'count(distinct(rc_user_text)) as cnt' ),
				$where,
				__METHOD__
			);
			if ( is_object($oRow) ) {
				$cached = $oRow->cnt;
			}
			if ( !MULTILOOKUP_NO_CACHE ) {
				$wgMemc->set( $key, $cached, 60 * 15 );
			}
		}

		$this->setNumRecords($cached);

		/* todo since there are now TWO modes, we need TWO keys to rule them all */
		$key = "{$this->mDBname}:MultiLookup:" . $this->mUsername . ":" . $this->mLimit . ":" . $this->mOffset;
		$cached = $wgMemc->get( $key );

		if ( !is_array( $cached ) || MULTILOOKUP_NO_CACHE ) {
			$res = $dbr->select(
				array( 'recentchanges' ),
				array( 'rc_user_text as user_name', 'max(rc_timestamp) as rc_timestamp' ),
				$where,
				__METHOD__,
				array(
					'GROUP BY' 	=> 'rc_user_text',
					'ORDER BY'	=> 'rc_user_text',
					'LIMIT'		=> $this->mLimit,
					'OFFSET'	=> ( $singleWiki ? $this->mOffset : 0 )
				)
			);

			while ( $row = $dbr->fetchObject( $res ) ) {
				$row->rc_database = $this->mDBname;
				$row->rc_url = $this->mWikia->city_url;
				$row->rc_city_title = $this->mWikia->city_title;
				$row->log_comment = false;
				$fetched_data[$row->user_name] = $row;
			}
			$dbr->freeResult( $res );
			unset( $res ) ;

			if ( !MULTILOOKUP_NO_CACHE ) {
				$wgMemc->set( $key, $fetched_data, 60 * 15 );
			}
		} else {
			/* get that data from memcache */
			$fetched_data = $cached ;
		}

		wfProfileOut( __METHOD__ );
		return $fetched_data;
	}

	/* a customized version of makeKnownLinkObj - hardened'n'modified for all those non-standard wikia out there */
	private function produceLink ( $nt, $text, $query, $url, $sk, $wiki_meta, $namespace, $article_id ) {
		global $wgContLang, $wgOut, $wgMetaNamespace ;

		$str = htmlspecialchars($nt->getLocalURL( $query ));

		/* replace empty namespaces, namely: "/:Something" of "title=:Something" stuff it's ugly, it's brutal, it doesn't lead anywhere */
		$old_str = $str ;
		$str = preg_replace ( '/title=:/i', "title=ns-" . $namespace . ":", $str ) ;
		$append = '' ;
		/* if found and replaced, we need that curid */
		if ( $str != $old_str ) {
			$append = "&curid=" . $article_id ;
		}
		$old_str = $str ;
		$str = preg_replace ( '/\/:/i', "/ns-" . $namespace . ":", $str ) ;
		if ( $str != $old_str ) {
			$append = "?curid=" . $article_id ;
		}

		/* replace NS_PROJECT space - it gets it from $wgMetaNamespace, which is completely wrong in this case  */
		if ( NS_PROJECT == $nt->getNamespace() ) {
			$str = preg_replace ( "/$wgMetaNamespace/", "Project", $str ) ;
		}

		$part = explode ( "php", $str ) ;
		if ( $part[0] == $str ) {
			$part = explode ( "wiki/", $str ) ;
			$u = $url . "wiki/" . $part[1] ;
		} else {
			$u = $url . "index.php" . $part[1] ;
		}

		if ( $nt->getFragment() != '' ) {
			if ( $nt->getPrefixedDbkey() == '' ) {
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
			$u .= '#' . str_replace( array_keys( $replacearray ), array_values( $replacearray ), $anchor );
		}
		if ( $text != '' ) {
			$r = "<a href=\"{$u}{$append}\">{$text}</a>";
		} else {
			$r = "<a href=\"{$u}{$append}\">" . urldecode( $u ) . "</a>";
		}

		return $r;
	}

	public function produceLine( $row ) {
		global $wgLang;
		$sk = RequestContext::getMain()->getSkin();
		$page_user = Title::makeTitle ( NS_USER, $row->user_name );
		$page_contribs = Title::makeTitle ( NS_SPECIAL, "Contributions/{$row->user_name}" );

		$meta = strtr( $row->rc_city_title, ' ', '_' );
		$contrib = $this->produceLink ( $page_contribs, $row->user_name, '', $row->rc_url, $sk, $meta, 0, 0 );
		return array( 'link' => $contrib, 'last_edit' => $wgLang->timeanddate( wfTimestamp( TS_MW, $row->rc_timestamp ), true ) );
	}
}
