<?php

/**
 * Class SpecialSitemapXmlController
 *
 * This code is designed to generate XML sitemaps very fast.
 * A sitemap consisting of 10k URLs should be generated in a fraction of a second.
 *
 * To make this possible:
 *
 *  * Don't construct a Title object for every URL
 *  * Don't call wfTimestamp for each timestamp read from database
 *  * Don't use templates or XML-building libraries (including XMLWriter) to render the XML
 */
class SitemapXmlModel extends WikiaModel {
	private $dbr;

	private function queryDb( $dbr, $nses, $justCount = false, $offset = null, $limit = null ) {
		$columns = [
			'page_title',
			'page_touched',
			'page_namespace',
		];

		$where = [
			'page_namespace' => $nses,
			'page_is_redirect' => false,
		];

		$extra = [
			'ORDER BY' => 'page_id',
			'OFFSET' => $offset,
			'LIMIT' => $limit,
		];

		if ( $justCount ) {
			$columns = [ 'COUNT(*) AS c' ];
			$extra = [];
		}

		return $dbr->select(
			'page',
			$columns,
			$where,
			__METHOD__,
			$extra
		);
	}

	public function __construct() {
		$this->dbr = wfGetDB( DB_SLAVE );
	}

	public function getNumberOfPagesForNamespaces( array $nses, $limit ) {
		$query = $this->queryDb( $this->dbr, $nses, true );
		$row = $this->dbr->fetchObject( $query );
		return ceil( $row->c / $limit );
	}

	public function getPages( array $nses, $offset, $limit ) {
		$query = $this->queryDb( $this->dbr, $nses, false, $offset, $limit );
		while ( $row = $this->dbr->fetchObject( $query ) ) {
			yield $row;
		}
	}
}
