<?php
/**
 * Created by PhpStorm.
 * User: krzychu
 * Date: 23.05.14
 * Time: 09:33
 */

class GamesRssModel extends BaseRssModel {
	const FEED_NAME = 'games';
	const MAX_NUM_ITEMS_IN_FEED = 15;
	const GAMING_HUB_CITY_ID = 955764;
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

		if ($this->isFreshContentInDb(self::FEED_NAME)){
			return $this->getLastRecoredsFromDb(self::FEED_NAME,  self::MAX_NUM_ITEMS_IN_FEED);
		}

		$timestamp = $this->getLastFeedTimestamp(self::FEED_NAME) + 1;
		$duplicates = $this->getLastDuplicatesFromDb(self::FEED_NAME );
		$hubData = $this->getDataFromHubs($timestamp);
		$hubData = $this->removeDuplicates($hubData, $duplicates);
		$hubData = $this->findIdForUrls(array_keys($hubData));
		$blogData = $this->getDataFromBlogs($timestamp);
		$blogData =  $this->removeDuplicates($blogData, $duplicates);

		$rawData = array_merge(
			$blogData,
			$hubData
		);
		$out = $this->processItems($rawData);
		$this->addFeedsToDb($out,self::FEED_NAME,false);
		if(count($out) != self::MAX_NUM_ITEMS_IN_FEED){
			$out = $this->getLastRecoredsFromDb(self::FEED_NAME, self::MAX_NUM_ITEMS_IN_FEED,true);
		}
		return $out;
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

	protected function getDataFromHubs($fromTimestamp){
		$model = new HubRssFeedModel($this->getFeedLanguage());
		$v3 = $model->getRealDataV3( self::GAMING_HUB_CITY_ID,null,true);
		foreach($v3 as $key=>$item){
			if($item['timestamp'] < $fromTimestamp ){
				unset($v3[$key]);
			}else{
				//add url as item for compatibility
				$v3[$key]['url'] = $key;
			}
		}
		return $v3;
	}

	protected function findIdForUrls($urls){
		$data = [];
		if(!empty($urls)){
			$f2 = new \Wikia\Search\Services\FeedEntitySearchService();
			$f2->setUrls($urls);
			$res = $f2->query('');
			foreach($res as $item){
				$item['hub'] = true;
				$item['wikia_id'] = $item['wid'];
				$item['page_id'] = $item['pageid'];
				$data[$item['url']] = $item;
			}
		}
		return $data;
	}



}