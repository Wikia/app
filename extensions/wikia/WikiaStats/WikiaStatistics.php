<?php

/**
 * @package MediaWiki
 * @author Piotr Molski <moli@wikia.com> for Wikia.com
 * @copyright (C) 2010, Wikia Inc.
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
		$mDate,
		$mText;
	const updateWithToday = false;
		
	public function __construct( $Title, $User, $articleId = 0, $text = '' ) {
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
		if ( $text ) {
			$this->mText = preg_replace( '/\[\[[^\:\]]+\:[^\]]*\]\]/', '', $text );
		}
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
			$numberWords = $this->numberWords();
			$newWords = str_word_count($this->mText);

			$dbw = wfGetDB( DB_MASTER, array(), $wgExternalDatawareDB );			
			$dbw->begin( __METHOD__ );
			try {
				# number of edits 
				$conditions = array( 
					'pe_wikia_id'	=> $wgCityId,
					'pe_page_id'	=> $this->mPageId,
					'pe_page_ns'	=> $this->mPageNs,
					'pe_date'		=> $this->mDate,
				);

				$oRow = $dbw->selectRow( 
					array( 'page_edits' ),
					array( 'pe_page_id, pe_all_count, pe_anon_count, pe_words' ),
					$conditions,
					__METHOD__
				);

				if ( $oRow ) {
					# update edits count
					$data = array( 
						'pe_all_count' 	=> intval($oRow->pe_all_count + $inc),
						'pe_is_content' => intval($this->mIsContent),
						'pe_diff_words'	=> intval($newWords - $oRow->pe_words),
						'pe_words' 		=> intval($newWords)
					);
					if ( empty($this->mUserId) ) {
						$data['pe_anon_count'] = intval($oRow->pe_anon_count + $inc);
					}
					$dbw->update( 'page_edits', $data, $conditions, __METHOD__ );
				} 
				else {
					# insert edits count
					$conditions['pe_all_count'] = $inc;
					$conditions['pe_is_content'] = intval($this->mIsContent);
					$conditions['pe_diff_words'] = intval($newWords - $numberWords);
					$conditions['pe_words'] = intval($newWords);
					if ( empty($this->mUserId) ) {
						$conditions['pe_anon_count'] = $inc;
					} else {
						$conditions['pe_anon_count'] = 0;
					}
					$dbw->insert( 'page_edits', $conditions, __METHOD__ );
				}
				
				#editor stats
				$conditions = array( 
					'pc_wikia_id'	=> $wgCityId,
					'pc_page_id'	=> $this->mPageId,
					'pc_page_ns'	=> $this->mPageNs,
					'pc_date'		=> $this->mDate,
					'pc_user_id'	=> $this->mUserId,
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
						'pc_is_content' => intval($this->mIsContent)
					);
					$dbw->update( 'page_editors', $data, $conditions, __METHOD__ );
				} 
				else {
					# insert edits count
					$conditions['pc_all_count'] = $inc;
					$conditions['pc_is_content'] = intval($this->mIsContent);
					$dbw->insert( 'page_editors', $conditions, __METHOD__ );
				}
				$dbw->commit( __METHOD__ );
			} catch ( DBConnectionError $error ) {
				$dbw->rollback( __METHOD__ );
				Wikia::log( __METHOD__, "info", "cannot update stats for Wikia: $wgCityId");
			} catch( DBQueryError $error ) {
				$dbw->rollback( __METHOD__ );
				Wikia::log( __METHOD__, "info", "cannot update stats for Wikia: $wgCityId");
			}
		}
		
		wfProfileOut( __METHOD__ );
		return $return;
	}

	/*
	 * get number of words for article 
	 *  
	 * @access private
	 * 
	 * return integer
	 */
	private function numberWords() {
		global $wgExternalDatawareDB, $wgCityId;
		wfProfileIn( __METHOD__ );
		$dbr = wfGetDB( DB_SLAVE, array(), $wgExternalDatawareDB );	

		# number of edits 
		$conditions = array( 
			'pe_wikia_id'	=> $wgCityId,
			'pe_page_id'	=> $this->mPageId,
			'pe_page_ns'	=> $this->mPageNs
		);

		$oRow = $dbr->selectRow( 
			array( 'page_edits' ),
			array( 'pe_words' ),
			$conditions,
			__METHOD__,
			array('ORDER BY' => 'pe_date desc', 'LIMIT' => 1)
		);
		
		wfProfileOut( __METHOD__ );
		return (isset($oRow->pe_words)) ? intval( $oRow->pe_words ) : 0;
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
	static public function saveComplete(&$Article, &$User, $text /* other params */) {
		wfProfileIn( __METHOD__ );
		if ( ( $Article instanceof Article ) && ( $User instanceof User ) ) {
			$Title = $Article->mTitle;
			$oEdits = new WikiaEditStatistics($Title, $User, 0, $text);
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
			$oEdits = new WikiaEditStatistics($Title, $User, $articleId, '');
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
		global $wgMemc, $wgStatsDB;
		wfProfileIn( __METHOD__ );
		
		$data = array();
		$cities = $this->getCities();
		
		if ( is_array($cities) && !empty($cities) ) {
			$memkey = wfMemcKey( __METHOD__, $this->mName, $limit );
			$data = $wgMemc->get( $memkey );
			
			if ( empty($data) ) {
				$dbr = wfGetDB( DB_SLAVE, array(), $wgStatsDB );
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
	private static $defaultLimit 			= 200;

	public static function getEditedArticles( $days = 7, $limit = 5, $onlyContent = true, $from_db = false ) {
    	global $wgExternalDatawareDB, $wgMemc;
		wfProfileIn( __METHOD__ );
    	
		$date_diff = date('Y-m-d', time() - $days * 60 * 60 * 24);
		$memkey = wfMemcKey( "WS:getEditedArticles", intval($days), intval($onlyContent), intval($limit) );
		$result = ( $from_db === true ) ? "" : $wgMemc->get( $memkey );
		if ( empty($result) ) {
			$data = array();
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
			
			while ( $oRow = $dbr->fetchObject( $oRes ) ) {
				$data[] = array(
					'wikia'		=> $oRow->pe_wikia_id,
					'page'		=> $oRow->pe_page_id,
					'count' 	=> $oRow->all_count
				);
			}
			$dbr->freeResult( $oRes );
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
			$wgMemc->set( $memkey, $result );
		}

		wfProfileOut( __METHOD__ );
		return $result;
	}

	public static function getPagesEditors( $days = 7, $limit = 5, $onlyContent = true, $recalculateLimit = false, $noHubDepe = false, $from_db = false ) {
    	global $wgExternalDatawareDB, $wgTTCache;
		wfProfileIn( __METHOD__ );
    	
		$dbLimit = self::$defaultLimit;
		$date_diff = date('Y-m-d', time() - $days * 60 * 60 * 24);
		$memkey = wfMemcKey( "WS:getPagesEditors", $days, $limit, intval($onlyContent), intval($recalculateLimit), intval($noHubDepe) );
		$result = ( $from_db === true ) ? "" : $wgTTCache->get( $memkey );
		if ( empty($result) ) {
			$data = array();
			$dbr = wfGetDB( DB_SLAVE, 'blobs', $wgExternalDatawareDB );
			
			$conditions = array("pc_date >= '$date_diff'");
			if ( $onlyContent === true ) {
				$conditions['pc_is_content'] = 1;
			}
			
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
			while ( $oRow = $dbr->fetchObject( $oRes ) ) {
				$data[] = array(
					'wikia'		=> $oRow->pc_wikia_id,
					'page'		=> $oRow->pc_page_id,
					'count' 	=> $oRow->all_count
				);
			}
			$dbr->freeResult( $oRes );

			$result = $values = array();
			$servers = array();
			$loop = 0; 
			if ( !empty( $data ) ) {
				# recalculate limit 
				$limitWikiHubs = self::$limitWikiHubs;
				if ( $recalculateLimit ){
					$factor = $limit/5;
					foreach( $limitWikiHubs as $key => $value ){
						$limitWikiHubs[$key] = ceil($value*$factor);
					}
					$delta = $limit - array_sum($limitWikiHubs);
					if ( $delta > 0){
						$limitWikiHubs['_default_'] += $delta;
					}
				}
				foreach ( $data as $row ) {
					if ( $loop >= $limit ) break;
					# check results
					if ( !empty( $servers[ $row['wikia'] ] ) ) continue;
					# check additional conditions
					$res = self::allowResultsForEditedArticles( $row, $from_db );
					if ( $res === false ) continue;
					
					list( $wikiaTitle, $db, $hub, $page_name, $wikia_url, $page_url, $count ) = array_values($res);
					
					if ( !$noHubDepe ) {
						# limit results
						if ( isset( $limitWikiHubs[ $hub ] ) ) {
							$hubLimit = $limitWikiHubs[ $hub ];
							$hubCounter = $hub;
						} else {
							$hubLimit = $limitWikiHubs[ '_default_' ];	
							$hubCounter = '_default_';
						}
						if ( !isset( $values[$hubCounter] ) ) $values[$hubCounter] = 0;
						if ( $values[$hubCounter] == $hubLimit ) continue;
					}
					# increase counter
					$values[$hubCounter]++; $loop++;
					$servers[$row['wikia']] = 1;
					
					# add to array
					if ($values[$hubCounter] > self::$limitWikiHubs[$hubCounter]){
						$res['out_of_limit'] = 1;			
					}
					$result[] = $res;
				}
			}
			unset($data);
			unset($servers);
			$wgTTCache->set( $memkey, $result );
		}

		wfProfileOut( __METHOD__ );
		return $result;
	}
	
	public static function excludeArticle($text) {
		$oRegexCore = new TextRegexCore(self::$excludeWikiArticles, 0);
		$res = false;
		if ( is_object($oRegexCore) ) {
			$res = $oRegexCore->addPhrase(preg_quote($text));

			// Regenerate the top 5 & 10 for the last 3 days (ie: purge memcache).
			self::getPagesEditors(3, 10, true, true, false, true);
			self::getPagesEditors(3, 10, true, false, false, true);
			self::getPagesEditors(3, 5, true, true, false, true);
			self::getPagesEditors(3, 5, true, false, false, true);
		}

		return $res;
	}

	/*
	 * allowResultsForEditedArticles
	 * 
	 * check: 
	 * 	- Wikia is enabled 
	 * 	- check city_lang doesn't exist in allowedLanguages array
	 * 	- check name of Wikia doesn't exist in excludeNames array
	 * 	- check name of Wikia doesn't exist in excludeNames array
	 * 	- check domain doesn't exist in excludeWikiDomainsKey list (textRegex)
	 * 	- check article doesn't exist in excludeWikiArticles list (textRegex)
	 */ 
	private static function allowResultsForEditedArticles ( $row, $from_db = false ) {
		global $wgTTCache;
		wfProfileIn( __METHOD__ );
		$result = array();

		$memkey = wfMemcKey( __METHOD__, 'oWikia', intval($row['wikia']) );
		$oWikia = $wgTTCache->get( $memkey );
		
		if ( !isset($oWikia) ) {
			$allowed = true;
			/*
			 * check city list
			 */
			$oWikia = WikiFactory::getWikiByID($row['wikia']);
			if ( !$oWikia ) $allowed = false;
			
			/*
			 * check city lang
			 */ 
			if ( $allowed && !in_array( $oWikia->city_lang, self::$allowedLanguages ) ) $allowed = false;
			
			/*
			 * check sitename
			 */
			if ( $allowed ) {
				$siteName = WikiFactory::getVarByName('wgSitename', $row['wikia']);
				if ( !$siteName ) $allowed = false;
			}
			
			/*
			 * check wikiname
			 */
			$oWikia->city_sitename = "";
			if ( $allowed ) {
				$oWikia->city_sitename = unserialize($siteName->cv_value);
				if ( !$oWikia->city_sitename ) {
					$allowed = false;
				} else {
					foreach( self::$excludeNames as $search ) {
						$pos = stripos( $oWikia->city_sitename, $search );
						if ( $pos !== false ) {
							$allowed = false;
						}
					}
				}
			}
			
			if ( !$allowed ) $oWikia = 'ERROR';
			# set in memc
			if ( $oWikia != 'ERROR' ) {
				$wgTTCache->set( $memkey, $oWikia, 60*60 );
			}
		}
		
		if ( $oWikia == 'ERROR' ) {
			wfProfileOut( __METHOD__ );
			return false;
		} 

		/* check article */
		$memkey = wfMemcKey( __METHOD__, 'article', intval($row['wikia']), intval($row['page']), $oWikia->city_dbname );
		$result = ( $from_db === true ) ? null : $wgTTCache->get( $memkey );
	
		if ( !isset($result) ) {
			$allowedPage = true;
			/*
			 * check Title && Wiki domain
			 */
			$oGTitle = GlobalTitle::newFromId( $row['page'], $row['wikia'], $oWikia->city_dbname );
			if ( !is_object($oGTitle) ) $allowedPage = false;

			if ( $allowedPage ) { 
				$wikiaUrl = $oGTitle->getServer();
				$pageUrl = $oGTitle->getFullURL();
				$articleName = $oGTitle->getArticleName();

				$oRegexCore = new TextRegexCore( self::$excludeWikiDomainsKey, 0 );
				if ( is_object( $oRegexCore ) ) {
					$allowed = $oRegexCore->isAllowedText( $wikiaUrl, "", false );
					if ( !$allowed ) $allowedPage = false;
				}
			}
			
			/*
			 * check hub name
			 */
			if ( $allowedPage ) {
				$hubName = WikiFactoryHub::getInstance()->getCategoryName($row['wikia']);
				if ( in_array($hubName, self::$excludeWikiHubs) ) $allowedPage = false;
			}

			/*
			 * check article name 
			 */
			if ( $allowedPage ) {
				$oRegexArticles = new TextRegexCore( self::$excludeWikiArticles, 0 );
				if ( is_object( $oRegexArticles ) ) {
					$filterText = sprintf("%s:%s", $oWikia->city_dbname, $articleName);
					$allowed = $oRegexArticles->isAllowedText( $filterText , "", false );
					if ( !$allowed ) $allowedPage = false;
				}
			}

			if ( !$allowedPage ) {
				$result = 'ERROR';
			} else {
				/*
				 * ok
				 */
				$result = array( 
					'wikia'		=> $oWikia->city_sitename,
					'db'		=> $oWikia->city_dbname,
					'hub' 		=> $hubName,
					'page_name'	=> $articleName,
					'wikia_url'	=> $wikiaUrl,
					'page_url'	=> $pageUrl,
					'count'		=> $row['count']
				);
				# set in memc
				$wgTTCache->set( $memkey, $result, 60*30 );
			}
		}
		
		if ( $result == 'ERROR' ) {
			$result = false;
		} 
		
		wfProfileOut( __METHOD__ );
		return $result;
	}

	public static function getCountEditedPages( $days = 7, $onlyContent = false ) {
    	global $wgExternalDatawareDB, $wgTTCache;
		wfProfileIn( __METHOD__ );
    	
		$memkey = wfMemcKey( __METHOD__, $days, intval($onlyContent) );
		$count = $wgTTCache->get( $memkey );
		if ( empty($count) ) {
			$count = 0;
			$dbr = wfGetDB( DB_SLAVE, 'blobs', $wgExternalDatawareDB );

			$dates = array();
			for ( $i = 1; $i <= $days; $i++ ) {
				$dates[] = date( 'Y-m-d', time() - ( ($i-1) * 60 * 60 * 24 ) );
			}
			$conditions = array();
			if ( count($dates) == 1 ) {
				$conditions = array('pe_date' => $dates[0] );
			} else {
				$conditions = array( "pe_date IN (".$dbr->makeList($dates).") " );
			}
			$field = ( $onlyContent === true ) ? 'pe_content_edits' : 'pe_edits';
			
			$oRes = $dbr->select(
				array( "page_edits_month" ),
				array( "$field as value" ),
				$conditions, 
				__METHOD__
			);
			while ( $oRow = $dbr->fetchObject( $oRes ) ) {
				$count += intval($oRow->value);
			}
			$dbr->freeResult( $oRes );

			$wgTTCache->set( $memkey , $count, 60*30 );
		}

		wfProfileOut( __METHOD__ );
		return $count;
	}

	public static function getCountAverageDayCreatePages( $month ) {
		global $wgExternalStatsDB, $wgTTCache;
		wfProfileIn( __METHOD__ );
    	
    	$month = str_replace("-", "", $month);
		$memkey = wfMemcKey( __METHOD__, $month );
		$count = $wgTTCache->get( $memkey );
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
			$wgTTCache->set( $memkey , $data, 60*60*3 );
		}

		wfProfileOut( __METHOD__ );
		return $count;
	}

	public static function getCountWordsInMonth( $month ) {
		global $wgExternalStatsDB, $wgTTCache;
		wfProfileIn( __METHOD__ );
    	
    	$month = str_replace("-", "", $month);
		$memkey = wfMemcKey( __METHOD__, $month );
		$count = $wgTTCache->get( $memkey );
		if ( empty($count) ) {
			$dbr = wfGetDB( DB_SLAVE, array(), $wgExternalStatsDB );
			
			$conditions = array( "cw_stats_date" => sprintf("%0d00000000", $month) );
			
			$oRow = $dbr->selectRow(
				array( "city_stats_full" ),
				array( "sum(cw_db_words) as all_count" ),
				$conditions,
				__METHOD__
			);
			$count = 0; if ( $oRow ) {
				$count = $oRow->all_count;
			}
			$wgTTCache->set( $memkey , $data, 60*60*12 );
		}

		wfProfileOut( __METHOD__ );
		return $count;
	}
	
	public static function countWordsInLastDays( $days = 7, $from_db = 0 ) {
		global $wgExternalDatawareDB, $wgTTCache;
		wfProfileIn( __METHOD__ );
		
		$result = 0;
		$memkey = wfMemcKey( "WS:countWordsLastDays", $days );
		if ( $from_db ) {
			$queries = array();
			for ( $i = 0; $i < $days; $i++ ) {
				$date = date( 'Y-m-d', time() - $i * 24 * 60 * 60 );
				$queries[] = "select pe_wikia_id, pe_page_id, pe_diff_words from page_edits where pe_date = '". $date . "'";
			}
			
			$q = "";
			if ( count($queries) ) { 
				$q  = "select sum(pe_diff_words) as cnt_words from ( ";
				$q .= implode( " union distinct ", $queries );
				$q .= ") as c";
			}
			
			if ( $q ) {
				$dbr = wfGetDB( DB_SLAVE, 'blobs', $wgExternalDatawareDB );	
				$res = $dbr->query($q, __METHOD__);
				if ( $oRow = $dbr->fetchObject($res) ) {
					$result = $oRow->cnt_words;
				}
				$wgTTCache->set($memkey, $oRow->cnt_words);
			}
		} else {
			$result = $wgTTCache->get($memkey);
		}
		
		return $result;
	}
}
