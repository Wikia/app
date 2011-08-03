<?php

class SpecialSearchDigest extends IndexPager {
	function __construct() {
		global $wgStatsDB;

		parent::__construct( 'SearchDigest' );
		$this->mDb = wfGetDB( DB_SLAVE, array(), $wgStatsDB );

		$this->mDB->selectDB( 'specials' );

		// create a Linker object so we don't have to create it every time in formatRow
		$this->linker = new Linker;
	}

	function formatRow( $row ) {
		$link = $this->linker->makeLinkObj( Title::newFromName( $row->sd_query ) );

		return $link . ' (' . $row->sd_misses . ')';
	}

	function getQueryInfo() {
		global $wgCityId;

		return array(
			'tables' => array( 'searchdigest' ),
			'fields' => array( 'sd_query', 'sd_misses' ),
			'conds' => array( 'sd_wiki' => $wgCityId ),
		);
	}

	function getIndexField() {
		return 'sd_misses';
	}
}
