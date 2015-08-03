<?php

/**
 * Abstract class that defines necessary set of methods for Insights QueryPage models
 */
abstract class InsightsQueryPageModel extends InsightsPageModel {

	protected
		$queryPageInstance;

	public
		$loopNotificationConfig = [
			'displayFixItMessage' => true,
		];

	abstract function getDataProvider();

	public function getInsightCacheParams() {
		return null;
	}

	/**
	 * @return QueryPage An object of a QueryPage's child class
	 */
	protected function getQueryPageInstance() {
		return $this->queryPageInstance;
	}

	public function wlhLinkMessage() {
		return 'insights-wanted-by';
	}

	public function purgeCacheAfterUpdateTask() {
		return true;
	}

	public function initModel( $params ) {
		$this->queryPageInstance = $this->getDataProvider();
	}

	/**
	 * Returns a whole config for loop notification mechanism or its single property
	 * @param string $singleProperty
	 * @return string|array
	 */
	public function getLoopNotificationConfig( $singleProperty = '' ) {
		if ( !empty( $singleProperty )
			&& isset( $this->loopNotificationConfig[$singleProperty] )
		) {
			return $this->loopNotificationConfig[$singleProperty];
		}

		return $this->loopNotificationConfig;
	}

	/**
	 * The main method that assembles all data on articles that should be displayed
	 * on a given Insights subpage
	 *
	 * @return Mixed|null An array with data of articles i.e. title, url, metadata etc.
	 */
	public function fetchArticlesData() {
		$cacheKey = $this->getMemcKey( self::INSIGHTS_MEMC_ARTICLES_KEY );
		$articlesData = WikiaDataAccess::cache( $cacheKey, self::INSIGHTS_MEMC_TTL, function () {
			$articlesData = [];

			$res = $this->queryPageInstance->doQuery();

			if ( $res->numRows() > 0 ) {
				$articlesData = $this->prepareData( $res );

				if ( $this->arePageViewsRequired() ) {
					$articlesIds = array_keys( $articlesData );
					$pageViewsData = $this->getPageViewsData( $articlesIds );
					$articlesData = $this->assignPageViewsData( $articlesData, $pageViewsData );
				}
			}

			return $articlesData;
		} );

		return $articlesData;
	}

	/**
	 * Function for sorting list alphabetical
	 */
	public function sortInsightsAlphabetical( $a, $b ) {
		return strcasecmp( $a['link']['text'], $b['link']['text'] );
	}

	/**
	 * Prepares a link to a Special:WhatLinksHere page
	 * for the article
	 * @param Title $title The target article's title object
	 * @param $result A number of referring links
	 * @param string $message A message key
	 * @return string A URL to the WLH page
	 * @throws MWException
	 */
	public function makeWlhLink( Title $title, $result ) {
		$wlh = SpecialPage::getTitleFor( 'Whatlinkshere', $title->getPrefixedText() );
		$label = wfMessage( $this->wlhLinkMessage() )->numParams( $result->value )->escaped();
		return Linker::link( $wlh, $label );
	}

	/**
	 * Removes an item from the querycache table if it has been fixed
	 *
	 * @param $type A qc_type value
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
