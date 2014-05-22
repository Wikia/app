<?php
/**
 * Created by PhpStorm.
 * User: krzychu
 * Date: 21.05.14
 * Time: 15:44
 */

class TvRssModel extends BaseRssModel {
	const FEED_NAME = 'tv';
	const TVRAGE_RSS_YESTERDAY = "http://www.tvrage.com/myrss.php?class=scripted&date=yesterday";
	const TVRAGE_RSS_TODAY = "http://www.tvrage.com/myrss.php?class=scripted&date=today";
	const MIN_ARTICLE_QUALITY = 30;
	const MAX_NUM_ITEMS_IN_FEED = 10;
	public function getFeedTitle() {
		return 'Wikia Tv Shows';
	}

	public function getFeedLanguage() {
		return 'en';
	}

	public function getFeedDescription() {
		return 'Wikia Tv Shows';
	}

	public function getFeedData() {

		if ($this->isFreshContentInDb(self::FEED_NAME)){
			return $this->getLastRecoredsFromDb(self::FEED_NAME,  self::MAX_NUM_ITEMS_IN_FEED);
		}

		$additionalContent = false;
		$rawData = $this->getWikiaArticlesFromExt();
		if(empty($rawData)) {
			$additionalContent = true;
		}
		$duplicates = $this->getLastDuplicatesFromDb(self::FEED_NAME );
		$rawData = $this->removeDuplicates($rawData, $duplicates);
		$externalDataCount = count($rawData);
		if( $externalDataCount < self::MAX_NUM_ITEMS_IN_FEED){
			$wikis = [];
			if(!empty($rawData)){
				foreach($rawData as $item){
					$wikis[$item['wikia_id']] = true;
				}
				$wikis = array_keys($wikis);

			}elseif( $additionalContent ) {
				$wikis = $this->getWikisFromPast();
			}

			$rawData = $this->getPopularContent($rawData,$wikis,$duplicates, self::MAX_NUM_ITEMS_IN_FEED - $externalDataCount );
		}

		$out = $this->processItems($rawData);
		$this->addFeedsToDb($out,self::FEED_NAME);

		if(count($out) != self::MAX_NUM_ITEMS_IN_FEED){
			$out = $this->getLastRecoredsFromDb(self::FEED_NAME, self::MAX_NUM_ITEMS_IN_FEED,true);
		}
		return $out;
	}

	protected function getWikisFromPast(){
		//select distinct(wrf_wikia_id) from  wikia_rss_feeds  where wrf_feed='tv' order by wrf_pub_date desc limit 3
		$wikisData= ( new WikiaSQL() )
			->SELECT(' distinct(wrf_wikia_id) wid ')
			->FROM( 'wikia_rss_feeds' )
			->WHERE('wrf_feed')->EQUAL_TO(self::FEED_NAME)
			->ORDER_BY('wrf_pub_date DESC')
			 ->LIMIT(3)
			->runLoop( $this->getDbSlave(), function (&$wikisData, $row )   {
					$wikisData[] = $row->wid;
				}
			);
		return $wikisData;

	}


	protected function getTVEpisodes() {
		//TODO: Use Http::get
		$data = simplexml_load_file( self::TVRAGE_RSS_YESTERDAY ) ;
		if(!$data){
			\Wikia\Logger\WikiaLogger::instance()->error(__METHOD_." : No content from TVRAGE !");
			return [];
		}
		$items = $data->children();
		$episodes = [];
		foreach ($items->children() as $elem) {
			if (!empty($elem->title)) {
				$EData = $this->parseTitle((string)$elem->title);
				$EData['episode_title'] = (string)$elem->description;
				if (!empty($EData['episode_title'])) {
					$episodes[] = $EData;
				}
			}
		}
		return $episodes;
	}

	protected function getWikiaArticles( $episodes ) {
		$data = [];
		foreach ( $episodes as $i => $episode ) {
			try {
				$response = $this->sendRequest( 'TvApiController', 'getEpisode', [
					'seriesName' => $episode['title'],
					'episodeName' => $episode['episode_title'],
					'minArticleQuality' => self::MIN_ARTICLE_QUALITY
				]);
				$item = $response->getData();
				$item['wikia_id'] = $item['wikiId'];
				$item['page_id'] = $item['articleId'];
				unset($item['wikiId'], $item['articleId']);
				$data[] = $item;
			} catch (Exception $e) {
				\Wikia\Logger\WikiaLogger::instance()->error(__METHOD_." : ". $e->getMessage());
			}
		}
		return $data;
	}


	protected function parseTitle($episodeRssTitle) {
		$episodeRssTitle = str_replace("- ", "", trim($episodeRssTitle));
		$titleArr = explode(" (", $episodeRssTitle);
		$parsed = array(
			"title" => $titleArr[0],
			"series" => "",
			"episode" => ""
		);
		if ( count($titleArr) > 1) {
			$epData = explode("x", trim($titleArr[1], ")"));
			$parsed['series'] = $epData[0];
			$parsed['episode'] = $epData[1];
		}
		return $parsed;
	}

	protected function getWikiaArticlesFromExt(){
		return $this->getWikiaArticles($this->getTVEpisodes());
	}
}