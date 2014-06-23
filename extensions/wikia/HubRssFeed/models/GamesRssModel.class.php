<?php

class GamesRssModel extends BaseRssModel {
	const FEED_NAME = 'Games';
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

	public function loadData( $lastTimestamp, $duplicates ) {
 		$blogData = $this->getDataFromBlogs( $lastTimestamp );
		$blogData = $this->removeDuplicates( $blogData, $duplicates );
		$hubData = $this->getDataFromHubs( self::GAMING_HUB_CITY_ID, $lastTimestamp, $duplicates );

		$rawData = array_merge(
			$blogData,
			$hubData
		);

		$out = $this->finalizeRecords($rawData, self::FEED_NAME );
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
		$feedModel->addFilters(['hc'=>'+((+host:"dragonage.wikia.com" AND +categories_mv_en:"News")
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