<?php

class SpecialSearchDigest extends SpecialPage {
	const MODE_CSV = 'csv';

	function __construct() {
		parent::__construct( 'SearchDigest' );
	}

	function execute( $mode ) {
		wfProfileIn(__METHOD__);
		global $wgOut;

		$wgOut->setPageTitle( wfMsg( 'searchdigest' ) );

		switch ( $mode ) {
			case self::MODE_CSV:
				$csv = new SearchDigestCSV();

				$csvText = $csv->getCSVText();

				$wgOut->setArticleBodyOnly( true );
				$this->setDownloadHeaders( $csvText );

				$wgOut->addHTML( $csvText );

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

		wfProfileOut(__METHOD__);
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
		global $wgSpecialsDB;

		parent::__construct();
		$this->mDb = wfGetDB( DB_SLAVE, array(), $wgSpecialsDB );

		// create a Linker object so we don't have to create it every time in formatRow
		$this->linker = new Linker;
	}

	function formatRow( $row ) {
		$link = $this->linker->makeLinkObj( Title::newFromText( $row->sd_query ) );

		return Xml::tags( 'li', null, $link . ' (' . $row->sd_misses . ')' );
	}

	function getQueryInfo() {
		global $wgCityId;

		// Get the date one week ago
		$dateLimit = date( 'Y-m-d', ( wfTimestamp( TS_UNIX ) - 604800 ) );

		return array(
			'tables' => array( 'searchdigest' ),
			'fields' => array( 'sd_query', 'sd_misses' ),
			'conds' => array( 'sd_wiki' => $wgCityId, 'sd_lastseen > ' . $this->mDb->addQuotes( $dateLimit ) ),
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
		wfProfileIn(__METHOD__);

		if ( !$this->mQueryDone ) {
			$this->doQuery();
		}

		# Don't announce the limit everywhere if it's the default
		$urlLimit = $this->mLimit == $this->mDefaultLimit ? '' : $this->mLimit;
		$minLim = $this->mOffset - $this->mLimit;
		$maxLim = $this->mOffset + $this->mLimit;

		if ( $this->mIsFirst ) {
			$prev = false;
			$first = false;
		} else {
			$prev = array(
				'offset' => ( $minLim < 0 ? 0 : $minLim ),
				'limit' => $urlLimit
			);
			if ( $this->mIsBackwards ) {
				$prev['offset'] = $maxLim;
				$prev['dir'] = 'prev';
			}
			$first = array( 'limit' => $urlLimit );
		}
		if ( $this->mIsLast ) {
			$next = false;
			$last = false;
		} else {
			$next = array( 'offset' => $maxLim, 'limit' => $urlLimit );
			$last = array( 'dir' => 'prev', 'limit' => $urlLimit );
			if ( $this->mIsBackwards ) {
				if ( !$this->mIsFirst ) {
					$next['offset'] = ( $minLim < 0 ? 0 : $minLim );
					$next['dir'] = 'prev';
				} else {
					$next['offset'] = $this->getNumRows();
				}
			}
		}

		wfProfileOut(__METHOD__);
		return array(
			'prev' => $prev,
			'next' => $next,
			'first' => $first,
			'last' => $last
		);
	}

	function reallyDoQuery( $offset, $limit, $descending ) {
		wfProfileIn(__METHOD__);

		$fname = __METHOD__ . ' (' . get_class( $this ) . ')';
		$info = $this->getQueryInfo();
		$tables = $info['tables'];
		$fields = $info['fields'];
		$conds = isset( $info['conds'] ) ? $info['conds'] : array();
		$options = isset( $info['options'] ) ? $info['options'] : array();
		$join_conds = isset( $info['join_conds'] ) ? $info['join_conds'] : array();
		if ( $descending ) {
			$options['ORDER BY'] = $this->mIndexField;
		} else {
			$options['ORDER BY'] = $this->mIndexField . ' DESC';
		}
		$options['LIMIT'] = intval( $limit );
		if ( $offset != '' ) {
			if ( $offset < 0 ) {
				$offset = 0;
			}
			$options['OFFSET'] = intval( $offset );
		}
		$res = $this->mDb->select( $tables, $fields, $conds, $fname, $options, $join_conds );
		$ret = new ResultWrapper( $this->mDb, $res );

		wfProfileOut(__METHOD__);
		return $ret;
	}
}

class SearchDigestCSV {
	function __construct() {
		global $wgStatsDB, $wgDevelEnvironment;

		if ( $wgDevelEnvironment ) {
			$this->mDb = wfGetDB( DB_SLAVE );
		} else {
			$this->mDb = wfGetDB( DB_SLAVE, array(), $wgStatsDB );
			$this->mDb->selectDB( 'specials' );
		}
	}

	function getCSVText() {
		wfProfileIn(__METHOD__);

		global $wgMemc, $wgCityId;

		$csvText = '';

		$memkey = __METHOD__ . ":" . $wgCityId;
		$cached = $wgMemc->get( $memkey );

		if ( empty( $cached ) ) {
			$res = $this->doQuery();

			foreach ( $res as $row ) {
				$csvText .= $row->sd_query . "," . $row->sd_misses . "\n";
			}

			$wgMemc->set( $memkey, $csvText, 60 * 60  );
		} else {
			$csvText = $cached;
		}

		wfProfileOut(__METHOD__);
		return $csvText;
	}

	private function doQuery() {
		wfProfileIn(__METHOD__);
		global $wgCityId;

		// Get the date one week ago
		$dateLimit = date( 'Y-m-d', ( wfTimestamp( TS_UNIX ) - 604800 ) );

		$res = $this->mDb->select(
			array( 'searchdigest' ),
			array( 'sd_query', 'sd_misses' ),
			array( 'sd_wiki' => $wgCityId, 'sd_lastseen > ' . $this->mDb->addQuotes( $dateLimit ) ),
			__METHOD__,
			array( 'ORDER BY' => 'sd_misses DESC' )
		);

		wfProfileOut(__METHOD__);
		return $res;
	}
}
