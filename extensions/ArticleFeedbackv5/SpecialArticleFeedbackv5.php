<?php
/**
 * SpecialArticleFeedbackv5 class
 *
 * @package    ArticleFeedback
 * @subpackage Special
 * @author     Greg Chiasson <gchiasson@omniti.com>
 * @version    $Id$
 */

/**
 * This is the Special page the shows the feedback dashboard
 *
 * @package    ArticleFeedback
 * @subpackage Special
 */
class SpecialArticleFeedbackv5 extends UnlistedSpecialPage {
	private $filters = array(
		'comment',
		'helpful',
		'visible'
	);
	private $sorts = array(
		'age',
		'helpful',
		'rating'
	);

	/**
	 * Constructor
	 */
	public function __construct() {
		global $wgUser;
		parent::__construct( 'ArticleFeedbackv5' );

		$showHidden  = $wgUser->isAllowed( 'aftv5-see-hidden-feedback' );
		$showDeleted = $wgUser->isAllowed( 'aftv5-see-deleted-feedback' );

		if ( $showHidden ) {
			array_push( $this->filters,
				'unhelpful', 'abusive', 'invisible'
			);
			# removing the 'needsoversight' filter, per Fabrice
		}

		if ( $showDeleted ) {
			$this->filters[] = 'deleted';
		}

		// NOTE: The 'all' option actually displays different things
		// based on the users role, which is handled in the filter:
		// - deleter's all is actually everything
		// - hidder's all is 'visible + hidden'
		// - regular non-admin only has 'all visible' not 'all'

		// The all option, if any, is only added once, at the end of the list,
		// which is why it's down here instead.
		if ( $showDeleted ) {
			$this->filters[] = 'all';
		} elseif( $showHidden ) {
			$this->filters[] = 'notdeleted';
		}
	}

	/**
	 * Executes the special page
	 *
	 * @param $param string the parameter passed in the url
	 */
	public function execute( $param ) {
		global $wgArticleFeedbackv5DashboardCategory, $wgUser;
		$out   = $this->getOutput();
		
		// set robot policy
		$out->setIndexPolicy('noindex');

		if( !$param ) {
			$out->addWikiMsg( 'articlefeedbackv5-invalid-page-id' );
			return;
		}

		if( preg_match('/^(.+)\/(\d+)$/', $param, $m ) ) {
			$param = $m[1];
		}

		$title = Title::newFromText( $param );

		// Page does not exist.
		if ( !$title->exists() ) {
			$out->addWikiMsg( 'articlefeedbackv5-invalid-page-id' );
			return;
		}

		$pageId = $title->getArticleID();
		$dbr    = wfGetDB( DB_SLAVE );
		$t      = $dbr->select(
			'categorylinks',
			'cl_from',
			array(
				'cl_from' => $pageId,
				'cl_to'   => $wgArticleFeedbackv5DashboardCategory
			),
			__METHOD__,
			array( 'LIMIT' => 1 )
		);

		// Page exists, but feedback is disabled.
		if ( $dbr->numRows( $t ) == 0 ) {
			$out->addWikiMsg( 'articlefeedbackv5-page-disabled' );
			return;
		}

		// Success!
		$ratings = $this->fetchOverallRating( $pageId );
		$found   = isset( $ratings['found'] ) ? $ratings['found'] : null;
		$rating  = isset( $ratings['rating'] ) ? $ratings['rating'] : null;

		$out->setPagetitle(
			$this->msg( 'articlefeedbackv5-special-pagetitle', $title )->escaped()
		);

		if ( !$pageId ) {
			$out->addWikiMsg( 'articlefeedbackv5-invalid-page-id' );
			return;
		}

		$helpPage  = 'Article_Feedback_Tool/Version_5/Help/Feedback_page'; 
		if( $wgUser->isAllowed( 'aftv5-delete-feedback' ) ) {
			$helpPage = 'Article_Feedback_Tool/Version_5/Help/Feedback_page_Oversighters';
		} elseif( $wgUser->isAllowed( 'aftv5-hide-feedback' ) ) {
			$helpPage = 'Article_Feedback_Tool/Version_5/Help/Feedback_page_Hiders';
		} elseif( !$wgUser->isAnon() ) {
			$helpPage = 'Article_Feedback_Tool/Version_5/Help/Feedback_page_Editors';
		}

		$helpTitle = Title::newFromText( $helpPage, NS_PROJECT );
		$out->addHTML(
			Html::openElement(
				'div',
				array( 'id' => 'articleFeedbackv5-header-wrap' )
			)
			. Html::openElement(
				'div',
				array( 'id' => 'articleFeedbackv5-header-links' )
			)
			. Linker::link(
				$title,
				$this->msg( 'articlefeedbackv5-go-to-article' )->escaped()
			)
			. ' | ' .
			Linker::link(
				$title->getTalkPage(),
				$this->msg( 'articlefeedbackv5-discussion-page' )->escaped()
			)
			. ' | ' .
			Linker::link(
				$helpTitle,
				$this->msg( 'articlefeedbackv5-whats-this' )->escaped()
			)
			. Html::closeElement( 'div' )
			. Html::openElement(
				'div',
				array( 'id' => 'articleFeedbackv5-showing-count-wrap' )
			)
			. $this->msg(
				'articlefeedbackv5-special-showing',
				Html::element( 'span', array( 'id' => 'articleFeedbackv5-feedback-count-total' ), '0' )
			)
			. Html::closeElement( 'div' )
		);

		if ( $found ) {
			$class = $found > 50 ? 'positive' : 'negative';
			$span = Html::rawElement( 'span', array(
				'class' => "stat-marker $class"
			), wfMsg( 'percent', $found ) );
			$out->addHtml(
				Html::openElement(
					'div',
					array( 'id' => 'articleFeedbackv5-percent-found-wrap' )
				)
				. $this->msg( 'articlefeedbackv5-percent-found' )->rawParams( $span )->escaped()
				. Html::closeElement( 'div' )
			);
		}
		
		// BETA notice
		$out->addHTML(
		    Html::element( 'span', array(
			    'class' => 'articlefeedbackv5-beta-notice'
		    ), $this->msg( 'articlefeedbackv5-beta-notice' )->text() )
			. Html::element( 'div', array( 'class' => 'float-clear' ) )
		);

		$out->addHtml(
			Html::element(
				'a',
				array(
					'href'  => '#',
					'id'    => 'articleFeedbackv5-special-add-feedback',
				),
				$this->msg( 'articlefeedbackv5-special-add-feedback' )->text()
			)
			. Html::element( 'div', array( 'class' => 'float-clear' ) )
			. Html::closeElement( 'div' )
		);

#		if ( $rating ) {
#			$out->addWikiMsg( 'articlefeedbackv5-overall-rating', $rating );
#		}

		$out->addJsConfigVars( 'afPageId', $pageId );
		// Only show the abuse counts to editors (ie, anyone allowed to 
		// hide content).
		if ( $wgUser->isAllowed( 'aftv5-see-hidden-feedback' ) ) {
			$out->addJsConfigVars( 'afCanEdit', 1 );
		}
		$out->addModules( 'ext.articleFeedbackv5.dashboard' );

		$sortLabels = array();
		foreach ( $this->sorts as $sort ) {
			$sortLabels[] = Html::element( 'img',
				array(
					'id'    => 'articleFeedbackv5-sort-arrow-' . $sort,
					'class' => 'articleFeedbackv5-sort-arrow'
				), '' )
				. Html::element(
				'a',
				array(
					'href'  => '#',
					'id'    => 'articleFeedbackv5-special-sort-' . $sort,
					'class' => 'articleFeedbackv5-sort-link'
				),
				$this->msg( 'articlefeedbackv5-special-sort-' . $sort )->text()
			);
		}

		$opts   = array();
		$counts = $this->getFilterCounts( $pageId );
		foreach ( $this->filters as $filter ) {
			$count = array_key_exists( $filter, $counts ) ? $counts[$filter] : 0;
			$key   = $this->msg( 'articlefeedbackv5-special-filter-'.$filter, $count )->escaped();
			if( in_array( $filter, array( 'comment', 'helpful', 'visible' ) ) ) {
				$opts[ (string) $key ] = $filter;
			} else {
				$opts[ '---------' ][ (string) $key ] = $filter;
			}
		}

		$filterSelect = new XmlSelect( false, 'articleFeedbackv5-filter-select' );
		$filterSelect->addOptions( $opts );

		$out->addHTML(
			Html::openElement(
				'div',
				array( 'id' => 'articleFeedbackv5-sort-filter-controls' )
			)
			. Html::openElement(
				'div',
				array( 'id' => 'articleFeedbackv5-sort' )
			)
			. Html::openElement(
				'span',
				array( 'class' => 'articleFeedbackv5-sort-label' )
			)
			. $this->msg( 'articlefeedbackv5-special-sort-label-before' )->escaped()
			. Html::closeElement( 'span' )
			. implode( $this->msg( 'pipe-separator' )->escaped(), $sortLabels )

			. $this->msg( 'articlefeedbackv5-special-sort-label-after' )->escaped()
			. Html::closeElement( 'div' )
			. Html::openElement(
				'div',
				array( 'id' => 'articleFeedbackv5-filter' )
			)
			. Html::openElement(
				'span',
				array( 'class' => 'articleFeedbackv5-filter-label' )
			)
			. $this->msg( 'articlefeedbackv5-special-filter-label-before' )->escaped()
			. Html::closeElement( 'span' )
			. $filterSelect->getHTML()
			. $this->msg( 'articlefeedbackv5-special-filter-label-after' )->escaped()
			. Html::closeElement( 'div' )


			. Html::closeElement( 'div' )
		);

		$out->addHTML(
			Html::element(
				'div',
				array(
					'id'    => 'articleFeedbackv5-show-feedback',
				)
			)
			. Html::element(
				'a',
				array(
					'href' => '#',
					'id'   => 'articleFeedbackv5-show-more'
				),
				$this->msg( 'articlefeedbackv5-special-more' )->text()
			)
		);
	}

	/**
	 * Takes an associative array of label to value and converts the message
	 * names into localized strings
	 *
	 * @param  $options array the options, indexed by label
	 * @return array    the options, indexed by localized and escaped text
	 */
	private function selectMsg( array $options ) {
		$newOpts = array();
		foreach ( $options as $label => $value ) {
			$newOpts[$this->msg( $label )->escaped()] = $value;
		}
		return $newOpts;
	}

	/**
	 * Grabs the overall rating for a page
	 *
	 * @param  $pageId int the page id
	 * @return array   the overall rating, as array (found => %, rating => avg)
	 */
	private function fetchOverallRating( $pageId ) {
		$rv = array();
		$dbr = wfGetDB( DB_SLAVE );
		$rows = $dbr->select(
			array(
				'aft_article_feedback_ratings_rollup',
				'aft_article_field'
			),
			array(
				'arr_total / arr_count AS rating',
				'afi_name'
			),
			array(
				'arr_page_id' => $pageId,
				'arr_field_id = afi_id',
				'afi_name' => array( 'found', 'rating' )
			)
		);

		foreach ( $rows as $row ) {
			if ( $row->afi_name == 'found' ) {
				$rv['found'] = ( int ) ( 100 * $row->rating );
			} elseif ( $row->afi_name == 'rating' ) {
				$rv['rating'] = ( int ) $row->rating;
			}
		}

		return $rv;
	}

	private function getFilterCounts( $pageId ) {
		$rv   = array();
		$dbr  = wfGetDB( DB_SLAVE );
		$rows = $dbr->select(
			'aft_article_filter_count',
			array(
				'afc_filter_name',
				'afc_filter_count'
			),
			array(
				'afc_page_id' => $pageId
			),
			array(),
			__METHOD__
		);

		foreach ( $rows as $row ) {
			$rv[ $row->afc_filter_name ] = $row->afc_filter_count;
		}

		return $rv;
	}
}

