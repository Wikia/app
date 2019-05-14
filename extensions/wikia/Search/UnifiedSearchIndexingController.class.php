<?php

class UnifiedSearchIndexingController extends WikiaController {

	/**
	 * Allows to find all pages for searchable namespaces in this wiki.
	 */
	public function get() {
		$namespaces = SearchEngine::searchableNamespaces();

		$offset = $this->getVal( 'offset', 0 );
		$limit = $this->getVal( 'limit', 1000 );

		$result = $this->findResults( $namespaces, $offset, $limit );

		$this->getResponse()->setFormat( 'json' );
		$this->getResponse()->setData( $result );
	}

	/**
	 * @param array $namespaces
	 * @param $offset
	 * @param $limit
	 * @return array
	 */
	private function findResults( array $namespaces, $offset, $limit ) {
		$db = wfGetDB( DB_SLAVE );

		$results =
			( new WikiaSQL() )->SELECT( "page.page_id" )
				->FROM( 'page' )
				->WHERE( 'page.page_namespace' )
				->IN( array_keys( $namespaces ) )
				->AND_( 'page.page_id' )
				->GREATER_THAN_OR_EQUAL( $offset )// fetching one more than limit to get next offset
				->LIMIT( $limit + 1 )
				->ORDER_BY( [ "page.page_id", 'asc' ] )
				->runLoop( $db, function ( &$result, $row ) {
					$result[] = $row->page_id;
				} );

		$splitByLimit = array_chunk( $results, $limit );

		return [
			'nextOffset' => isset( $splitByLimit[1][0] ) ? $splitByLimit[1][0] : null,
			'pageIds' => isset( $splitByLimit[0] ) ? $splitByLimit[0] : [],
		];

	}
}
