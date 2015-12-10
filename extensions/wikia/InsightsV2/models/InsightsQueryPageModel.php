<?php

/**
 * Abstract class that defines necessary set of methods for Insights QueryPage models
 */
abstract class InsightsQueryPageModel extends InsightsPageModel {

	protected $queryPageInstance;

	abstract function getDataProvider();

	/**
	 * @return QueryPage An object of a QueryPage's child class
	 */
	protected function getQueryPageInstance() {
		if ( empty( $this->queryPageInstance ) ) {
			$this->queryPageInstance = $this->getDataProvider();
		}

		return $this->queryPageInstance;
	}

	public function purgeCacheAfterUpdateTask() {
		return true;
	}

	/**
	 * The main method that assembles all data on articles that should be displayed
	 * on a given Insights subpage
	 *
	 * @return Mixed|null An array with data of articles i.e. title, url, metadata etc.
	 */
	public function fetchArticlesData() {
		$cacheKey = ( new InsightsCache( $this->getConfig() ) )->getMemcKey( InsightsCache::INSIGHTS_MEMC_ARTICLES_KEY );
		$articlesData = WikiaDataAccess::cache( $cacheKey, InsightsCache::INSIGHTS_MEMC_TTL, function () {
			$articlesData = [];

			$res = $this->getQueryPageInstance()->doQuery();

			if ( $res->numRows() > 0 ) {
				$articlesData = $this->prepareData( $res );

				if ( $this->getConfig()->showPageViews() ) {
					$articlesData = ( new InsightsPageViews( $this->getConfig() ) )->assignPageViewsData( $articlesData );
				}
			}

			return $articlesData;
		} );

		return $articlesData;
	}

	/**
	 * Removes an item from the querycache table if it has been fixed
	 *
	 * @param string $type A qc_type value
	 * @param Title $title A Title object for the article
	 * @return bool
	 * @throws DBUnexpectedError
	 */
	public function removeFixedItem( $type, Title $title ) {
		$dbw = wfGetDB( DB_MASTER );
		$dbw->delete(
			'querycache',
			[
				'qc_type' => $type,
				'qc_namespace' => $title->getNamespace(),
				'qc_title' => $title->getDBkey(),
			],
			__METHOD__
		);

		$affectedRows = $dbw->affectedRows();
		$dbw->commit( __METHOD__ );

		return $affectedRows > 0;
	}

	/**
	 * Get data for the next element that a user can take care of.
	 *
	 * @param string $type A key of a QueryPage
	 * @param string $articleName A title of an article
	 * @return Array The next item's data
	 */
	public function getNextItem( $type, $articleName ) {
		$next = [];

		$dbr = wfGetDB( DB_SLAVE );
		$articleName = $dbr->strencode( $articleName );

		$res = $dbr->select(
			'querycache',
			'qc_title',
			[ 'qc_type' => ucfirst( $type ), "qc_title != '$articleName'" ],
			'DatabaseBase::select',
			[ 'LIMIT' => 1 ]
		);

		if ( $res->numRows() > 0 ) {
			$row = $dbr->fetchObject( $res );

			$title = Title::newFromText( $row->qc_title );
			$next['link'] = InsightsHelper::getTitleLink( $title, self::getUrlParams() );
		}

		return $next;
	}
}
