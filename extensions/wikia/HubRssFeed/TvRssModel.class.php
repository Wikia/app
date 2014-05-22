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
/*
		if ($this->isFreshContentInDb(self::FEED_NAME)){
			return $this->getLastRecoredsFromDb(self::FEED_NAME);
		}
		return [];*/
		$rawData = $this->getWikiaArticlesFromExt();
		$duplicates = $this->getLastDuplicatesFromDb(self::FEED_NAME );
		$rawData = $this->removeDuplicates($rawData, $duplicates);
		$wikis = [];
		foreach($rawData as $item){
			$wikis[$item['wikia_id']] = true;
		}
		$model = new PopularArticlesModel();

		foreach($wikis as $wid=>$v ){
			$list = $model->getArticles($wid);
			foreach($list as $item){
				if(!array_key_exists($item['url'],$duplicates)){
					$rawData[] = $item;
					break;
				}
			}

		}
		$out = $this->processItems($rawData);
		var_dump($rawData,$out);
		//$this->addFeedsToDb($out,self::FEED_NAME);
		//var_dump($duplicates,$out);
		die();
		//return $out;
	}

	protected function getTVEpisodes() {
		$data = simplexml_load_file( self::TVRAGE_RSS_YESTERDAY ) ;
		if(!$data){
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