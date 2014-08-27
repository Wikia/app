<?php
/*TODO: Refactor in 20% (mostly copied from GamesRssFeed)*/
class MarvelRssModel extends BaseRssModel {
	const FEED_NAME = 'Marvel';
	const LANGUAGE = 'en';
	const MAX_NUM_ITEMS_IN_FEED = 15;
	const SOURCE_BLOGS = 'blogs';

	public function getFeedTitle() {
		return 'Wikia Marvel Feed';
	}

	public function getFeedDescription() {
		return 'From Wikia community - Marvel Feed';
	}

	public function loadData( $lastTimestamp, $duplicates ) {
 		$blogData = $this->getDataFromBlogs( $lastTimestamp );
		$blogData = $this->removeDuplicates( $blogData, $duplicates );

		$out = $this->finalizeRecords($blogData, self::getFeedName() );
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
		$feedModel->addFilters(['hc'=>'+((+host:"marvel.wikia.com" AND +categories_mv_en:"News posts")) +ns:500']);

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
		}
		return $item;
	}


}