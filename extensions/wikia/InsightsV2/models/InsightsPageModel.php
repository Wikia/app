<?php
/**
 * Abstract class that defines necessary set of methods for Insights page models
 */
use Wikia\Logger\Loggable;

abstract class InsightsPageModel extends InsightsModel {
	use Loggable;

	private $template = 'subpageList';
	private $insightsSorting;

	public function getPaginationUrlParams() {
		return [];
	}

	/**
	 * @return string A name of the page's template
	 */
	public function getTemplate() {
		return $this->template;
	}

	/**
	 * @return bool
	 */
	public function arePageViewsRequired() {
		return true;
	}

	public function hasAltAction() {
		return false;
	}

	public function getAltAction( Title $title ) {
		return [];
	}

	/**
	 * Tells whether link to Special:WhatLinksHere should be displayed for insight type
	 * @return bool
	 */
	public function isWlhLinkRequired() {
		return false;
	}

	public function purgeCacheAfterUpdateTask() {
		return true;
	}

	/**
	 * Returns an array of boolean values that you can use
	 * to toggle columns of a subpage's table view
	 * (e.g. turn the column with number of views on or off)
	 *
	 * @return array An array of boolean values
	 */
	public function getViewData() {
		$data['display'] = [
			'pageviews'	=> $this->arePageViewsRequired(),
			'altaction'	=> $this->hasAltAction(),
		];
		return $data;
	}

	/**
	 * Get list of articles related to the given QueryPage category
	 *
	 * @return array
	 */
	public function getContent( $params, $offset, $limit ) {


		$content = [];

		/**
		 * 1. Prepare data of articles - title, last revision, link etc.
		 */
		$articlesData = $this->fetchArticlesData();

		if ( !empty( $articlesData ) ) {

			/**
			 * 2. Slice a sorting table to retrieve a page
			 */

			$data = ( new InsightsSorting() )->getSortedData( $articlesData, $params );
			$ids = array_slice( $data, $offset, $limit, true );

			/**
			 * 3. Populate $content array with data for each article id
			 */
			foreach ( $ids as $id ) {
				$content[] = $articlesData[$id];
			}
		}

		return $content;
	}

	/**
	 * Prepares all data in a format that is easy to use for display.
	 *
	 * @param $res Results to display
	 * @return array
	 * @throws MWException
	 */
	public function prepareData( $res ) {
		$data = [];
		$dbr = wfGetDB( DB_SLAVE );
		$itemData = new InsightsItemData();

		while ( $row = $dbr->fetchObject( $res ) ) {
			if ( $row->title ) {
				$article = [];
				$params = $this->getUrlParams();

				$title = Title::newFromText( $row->title, $row->namespace );
				if ( $title === null ) {
					$this->error( 'InsightsPageModel received reference to non existent page' );
					continue;
				}
				$article['link'] = InsightsHelper::getTitleLink( $title, $params );

				$article['metadata']['lastRevision'] = $itemData->prepareRevisionData( $title->getLatestRevID() );

				if ( $this->isWlhLinkRequired() ) {
					$article['metadata']['wantedBy'] = [
						'message' => $this->wlhLinkMessage(),
						'value' => (int)$row->value,
						'url' => $itemData->getWlhUrl( $title ),
					];
				}

				if ( $this->arePageViewsRequired() ) {
					$article['metadata']['pv7'] = 0;
					$article['metadata']['pv28'] = 0;
					$article['metadata']['pvDiff'] = 0;
				}

				if ( $this->hasAltAction() ) {
					$article['altaction'] = $this->getAltAction( $title );
				}

				$data[ $title->getArticleID() ] = $article;
			}
		}

		return $data;
	}

	/**
	 * Get a type of a subpage and an edit parameter
	 * @return array
	 */
	public function getUrlParams() {
		$params = array_merge(
			InsightsHelper::getEditUrlParams(),
			$this->getInsightParam()
		);

		return $params;
	}

	/**
	 * Insights loop notification shown in view mode
	 * @return string
	 */
	public function getInProgressNotificationParams() {
		return '';
	}
}
