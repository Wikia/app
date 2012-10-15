<?php

class ReaderFeedback {
	protected static $feedbackTags = array();
	protected static $feedbackTagWeight = array();
	protected static $loaded = false;

	public static function load() {
		global $wgFeedbackTags;
		if( self::$loaded ) return true;
		foreach( $wgFeedbackTags as $tag => $weight ) {
			# Tag names used as part of file names. "Overall" tag is a
			# weighted aggregate, so it cannot be used either.
			if( !preg_match('/^[a-zA-Z]{1,20}$/',$tag) || $tag === 'overall' ) {
				throw new MWException( 'ReaderFeedback given invalid tag name!' );
			}
			self::$feedbackTagWeight[$tag] = $weight;
			for( $i=0; $i <= 4; $i++ ) {
				self::$feedbackTags[$tag][$i] = "feedback-{$tag}-{$i}";
			}
		}
		self::$loaded = true;
	}
	
	################# Basic accessors #################
	
	/**
	 * Get the array of tag feedback tags
	 * @return array
	 */
	public static function getFeedbackTags() {
		self::load();
		return self::$feedbackTags;
	}
	
	/**
	 * Get the weight of a feedback tag
	 * @param string $tag
	 * @return array
	 */
	public static function getFeedbackWeight( $tag ) {
		self::load();
		return self::$feedbackTagWeight[$tag];
	}

	/**
	 * Get the number of reviews that is considered a good sample
	 * @return int
	 */	
	public static function getFeedbackSize() {
		global $wgFeedbackSizeThreshhold;
		return (int)$wgFeedbackSizeThreshhold;
	}
	
	################# Utility functions #################

	/**
	 * @param Article $article
	 * @param string $tag
	 * @param bool $forUpdate, use master?
	 * @return array(real,int)
	 * Get article rating for this tag for the last few days
	 */
	public static function getAverageRating( $article, $tag, $forUpdate=false ) {
		global $wgFeedbackAge;
		$db = $forUpdate ? wfGetDB( DB_MASTER ) : wfGetDB( DB_SLAVE );
		$cutoff_unixtime = time() - $wgFeedbackAge;
		// rfh_date is always MW format on all dbms
		$encCutoff = $db->addQuotes( wfTimestamp( TS_MW, $cutoff_unixtime ) );
		$row = $db->selectRow( 'reader_feedback_history', 
			array('SUM(rfh_total)/SUM(rfh_count) AS ave, SUM(rfh_count) AS count'),
			array( 'rfh_page_id' => $article->getId(), 'rfh_tag' => $tag,
				"rfh_date >= {$encCutoff}" ),
			__METHOD__ );
		$data = $row && $row->count ?
			array($row->ave,$row->count) : array(0,0);
		return $data;
	}
	
	/**
	 * Purge outdated page average data
	 * @return bool
	 */	
	public static function purgeExpiredAverages() {
		global $wgFeedbackAge;
		$dbw = wfGetDB( DB_MASTER );
		$cutoff = $dbw->addQuotes( $dbw->timestamp( time() - $wgFeedbackAge ) );
		$dbw->delete( 'reader_feedback_pages', array("rfp_touched < $cutoff"), __METHOD__ );
		return ( $dbw->affectedRows() != 0 );
	}
	
	/**
	* Is this page in rateable namespace?
	* @param Title, $title
	* @return bool
	*/
	public static function isPageRateable( $title ) {
		global $wgFeedbackNamespaces;
		# FIXME: Treat NS_MEDIA as NS_FILE
		$ns = ( $title->getNamespace() == NS_MEDIA ) ? NS_FILE : $title->getNamespace();
		# Check for MW: pages and whitelist for exempt pages
		if( $ns == NS_MEDIAWIKI ) {
			return false;
		}
		return ( in_array($ns,$wgFeedbackNamespaces) && !$title->isTalkPage() );
	}
	
   	/**
	* Expand feedback ratings into an array
	* @param string $ratings
	* @return Array
	*/
	public static function expandRatings( $rating ) {
		$dims = array();
		$pairs = explode( "\n", $rating );
		foreach( $pairs as $pair ) {
			if( strpos($pair,'=') ) {
				list($tag,$value) = explode( '=', trim($pair), 2 );
				$dims[$tag] = intval($value);
			}
		}
		return $dims;
	}
	
   	/**
	* Get a table of the vote totals for a page
	* @param Title $page
	* @param int $period, number of days back
	* @param array $add, optional vote to add on (used to visually avoid lag)
	* @param string $cache, optional param to not use cache
	* @return string HTML table
	*/	
	public static function getVoteAggregates(
		$page, $period, $add = array(), $cache = 'useCache'
	) {
		global $wgLang, $wgMemc;
		$votes = null;
		$now = time();
		$key = wfMemcKey( 'feedback', 'ratingtally', $page->getArticleId(), $period );
		// Check cache
		if( $cache == 'useCache' ) {
			$set = $wgMemc->get($key);
			// Cutoff is at the 24 hour mark due to the way the aggregate 
			// schema groups ratings by date for graphs.
			$cache_cutoff = $now - ($now % 86400);
			if( is_array($set) && count($set) == 2 ) {
				list($val,$time) = $set;
				$touched = wfTimestamp( TS_UNIX, RatingHistory::getTouched($page) );
				if( $time > $cache_cutoff && $time > $touched ) {
					$votes = $val;
				}
			}
		}
		// Do query, cache miss
		if( !isset($votes) ) {
			// Set cutoff time for period
			$dbr = wfGetDB( DB_SLAVE );
			$cutoff_unixtime = $now - ($period * 24 * 3600);
			// Use integral number of days to be consistent with graphs
			$cutoff_unixtime = $cutoff_unixtime - ($cutoff_unixtime % 86400);
			$cutoff = $dbr->addQuotes( $dbr->timestamp( $cutoff_unixtime ) );
			// Get the first revision possibly voted on in the range
			$firstRevTS = $dbr->selectField( 'revision',
				'rev_timestamp',
				array( 'rev_page' => $page->getArticleId(), "rev_timestamp <= $cutoff" ),
				__METHOD__,
				array( 'ORDER BY' => 'rev_timestamp DESC' )
			);
			// Find average, median...
			$res = $dbr->select( array( 'revision', 'reader_feedback' ),
				array( 'rfb_ratings' ),
				array( 'rev_page' => $page->getArticleId(),
					"rev_id = rfb_rev_id",
					"rfb_timestamp >= $cutoff",
					// Trigger INDEX usage
					"rev_timestamp >= ".$dbr->addQuotes($firstRevTS) ),
				__METHOD__,
				array( 'USE INDEX' => array('revision' => 'page_timestamp') )
			);
			$votes = array();
			foreach( ReaderFeedback::getFeedbackTags() as $tag => $w ) {
				$votes[$tag] = array( 0 => 0, 1 => 0, 2 => 0, 3 => 0, 4 => 0 );
			}
			// Read votes and tally the numbers
			foreach ( $res as $row ) {
				$dims = ReaderFeedback::expandRatings( $row->rfb_ratings );
				foreach( $dims as $tag => $val ) {
					if( isset($votes[$tag]) && isset($votes[$tag][$val]) ) {
						$votes[$tag][$val]++;
					}
				}
			}
			// Tack on $add for display (used to avoid cache/lag)
			foreach( $add as $tag => $val ) {
				if( isset($votes[$tag]) && isset($votes[$tag][$val]) ) {
					$votes[$tag][$val]++;
				}
			}
			$wgMemc->set( $key, array( $votes, $now ), 24*3600 );
		}
		// Output multi-column list
		$html = "<table class='rfb-reader_feedback_table' cellspacing='0'><tr>";
		foreach( ReaderFeedback::getFeedbackTags() as $tag => $w ) {
			// Get tag average...
			$dist = isset($votes[$tag]) ? $votes[$tag] : array();
			$count = array_sum($dist);
			if( $count ) {
				$ave = ($dist[0] + 2*$dist[1] + 3*$dist[2] + 4*$dist[3] + 5*$dist[4])/$count;
				$ave = round($ave,1);
			} else {
				$ave = '-'; // DIV by zero
			}
			$html .= '<td align="center"><b>'.wfMsgHtml("readerfeedback-$tag").'</b>&#160;&#160;'.
				'<sup>('.wfMsgHtml('ratinghistory-ave',$wgLang->formatNum($ave)).')</sup></td>';
		}
		$html .= '</tr><tr>';
		foreach( $votes as $dist ) {
			$html .= '<td><table>';
			$html .= '<tr><th align="left">'.wfMsgHtml('ratinghistory-table-rating').'</th>';
			for( $i = 1; $i <= 5; $i++ ) {
				$html .= "<td align='center' class='rfb-rating-option-".($i-1)."'>$i</td>";
			}
			$html .= '</tr><tr>';
			$html .= '<th align="left">'.wfMsgHtml("ratinghistory-table-votes").'</th>';
			$html .= '<td align="center">'.$dist[0].'</td>';
			$html .= '<td align="center">'.$dist[1].'</td>';
			$html .= '<td align="center">'.$dist[2].'</td>';
			$html .= '<td align="center">'.$dist[3].'</td>';
			$html .= '<td align="center">'.$dist[4].'</td>';
			$html .= "</tr></table></td>\n";
		}
		$html .= '</tr></table>';
		return $html;
	}
	
	/**
	 * Get JS script params for onloading
	 */
	public static function getJSFeedbackParams() {
		self::load();
		# Param to pass to JS function to know if tags are at quality level
		global $wgFeedbackTags;
		$params = array( 'tags' => (object)$wgFeedbackTags );
		return (object)$params;
	}

}
