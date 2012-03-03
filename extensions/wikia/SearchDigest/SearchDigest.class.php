<?php

class SpecialSearchDigest extends SpecialPage {
	const MODE_CSV = 'csv';

	function __construct() {
		parent::__construct( 'SearchDigest' );	
	}

	function execute( $mode ) {
		global $wgOut;

		$wgOut->setPageTitle( wfMsg( 'searchdigest-title' ) );	

		switch ( $mode ) {
			case self::MODE_CSV:
				$pager = new SearchDigestCSVPager();

				// display all results
				$pager->setLimit( $pager->getNumRows() + 1 );

				$csv = $pager->getBody();

				$wgOut->setArticleBodyOnly( true );
				$this->setDownloadHeaders( $csv );

				$wgOut->addHTML( $csv );

				break;
			default:
				$pager = new SearchDigestPager();

				$downloadUrl = Title::newFromText( $this->mName . '/' . self::MODE_CSV, NS_SPECIAL )->getLocalUrl();

				$html = $pager->getNavigationBar() . $pager->getBody() . $pager->getNavigationBar();

				$html .= Xml::openElement( 'nav' );
				$html .= Xml::element(
					'a',
					array(
						'href' => $downloadUrl,
						'class' => 'wikia-button'
					),
					wfMsg( 'searchdigest-download-csv' )
				);
				$html .= Xml::closeElement( 'nav' );

				$wgOut->addHTML( $html );
		}
	}

	private function setDownloadHeaders( $output ) {
		header("Content-Description: File Transfer");

		//Use the switch-generated Content-Type
		header("Content-Type: text/plain");
		header("Content-Disposition: attachment; filename=\"search-digest.csv\"");

		//Force the download
		header("Content-Transfer-Encoding: utf-8");
		header("Content-Length: " . strlen($output) );
	}
}

class SearchDigestPager extends ReverseChronologicalPager {
	function __construct() {
		global $wgStatsDB, $wgDevelEnvironment;

		parent::__construct( 'SearchDigest' );

		if ( $wgDevelEnvironment ) {
			$this->mDb = wfGetDB( DB_SLAVE );
		} else {
			$this->mDb = wfGetDB( DB_SLAVE, array(), $wgStatsDB );
			$this->mDb->selectDB( 'specials' );
		}

		// create a Linker object so we don't have to create it every time in formatRow
		$this->linker = new Linker;
	}

	function formatRow( $row ) {
		$link = $this->linker->makeLinkObj( Title::newFromText( $row->sd_query ) );

		return Xml::tags( 'li', null, $link . ' (' . $row->sd_misses . ')' );
	}

	function getQueryInfo() {
		global $wgCityId;

		return array(
			'tables' => array( 'searchdigest' ),
			'fields' => array( 'sd_query', 'sd_misses' ),
			'conds' => array( 'sd_wiki' => $wgCityId ),
			'options' => array( 'ORDER_BY sd_misses DESC' ),
		);
	}

	function getIndexField() {
		return 'sd_misses';
	}

	function getStartBody() {
		return '<ul>';
	}

	function getEndBody() {
		return '</ul>';
	}

	/**
	 * Override these functions to allow for offsetting based on result number as there aren't unique indices
	 */
	function getPagingQueries() {
		if ( !$this->mQueryDone ) {
			$this->doQuery();
		}

		# Don't announce the limit everywhere if it's the default
		$urlLimit = $this->mLimit == $this->mDefaultLimit ? '' : $this->mLimit;
		$minLim = $this->mOffset - $urlLimit;

		if ( $this->mIsFirst || intval( $this->mOffset ) <= 0 ) {
			$prev = false;
			$first = false;
		} else {
			$prev = array(
				'offset' => ( $minLim < 0 ? 0 : $minLim ),
				'limit' => $urlLimit
			);
			$first = array( 'limit' => $urlLimit );
		}
		if ( $this->mIsLast ) {
			$next = false;
			$last = false;
		} else {
			$next = array( 'offset' => ( $this->mOffset + $this->mLimit ), 'limit' => $urlLimit );
			$last = array( 'dir' => 'prev', 'limit' => $urlLimit );
		}
		return array(
			'prev' => $prev,
			'next' => $next,
			'first' => $first,
			'last' => $last
		);
	}

	function reallyDoQuery( $offset, $limit, $descending ) {
		$fname = __METHOD__ . ' (' . get_class( $this ) . ')';
		$info = $this->getQueryInfo();
		$tables = $info['tables'];
		$fields = $info['fields'];
		$conds = isset( $info['conds'] ) ? $info['conds'] : array();
		$options = isset( $info['options'] ) ? $info['options'] : array();
		$join_conds = isset( $info['join_conds'] ) ? $info['join_conds'] : array();
		$options['ORDER BY'] = $this->mIndexField . ' DESC';
		$options['LIMIT'] = intval( $limit );
		if ( $offset != '' ) {
			if ( $offset < 0 ) {
				$offset = 0;
			}
			$options['OFFSET'] = intval( $offset );
		}
		$res = $this->mDb->select( $tables, $fields, $conds, $fname, $options, $join_conds );
		return new ResultWrapper( $this->mDb, $res );
	}
}

class SearchDigestCSVPager extends SearchDigestPager {
	function getStartBody() { return ''; }

	function getEndBody() { return ''; }

	function formatRow( $row ) {
		return $row->sd_query . "," . $row->sd_misses . "\n";
	}
}
