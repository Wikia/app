<?php

class PopularPages extends PageQueryPage {
	const LIMIT = 1000;
	const POPULAR_PAGES_TYPE = 'Popularpages';

	function __construct( $name = self::POPULAR_PAGES_TYPE ) {
		parent::__construct( $name );
	}

	public function isListed() {
		return false;
	}

	public function isExpensive() {
		return true;
	}

	/**
	 * A wrapper for calling the querycache table
	 *
	 * @param bool $offset
	 * @param int $limit
	 * @return ResultWrapper
	 */
	public function doQuery( $offset = false, $limit = self::LIMIT ) {
		return $this->fetchFromCache( $limit, $offset );
	}

	/**
	 * Update the querycache table
	 *
	 * @param bool $limit Only for consistency
	 * @param bool $ignoreErrors Only for consistency
	 * @return bool|int
	 */
	public function recache( $limit = false, $ignoreErrors = true ) {
		$dbw = wfGetDB( DB_MASTER );

		/**
		 * 1. Get the new data first
		 */
		$popularPages = $this->reallyDoQuery();
		$dbw->begin();

		/**
		 * 2. Delete the existing records
		 */
		( new WikiaSQL() )
			->DELETE( 'querycache' )
			->WHERE( 'qc_type' )->EQUAL_TO( $this->getName() )
			->run( $dbw );

		/**
		 * 3. Insert the new records if the $popularPages array is not empty
		 */
		$num = 0;
		if ( !empty( $popularPages ) ) {

			( new WikiaSQL() )
				->INSERT()->INTO( 'querycache', [
					'qc_type',
					'qc_value',
					'qc_namespace',
					'qc_title'
				] )
				->VALUES( $popularPages )
				->run( $dbw );

			$num = $dbw->affectedRows();
			if ( $num === 0 ) {
				$dbw->rollback();
				$num = false;
			} else {
				$dbw->commit();
			}
		}

		wfRunHooks( 'PopularPagesQueryRecached' );

		return $num;
	}

	/**
	 * Returns an array with list of pages on wikia.
	 *
	 * @param bool $limit Only for consistency
	 * @param bool $offset Only for consistency
	 * @return array
	 */
	public function reallyDoQuery( $limit = false, $offset = false ) {
		global $wgContentNamespaces;

		$dbr = wfGetDB( DB_SLAVE, [ $this->getName(), __METHOD__, 'vslow' ] );

		$contentPages = ( new WikiaSQL() )
			->SELECT( 'page_id', 'page_title', 'page_namespace' )
			->FROM( 'page' )
			->WHERE( 'page_namespace' )->IN( $wgContentNamespaces )
			->runLoop( $dbr, function ( &$contentPages, $row ) {
				$contentPages[$row->page_id] = [
					$this->getName(),
					$row->page_id,
					$row->page_namespace,
					$row->page_title,
				];
			} );

		return $contentPages;
	}
}
