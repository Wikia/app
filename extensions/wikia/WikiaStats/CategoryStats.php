<?php

/**
 * @package MediaWiki
 * @author Piotr Molski <moli@wikia.com> for Wikia.com
 * @copyright (C) 2007, Wikia Inc.
 * @licence GNU General Public Licence 2.0 or later
 * @version: $Id: Classes.php 6127 2007-10-11 11:10:32Z moli $
 */

/*
 * hooks
 */
$wgHooks['ArticleSaveComplete'][] = "CategoryTrigger::saveComplete";
$wgHooks['ArticleDeleteComplete'][] = "CategoryTrigger::deleteComplete";
$wgHooks['UndeleteComplete'][] = "CategoryTrigger::undeleteComplete";

class CategoryTrigger {
	private $mPageId, $mPageNs, $mUserId, $mDate;
	const updateWithToday = false;
		
	public function __construct( $Title, $User, $articleId = 0 ) {
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
			$this->mUserId = $User->getID();
		} else {
			$this->mUserId = $User;
		}
		$this->mDate = date('Y-m-d');
	}

	public function setPageId($page_id) { $this->mPageId = $page_id; }
	public function setUserId($user_id) { $this->mUserId = $user_id; }
	public function setDate($date) { $this->mDate = $date; }
	
	/**
	 * sql_increase -- update stats (it uses SQL functions)
	 *
	 * @access private
	 *
	 * @return boolean
	 */
	public function sql_increase( $inc = 1 ) {
		wfProfileIn( __METHOD__ );
		
		$res = 0;
		$dbw = wfGetDB( DB_MASTER );
		if ( $inc == 1 ) { 
			$select = sprintf(
				"category_edits_inc(%0d, %0d, %0d, %0d) as row_count", 
				$this->mPageId,
				$this->mPageNs,
				$this->mUserId,
				$inc
			);
		} else {
			$select = sprintf(
				"category_edits_rev_inc(%0d, %0d) as row_count", 
				$this->mPageId,
				$this->mPageNs
			);
		}
		$oRow = $dbw->selectRow( '', $select, '', __METHOD__ );
				
		if( $oRow ) {
			$res = $oRow->row_count;
		} 
		
		wfProfileOut( __METHOD__ );
		return $res;
	}
	
	/**
	 * increase -- update stats
	 *
	 * @access private
	 *
	 * @return boolean
	 */
	public function increase( $inc = 1 ) {
		wfProfileIn( __METHOD__ );
		
		$return = 0;
		
		if ( !empty($this->mUserId) ) {
			$dbr = wfGetDB( DB_SLAVE );

			# number of edits 
			$res = $dbr->select( 
				array('categorylinks', 'category'), 
				array( 'cat_id' ), 
				array( 
					'cl_to = cat_title',
					'cl_from' => $this->mPageId 
				), 
				__METHOD__ 
			);
			
			if ( $dbr->numRows($res) ) { 
				$dbw = wfGetDB( DB_MASTER );
				while( $oRow = $dbr->fetchObject($res) ) {
					# number of edits
					$conditions = array(
						'ce_cat_id'		=> $oRow->cat_id,
						'ce_page_id'	=> $this->mPageId,
						'ce_page_ns'	=> $this->mPageNs,
						'ce_user_id'	=> $this->mUserId,
						'ce_date'		=> $this->mDate
					);

					$Row = $dbr->selectRow ( 'category_edits', array('ce_count'), $conditions, __METHOD__ );
					if ( $Row ) {
						# update edits count
						$count = $Row->ce_count + $inc;
						$dbw->update( 'category_edits', array( 'ce_count' => $count ), $conditions, __METHOD__ );
					} else {
						# insert edits count
						$conditions['ce_count'] = $inc;
						$dbw->insert( 'category_edits', $conditions, __METHOD__ );
					}

					$user_conditions = array( 'cue_user_id' => $this->mUserId, 'cue_cat_id' => $oRow->cat_id );
					$Row = $dbr->selectRow ( 'category_user_edits', array('cue_count'), $user_conditions, __METHOD__ );
					if ( $Row ) {
						# update edits count
						$count = $Row->cue_count + $inc;
						$dbw->update( 'category_user_edits', array( 'cue_count' => $count ), $user_conditions, __METHOD__ );
					} else {
						# insert edits count
						$user_conditions['cue_count'] = $inc;
						$dbw->insert( 'category_user_edits', $user_conditions, __METHOD__ );
					}
					
					$return++;
				}
				$dbr->freeResult($res);
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
				'rev_deleted'	=> 0,
				'rev_user > 0'
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
		wfProfileIn( __METHOD__ );

		$return = 0;
		$user_pages = array();
		$dbr = wfGetDB( DB_SLAVE );
		$res = $dbr->select( 
			'category_edits', 
			array( 'ce_user_id as user_id', 'ce_cat_id as cat_id', 'count(ce_user_id) as cnt' ), 
			array( 'ce_page_id' => $this->mPageId ),
			__METHOD__,
			array( 'GROUP BY' => 'ce_user_id, ce_cat_id' )
		);
		
		if ( $dbr->numRows($res) ) { 
			while( $oRow = $dbr->fetchObject($res) ) {
				$user_pages[$oRow->user_id][$oRow->cat_id] = intval($oRow->cnt);
			}
			$dbr->freeResult($res);
		}
		
		$dbw = wfGetDB( DB_MASTER );
		if ( count($user_pages) > 0 ) {
			foreach($user_pages as $user_id => $cats) {
				if ( !empty($cats) ) {
					foreach($cats as $cat_id => $count) {
						$dbw->update( 
							'category_user_edits', 
							array( "cue_count = cue_count - $count" ), 
							array( 
								'cue_user_id' => $user_id,
								'cue_cat_id' => $cat_id
							),
							__METHOD__ 
						);
						$return += $count;
					}
				}
			};
		}
		$dbw->delete( 'category_edits', array( 'ce_page_id' => $this->mPageId ), __METHOD__ );
		
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
			$oEdits = new CategoryTrigger($Title, $User);
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
			$oEdits = new CategoryTrigger($Title, $User, $articleId);
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
				$oEdits = new CategoryTrigger($Title, $User);
				$oEdits->increaseRevision( );
			}
		}
		wfProfileOut( __METHOD__ );
		return true;
	}
}

class CategoryEdits {
	private 
		$mCatId,
		$mCatName,
		$mCatPageCount,
		$mPercent,
		$mCatSubcatCount;
	
	/**
	 * initialization
	 * 
	 * @access public
	 *
	 * @param String or Integer $cat,
	 */
	private function __construct( Category $Cat ) {
		$this->mCatId = $Cat->getID(); 
		$this->mCatName = $Cat->getName();
		$this->mCatPageCount = $Cat->getPageCount();
		$this->mCatSubcatCount = $Cat->getSubcatCount();
		$this->mPercent = 0;
	}
	
	/**
	 * newFromId 
	 * 
	 * @access public
	 *
	 * @param Integer $catid 
	 */

	public function newFromId($catid) {
		$cat = Category::newFromID($catid);
		return new CategoryEdits($cat);
	}

	/**
	 * newFromName
	 * 
	 * @access public
	 *
	 * @param Integer $catid 
	 */

	public function newFromName($catname) {
		$Cat = Category::newFromName($catname);
		return new CategoryEdits($Cat);
	}

	/**
	 * getPercent 
	 * 
	 * @access public
	 *
	 * @param Integer $incat - percent of pages in other ($incat) category
	 */
	
	public function getPercent($incat) {
		global $wgMemc;
		wfProfileIn( __METHOD__ );
		
		if ( is_int($incat) ) {
			# integer
			$CatIn = Category::newFromID($incat);
		} else {
			# integer
			$CatIn = Category::newFromName($incat);
		}
		
		if ( is_object( $CatIn ) && !empty( $this->mCatPageCount ) ) {
			$memkey = $this->getPercentMemcKey($CatIn);
			$data = $wgMemc->get( $memkey );
			
			if ( empty($data) ) {
				$dbr = wfGetDB( DB_SLAVE );
				$Row = $dbr->selectRow ( 
					array( 'categorylinks AS c1', 'categorylinks AS c2' ),
					array( 'count(c2.cl_to) as cnt' ),
					array(
						'c2.cl_to' => $this->mCatName
					),
					__METHOD__,
					"",
					array(
						'categorylinks AS c2' => array(
							'JOIN', 
							implode ( ' AND ', 
								array( 
									'c1.cl_from = c2.cl_from',
									'c1.cl_to = ' . $dbr->addQuotes($CatIn->getName())
								)
							)
						)
					)
				);
				if ( $Row ) {
					$data = intval($Row->cnt);
					$wgMemc->set( $memkey , $data, 60*5 );
				}
			}
			# calculate percent
			$this->mPercent = wfPercent( ($data * 100)/$this->mCatPageCount, 2 );
		}

		wfProfileOut( __METHOD__ );
		return $this->mPercent;
	}
	
	/**
	 * Return the memcache key for the caching of the percentage-complete
	 * of the given category.
	 */
	function getPercentMemcKey($CatIn){
		return wfMemcKey( 'percent', $this->mCatId, $CatIn->getID() );
	}

	/**
	 * Purge the memcache storage of the percentage-complete for the category
	 * whose name or id is provided in $incat.
	 *
	 * This allows the GUI to keep the percentage-bar fresh when it is known
	 * that there has been a change.
	 */
	function purgePercentInCat($incat){
		global $wgMemc;
		if ( is_int($incat) ) {
			# integer
			$CatIn = Category::newFromID($incat);
		} else {
			# integer
			$CatIn = Category::newFromName($incat);
		}
		$memkey = $this->getPercentMemcKey($CatIn);
		$wgMemc->delete($memkey);
	}

	/**
	 * getPercentInCats
	 * 
	 * @access public
	 *
	 * @param Integer $cat1 - first category (id/name)
	 * @param Integer $cat2 - second category (id/name)
	 */
	
	public function getPercentInCats($cat1, $cat2) {
		global $wgMemc;
		wfProfileIn( __METHOD__ );

		$firstCount = $secCount = 0;
		$return = 0;
		if ( is_int($cat1) ) { # id(?)
			$CatFirst = Category::newFromID($cat1);
		} else { # name
			$CatFirst = Category::newFromName($cat1);
		}
		
		if ( !is_object( $CatFirst ) ) {
			wfProfileOut( __METHOD__ );
			return $return;
		}
		
		if ( is_int($cat2) ) { # id(?)
			$CatSec = Category::newFromID($cat2);
		} else { # name
			$CatSec = Category::newFromName($cat2);
		}

		if ( !is_object( $CatSec ) ) {
			$return = 100;
			wfProfileOut( __METHOD__ );
			return $return;
		}

		$memkey = $this->getPercentInCatsMemcKey($CatFirst, $CatSec);
		$return = $wgMemc->get( $memkey );
			
		if ( empty($return) ) {
			$dbr = wfGetDB( DB_SLAVE );
			$Row = $dbr->selectRow ( 
				array( 'categorylinks AS c1', 'categorylinks AS c2' ),
				array( 'count(c2.cl_to) as cnt' ),
				array(
					'c2.cl_to' => $this->mCatName
				),
				__METHOD__,
				"",
				array(
					'categorylinks AS c2' => array(
						'JOIN', 
						implode ( ' AND ', 
							array( 
								'c1.cl_from = c2.cl_from',
								'c1.cl_to = ' . $dbr->addQuotes($CatFirst->getName())
							)
						)
					)
				)
			);
			$firstCount = ( $Row ) ? intval($Row->cnt) : 0;

			# second category
			$Row = $dbr->selectRow ( 
				array( 'categorylinks AS c1', 'categorylinks AS c2' ),
				array( 'count(c2.cl_to) as cnt' ),
				array(
					'c2.cl_to' => $this->mCatName
				),
				__METHOD__,
				"",
				array(
					'categorylinks AS c2' => array(
						'JOIN', 
						implode ( ' AND ', 
							array( 
								'c1.cl_from = c2.cl_from',
								'c1.cl_to = ' . $dbr->addQuotes($CatSec->getName())
							)
						)
					)
				)
			);
			$secCount = ( $Row ) ? intval($Row->cnt) : 0;
			
			$sum = $secCount + $firstCount;
			if ( $sum > 0 ) {
				$return = array(
					round( ($firstCount * 100)/$sum ),
					$firstCount,
					$secCount
				);
				$wgMemc->set( $memkey , $return, 60*5 );
			} else {
				$return = array(
					0,
					$firstCount,
					$secCount
				);
			}
		}


		wfProfileOut( __METHOD__ );
		return $return;
	}

	/**
	 * Returns the memcache key for the cache for getPercentInCats (intersection of one category into
	 * each of two other categories).
	 */
	function getPercentInCatsMemcKey($CatFirst, $CatSec){
		return wfMemcKey( 'percentcats', $this->mCatId, $CatFirst->getId(), $CatSec->getId() );
	} // end getPercentInCatsMemcKey()

	/**
	 * Purges the memcached value for intersection of this category with each of two others.
	 * That cached value is used in getPercentInCats().
	 *
	 * @access public
	 *
	 * @param Integer $cat1 - first category (id/name)
	 * @param Integer $cat2 - second category (id/name)
	 */
	public function purgePercentInCats($cat1, $cat2){
		wfProfileIn( __METHOD__ );

		if ( is_int($cat1) ) { # id(?)
			$CatFirst = Category::newFromID($cat1);
		} else { # name
			$CatFirst = Category::newFromName($cat1);
		}
		
		if ( !is_object( $CatFirst ) ) {
			wfProfileOut( __METHOD__ );
			return;
		}
		
		if ( is_int($cat2) ) { # id(?)
			$CatSec = Category::newFromID($cat2);
		} else { # name
			$CatSec = Category::newFromName($cat2);
		}

		if ( !is_object( $CatSec ) ) {
			wfProfileOut( __METHOD__ );
			return;
		}

		global $wgMemc;
		$memkey = $this->getPercentInCatsMemcKey($CatFirst, $CatSec);
		$wgMemc->delete($memkey);

		wfProfileOut( __METHOD__ );
	} // end purgePercentInCats()
	
	/**
	 * getPages
	 * 
	 * @access public
	 *
	 * @param Integer $incat - pages in $incat category
	 * @param Array $namespaces - IDs of NS (all namespace if empty)
	 * @param Integer $limit - the maximum number of desired results to return... the real maximum will
	 *                         be one higher.  This allows the caller to tell if they need a "Next" link.
	 * @param Integer $offset
	 */
	public function getPages($incat, $namespaces = array(), $limit = 30, $offset = 0) {
		global $wgMemc;
		wfProfileIn( __METHOD__ );
		
		$pages = $result = array();
		if ( is_int($incat) ) {
			# integer
			$CatIn = Category::newFromID($incat);
		} else {
			$CatIn = Category::newFromName($incat);
		}
		
		if ( is_object( $CatIn ) && !empty( $this->mCatPageCount ) ) {
			$dbr = wfGetDB( DB_SLAVE );
			
			$nsPaces = (!empty($namespaces)) ? $dbr->makeList( $namespaces ) : "";
			$memkey = $this->getPagesMemcKey($CatIn, $namespaces); // intentionally raw namespaces here, not nsPaces
			$pages = $wgMemc->get( $memkey );
			
			$conditional = array(
				'page_id = rev_page',
				'page_latest = rev_id',
				'page_is_redirect = 0',
				'c2.cl_to' => $this->mCatName
			);
			if ($nsPaces != "") {
				$conditional[] = 'page_namespace in (' . $nsPaces . ')';
			}

			if ( empty($pages) ) {
				$res = $dbr->select ( 
					array( 'revision', 'page', 'categorylinks AS c1', 'categorylinks AS c2' ),
					array( 'rev_page, rev_timestamp, page_title, page_namespace' ),
					$conditional,
					__METHOD__,	
					"",
					array(
						'categorylinks AS c1' => array(
							'JOIN', 
							'c1.cl_from = page_id',
						),
						'categorylinks AS c2' => array(
							'JOIN', 
							implode ( ' AND ', 
								array( 
									'c1.cl_from = c2.cl_from',
									'c1.cl_to = ' . $dbr->addQuotes($CatIn->getName())
								)
							)
						)
					)
				);

				if ( $dbr->numRows($res) ) { 
					$pages = array();
					while( $oRow = $dbr->fetchObject($res) ) {
						$pages[$oRow->rev_timestamp] = array(
							'id' => $oRow->rev_page, 
							'title' => $oRow->page_title, 
							'ns' => $oRow->page_namespace
						);
					}
					$dbr->freeResult($res);
					$wgMemc->set( $memkey, $pages, 60*30 );
				}
			} 
			
			/* sort results and slice array */
			if ( !empty($pages) && is_array($pages) ) {
				krsort($pages); 
				$result = array_slice($pages, $offset, $limit + 1, true);
			}
		}

		wfProfileOut( __METHOD__ );
		return $result;
	}

	/**
	 * Returns the memcache key for the collection of pages in the given category.
	 *
	 * @param Category $CatIn - Category whose pages this is for
	 * @param Array $namespaces - IDs of NS (all namespace if empty)
	 */
	function getPagesMemcKey($CatIn, $namespaces = array()){
		wfProfileIn( __METHOD__ );
		$retVal = "";

		if ( is_object( $CatIn ) && !empty( $this->mCatPageCount ) ) {
			if(!empty($namespaces)){
				$dbr = wfGetDB( DB_SLAVE );
				$nsPaces = $dbr->makeList( $namespaces );
			} else {
				$nsPaces = "";
			}

			$retVal = wfMemcKey( 'cepages', $this->mCatId, $CatIn->getID(), md5($nsPaces) );
		}

		wfProfileOut( __METHOD__ );
		return $retVal;
	} // end getPagesMemcKey()

	/**
	 * Purges the memcached value of pages in the incat category.
	 *
	 * @access public
	 *
	 * @param Integer $incat - pages in $incat category (may be id or name).
	 */
	public function purgePagesInCat($incat){
		if ( is_int($incat) ) {
			$CatIn = Category::newFromID($incat);
		} else {
			$CatIn = Category::newFromName($incat);
		}
		$memkey = $this->getPagesMemcKey($CatIn);

		global $wgMemc;
		$wgMemc->delete($memkey);
	} // end purgePagesInCat()

	/**
	 * getContribs - list of contributors to category
	 * 
	 * @access public
	 *
	 * @param Boolean $show_staff - show staff users on list
	 * @param Integer $limit,
	 * @param Integer $offset,
	 * 
	 */
	public function getContribs($show_staff = true, $limit = 30, $offset = 0) {
		global $wgMemc;
		wfProfileIn( __METHOD__ );

		$memkey = wfMemcKey( 'contribs', $this->mCatId, intval($show_staff), $limit, $offset );
		$users = $wgMemc->get( $memkey );
		
		if ( empty($users) ) {
			$group_cond = "ug_group = 'bot'";
			if ( empty($show_staff) ) {
				$group_cond = "ug_group in ('bot', 'staff')";
			}
			
			$dbr = wfGetDB( DB_SLAVE );
			$res = $dbr->select ( 
				array( 'category_user_edits', 'user_groups' ),
				array( 'cue_user_id as user_id, cue_count as cnt' ),
				array( 
					'cue_cat_id' => $this->mCatId,
					'ug_user is null'
				),
				__METHOD__,
				array( 
					'ORDER BY' => 'cue_count DESC',
					'LIMIT' => $limit,
					'OFFSET' => $offset * $limit
				),
				array(
					'user_groups' => array( 'LEFT JOIN', 
						implode ( ' AND ', 
							array(
								"cue_user_id = ug_user",
								$group_cond
							)
						)
					)
				)
			);
			if ( $dbr->numRows($res) ) { 
				$users = array();
				while( $oRow = $dbr->fetchObject($res) ) {
					$users[$oRow->user_id] = $oRow->cnt;
				}
				$dbr->freeResult($res);
				$wgMemc->set( $memkey, $users, 60*2 );
			}
		}
		
		wfProfileOut( __METHOD__ );
		return $users;
	}


	/**
	 * getXDayContribs - list of contributors to category in the last X days
	 * 
	 * @access public
	 *
	 * @param Integer $days,
	 * @param Boolean $show_staff - show staff users on list
	 * @param Integer $limit,
	 * @param Integer $offset,
	 * 
	 */
	public function getXDayContribs($days = 7, $show_staff = true, $limit = 30, $offset = 0) {
		global $wgMemc;
		wfProfileIn( __METHOD__ );

		$memkey = wfMemcKey( 'xdayscontribs', $this->mCatId, intval($show_staff), $days, $limit, $offset );
		$users = $wgMemc->get( $memkey );
		
		if ( empty($users) ) {
			$group_cond = "ug_group = 'bot'";
			if ( empty($show_staff) ) {
				$group_cond = "ug_group in ('bot', 'staff')";
			}
			$min_date = date('Y-m-d', time() - $days * 24 * 60 * 60);
			$dbr = wfGetDB( DB_SLAVE );
			$res = $dbr->select ( 
				array( 'category_edits', 'user_groups' ),
				array( 'ce_user_id as user_id, ce_count as cnt' ),
				array( 
					"ce_cat_id" => $this->mCatId,
					"ug_user is null",
					"ce_date >= '$min_date'"
				),
				__METHOD__,
				"",
				array(
					'user_groups' => array( 'LEFT JOIN', 
						implode ( ' AND ', 
							array(
								"ce_user_id = ug_user",
								$group_cond
							)
						)
					)
				)
			);
			
			if ( $dbr->numRows($res) ) {
				$users = $tmp = array();
				while( $oRow = $dbr->fetchObject($res) ) {
					if ( !isset($tmp[$oRow->user_id]) ) {
						$tmp[$oRow->user_id] = 0;
					}
					$tmp[$oRow->user_id] += $oRow->cnt;
				}
				$dbr->freeResult($res);
				if ( count($tmp) > 0 ) { 
					arsort($tmp); 
					$users = array_slice($tmp, $limit * $offset, $limit, true);
				}
				$wgMemc->set( $memkey, $users, 60*15 );
			}
		}
		
		wfProfileOut( __METHOD__ );
		return $users;
	}

	/**
	 * getMostEdited - list of most edited pages in category
	 * 
	 * @access public
	 *
	 * @param Integer $incat - percent of pages in $incat category
	 * @param Array $namespaces - IDs of NS (all namespace if empty)
	 * @param Integer $limit 
	 * @param Integer $offset
	 * 
	 */
	public function getMostEdited($incat, $namespaces = array(), $limit = 30, $offset = 0) {
		global $wgMemc;
		wfProfileIn( __METHOD__ );

		$pages = array();
		if ( is_int($incat) ) {
			# integer
			$CatIn = Category::newFromID($incat);
		} else {
			# integer
			$CatIn = Category::newFromName($incat);
		}
		
		if ( is_object( $CatIn ) && !empty( $this->mCatPageCount ) ) {
			$dbr = wfGetDB( DB_SLAVE );
			$catId = $CatIn->getID();
			$nsPaces = (!empty($namespaces)) ? $dbr->makeList( $namespaces ) : "";
			$memkey = wfMemcKey( 'pages', $this->mCatId, $catId, md5($nsPaces), $limit, $offset );
			$pages = $wgMemc->get( $memkey );
			
			if ( empty($pages) ) {
				$res = $dbr->select ( 
					array( 'category_edits', 'page' ),
					array( 'ce_page_id as id, page_title as title, ce_page_ns as namespace, sum(ce_count) as edits' ),
					array( 
						sprintf('ce_page_id in (select ce_page_id from category_edits where ce_cat_id = %d)', intval( $catId ) ),
						'ce_cat_id' => $this->mCatId,
						'page_is_redirect' => 0
					),
					__METHOD__,
					array( 
						'GROUP BY' => 'ce_page_id',
					)
				);
				if ( $dbr->numRows($res) ) {
					$pages = $tmp = array();
					while( $oRow = $dbr->fetchObject($res) ) {
						$tmp[$oRow->edits][$oRow->ce_page_id] = array(
							'id' 		=> $oRow->id,
							'title' 	=> $oRow->title,
							'namespace' => $oRow->namespace,
							'edits'		=> $oRow->edits
						);
					}
					$dbr->freeResult($res);
					if ( count($tmp) > 0 ) { 
						$a = 0; krsort($tmp); 
						foreach ( $tmp as $key => $p ) {
							if ( ( $a >= $offset ) && ( $a - $offset < $limit ) ) {
								list ( , $pages[] ) = each( $p );
							}
						}
						$wgMemc->set( $memkey, $pages, 60*10 );
					}
				}
			}
		}
		
		wfProfileOut( __METHOD__ );
		return $pages;
	}

	/**
	 * getSubcategories - get all subcategories of the currently configured category.
	 * 
	 * @access public
	 * @param Array $categories - array into which the subcategories will be added as
	 *                            key/value pairs where the category id is the key and the
	 *                            category title is the value.  If the key is already set in
	 *                            the <code>categories</code> array, the value will NOT be changed.
	 * @return Array a mapping from category.cat_id to category.cat_title of the subcategories of the
	 *               currently configured category.
	 */
	public function getSubcategories( &$categories ) {
		global $wgMemc;
		wfProfileIn( __METHOD__ );

		$cats = array();
		if ( $this->mCatSubcatCount > 0 ) {
			$dbr = wfGetDB( DB_SLAVE );
			$memkey = wfMemcKey( 'subcats', $this->mCatId );
			$cats = $wgMemc->get( $memkey );
			if ( empty($cats) ) {
				$res = $dbr->select ( 
					array( 'page as cat', 'categorylinks', 'category' ),
					array( 'cat_id, cat_title, cat_subcats' ),
					array( 
						'cl_to' => $this->mCatName,
						'cat.page_namespace' => NS_CATEGORY
					),
					__METHOD__,
					"",
					array(
						'categorylinks' => array( 'JOIN', 'cl_from = cat.page_id' ),
						'category' => array( 'LEFT JOIN', 
							implode ( ' AND ', 
								array(
									'cat_title = page_title',
									'page_namespace = ' . NS_CATEGORY
								)
							)
						)
					)
				);
				if ( $dbr->numRows($res) ) {
					$cats = array();
					while( $oRow = $dbr->fetchObject($res) ) {
						if ( !empty( $oRow->cat_id ) && !empty($oRow->cat_title) ) { 
							$cats[ $oRow->cat_id ] = array(
								$oRow->cat_subcats,
								$oRow->cat_title
							);
						}
					}
					$dbr->freeResult($res);
					$wgMemc->set( $memkey, $cats, 60*10 );
				}
			} 
			
			if ( !empty($cats) ) {
				foreach ( $cats as $cat_id => $values ) {
					list( $subcats, $catTitle ) = $values;
					if ( !isset($categories[$cat_id]) ) {
						$categories[$cat_id] = $catTitle;
						/* full tree is not needed now, first level is enough
						if ( $subcats > 0 ) {
							$oCat = self::newFromId($cat_id);
							if ( $oCat ) {
								$oCat->getSubcategories($categories);
							}
						}
						*/
					}
				}
			}
		}

		wfProfileOut( __METHOD__ );
		return $cats;
	}

        /**
         * getPageCount
         *
         * @access public
         *
         *
         */

        public function getPageCount() {
                return $this->mCatPageCount;
        }

}
