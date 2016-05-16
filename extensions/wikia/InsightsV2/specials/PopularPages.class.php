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

		( new WikiaSQL() )
			->DELETE( 'querycache' )
			->WHERE( 'qc_type' )->EQUAL_TO( $this->getName() )
			->run( $dbw );

		$num = 0;
		$popularPages = $this->reallyDoQuery();
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
			wfWaitForSlaves();
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
		global $wgCityId;

		$topArticles = DataMartService::getTopArticlesByPageview(
			$wgCityId,
			null,
			null,
			false,
			self::LIMIT
		);

		$topArticlesFormatted = [];
		foreach ( $topArticles as $pageId => $pageViewsData ) {
			$title = Title::newFromID( $pageId );
			if ( $title instanceof Title ) {
				$topArticlesFormatted[$pageId] = [
					$this->getName(),
					$pageId,
					$pageViewsData['namespace_id'],
					$title->getDBkey(),
				];
			}
		}
		return $topArticlesFormatted;
	}
}
