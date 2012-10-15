<?php
/**
 * SpecialPage for ArticleFeedback extension
 *
 * @file
 * @ingroup Extensions
 */

class SpecialArticleFeedback extends SpecialPage {

	/* Methods */

	public function __construct() {
		parent::__construct( 'ArticleFeedback' );
	}

	public function execute( $par ) {
		global $wgOut, $wgLang, $wgArticleFeedbackDashboard, $wgArticleFeedbackDashboardTalkPage;

		$wgOut->addModules( 'ext.articleFeedback.dashboard' );
		$this->setHeaders();
		if ( $wgArticleFeedbackDashboard ) {
			// fetch the highest and lowest rated articles
			$highs_lows = $this->getDailyHighsAndLows();

			// determine the highest rated articles
			$highs = $this->getDailyHighs( $highs_lows );

			// .. and the lowest rated articles
			$lows = $this->getDailyLows( $highs_lows );

			// provide some messaging above high/low tables
			$wgOut->addWikiMsg( 'articleFeedback-copy-above-highlow-tables', $wgArticleFeedbackDashboardTalkPage );

			//render daily highs table
			$this->renderDailyHighsAndLows( $highs, wfMsg( 'articleFeedback-table-caption-dailyhighs', $wgLang->date( time() )));

			//render daily lows table
			$this->renderDailyHighsAndLows( $lows, wfMsg( 'articleFeedback-table-caption-dailylows', $wgLang->date( time() )));

			/*
			This functionality does not exist yet.
			$this->renderWeeklyMostChanged();*/
			$this->renderProblems();

			$wgOut->addWikiMsg( 'articlefeedback-dashboard-bottom' );
		} else {
			$wgOut->addWikiText( 'This page has been disabled.' );
		}
	}

	/* Protected Methods */

	/**
	 * Returns an HTML table containing data from a given two dimensional array.
	 *
	 * @param $headings Array: List of rows, each a list of column data (values will be escaped)
	 * @param $rows Array: List of rows, each a list of either calss/column data pairs (values will
	 * be escaped), or arrays containing attr, text and html fields, used to set attributes, text or
	 * HTML content of the cell
	 * @param $attribs Array: List of HTML attributes to apply to the table
	 * @return String: HTML table code
	 */
	protected function renderTable( $caption, array $headings, array $rows, $id = null ) {
		global $wgOut;

		$table = Html::openElement( 'table', array(
			'class' => 'articleFeedback-table sortable', 'id' => $id
		) );
		// Caption
		$table .= Html::element( 'caption', array(), $caption );
		// Head
		$table .= Html::openElement( 'thead' );
		$table .= Html::openElement( 'tr' );
		foreach ( $headings as $heading ) {
			$table .= Html::element( 'th', array(), $heading );
		}
		$table .= Html::closeElement( 'tr' );
		$table .= Html::closeElement( 'thead' );
		// Body
		$table .= Html::openElement( 'tbody' );
		foreach ( $rows as $row ) {
			$table .= Html::openElement( 'tr' );
			foreach ( $row as $column ) {
				$attr = array();
				if ( is_array( $column ) ) {
					if ( isset( $column['attr'] ) && is_array( $column['attr'] ) ) {
						$attr = $column['attr'];
					}
					if ( isset( $column['text'] ) ) {
						$table .= Html::element( 'td', $attr, $column['text'] );
					} elseif ( isset( $column['html'] ) ) {
						$table .= Html::rawElement( 'td', $attr, $column['html'] );
					} else {
						$table .= Html::element( 'td', $attr );
					}
				} else {
					$table .= Html::rawElement( 'td', $attr, $column );
				}
			}
			$table .= Html::closeElement( 'tr' );
		}
		$table .= Html::closeElement( 'tbody' );
		$table .= Html::closeElement( 'table' );
		$wgOut->addHtml( $table );
	}

	/**
	 * Renders daily highs and lows
	 *
	 * @return String: HTML table of daily highs and lows
	 */
	protected function renderDailyHighsAndLows( $pages, $caption ) {
		global $wgUser;

		// Pre-fill page ID cache
		$ids = array();
		foreach ( $pages as $page ) {
			$ids[] = $page['page'];
		}
		self::populateTitleCache( $ids );
		
		$categories = self::getCategories();

		$rows = array();
		if ( $pages ) {
			foreach ( $pages as $page ) {
				$row = array();
				$pageTitle = self::getTitleFromID( $page['page'] );
				if ( !$pageTitle ) {
					continue;
				}
				$row['page'] = $wgUser->getSkin()->link( $pageTitle, $pageTitle->getPrefixedText() );
				foreach ( $categories as $catid => $catmsg ) {
					if ( isset( $page['ratings'][$catid] ) ) {
						$number = $this->formatNumber( $page['ratings'][$catid] );
						$class = round( $page['ratings'][$catid] );
					} else {
						$number = wfMsg( 'articlefeedback-table-noratings' );
						$class = 'none';
					}
					$row[] = array(
						'text' => $number,
						'attr' => array(
							'class' => 'articleFeedback-table-column-rating ' .
								'articleFeedback-table-column-score-' . $class
						)
					);
				}
				$row[] = array(
					'text' => $this->formatNumber( $page['average'] ),
					'attr' => array(
						'class' => 'articleFeedback-table-column-average ' .
							'articleFeedback-table-column-score-' . round( $page['average'] )
					)
				);
				$rows[] = $row;
			}
		}

		$this->renderTable(
			$caption,
			array_merge(
				array( wfMsg( 'articleFeedback-table-heading-page' ) ),
				$categories,
				array( wfMsg( 'articleFeedback-table-heading-average' ) )
			),
			$rows,
			'articleFeedback-table-highsandlows'
		);
	}

	/**
	 * Renders weekly most changed
	 *
	 * @return String: HTML table of weekly most changed
	 */
	protected function renderWeeklyMostChanged() {
		global $wgUser;
		
		$categories = self::getCategories();

		$rows = array();
		foreach ( $this->getWeeklyMostChanged() as $page ) {
			$row = array();
			$pageTitle = Title::newFromText( $page['page'] );
			$row['page'] = $wgUser->getSkin()->link( $pageTitle, $pageTitle->getPrefixedText() );
			foreach ( $categories as $catid => $catmsg ) {
				if ( isset( $page['changes'][$catid] ) ) {
					$number = $this->formatNumber( $page['changes'][$catid] );
				} else {
					$number = wfMsg( 'articlefeedback-table-noratings' );
				}
				$row[] = array(
					'text' => $number,
					'attr' => array(
						'class' => 'articleFeedback-table-column-changes'
					)
				);
			}
			$rows[] = $row;
		}
		$this->renderTable(
			wfMsg( 'articleFeedback-table-caption-weeklymostchanged' ),
			array_merge(
				array( wfMsg( 'articleFeedback-table-heading-page' ) ),
				$categories
			),
			$rows,
			'articleFeedback-table-weeklymostchanged'
		);
	}

	/**
	 * Renders problem articles table
	 *
	 * @return String: HTML table of recent lows
	 */
	protected function renderProblems() {
		global $wgUser;

		$problems = $this->getProblems();
		$categories = self::getCategories();

		// Pre-fill page ID cache
		$ids = array();
		foreach ( $problems as $page ) {
			$ids[] = $page['page'];
		}
		self::populateTitleCache( $ids );

		$rows = array();
		foreach ( $problems as $page ) {
			$row = array();
			$pageTitle = self::getTitleFromID( $page['page'] );
			if ( !$pageTitle ) {
				continue;
			}
			$row['page'] = $wgUser->getSkin()->link( $pageTitle, $pageTitle->getPrefixedText() );
			foreach ( $categories as $catid => $catmsg ) {
				if ( isset( $page['ratings'][$catid] ) ) {
					$number = $this->formatNumber( $page['ratings'][$catid] );
					$class = round( $page['ratings'][$catid] );
				} else {
					$number = wfMsg( 'articlefeedback-table-noratings' );
					$class = 'none';
				}
				$row[] = array(
					'text' => $number,
					'attr' => array(
						'class' => 'articleFeedback-table-column-rating ' .
							'articleFeedback-table-column-score-' . $class
					)
				);
			}
			$row[] = array(
				'text' => $this->formatNumber( $page['average'] ),
				'attr' => array(
					'class' => 'articleFeedback-table-column-average ' .
						'articleFeedback-table-column-score-' . round( $page['average'] )
				)
			);
			$rows[] = $row;
		}
		$this->renderTable(
			wfMsg( 'articleFeedback-table-caption-recentlows' ),
			array_merge(
				array( wfMsg( 'articleFeedback-table-heading-page' ) ),
				$categories,
				array( wfMsg( 'articleFeedback-table-heading-average' ) )
			),
			$rows,
			'articleFeedback-table-recentlows'
		);
	}

	/**
	 * Gets a list of articles which were rated exceptionally low
	 */
	protected function getProblems() {
		global $wgMemc;
		// check if we've got results in the cache
		$key = wfMemcKey( 'article_feedback_stats_problems' );
		$cache = $wgMemc->get( $key );
		if ( is_array( $cache )) {
			$problems = $cache;
		} else {
			$dbr = wfGetDB( DB_SLAVE );
			$typeID = self::getStatsTypeId( 'problems' );
			// first find the freshest timestamp
			$row = $dbr->selectRow(
				'article_feedback_stats',
				array( 'afs_ts' ),
				array( 'afs_stats_type_id' => $typeID ),
				__METHOD__,
				array( "ORDER BY" => "afs_ts DESC", "LIMIT" => 1 )
			);

			// if we have no results, just return
			if ( !$row || !$row->afs_ts ) {
				return array();
			}

			// select ratings with that ts
			$result = $dbr->select(
				'article_feedback_stats',
				array(
					'afs_page_id',
					'afs_orderable_data',
					'afs_data'
				),
				array(
					'afs_ts' => $row->afs_ts,
					'afs_stats_type_id' => $typeID
				),
				__METHOD__,
				array( "ORDER BY" => "afs_orderable_data" )
			);
			$problems = $this->buildProblems( $result );
			$wgMemc->set( $key, $problems, 86400 );
		}

		return $problems;
	}

	/**
	 * Gets a list of articles which were rated exceptionally high or low.
	 *
	 * - Based on average of all rating categories
	 * - Gets 50 highest rated and 50 lowest rated
	 * - Only consider articles with 10+ ratings in the last 24 hours
	 *
	 * This data should be updated daily, ideally though a scheduled batch job
	 */
	protected function getDailyHighsAndLows() {
		global $wgMemc;
		// check if we've got results in the cache
		$key = wfMemcKey( 'article_feedback_stats_highs_lows' );
		$cache = $wgMemc->get( $key );
		if ( is_array( $cache )) {
			$highs_lows = $cache;
		} else {
			$dbr = wfGetDB( DB_SLAVE );
			$typeID = self::getStatsTypeId( 'highs_and_lows' );
			// first find the freshest timestamp
			$row = $dbr->selectRow(
				'article_feedback_stats',
				array( 'afs_ts' ),
				array( 'afs_stats_type_id' => $typeID ),
				__METHOD__,
				array( "ORDER BY" => "afs_ts DESC", "LIMIT" => 1 )
			);

			// if we have no results, just return
			if ( !$row || !$row->afs_ts ) {
				return array();
			}

			// select ratings with that ts
			$result = $dbr->select(
				'article_feedback_stats',
				array(
					'afs_page_id',
					'afs_orderable_data',
					'afs_data'
				),
				array(
					'afs_ts' => $row->afs_ts,
					'afs_stats_type_id' => $typeID,
				),
				__METHOD__,
				array( "ORDER BY" => "afs_orderable_data" )
			);
			$highs_lows = $this->buildHighsAndLows( $result );
			$wgMemc->set( $key, $highs_lows, 86400 );
		}

		return $highs_lows;
	}

	/**
	 * Determine the 'highest' rated articles
	 *
	 * Divides the number of ratings in half to determine the range of
	 * articles to consider 'highest'.  In the event of an odd number
	 * of articles, (determined by checking for modulus of # of ratings / 2),
	 * round up, giving preference to the 'highs' so
	 * everyone feels warm and fuzzy about having more 'highs', as
	 * it were...
	 *
	 * @param array Pre-orderd from highest to lowest
	 * @return array Containing the... highest rated article data
	 */
	protected function getDailyHighs( $highs_lows ) {
		$num_ratings = count( $highs_lows );
		if ( $num_ratings % 2 ) {
			$num_highs = round( $num_ratings / 2 );
		} else {
			$num_highs = $num_ratings / 2;
		}
		$highs = array_slice( $highs_lows, -$num_highs, $num_highs );

		// Sort descending
		return array_reverse( $highs );
	}

	/**
	 * Determine the 'lowest' rated articles
	 *
	 * @see getDailyHighs() However, if we are dealing with an odd number of
	 * 	ratings, round up and then subtract 1 since we are giving preference
	 * 	to the 'highs' when dealing with an odd number of ratings.  We do this
	 * 	rather than rely on PHP's rounding 'modes' for compaitibility with
	 *  PHP < 5.3
	 * @param array Pre-orderd from lowest to highest
	 * @return array Containing the... lowest rated article data
	 */
	protected function getDailyLows( $highs_lows ) {
		$num_ratings = count( $highs_lows );
		if ( $num_ratings % 2 ) {
			$num_lows = round( $num_ratings / 2 ) - 1;
		} else {
			$num_lows = $num_ratings / 2;
		}
		return array_slice( $highs_lows, 0, $num_lows );
	}

	/**
	 * Build data store of highs/lows for use when rendering table
	 * @param object Database result or array of rows
	 * @return array
	 */
	public static function buildHighsAndLows( $result ) {
		$highs_lows = array();
		foreach ( $result as $row ) {
			if ( is_array( $row ) ) {
				$row = (object)$row;
			}
			$highs_lows[] = array(
				'page' => $row->afs_page_id,
				'ratings' => FormatJson::decode( $row->afs_data, true ),
				'average' => $row->afs_orderable_data
			);
		}
		return $highs_lows;
	}

	/**
	 * Build data store of problems for use when rendering table
	 * @param object Database result or array of rows
	 * @return array
	 */
	public static function buildProblems( $result ) {
		$problems = array();
		foreach( $result as $row ) {
			if ( is_array( $row ) ) {
				$row = (object)$row;
			}
			$problems[] = array(
				'page' => $row->afs_page_id,
				'ratings' => FormatJson::decode( $row->afs_data, true ),
				'average' => $row->afs_orderable_data
			);
		}
		return $problems;
	}

	/**
	 * Get the stats type id for a given stat type
	 * @param string $stats_type
	 */
	public static function getStatsTypeId( $stats_type ) {
		global $wgMemc;
		$key = wfMemcKey( 'article_feedback_stats_type_' . $stats_type );
		$cache = $wgMemc->get( $key );
		if ( $cache ) {
			return $cache;
		}

		$dbr = wfGetDB( DB_SLAVE );
		$row = $dbr->selectRow(
			'article_feedback_stats_types',
			array( 'afst_id' ),
			array( 'afst_type' => $stats_type ),
			__METHOD__,
			array( )
		);
		$wgMemc->set( $key, $row->afst_id );
		return $row->afst_id;
	}

	/**
	 * Gets a list of articles which have quickly changing ratings.
	 *
	 * - Based on any rating category
	 * - Gets 50 most improved and 50 most worsened
	 * - Only consider articles with 100+ ratings in the last 7 days
	 *
	 * This data should be updated daily, ideally though a scheduled batch job
	 */
	protected function getWeeklyMostChanged() {
		return array(
			array(
				'page' => 'Main Page',
				// List of differences for each rating in the past 7 days
				'changes' => array(
					1 => 1,
					2 => 2,
					3 => 0,
					4 => 0,
				),
			),
			array(
				'page' => 'Test Article',
				'changes' => array(
					1 => 0,
					2 => 0,
					3 => 1,
					4 => 2,
				),
			)
		);
	}

	/* Protected Static Members */

	protected static $categories;
	protected static $titleCache = array();

	/* Protected Static Methods */

	protected static function formatNumber( $number ) {
		global $wgLang;

		return $wgLang->formatNum( number_format( $number, 2 ) );
	}

	protected static function getCategories() {
		global $wgArticleFeedbackRatingTypes;

		if ( !isset( self::$categories ) ) {
			foreach ( $wgArticleFeedbackRatingTypes as $id => $rating ) {
				self::$categories[$id] = wfMsg( "articlefeedback-field-$rating-label" );
			}
		}
		return self::$categories;
	}

	protected static function getTitleFromID( $id ) {
		// There's no caching in Title::newFromId() so we hack our own around it
		if ( !isset( self::$titleCache[$id] ) ) {
			self::$titleCache[$id] = Title::newFromId( $id );
		}
		return self::$titleCache[$id];
	}

	protected static function populateTitleCache( $ids ) {
		$toQuery = array_diff( $ids, array_keys( self::$titleCache ) );
		$titles = Title::newFromIds( $toQuery );
		foreach ( $titles as $title ) {
			self::$titleCache[$title->getArticleID()] = $title;
		}
	}
}
