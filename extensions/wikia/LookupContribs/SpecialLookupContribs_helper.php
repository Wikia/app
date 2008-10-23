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
    var $mUsername, $mNumRecords;

    public function __construct($username) {
        $this->mUsername = $username;
		wfLoadExtensionMessages("SpecialLookupContribs");        
    }
    
	/* return if such user exists */
	public function checkUser() {
		global $wgUser ;

		if (empty($this->mUsername)) {
			return false;
		}

		/* for all those anonymous users out there */
		if ($wgUser->isIP($this->mUsername)) {
			return true ;
		}
		
		$uid = User::idFromName($this->mUsername);
		if (empty($uid)) {
			return false;
		}
		
		return true;
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
		
		foreach ($wgLookupContribsExcluded as $excluded) {
			$result[] = WikiFactory::DBtoID($excluded);
		}
		
		wfProfileOut( __METHOD__ );
		return $result ;
	}
	
	function exclusionCheck ($database) {
		global $wgLookupContribsExcluded;
		/* grumble grumble _precautions_ cough */
		if (!isset($wgLookupContribsExcluded) || (!is_array($wgLookupContribsExcluded)) || (empty($wgLookupContribsExcluded))  ) {
			return true;
		}
		foreach ($wgLookupContribsExcluded as $excluded) {
	       	if ($excluded == $database) {
				return false;
			}
		}
		return true;
	}

	/* fetch all wikias from the database */
	function getWikiList() {
		global $wgMemc, $wgSharedDB;
		/* 
		 will memcache this - but where will be mechanism controlling that when we add/delete wikias from database?
		 won't the data get outdated? surely it would 
		*/
		$wikias_array = array();
		$memkey = wfForeignMemcKey( $wgSharedDB, null, "LookupContribs", "wikias" );
		$cached = $wgMemc->get($memkey);
		if (!is_array ($cached) || LOOKUPCONTRIBS_NO_CACHE) { 
			$dbr =& wfGetDB(DB_SLAVE);
			$query = "SELECT city_id, city_dbname, city_url, city_title FROM ". wfSharedTable("city_list"). " WHERE city_public != 0";
			$res = $dbr->query ($query);
			while ($row = $dbr->fetchObject($res)) {
				$wikias_array[$row->city_id] = $row;
			}
			$dbr->freeResult ($res);
			if (!LOOKUPCONTRIBS_NO_CACHE) $wgMemc->set( $memkey, $wikias_array );
		} else { 
			$wikias_array = $cached;
		}
		
		return $wikias_array;
	}
	
	function checkUserActivity($username) {
		global $wgMemc, $wgSharedDB, $wgDBStats;
		$userActivity = array();
		$memkey = wfForeignMemcKey( $wgSharedDB, null, "LookupContribs", "UserActivity", $username );
		$cached = $wgMemc->get($memkey);
		if (!is_array ($cached) || LOOKUPCONTRIBS_NO_CACHE) { 
			$dbs =& wfGetDBStats();
			if (!is_null($dbs)) {
				$query = "select ca_latest_activity from `{$wgDBStats}`.`city_user_activity` where ca_user_text = {$dbs->addQuotes($username)}";
				$res = $dbs->query ($query);
				if ($row = $dbs->fetchObject($res)) {
					$userActivity = $row->ca_latest_activity;
				}
				$dbs->freeResult($res);
				if (!LOOKUPCONTRIBS_NO_CACHE) {
					$wgMemc->set( $memkey, $userActivity, 60*3 );
				}
			}
		} else { 
			$userActivity = $cached;
		}
		
		return $userActivity;
	}
	
	function checkUserActivityExternal($username) {
		global $wgMemc, $wgSharedDB, $wgDBStats, $wgContLang;
		$userActivity = array();
		$oUser = User::newFromName($username);
		if (!$oUser instanceof User) {
			wfDebug( "User $username not found\n" );
			return $userActivity;
		}
		$iUserId = $oUser->getId();
		$memkey = wfForeignMemcKey( $wgSharedDB, null, "LookupContribs", "UserActivityExt", $iUserId );
		$cached = $wgMemc->get($memkey);
		if (!is_array ($cached) || LOOKUPCONTRIBS_NO_CACHE) { 
			$dbext =& wfGetDBExt();
			if (!is_null($dbext)) {
				$query = "select rev_wikia_id, max(rev_timestamp) as max_activity, unix_timestamp(rev_timestamp) as max_timestamp ";
				$query .= "from `dataware`.`blobs` where rev_user = ".intval($iUserId)." and rev_wikia_id > 0 ";
				//$query .= "and rev_status = 'active' and blob_text is not null ";
				$query .= "group by rev_wikia_id";
				$res = $dbext->query ($query);
				while ($row = $dbext->fetchObject($res)) {
					$userActivity[$row->max_timestamp] = $row->rev_wikia_id;
				}
				if (!empty($userActivity)) {
					krsort($userActivity);
				}				
				$dbext->freeResult($res);
				if (!LOOKUPCONTRIBS_NO_CACHE) {
					$wgMemc->set( $memkey, $userActivity, 60*3 );
				}
			}
		} else { 
			$userActivity = $cached;
		}
		
		return $userActivity;
	}

	private function __getDBname($database) {
		global $wgDBname;
		return (LC_TEST) ? $wgDBname : $database;
	}

	/* fetch all contributions from that given database */
	function fetchContribs ($database, $fetch_mode) {
		global $wgOut, $wgRequest, $wgLang, $wgMemc, $wgSharedDB ;
		global $wgDBStatsServer, $wgDBStats, $wgContLang;
		wfProfileIn( __METHOD__ );
		$fetched_data = array ();

		$oUser = User::newFromName($this->mUsername);
		if (!$oUser instanceof User) {
			wfDebug( "User $username not found\n" );
			wfProfileOut( __METHOD__ );
			return $fetched_data;
		}
		$iUserId = $oUser->getId();

		/* todo since there are now TWO modes, we need TWO keys to rule them all */
		$key = "$database:LookupContribs:$fetch_mode:".$iUserId;
		$cached = $wgMemc->get($key);

		if ( !is_array($cached) || LOOKUPCONTRIBS_NO_CACHE) {
			/* get that data from database */
			$dbr =& wfGetDB(DB_SLAVE);
			/* don't check these databases - their structure is not overly compactible */
			$excCities = $this->getExclusionList();
			/* */
			if ( $fetch_mode == 'normal' ) {
				$res = $dbr->select(
					"`{$this->__getDBname($database)}`.`recentchanges`, `{$this->__getDBname($database)}`.`revision`",
					array ( 
						'rc_title',
						'rev_id',
						'rev_page as page_id',
						'rev_timestamp as timestamp',
						'rc_namespace',
						'rc_new' 
					),
					array (
						'rev_user' => intval($iUserId),
						' rc_timestamp = rev_timestamp '
					),
					__METHOD__,
					array (
						'ORDER BY'	=> 'rev_timestamp DESC'
					)
				);
			} else if ( $fetch_mode == 'final' ) {
				$res = $dbr->select(
					"`{$this->__getDBname($database)}`.`revision`, `{$this->__getDBname($database)}`.`page`",
					array ( 
						'page_title as rc_title',
						'rev_id',
						'page_id',
						'rev_timestamp as timestamp',
						'page_namespace as rc_namespace',
						'0 as rc_new',
						'0 as page_remove' 
					),
					array (
						'rev_user' => intval($iUserId),
						' rev_id = page_latest '
					),
					__METHOD__,
					array (
						'ORDER BY'	=> 'rev_timestamp DESC',
					)
				);
			} else if ( $fetch_mode == 'all' ) {
				$res = $dbr->select(
					"`{$this->__getDBname($database)}`.`revision`, `{$this->__getDBname($database)}`.`page`",
					array ( 
						'page_title as rc_title',
						'rev_id',
						'page_id',
						'rev_timestamp as timestamp',
						'page_namespace as rc_namespace',
						'0 as rc_new',
						'0 as page_remove' 
					),
					array (
						'rev_user' => intval($iUserId),
						' page_id = rev_page '
					),
					__METHOD__,
					array (
						'ORDER BY'	=> 'rev_timestamp DESC',
					)
				);
			} else {
				$res = false;
			}

			$result_found_already = false ;
			$city_id = WikiFactory::DBtoID($database);
			$wikia = WikiFactory::getWikiByID($city_id);
			if ( !empty($res) && !empty($wikia) ) {
				while ( $row = $dbr->fetchObject( $res ) ) {
					$row->rc_database = $database;
					$row->rc_url = $wikia->city_url;
					$row->rc_city_title = $wikia->city_title;
					$row->log_comment = false;
					$fetched_data[$row->timestamp] = $row;
				}
				$dbr->freeResult( $res );
				$this->mNumRecords = count($fetched_data);
				$result_found_already = ($this->mNumRecords > 0);
				unset($res) ;

				// this produces additional results...
				// don't do that if we are in links mode and result was found already
				if ( empty($result_found_already) ) {
					$res = $dbr->select (
						" `{$this->__getDBname($database)}`.`logging` ",
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
						array (
							'log_action' => "tag",
							'log_user' => intval($iUserId),
						),
						__METHOD__
					);

					$num_res = $dbr->numRows( $res );
					if ( !empty($res) && !empty($num_res) ) {
						while ( $row = $dbr->fetchObject( $res ) ) {
							$row->rc_database = $database;
							$row->rc_url = $wikia->city_url;
							$row->rc_city_title = $wikia->city_title;
							$fetched_data[$row->timestamp] = $row;
						}
						$dbr->freeResult( $res );
						$this->mNumRecords = count($fetched_data);
					}
					$result_found_already = ($this->mNumRecords > 0);
					unset($res);
				}
				
				/*
				 *  get data from archive (remove articles) 
				 * and display what articles was edited by user 
				 * 
				 */
				if ( empty($result_found_already) && ($fetch_mode == 'all') ) {
					$res = $dbr->select (
						" `{$this->__getDBname($database)}`.`archive` ",
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
						array (
							'ar_user' => intval($iUserId),
						),
						__METHOD__
					);

					$num_res = $dbr->numRows( $res );
					if ( !empty($res) && !empty($num_res) ) {
						while ( $row = $dbr->fetchObject( $res ) ) {
							$row->rc_database = $database;
							$row->rc_url = $wikia->city_url;
							$row->rc_city_title = $wikia->city_title;
							$fetched_data[$row->timestamp] = $row;
						}
						$dbr->freeResult( $res );
						$this->mNumRecords = count($fetched_data);
					}
					unset($res);
				}
				if (!LOOKUPCONTRIBS_NO_CACHE) {
					$wgMemc->set($key, $fetched_data, 60*15);
				}
			}
		} else {
			/* get that data from memcache */
			$this->mNumRecords = count($cached) ;
			$fetched_data = $cached ;
		}

		wfProfileOut( __METHOD__ );
		return $fetched_data;
	}
	
	/* a customized version of makeKnownLinkObj - hardened'n'modified for all those non-standard wikia out there */
	private function produceLink ($nt, $text = '', $query = '', $url = '', $sk, $wiki_meta, $namespace, $article_id) {
		global $wgContLang, $wgOut, $wgMetaNamespace ;

		$str = $nt->escapeLocalURL ($query) ;

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

	public function produceLine($row, $username, $mode) {
		global $wgLang, $wgOut, $wgRequest, $wgUser;
		$result = array();
		$sk = $wgUser->getSkin();
		$page_user = Title::makeTitle (NS_USER, $username);
		#---
		$page_contribs = "";
		if ($row->page_remove == 1) {
			$page_contribs = Title::makeTitle (NS_SPECIAL, "Log");
		} else {
			$page_contribs = Title::makeTitle (NS_SPECIAL, "Contributions/{$username}");
		}
		$meta = strtr($row->rc_city_title,' ','_');
		$page = Title::makeTitle ($row->rc_namespace, $row->rc_title);
		$user = $sk->makeKnownLinkObj ($page_user, $username);
		#---
		$contrib = "";
		if ($row->page_remove == 1) {
			$contrib = '('.$this->produceLink ($page_contribs, wfMsg('lookupcontribslog'), "page=$page", $row->rc_url, $sk, $meta, $row->rc_namespace, $row->page_id ) .')';			
		} else {
			$contrib = '('.$this->produceLink ($page_contribs, wfMsg('lookupcontribscontribs'), '', $row->rc_url, $sk, $meta, $row->rc_namespace, $row->page_id ) .')';
		}

		$link = $this->produceLink ($page, '', '', $row->rc_url, $sk, $meta, $row->rc_namespace, $row->page_id) . ( $row->log_comment ? " <small>($row->log_comment)</small>" : "" );
		if ($row->page_remove == 1) {
			$link = wfMsg('lookupcontribspageremoved') . $link;
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

?>
