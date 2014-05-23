<?php
/**
 * Created by PhpStorm.
 * User: krzychu
 * Date: 23.05.14
 * Time: 09:33
 */

class GamesRssModel extends BaseRssModel {
	const FEED_NAME = 'games';
	const MAX_NUM_ITEMS_IN_FEED = 30;

	public function getFeedTitle() {
		return 'Wikia Games Feed';
	}

	public function getFeedLanguage() {
		return 'en';
	}

	public function getFeedDescription() {
		return 'Wikia Games Feed';
	}

	public function getFeedData() {
		var_dump($this->getDataFromBlogs(0));
		die();
	}

	protected function getDataFromBlogs($fromTimestamp){
		$feedModel = new \Wikia\Search\Services\FeedEntitySearchService();
		$fromDate = date('Y-m-d\TH:i:s\Z', $fromTimestamp);
		$feedModel->setRowLimit(self::MAX_NUM_ITEMS_IN_FEED);
		$feedModel->setSorts(['created'=>'desc']);
		$rows = $feedModel->query( '((+host:"dragonage.wikia.com" AND +categories_mv_en:"News")
		| (+host:"warframe.wikia.com" AND +categories_mv_en:"Blog posts")
		| (+host:"monsterhunter.wikia.com" AND +categories_mv_en:"News")
		| (+host:"darksouls.wikia.com" AND +categories_mv_en:"News")
		| (+host:"halo.wikia.com" AND +categories_mv_en:"Blog_posts/News")
		| (+host:"gta.wikia.com" AND +categories_mv_en:"News")
		| (+host:"fallout.wikia.com" AND +categories_mv_en:"News")
		| (+host:"elderscrolls.wikia.com" AND +categories_mv_en:"News")
		| (+host:"leagueoflegends.wikia.com" AND +categories_mv_en:"News_blog")) AND created:[ '.$fromDate.' TO * ]' );
		return $rows;
	}



}