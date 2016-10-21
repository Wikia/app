<?php

class PopularArticlesModel {
	const REQUIRED_MIN_QUALITY = 80;
	const DEFAULT_RESULTS_NUMBER = 200;

	/**
	 * @return bool|string
	 */
	protected function lastWeeklyRollupDate() {
		$now = strtotime( 'last Sunday' );
		return date( 'Y-m-d', $now );
	}


	/**
	 * Returns a list of recently edited ADN popular articles
	 *
	 * @param $wiki_id
	 * @return array
	 */
	public function getArticles( $wiki_id ) {
		$page_ids = $this->getRecentlyEditedPageIds( $wiki_id );
		$quality_results = $this->filterResultsOverQuality( $wiki_id, $page_ids );
		$results = $this->sortByWeeklyPageviews( $quality_results, $wiki_id, $page_ids );

		return array_slice( $results, 0, self::DEFAULT_RESULTS_NUMBER );
	}

	/**
	 * Fetches up to 200 most recently edited articles from a given wiki
	 *
	 * @param $wiki_id
	 * @return ResultWrapper
	 */
	protected function getRecentlyEditedPageResult( $wiki_id ) {
		$sdb = wfGetDB( DB_SLAVE, [ ], WikiFactory::IDtoDB( $wiki_id ) );
		return $sdb->query( 'select page_id,page_title from page where page_namespace = 0 order by page_latest desc limit ' . self::DEFAULT_RESULTS_NUMBER );
	}


	/**
	 * Fetches up to 200 most recently edited articles from a given wiki (without Mainpages)
	 *
	 * @param $wiki_id
	 * @return array
	 */
	protected function getRecentlyEditedPageIds( $wiki_id ) {
		$result = $this->getRecentlyEditedPageResult( $wiki_id );
		$page_ids = [ ];
		while ( $row = $result->fetchObject() ) {
			$title = Title::newFromText( $row->page_title );

			if ( $title instanceof Title && !$title->isMainPage() ) {
				$page_ids [ ] = intval( $row->page_id );
			}
		}

		return $page_ids;
	}

	/**
	 * @param $wiki_id
	 * @param $page_ids
	 */
	private function filterResultsOverQuality( $wiki_id, $page_ids ) {
		$solr_ids = array_map( function ( $id ) use ( $wiki_id ) {
			return $wiki_id . '_' . $id;
		}, $page_ids );

		$service = new \Wikia\Search\Services\FeedEntitySearchService();
		$service->setIds( $solr_ids );
		$service->setQuality( self::REQUIRED_MIN_QUALITY );
		return $service->query( '' );
	}

	/**
	 * @param $wiki_id
	 * @param $page_ids
	 */
	private function getPageViewsMap( $wiki_id, $page_ids ) {
		global $wgDWStatsDB;

		$pageviews_map = [ ];

		$ddb = wfGetDB( DB_SLAVE, [ ], $wgDWStatsDB );

		$sql = 'select * from rollup_wiki_article_pageviews where '
			. 'wiki_id = ' . (int)$wiki_id
			. ' and period_id = 2 '
			. ' and namespace_id = 0 and time_id="' . $this->lastWeeklyRollupDate() . '" '
			. ' and article_id in (' . implode( ',', $page_ids ) . ') ';

		$stats = $ddb->query( $sql );

		while ( $object = $stats->fetchObject() ) {
			$pageviews_map[ $object->article_id ] = $object->pageviews;
		}

		return $pageviews_map;
	}

	/**
	 * @param $articlefeed
	 * @param $wiki_id
	 * @param $page_ids
	 * @return array
	 */
	private function sortByWeeklyPageviews( $articlefeed, $wiki_id, $page_ids ) {
		$results = [ ];

		$pageviews_map = $this->getPageViewsMap( $wiki_id, $page_ids );

		foreach ( $articlefeed as $feed_item ) {
			$pageviews [ ] = intval( $pageviews_map[ $feed_item[ 'pageid' ] ] );
			$results[ ] = [
				'url' => $feed_item[ 'url' ],
				'wikia_id' => $wiki_id,
				'page_id' => $feed_item[ 'pageid' ],
			];
		}

		array_multisort( $pageviews, SORT_DESC, SORT_NUMERIC, $results );
		return $results;
	}
}
