<?php

class SitemapXmlModel extends WikiaModel {
	private $dbr;

	public function __construct() {
		$this->dbr = wfGetDB( DB_SLAVE );
	}

	public function getPageNumber( array $nses, $limit ) {
		$sql = $this->getQuery( $nses )
			->COUNT( '*' )->AS_( 'c' );

		$count = $sql->run( $this->dbr, function ( $result ) {
			return $result->fetchObject()->c;
		} );

		return ceil( $count / $limit );
	}

	public function getItems( array $nses, $offset, $limit ) {
		$sql = $this->getQuery( $nses )
			->FIELD( 'page_namespace', 'page_title', 'page_touched' )
			->OFFSET( $offset )->LIMIT( $limit );

		return $sql->run( $this->dbr, function ( $result ) {
			while ( $row = $result->fetchObject() ) {
				yield $row;
			}
		} );
	}

	/**
	 * @param array $nses
	 * @return WikiaSQL
	 */
	private function getQuery( array $nses ) {
		return ( new WikiaSQL() )
			->SELECT()
			->FROM( 'page' )
			->WHERE( 'page_namespace' )->IN( $nses )
			->AND_( 'page_is_redirect' )->EQUAL_TO( false )
			->ORDER_BY( 'page_id' );
	}
}
