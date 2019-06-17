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
	 * Allows to find all wikis to be indexed.
	 */
	public function getWikis() {
		$offset = $this->getVal( 'offset', 0 );
		$limit = $this->getVal( 'limit', 1000 );

		$result = $this->findWikiResults( $offset, $limit );

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
			( new WikiaSQL() )->SELECT( 'page.page_id' )
				->FROM( 'page' )
				->WHERE( 'page.page_namespace' )
				->IN( array_keys( $namespaces ) )
				->AND_( 'page.page_id' )
				->GREATER_THAN_OR_EQUAL( $offset )
				->LIMIT( $limit + 1 )// fetching one more than limit to get next offset
				->ORDER_BY( [ 'page.page_id', 'asc' ] )
				->runLoop( $db, function ( &$result, $row ) {
					$result[] = $row->page_id;
				} );

		$splitByLimit = array_chunk( $results, $limit );

		return [
			'nextOffset' => isset( $splitByLimit[1][0] ) ? $splitByLimit[1][0] : null,
			'pageIds' => isset( $splitByLimit[0] ) ? $splitByLimit[0] : [],
		];
	}

	private function findWikiResults( $offset, $limit ) {
		$db = wfGetDB( DB_SLAVE, null, 'wikicities' );

		$results =
			( new WikiaSQL() )->SELECT( 'wikicities.city_list.city_id' )
				->FROM( 'wikicities.city_list' )
				->WHERE( 'wikicities.city_list.city_id' )
				->GREATER_THAN_OR_EQUAL( $offset )
				->LIMIT( $limit + 1 )// fetching one more than limit to get next offset
				->ORDER_BY( [ 'wikicities.city_list.city_id', 'asc' ] )
				->runLoop( $db, function ( &$result, $row ) {
					$result[] = $row->city_id;
				} );

		$splitByLimit = array_chunk( $results, $limit );

		return [
			'nextOffset' => isset( $splitByLimit[1][0] ) ? $splitByLimit[1][0] : null,
			'wikiIds' => isset( $splitByLimit[0] ) ? $splitByLimit[0] : [],
		];
	}
}
