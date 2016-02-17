<?php

class InsightsContext {
	private $strategy = null;
	private $config = null;
	private $articlesData = [];
	private $params = [];
	private $paginator = null;

	public function __construct( InsightsModel $strategy, $params = [] ) {
		$this->strategy = $strategy;
		$this->config = $strategy->getConfig();
		$this->params = $params;
	}

	/**
	 * Get list of articles related to the given QueryPage category
	 *
	 * @return array
	 */
	public function getContent() {
		$content = [];

		$this->articlesData = $this->fetchData();
		if ( !empty ( $this->articlesData ) ) {
			$sortedIds = $this->sortData();
			$content = $this->sliceData( $sortedIds );
		}

		return $content;
	}

	public function fetchData() {
		$cacheKey = ( new InsightsCache( $this->config ) )->getMemcKey( InsightsCache::INSIGHTS_MEMC_ARTICLES_KEY );
		$articlesData = WikiaDataAccess::cache( $cacheKey, InsightsCache::INSIGHTS_MEMC_TTL, function () {
			$articlesData  = $this->strategy->fetchArticlesData();
			$articlesData = $this->prepareData( $articlesData );

			if ( $this->config->showPageViews() ) {
				$articlesData = ( new InsightsPageViews( $this->config ) )->assignPageViewsData( $articlesData );
			}

			return $articlesData;
		} );

		return $articlesData;
	}

	public function getPagination() {
		return $this->getPaginator()->getPagination();
	}

	/**
	 * Prepares all data in a format that is easy to use for display.
	 *
	 * @param Array $res Results to display
	 * @return array
	 * @throws MWException
	 */
	private function prepareData( $pages ) {
		$data = [];
		$itemData = new InsightsItemData( $this->config, $this->strategy->getUrlParams() );

		foreach ( $pages as $page ) {
			$title = $page['title'];

			if ( !$title instanceof Title ) {
				continue;
			}

			$article = $itemData->getArticleData( $title );

			if ( $this->config->showWhatLinksHere() ) {
				$article['metadata']['wantedBy'] = $itemData->getWhatLinksHereData( $title, $page['value'] );
			}

			if ( $this->config->hasAction() ) {
				$article['altaction'] = $this->strategy->getAction( $title );
			}

			if ( !empty ( $page['pageId'] ) ) {
				$data[ $page['pageId'] ] = $article;
			} else {
				$data[] = $article;
			}
		}

		return $data;
	}

	private function sortData() {
		return ( new InsightsSorting( $this->config ) )->getSortedData( $this->articlesData, $this->params );
	}

	private function sliceData( $sortedIds ) {
		$content = [];
		$offset = $this->getPaginator()->getOffset();
		$limit = $this->getPaginator()->getLimit();

		$ids = array_slice( $sortedIds, $offset, $limit, true );

		foreach ( $ids as $id ) {
			$content[] = $this->articlesData[$id];
		}

		return $content;
	}

	private function getPaginator() {
		if ( is_null( $this->paginator ) ) {
			$this->paginator = new InsightsPaginator( $this->config->getInsightType(), $this->params );
		}

		return $this->paginator;
	}
}
