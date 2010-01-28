<?php

/**
 * @package MediaWiki
 * @author Piotr Molski <moli@wikia.com> for Wikia.com
 * @copyright (C) 2007, Wikia Inc.
 * @licence GNU General Public Licence 2.0 or later
 * @version: $Id: Classes.php 6127 2007-10-11 11:10:32Z moli $
 */

/*
 * classes
 * 1. WikiaEditStatistics
 * 2. WikiaHubStats
 * 3. WikiaGlobalStats
 */

/*
 * hooks
 */
$wgHooks['ArticleSaveComplete'][] = "WikiaEditStatistics::saveComplete";
$wgHooks['ArticleDeleteComplete'][] = "WikiaEditStatistics::deleteComplete";
$wgHooks['UndeleteComplete'][] = "WikiaEditStatistics::undeleteComplete";

/*
 * update statistics 
 */

class WikiaEditStatistics {
	private 
		$mPageId, 
		$mPageNs, 
		$mIsContent,
		$mDate;
	const updateWithToday = false;
		
	public function __construct( $Title, $User, $articleId = 0 ) {
		global $wgEnableBlogArticles;
		/**
		 * initialization	
		 */
		$this->mPageNs = $Title->getNamespace();
		if ( empty($articleId) ) {
			$this->mPageId = $Title->getArticleID();
			if ( empty($this->mPageId) ) {
				$Title->getArticleID(GAID_FOR_UPDATE);
			}
		} else {
			$this->setPageId($articleId);
		}

		if ( is_object ( $User ) ) {
			$this->mUserId = intval($User->getID());
		} else {
			$this->mUserId = intval($User);
		}
		$this->mIsContent = 
			( $Title->isContentPage() ) && 
			( 
				($wgEnableBlogArticles) && 
				(!in_array($this->mPageNs, array(NS_BLOG_ARTICLE, NS_BLOG_ARTICLE_TALK, NS_BLOG_LISTING, NS_BLOG_LISTING_TALK))) 
			);

		$this->mDate = date('Y-m-d');
	}

	public function setPageId($page_id) { $this->mPageId = $page_id; }
	public function setUserId($user_id) { $this->mUserId = $user_id; }
	public function setDate($date) { $this->mDate = $date; }
		
	/**
	 * increase -- update stats
	 *
	 * @access private
	 *
	 * @return boolean
	 */
	public function increase( $inc = 1 ) {
		global $wgExternalDatawareDB, $wgCityId;
		wfProfileIn( __METHOD__ );
		
		$return = 0;
		if ( !empty($this->mPageId) ) {
			$dbw = wfGetDB( DB_MASTER, array(), $wgExternalDatawareDB );			

			# number of edits 
			$conditions = array( 
				'pe_wikia_id'	=> $wgCityId,
				'pe_page_id'	=> $this->mPageId,
				'pe_page_ns'	=> $this->mPageNs,
				'pe_date'		=> $this->mDate
			);

			$oRow = $dbw->selectRow( 
				array( 'page_edits' ),
				array( 'pe_page_id, pe_all_count, pe_anon_count' ),
				$conditions,
				__METHOD__
			);

			if ( $oRow ) {
				# update edits count
				$data = array( 
					'pe_all_count' 	=> intval($oRow->pe_all_count + $inc),
					'pe_is_content' => $this->mIsContent
				);
				if ( empty($this->mUserId) ) {
					$data['pe_anon_count'] = intval($oRow->pe_anon_count + $inc);
				}
				$dbw->update( 'page_edits', $data, $conditions, __METHOD__ );
			} 
			else {
				# insert edits count
				$conditions['pe_all_count'] = $inc;
				$conditions['pe_is_content'] = $this->mIsContent;
				if ( empty($this->mUserId) ) {
					$conditions['pe_anon_count'] = $inc;
				};
				$dbw->insert( 'page_edits', $conditions, __METHOD__ );
			}
			
			#editor stats
			$conditions = array( 
				'pc_wikia_id'	=> $wgCityId,
				'pc_page_id'	=> $this->mPageId,
				'pc_page_ns'	=> $this->mPageNs,
				'pc_date'		=> $this->mDate,
				'pc_user_id'	=> $this->mUserId
			);

			$oRow = $dbw->selectRow( 
				array( 'page_editors' ),
				array( 'pc_all_count' ),
				$conditions,
				__METHOD__
			);

			if ( $oRow ) {
				# update edits count
				$data = array( 
					'pc_all_count' 	=> intval($oRow->pc_all_count + $inc),
					'pc_is_content' => $this->mIsContent
				);
				$dbw->update( 'page_editors', $data, $conditions, __METHOD__ );
			} 
			else {
				# insert edits count
				$conditions['pc_all_count'] = $inc;
				$conditions['pc_is_content'] = $this->mIsContent;
				$dbw->insert( 'page_editors', $conditions, __METHOD__ );
			}
		}
		
		wfProfileOut( __METHOD__ );
		return $return;
	}

	/**
	 * increaseRevision  -- update stats
	 *
	 * @access private
	 *
	 * @return boolean
	 */
	public function increaseRevision( $inc = 1 ) {
		wfProfileIn( __METHOD__ );
		
		$return = 0;
		# after undelete function we have to check number of restored revisions 
		$dbr = wfGetDB( DB_SLAVE );
		$res = $dbr->select( 
			'revision', 
			array( 'rev_user', 'cast(rev_timestamp as date) as rev_date' ), 
			array( 
				'rev_page'		=> $this->mPageId,
				'rev_deleted'	=> 0
			), 
			__METHOD__ 
		);
		
		if ( $dbr->numRows($res) ) { 
			while( $oRow = $dbr->fetchObject($res) ) {
				$this->setUserId($oRow->rev_user);
				if ( self::updateWithToday == false ) {
					$this->setDate($oRow->rev_date);
				}
				$update = $this->increase($inc);
				if ( !empty($update) ) $return += $update;
			}
			$dbr->freeResult($res);
		}
		
		wfProfileOut( __METHOD__ );
		return $return;
	}

	/**
	 * decrease -- update stats
	 *
	 * @access private
	 *
	 * @return boolean
	 */
	public function decrease() {
		global $wgCityId, $wgExternalDatawareDB;
		wfProfileIn( __METHOD__ );

		$return = 0;
		if ( !empty($this->mPageId) ) {
			#edits
			$conditions = array( 
				'pe_wikia_id'	=> $wgCityId,
				'pe_page_id'	=> $this->mPageId,
				'pe_page_ns'	=> $this->mPageNs,
				'pe_date'		=> $this->mDate
			);
			$dbw = wfGetDB( DB_MASTER, array(), $wgExternalDatawareDB );			
			$dbw->delete( 'page_edits', $conditions, __METHOD__ );

			#editors
			$conditions = array( 
				'pc_wikia_id'	=> $wgCityId,
				'pc_page_id'	=> $this->mPageId,
				'pc_page_ns'	=> $this->mPageNs,
				'pc_date'		=> $this->mDate
			);
			$dbw->delete( 'page_editors', $conditions, __METHOD__ );
		}
		
		wfProfileOut( __METHOD__ );
		return $return;
	}

	/**
	 * saveComplete -- hook 
	 *
	 * @static
	 * @access public
	 *
	 * @param Article $Article,
	 * @param User $User,
	 *
	 * @return true
	 */
	static public function saveComplete(&$Article, &$User /* other params */) {
		wfProfileIn( __METHOD__ );
		if ( ( $Article instanceof Article ) && ( $User instanceof User ) ) {
			$Title = $Article->mTitle;
			$oEdits = new WikiaEditStatistics($Title, $User);
			$oEdits->increase();
		}
		wfProfileOut( __METHOD__ );
		return true;		
	}

	/**
	 * deleteComplete -- hook 
	 *
	 * @static
	 * @access public
	 *
	 * @param Article $Article,
	 * @param User $User,
	 * @param String $reason,
	 * @param String $articleId,
	 *
	 * @return true
	 */
	static public function deleteComplete( &$Article, &$User, $reason, $articleId ) {
		wfProfileIn( __METHOD__ );
		if ( ( $Article instanceof Article ) && ( $User instanceof User ) ) {
			$Title = $Article->mTitle;
			$oEdits = new WikiaEditStatistics($Title, $User, $articleId);
			$oEdits->decrease();
		}
		wfProfileOut( __METHOD__ );
		return true;
	}
	
	/**
	 * undeleteComplete -- hook 
	 *
	 * @static
	 * @access public
	 *
	 * @param Title $Title,
	 * @param User $User,
	 * @param String reason
	 *
	 * @return true
	 */
	static public function undeleteComplete( &$Title, $User, $reason ) {
		wfProfileIn( __METHOD__ );
		if ( ( $Title instanceof Title ) && ( $User instanceof User ) ) {
			$newId = $Title->getLatestRevID();
			if ( empty($newId) ) {
				$newId = $Title->getLatestRevID(GAID_FOR_UPDATE);
			}
			$revCount = $Title->countRevisionsBetween( 1, $newId );
			if ( $revCount ) {
				$oEdits = new WikiaEditStatistics($Title, $User);
				$oEdits->increaseRevision( );
			}
		}
		wfProfileOut( __METHOD__ );
		return true;
	}
}

/*
 * per hub statistics 
 */
class WikiaHubStats {
	const PV_MONTHS = 12;
	private 
		$mCityId,
		$mWFHub,
		$mName;
	
	/**
	 * initialization
	 * 
	 * @access public
	 *
	 * @param String or Integer $cat,
	 */
	function __construct( $cityId, $hubName = null ) {
		$this->mCityId = $cityId;
		$this->mWFHub = WikiFactoryHub::getInstance();
		$this->mName = $hubName;
		if ( empty($this->mName) ) {
			$this->mName = $this->mWFHub->getCategoryName($this->mCityId);
		} 
	}
	
	/**
	 * newFromId 
	 * 
	 * @access public
	 *
	 * @param Integer $catid 
	 */
	public function newFromId( $cityId ) {
		return new WikiaHubStats($cityId);
	}

	/**
	 * newFromHub
	 * 
	 * @access public
	 *
	 * @param String $hubName
	 */
	public function newFromHub( $hubName ) {
		global $wgCityId;
		return new WikiaHubStats($cityId, $hubName);
	}

	/**
	 * getTopPVWikis 
	 * 
	 * @access public
	 *
	 * @param Array $data - list of Top Wikis (by PV) in hub
	 */
	public function getTopPVWikis( $limit = 20 ) {
		global $wgMemc, $wgExternalStatsDB;
		wfProfileIn( __METHOD__ );
		
		$data = array();
		$cities = $this->getCities();
		
		if ( is_array($cities) && !empty($cities) ) {
			$memkey = wfMemcKey( __METHOD__, $this->mName, $limit );
			$data = $wgMemc->get( $memkey );
			
			if ( empty($data) ) {
				$dbr = wfGetDB( DB_SLAVE, array(), $wgExternalStatsDB );
				$oRes = $dbr->select(
					array( 'city_page_views' ),
					array( 'pv_city_id, sum(pv_views) as views' ),
					array(
						sprintf( ' pv_use_date >= last_day(now() - interval %d day) ', self::PV_MONTHS * 30 ),
						'pv_namespace' => 0,
						' pv_city_id in (' . $dbr->makeList($cities) . ') '
					),
					__METHOD__,
					array(
						'GROUP BY' => 'pv_city_id'
					)
				);

				$order = $data = array(); 
				while ( $oRow = $dbr->fetchObject( $oRes ) ) {
					$order[$oRow->pv_city_id] = $oRow->views;
				}
				$dbr->freeResult( $oRes );

				if ( !empty($order) ) {
					arsort($order);
					$loop = 0; foreach ( $order as $city_id => $views ) {
						if ( $loop > $limit ) break;
						$domain = WikiFactory::getVarValueByName( "wgServer", $city_id );
						if ( $domain ) {
							$data[$city_id] = array('url' => $domain, 'count' => $views);
							$loop++;
						}
					}
					$wgMemc->set( $memkey, $data, 60*60 );
				}
			}
		}

		wfProfileOut( __METHOD__ );
		return $data;
	}
	
	/**
	 * getCities
	 * 
	 * @access private
	 *
	 * @param Array $data - list of Wikis in hub
	 */
	private function getCities() {
    	global $wgExternalSharedDB, $wgMemc;
		wfProfileIn( __METHOD__ );

		$memkey = wfMemcKey( __METHOD__, $this->mName );
		$data = $wgMemc->get( $memkey );
		if ( empty($data) ) {
			$dbr = wfGetDB( DB_SLAVE, array(), $wgExternalSharedDB );
			
			$oRes = $dbr->select(
				array( "city_cats_view" ),
				array( "cc_city_id" ),
				array( "cc_name" => $this->mName ),
				__METHOD__
			);
			$data = array(); while ( $oRow = $dbr->fetchObject( $oRes ) ) {
				$data[] = $oRow->cc_city_id;
			}
			$dbr->freeResult( $oRes );
			$wgMemc->set( $memkey , $data, 60*60*24 );
		}

		wfProfileOut( __METHOD__ );
		return $data;
	}
}

/*
 * global edits statistics 
 */
class WikiaGlobalStats {
	private static $excludeNames 			= array('un', 'fanon', 'sex');
	private static $allowedLanguages 		= array('en');
	private static $excludeWikiDomainsKey 	= 'homepage-exclude-wikis';
	private static $excludeWikiArticles 	= 'homepage-exclude-pages';
	private static $excludeWikiHubs 		= array( 'Humor' );
	private static $limitWikiHubs 			= array( 'Gaming' => 2, 'Entertainment' => 2, '_default_' => 1 );
	private static $defaultLimit 			= 100;

	public static function getEditedArticles( $days = 7, $limit = 5, $onlyContent = true ) {
    	global $wgExternalDatawareDB, $wgMemc;
		wfProfileIn( __METHOD__ );
    	
		$date_diff = date('Y-m-d', time() - $days * 60 * 60 * 24);
		$memkey = wfMemcKey( __METHOD__, $days, intval($onlyContent) );
		$data = $wgMemc->get( $memkey );
		if ( empty($data) ) {
			$dbr = wfGetDB( DB_SLAVE, 'blobs', $wgExternalDatawareDB );
			
			$conditions = array("pe_date >= '$date_diff'");
			if ( $onlyContent === true ) {
				$conditions['pe_is_content'] = 1;
			}
			
			$oRes = $dbr->select(
				array( "page_edits" ),
				array( "pe_is_content, pe_wikia_id, pe_page_id, sum(pe_all_count) as all_count" ),
				$conditions,
				__METHOD__,
				array(
					'GROUP BY' 	=> 'pe_wikia_id, pe_page_id',
					'ORDER BY' 	=> 'all_count desc',
					'LIMIT'		=> self::$defaultLimit
				)
			);
			$data = array(); while ( $oRow = $dbr->fetchObject( $oRes ) ) {
				$data[] = array(
					'wikia'		=> $oRow->pe_wikia_id,
					'page'		=> $oRow->pe_page_id,
					'count' 	=> $oRow->all_count
				);
			}
			$dbr->freeResult( $oRes );
			$wgMemc->set( $memkey , $data, 60*60 );
		}

		$result = $values = array();
		$loop = 0;
		if ( !empty( $data ) ) {
			foreach ( $data as $row ) {
				if ( $loop >= $limit ) break;
				# check results
				$res = self::allowResultsForEditedArticles( $row );
				if ( $res === false ) continue;
				
				list( $wikiaTitle, $db, $hub, $wikia_ul, $page_url, $count ) = array_values($res);
				if ( !isset( $values[$hub] ) ) $values[$hub] = 0;
				
				# limit results
				$hubLimit = ( isset( self::$limitWikiHubs[ $hub ] ) ) 
					? self::$limitWikiHubs[ $hub ]
					: self::$limitWikiHubs[ '_default_' ];
				if ( $values[$hub] == $hubLimit ) continue;
				
				# add to array
				$result[] = $res;
				# increase counter
				$values[$hub]++; $loop++;
			}
		}

		wfProfileOut( __METHOD__ );
		return $result;
	}

	public static function getPagesEditors( $days = 7, $limit = 5, $onlyContent = true ) {
    	global $wgExternalDatawareDB, $wgMemc;
		wfProfileIn( __METHOD__ );
    	
		$date_diff = date('Y-m-d', time() - $days * 60 * 60 * 24);
		$memkey = wfMemcKey( __METHOD__, $days, intval($onlyContent) );
		$data = $wgMemc->get( $memkey );
		if ( empty($data) ) {
			$dbr = wfGetDB( DB_SLAVE, 'blobs', $wgExternalDatawareDB );
			
			$conditions = array("pc_date >= '$date_diff'");
			if ( $onlyContent === true ) {
				$conditions['pc_is_content'] = 1;
			}
			
			$dbLimit = (int) ($limit/3)*self::$defaultLimit;
			$oRes = $dbr->select(
				array( "page_editors" ),
				array( "pc_is_content, pc_wikia_id, pc_page_id, count(distinct(pc_user_id)) as all_count" ),
				$conditions,
				__METHOD__,
				array(
					'GROUP BY' 	=> 'pc_wikia_id, pc_page_id',
					'ORDER BY' 	=> 'all_count desc',
					'LIMIT'		=> $dbLimit
				)
			);
			$data = array(); while ( $oRow = $dbr->fetchObject( $oRes ) ) {
				$data[] = array(
					'wikia'		=> $oRow->pc_wikia_id,
					'page'		=> $oRow->pc_page_id,
					'count' 	=> $oRow->all_count
				);
			}
			$dbr->freeResult( $oRes );
			$wgMemc->set( $memkey , $data, 60*60 );
		}

		$result = $values = array();
		$loop = 0;
		if ( !empty( $data ) ) {
			foreach ( $data as $row ) {
				if ( $loop >= $limit ) break;
				# check results
				$res = self::allowResultsForEditedArticles( $row );
				if ( $res === false ) continue;
				
				list( $wikiaTitle, $db, $hub, $wikia_ul, $page_url, $count ) = array_values($res);
				if ( !isset( $values[$hub] ) ) $values[$hub] = 0;
				
				# limit results
				$hubLimit = ( isset( self::$limitWikiHubs[ $hub ] ) ) 
					? self::$limitWikiHubs[ $hub ]
					: self::$limitWikiHubs[ '_default_' ];
				if ( $values[$hub] == $hubLimit ) continue;
				
				# add to array
				$result[] = $res;
				# increase counter
				$values[$hub]++; $loop++;
			}
		}

		wfProfileOut( __METHOD__ );
		return $result;
	}
	
	public static function excludeArticle($text) {
		$oRegexCore = new TextRegexCore(self::$excludeWikiArticles, 0);
		$res = false;
		if ( is_object($oRegexCore) ) {
			$res = $oRegexCore->addPhrase(preg_quote($text));
		}
		return $res;
	}
	
	private static function allowResultsForEditedArticles ( $row ) {
		wfProfileIn( __METHOD__ );
		$result = array();
		
		$oWikia = WikiFactory::getWikiByID($row['wikia']);
		/*
		 * check city list
		 */
		if ( !$oWikia ) {
			wfProfileOut( __METHOD__ );
			return false;
		}

		if ( !in_array( $oWikia->city_lang, self::$allowedLanguages ) ) {
			wfProfileOut( __METHOD__ );
			return false;
		}
		
		/*
		 * check sitename
		 */
		$siteName = WikiFactory::getVarByName('wgSitename', $row['wikia']);
		if ( !$siteName ) {
			wfProfileOut( __METHOD__ );
			return false;
		}
		
		/*
		 * check wikiname
		 */
		$wikiName = unserialize($siteName->cv_value);
		if ( !$wikiName ) {
			wfProfileOut( __METHOD__ );
			return false;
		}
		
		foreach( self::$excludeNames as $search ) {
			$pos = stripos( $wikiName, $search );
			if ( $pos !== false ) {
				wfProfileOut( __METHOD__ );
				return false;
			}
		}

		/*
		 * check Title && Wiki domain
		 */
		$oGTitle = GlobalTitle::newFromId( $row['page'], $row['wikia'], $oWikia->city_dbname );
		if ( !is_object($oGTitle) ) {
			wfProfileOut( __METHOD__ );
			return false;
		}

		$wikiaUrl = $oGTitle->getServer();
		$pageUrl = $oGTitle->getFullURL();
		$articleName = $oGTitle->getArticleName();

		$oRegexCore = new TextRegexCore( self::$excludeWikiDomainsKey, 0 );
		if ( is_object( $oRegexCore ) ) {
			$allowed = $oRegexCore->isAllowedText( $wikiaUrl, "", false );
			if ( !$allowed ) {
				wfProfileOut( __METHOD__ );
				return false;
			}
		}
		
		/*
		 * check hub name
		 */
		$hubName = WikiFactoryHub::getInstance()->getCategoryName($row['wikia']);
		if ( in_array($hubName, self::$excludeWikiHubs) ) {
			wfProfileOut( __METHOD__ );
			return false;
		}

		/*
		 * check article name 
		 */
		$oRegexArticles = new TextRegexCore( self::$excludeWikiArticles, 0 );
		if ( is_object( $oRegexArticles ) ) {
			$filterText = sprintf("%s:%s", $oWikia->city_dbname, $articleName);
			$allowed = $oRegexArticles->isAllowedText( $filterText , "", false );
			if ( !$allowed ) {
				wfProfileOut( __METHOD__ );
				return false;
			}
		}

		/*
		 * ok
		 */
		$result = array( 
			'wikia'		=> $wikiName,
			'db'		=> $oWikia->city_dbname,
			'hub' 		=> $hubName,
			'page_name'	=> $articleName,
			'wikia_url'	=> $wikiaUrl,
			'page_url'	=> $pageUrl,
			'count'		=> $row['count']
		);
		
		wfProfileOut( __METHOD__ );
		
		return $result;
	}

	public static function getCountEditedPages( $days = 7, $onlyContent = false ) {
    	global $wgExternalDatawareDB, $wgMemc;
		wfProfileIn( __METHOD__ );
    	
		$date_diff = date('Y-m-d', time() - $days * 60 * 60 * 24);
		$memkey = wfMemcKey( __METHOD__, $days, intval($onlyContent) );
		$count = $wgMemc->get( $memkey );
		if ( empty($count) ) {
			$dbr = wfGetDB( DB_SLAVE, 'blobs', $wgExternalDatawareDB );
			
			$conditions = array("pe_date >= '$date_diff'");
			if ( $onlyContent === true ) {
				$conditions['pe_is_content'] = 1;
			}
			
			$oRow = $dbr->selectRow(
				array( "page_edits" ),
				array( "sum(pe_all_count) as all_count" ),
				$conditions,
				__METHOD__
			);
			$count = 0; if ( $oRow ) {
				$count = $oRow->all_count;
			}
			$wgMemc->set( $memkey , $data, 60*30 );
		}

		wfProfileOut( __METHOD__ );
		return $count;
	}

	public static function getCountAverageDayCreatePages( $month ) {
		global $wgExternalStatsDB, $wgMemc;
		wfProfileIn( __METHOD__ );
    	
    	$month = str_replace("-", "", $month);
		$memkey = wfMemcKey( __METHOD__, $month );
		$count = $wgMemc->get( $memkey );
		if ( empty($count) ) {
			$dbr = wfGetDB( DB_SLAVE, array(), $wgExternalStatsDB );
			
			$conditions = array( "cw_stats_date" => sprintf("%0d00000000", $month) );
			
			$oRow = $dbr->selectRow(
				array( "city_stats_full" ),
				array( "sum(cw_article_new_per_day) as all_count" ),
				$conditions,
				__METHOD__
			);
			$count = 0; if ( $oRow ) {
				$count = $oRow->all_count;
			}
			$wgMemc->set( $memkey , $data, 60*60*3 );
		}

		wfProfileOut( __METHOD__ );
		return $count;
	}

}
