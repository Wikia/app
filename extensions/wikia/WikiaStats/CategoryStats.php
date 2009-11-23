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
		$mPercent;
	
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
			$memkey = wfMemcKey( 'percent', $this->mCatId, $CatIn->getID() );
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
					$wgMemc->set( $memkey , $data, 60*60 );
				}
			}
			# calculate percent
			$this->mPercent = wfPercent( ($data * 100)/$this->mCatPageCount, 2 );
		}

		wfProfileOut( __METHOD__ );
		return $this->mPercent;
	}
	
	/**
	 * getPages
	 * 
	 * @access public
	 *
	 * @param Integer $incat - percent of pages in $incat category
	 */
	public function getPages($incat) {
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
			$memkey = wfMemcKey( 'pages', $this->mCatId, $CatIn->getID() );
			$pages = $wgMemc->get( $memkey );
			
			if ( empty($pages) ) {
				$dbr = wfGetDB( DB_SLAVE );
				$res = $dbr->select ( 
					array( 'categorylinks AS c1', 'categorylinks AS c2' ),
					array( 'c2.cl_from as page_id' ),
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
				if ( $dbr->numRows($res) ) { 
					$pages = array();
					while( $oRow = $dbr->fetchObject($res) ) {
						$pages[] = $oRow->page_id;
					}
					$dbr->freeResult($res);
					$wgMemc->set( $memkey, $pages, 60*5 );
				}
			}
		}

		wfProfileOut( __METHOD__ );
		return $pages;
	}
	
	/**
	 * getContribs - list of contributors to category
	 * 
	 * @access public
	 *
	 * @param Integer $limit,
	 * @param Integer $offset,
	 * 
	 */
	public function getContribs($limit = 30, $offset = 0) {
		global $wgMemc;
		wfProfileIn( __METHOD__ );

		$memkey = wfMemcKey( 'contribs', $this->mCatId, $limit, $offset );
		$users = $wgMemc->get( $memkey );
		
		if ( empty($users) ) {
			$dbr = wfGetDB( DB_SLAVE );
			$res = $dbr->select ( 
				array( 'category_user_edits' ),
				array( 'cue_user_id as user_id, cue_count as cnt' ),
				array( 'cue_cat_id' => $this->mCatId ),
				__METHOD__,
				array( 
					'ORDER BY' => 'cue_count DESC',
					'LIMIT' => $limit + 1,
					'OFFSET' => $offset * $limit
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
	 * @param Integer $limit,
	 * @param Integer $offset,
	 * 
	 */
	public function getXDayContribs($days = 7, $limit = 30, $offset = 0) {
		global $wgMemc;
		wfProfileIn( __METHOD__ );

		$memkey = wfMemcKey( 'xdayscontribs', $this->mCatId, $days, $limit, $offset );
		$users = $wgMemc->get( $memkey );
		
		if ( empty($users) ) {
			$dbr = wfGetDB( DB_SLAVE );
			$res = $dbr->select ( 
				array( 'category_user_edits' ),
				array( 'ce_user_id as user_id, sum(ce_count) as cnt' ),
				array( 'cue_cat_id' => $this->mCatId ),
				__METHOD__,
				array( 
					'GROUP BY' => 'ce_user_id',
					'USE INDEX' => 'cat_user'
				)
			);
			if ( $dbr->numRows($res) ) { 
				$users = $tmp = array();
				while( $oRow = $dbr->fetchObject($res) ) {
					$tmp[$oRow->user_id] = $oRow->cnt;
				}
				$dbr->freeResult($res);
				if ( count($tmp) > 0 ) { 
					arsort($tmp); 
					$users = array_slice($tmp, $limit * $offset, $offset, true);
				}
				$wgMemc->set( $memkey, $users, 60*30 );
			}
		}
		
		wfProfileOut( __METHOD__ );
		return $users;
	}
}


/*
CREATE TABLE `category_edits` (
  `ce_cat_id` int(10) unsigned NOT NULL,
  `ce_page_id` int(8) unsigned NOT NULL,
  `ce_page_ns` int(6) unsigned NOT NULL,
  `ce_user_id` int(10) unsigned NOT NULL,
  `ce_date` DATE NOT NULL,
  `ce_count` int(10) unsigned NOT NULL,
  PRIMARY KEY (`ce_cat_id`,`ce_page_id`,`ce_page_ns`,`ce_user_id`,`ce_date`),
  KEY `cat_date` (`ce_cat_id`, `ce_date`),
  KEY `cat_user_date` (`ce_cat_id`, `ce_date`, `ce_user_id`),
  KEY `cat_page_date` (`ce_cat_id`,`ce_page_id`,`ce_count`,`ce_date`),
  KEY `cat_user` (`ce_cat_id`,`ce_user_id`),
  KEY `user_pages` (`ce_page_id`,`ce_user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `category_user_edits` (
  `cue_cat_id` int(10) unsigned NOT NULL,
  `cue_user_id` int(10) unsigned NOT NULL,
  `cue_count` int(10) unsigned NOT NULL,
  PRIMARY KEY (`cue_cat_id`,`cue_user_id`),
  KEY (`cue_user_id`, `cue_count`),
  KEY (`cue_cat_id`,`cue_count`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

DROP FUNCTION IF EXISTS category_edits_inc;
CREATE FUNCTION category_edits_inc( __pageid__ INTEGER, __page_ns__ SMALLINT, __userid__ INTEGER, __inc__ INTEGER ) RETURNS INTEGER
BEGIN
	DECLARE __done__ INT DEFAULT 0;
	DECLARE __catid__ INT DEFAULT 0;
	DECLARE __date__ DATE DEFAULT CAST(now() AS DATE);
	DECLARE __rows__ INT DEFAULT 0;

	DECLARE CUR_CATEGORY CURSOR FOR 
		SELECT cat_id FROM categorylinks, category 
		WHERE cl_to = cat_title and cl_from = __pageid__;
	DECLARE CONTINUE HANDLER FOR NOT FOUND SET __done__ = 1;

	OPEN CUR_CATEGORY;
		REPEAT
    		FETCH CUR_CATEGORY INTO __catid__;
			IF NOT __done__ THEN
				SET __rows__ = __rows__ + 1;
				INSERT INTO category_edits 
					(ce_cat_id, ce_page_id, ce_page_ns, ce_user_id, ce_date, ce_count) 
				VALUES 
					(__catid__, __pageid__, __page_ns__, __userid__, __date__, __inc__)
				ON DUPLICATE KEY 
					UPDATE ce_count = ce_count + __inc__;
			END IF;
		UNTIL __done__ END REPEAT;
	CLOSE CUR_CATEGORY;
	
	RETURN __rows__;
END;

DROP FUNCTION IF EXISTS category_edits_rev_inc;
CREATE FUNCTION category_edits_rev_inc( __pageid__ INTEGER, __page_ns__ SMALLINT ) RETURNS INTEGER
BEGIN
	DECLARE __done__ INT DEFAULT 0;
	DECLARE __userid__ INT DEFAULT 0;
	DECLARE __rows__ INT DEFAULT 0;
	DECLARE __rowsinc__ INT DEFAULT 0;

	DECLARE CUR_REVISION CURSOR FOR 
		SELECT rev_user FROM revision where rev_page = __pageid__ and rev_deleted = 0 and rev_user > 0;
	DECLARE CONTINUE HANDLER FOR NOT FOUND SET __done__ = 1;

	OPEN CUR_REVISION;
		REPEAT
    		FETCH CUR_REVISION INTO __userid__;
			IF NOT __done__ THEN
				SELECT category_edits_inc( __pageid__, __page_ns__, __userid__, 1 ) INTO __rowsinc__;
				SET __rows__ = __rows__ + __rowsinc__;
			END IF;
		UNTIL __done__ END REPEAT;
	CLOSE CUR_REVISION;
	
	RETURN __rows__;
END;

*/
