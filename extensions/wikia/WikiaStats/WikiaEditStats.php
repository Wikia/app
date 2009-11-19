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
$wgHooks['ArticleSaveComplete'][] = "WikiaEditStats::saveComplete";
$wgHooks['ArticleDeleteComplete'][] = "WikiaEditStats::deleteComplete";
$wgHooks['UndeleteComplete'][] = "WikiaEditStats::undeleteComplete";

class WikiaEditStats {
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
		#error_log ( $select . " => " . $res );
		
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
					error_log(print_r($conditions, true));

					$Row = $dbr->selectRow ( 
						'category_edits',
						array('ce_count'),
						$conditions,
						__METHOD__
					);
					if ( $Row ) {
						# update edits count
						$count = $Row->ce_count + $inc;
						$dbw->update( 
							'category_edits',
							array( /* SET */
								'ce_count' 	=> $count,
								'ce_ts'		=> wfTimestamp( TS_DB )
							),
							$conditions,
							__METHOD__ );
					} else {
						# insert edits count
						$conditions['ce_count'] = $inc;
						$dbw->insert(
							'category_edits',
							$conditions,
							__METHOD__ 
						);
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
		$dbw = wfGetDB( DB_MASTER );
		$dbw->delete( 'category_edits',
			array( 
				'ce_page_id' => $this->mPageId
			), 
			__METHOD__ 
		);
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
			$oEdits = new WikiaEditStats($Title, $User);
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
			$oEdits = new WikiaEditStats($Title, $User, $articleId);
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
				$oEdits = new WikiaEditStats($Title, $User);
				$oEdits->increaseRevision( );
			}
		}
		wfProfileOut( __METHOD__ );
		return true;
	}
}

/*
CREATE TABLE `category_edits` (
  `ce_cat_id` int(10) unsigned NOT NULL,
  `ce_page_id` int(8) unsigned NOT NULL,
  `ce_page_ns` int(6) unsigned NOT NULL,
  `ce_user_id` int(10) unsigned NOT NULL,
  `ce_date` DATE NOT NULL,
  `ce_ts` TIMESTAMP NOT NULL default CURRENT_TIMESTAMP,
  `ce_count` int(10) unsigned NOT NULL,
  PRIMARY KEY (`ce_cat_id`,`ce_page_id`,`ce_page_ns`,`ce_user_id`,`ce_date`),
  KEY `cat_date` (`ce_cat_id`, `ce_date`),
  KEY `cat_user_date` (`ce_cat_id`, `ce_date`, `ce_user_id`),
  KEY `cat_ts` (`ce_cat_id`, `ce_ts`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1

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
					UPDATE ce_count = ce_count + __inc__, ce_ts = values(ce_ts);
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
