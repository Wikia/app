<?php

class GamesRssModel extends BaseRssModel {
	const FEED_NAME = 'games';
	const URL_ENDPOINT = '/Games';
	const MAX_NUM_ITEMS_IN_FEED = 15;
	const GAMING_HUB_CITY_ID = 955764;
	const FRESH_CONTENT_TTL_HOURS = 24;
	const SOURCE_BLOGS = 'blogs';

	public function getFeedTitle() {
		return 'Wikia Games Feed';
	}

	public function getFeedLanguage() {
		return 'en';
	}

	public function getFeedDescription() {
		return 'From Wikia community - Video Games';
	}

	public function getFeedData() {

		if ( $this->forceRegenerateFeed == false && $this->isFreshContentInDb( self::FEED_NAME, self::FRESH_CONTENT_TTL_HOURS ) ) {
			return $this->getLastRecordsFromDb( self::FEED_NAME, self::MAX_NUM_ITEMS_IN_FEED );
		}

		$timestamp = $this->getLastFeedTimestamp( self::FEED_NAME ) + 1;
		$duplicates = $this->getLastDuplicatesFromDb( self::FEED_NAME );

		$blogData = $this->getDataFromBlogs( $timestamp );
		$blogData = $this->removeDuplicates( $blogData, $duplicates );
		$hubData = [];
		if ( !empty( $blogData ) || $this->forceRegenerateFeed ) {
			$hubData = $this->getDataFromHubs( self::GAMING_HUB_CITY_ID, $timestamp, $duplicates );
		}
		$rawData = array_merge(
			$blogData,
			$hubData
		);

		$out = $this->finalizeRecords($rawData,self::MAX_NUM_ITEMS_IN_FEED, self::FEED_NAME );
		return $out;
	}

	protected function getDataFromBlogs( $fromTimestamp ) {
		if(!$fromTimestamp){
			$fromTimestamp = strtotime("now - 1 month");
		}
		$feedModel = new \Wikia\Search\Services\FeedEntitySearchService();
		$fromDate = date( 'Y-m-d\TH:i:s\Z', $fromTimestamp );
		$feedModel->setRowLimit( self::MAX_NUM_ITEMS_IN_FEED );
		$feedModel->setSorts( [ 'created' => 'desc' ] );
		$feedModel->setFilters(['hc'=>'+((+host:"dragonage.wikia.com" AND +categories_mv_en:"News")
		| (+host:"warframe.wikia.com" AND +categories_mv_en:"Blog posts")
		| (+host:"monsterhunter.wikia.com" AND +categories_mv_en:"News")
		| (+host:"darksouls.wikia.com" AND +categories_mv_en:"News")
		| (+host:"halo.wikia.com" AND +categories_mv_en:"Blog_posts/News")
		| (+host:"gta.wikia.com" AND +categories_mv_en:"News")
		| (+host:"fallout.wikia.com" AND +categories_mv_en:"News")
		| (+host:"elderscrolls.wikia.com" AND +categories_mv_en:"News")
		| (+host:"leagueoflegends.wikia.com" AND +categories_mv_en:"News_blog")) +ns:500']);

		$rows = $feedModel->query( '+created:[ ' . $fromDate . ' TO * ]');
		foreach($rows as &$item){
			//TODO: find better way for this
			$item[ 'source' ] = self::SOURCE_BLOGS;
		}
		return $rows;
	}


	protected function formatTitle( $item ) {
		switch ( $item[ 'source' ] ) {
			case self::SOURCE_BLOGS:
				$item = $this->makeBlogTitle( $item );
				break;
			case self::SOURCE_HUB:
				//no change
				break;
		}
		return $item;
	}


}