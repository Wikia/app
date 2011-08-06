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

				header("Content-Description: File Transfer");

				//Use the switch-generated Content-Type
				header("Content-Type: text/plain");
				header("Content-Disposition: attachment; filename=\"search-digest.csv\"");

				//Force the download
				header("Content-Transfer-Encoding: utf-8");
				header("Content-Length: ".strlen($csv));

				$wgOut->addHTML( $csv );

				break;
			default:
				$pager = new SearchDigestPager();

				$downloadUrl = Title::newFromText( $this->mName . '/' . self::MODE_CSV, NS_SPECIAL )->getLocalUrl();
				$wgOut->addHTML( Xml::element( 
						'a',
						array(
							'href' => $downloadUrl,
							'class' => 'wikia-button'
						),
						wfMsg( 'searchdigest-download-csv' )
					)
				);

				$html = $pager->getNavigationBar() . $pager->getBody() . $pager->getNavigationBar();

				$wgOut->addHTML( $html );
		}
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
}

class SearchDigestCSVPager extends SearchDigestPager {
	function getStartBody() { return ''; }

	function getEndBody() { return ''; }

	function formatRow( $row ) {
		return $row->sd_query . "," . $row->sd_misses . "\n";
	}
}
