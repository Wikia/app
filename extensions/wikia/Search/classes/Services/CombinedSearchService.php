<?php

namespace Wikia\Search\Services;
use WikiService;
use Wikia\Measurements\Time;
use Wikia\Search\Config;
use Wikia\Search\Field\Field;
use Wikia\Search\QueryService\Factory;
use Wikia\Search\Utilities;

class CombinedSearchService {
	const CROSS_WIKI_RESULTS = 3;
	const MAX_ARTICLES_PER_WIKI = 5;
	const TOP_ARTICLES_PER_WIKI = 3;
	const MAX_TOTAL_ARTICLES = 6;
	const SNIPPET_LENGTH = 200;
	const IMAGE_SIZE = 80;
	const TOP_ARTICLES_CACHE_TIME = 604800; // 60 * 60 * 24 * 7 - one week

	/**
	 * @var bool
	 */
	private $hideNonCommercialContent = false;

	/**
	 * @var WikiService
	 */
	private $wikiService;

	function __construct( $wikiService = null ) {
		$this->wikiService = $wikiService === null ? new WikiService() : $wikiService;
	}

	/**
	 * @param \WikiService $wikiService
	 */
	public function setWikiService($wikiService) {
		$this->wikiService = $wikiService;
	}

	/**
	 * @return \WikiService
	 */
	public function getWikiService() {
		return $this->wikiService;
	}

	/**
	 * @param boolean $hideNonCommercialContent
	 */
	public function setHideNonCommercialContent($hideNonCommercialContent) {
		$this->hideNonCommercialContent = $hideNonCommercialContent;
	}

	/**
	 * @return boolean
	 */
	public function getHideNonCommercialContent() {
		return $this->hideNonCommercialContent;
	}

	public function search($query, $langs, $namespaces, $hubs, $limit = null) {
		$timer = Time::start([__CLASS__, __METHOD__]);
		$wikias = $this->searchForWikias($query, $langs, $hubs);

		$limit = ( $limit !== null ) ? $limit : self::MAX_TOTAL_ARTICLES;
		if ( !empty( $wikias ) ) {
			//set only if we have any wikis to check
			$maxArticlesPerWiki = min ( (int)ceil( $limit / count( $wikias ) ), self::MAX_ARTICLES_PER_WIKI );
			$articles = $this->searchForArticles($query, $namespaces, $wikias, $maxArticlesPerWiki);
			$timer->stop();
			return [
				"wikias" => $wikias,
				"articles" => array_slice( $articles, 0, $limit )
			];
		} else {
			return [
				"wikias" => [],
				"articles" => []
			];
		}
	}

	/**
	 * @param $query
	 * @param $namespaces
	 * @param $wikias
	 * @param $maxArticlesPerWiki
	 * @return array
	 */
	public function searchForArticles($query, $namespaces, $wikias, $maxArticlesPerWiki) {
		$timer = Time::start([__CLASS__, __METHOD__]);
		$articles = [];
		foreach ($wikias as $wiki) {
			$currentResults = $this->querySolrForArticles($query, $namespaces, $maxArticlesPerWiki, $wiki['wikiId'], $wiki['lang']);
			foreach ($currentResults as $article) {
				$articles[] = $this->processArticle($article);
			}
		}
		$timer->stop();
		return $articles;
	}

	/**
	 * @param $query
	 * @param $namespaces
	 * @param $maxArticlesPerWiki
	 * @param $wikiId
	 * @param $wikiLang
	 * @return array
	 */
	protected function querySolrForArticles($query, $namespaces, $maxArticlesPerWiki, $wikiId, $wikiLang) {
		$requestedFields = ["title", "url", "id", "score", "pageid", "lang", "wid", Utilities::field('html', $wikiLang)];
		$searchConfig = new Config;
		$searchConfig->setQuery($query)
			->setLimit($maxArticlesPerWiki)
			->setPage(1)
			->setOnWiki(true)
			->setRequestedFields($requestedFields)
			->setWikiId($wikiId)
			->setNamespaces($namespaces)
			->setFilterQuery("is_main_page:false")
			->setRank('default');
		$resultSet = (new Factory)->getFromConfig($searchConfig)->search();
		$currentResults = $resultSet->toArray($requestedFields);
		return $currentResults;
	}

	/**
	 * @param $query
	 * @param $langs
	 * @param $hubs
	 * @return array
	 */
	public function searchForWikias($query, $langs, $hubs) {
		$timer = Time::start([__CLASS__, __METHOD__]);
		$wikias = [];
		foreach ($langs as $lang) {
			$crossWikiResults = $this->queryForWikias($query, $hubs, $lang);
			foreach ($crossWikiResults as $wikiSearchResult) {
				$wikias[] = $this->processWiki($wikiSearchResult);
			}
			if (sizeof($wikias) >= self::CROSS_WIKI_RESULTS) {
				break;
			}
		}
		$wikias = array_slice($wikias, 0, self::CROSS_WIKI_RESULTS);
		$timer->stop();
		return $wikias;
	}

	/**
	 * @param $query
	 * @param $hubs
	 * @param $lang
	 * @return array
	 */
	public function queryForWikias($query, $hubs, $lang) {
		$crossWikiSearchConfig = new Config;
		$crossWikiSearchConfig->setQuery($query)
			->setLimit(self::CROSS_WIKI_RESULTS)
			->setPage(1)
			->setRank('default')
			->setInterWiki(true)
			->setCommercialUse($this->getHideNonCommercialContent())
			->setLanguageCode($lang);
		if ( !empty($hubs) ) {
			$crossWikiSearchConfig->setHubs($hubs);
		}
		$crossWikiResultSet = (new Factory)->getFromConfig($crossWikiSearchConfig)->search();
		$crossWikiResults = $crossWikiResultSet->toArray(["sitename_txt", "url", "id", "description_txt", "lang_s", "score", "description_txt"]);
		return $crossWikiResults;
	}

	protected function processWiki( $wikiInfo ) {
		$outputModel = [];
		$outputModel['wikiId'] = (int) $wikiInfo['id'];
		$outputModel['name'] = $wikiInfo['sitename_txt'][0]; // this is multivalue field
		$outputModel['url'] = $wikiInfo['url'];
		$outputModel['lang'] = $wikiInfo['lang_s'];
		$outputModel['snippet'] = $wikiInfo['description_txt'];
		$outputModel['wordmark'] = $this->wikiService->getWikiWordmark( $outputModel['wikiId'] );

		$outputModel['topArticles'] = $this->getTopArticles( $outputModel['wikiId'], $outputModel['lang'] );

		return $outputModel;
	}

	private function processArticle( $articleInfo ) {
		$outputModel = [];
		$outputModel['wikiId'] = $articleInfo['wid'];
		$outputModel['articleId'] = $articleInfo['pageid'];
		$outputModel['title'] = $articleInfo['title'];
		$outputModel['url'] = $articleInfo['url'];
		$outputModel['lang'] = $articleInfo['lang'];

		if ( isset($articleInfo[Utilities::field('html', $articleInfo['lang'])]) ) {
			$fullText = $articleInfo[Utilities::field('html', $articleInfo['lang'])];
			$outputModel['snippet'] = trim( wfShortenText( $fullText, self::SNIPPET_LENGTH, true ) );
		}
		$image = $this->getImage($outputModel["wikiId"], $outputModel["articleId"]);
		if ( !empty($image) ) {
			$outputModel['image'] = $image;
		}

		return $outputModel;
	}

	/**
	 * @param $outputModel
	 * @return mixed
	 */
	protected function getImage( $wikiId, $articleId ) {
		$dbName = '';
		try {
			$row = \WikiFactory::getWikiByID($wikiId);
			if ($row) {
				$dbName = $row->city_dbname;
				if (!empty($dbName)) {
					$db = wfGetDB(DB_SLAVE, [], $dbName); // throws if database does not exits.
					$imageServing = new \ImageServing(
						[$articleId],
						self::IMAGE_SIZE,
						self::IMAGE_SIZE,
						$db
					);
					$images = $imageServing->getImages(1)[$articleId];
					if ($images && sizeof($images) > 0) {
						$imageName = $images[0]['name'];
						$file = \GlobalFile::newFromText($imageName, $wikiId);
						if ($file->exists()) {
							return ($imageServing->getUrl($file, $file->getWidth(), $file->getHeight()));
						}
					}
				}
			}
		} catch (\DBConnectionError $ex) {
			// Swallow this exception. there is no simple way of telling if database does not exist other than catching exception.
			// Or am I wrong ?
			\Wikia::log(__METHOD__, false, "Cannot get database connection to " . $dbName);
		}
		return null;
	}

	protected function getTopArticles( $wikiId, $lang ) {
		return \WikiaDataAccess::cache( wfSharedMemcKey( "CombinedSearchService", $wikiId, $lang ), self::TOP_ARTICLES_CACHE_TIME, function() use( $wikiId, $lang ) {
			$timer = Time::start(["CombinedSearchService", "getTopArticles"]);
			$requestedFields = [ "title", "url", "id", "score", "pageid", "lang", "wid", Utilities::field('html', $lang) ];
			$topArticlesMap = \DataMartService::getTopArticlesByPageview(
				$wikiId,
				null,
				[ NS_MAIN ],
				false,
				self::TOP_ARTICLES_PER_WIKI + 1
			);

			$query = " +(" . Utilities::valueForField("wid", $wikiId) . ") ";
			$query .= " +( " . implode( " OR ", array_map(function( $x ) { return Utilities::valueForField("pageid", $x); }, array_keys($topArticlesMap)) ) . ") ";
			$query .= " +(is_main_page:false) ";

			$searchConfig = new Config;
			$searchConfig
				->setLimit( self::TOP_ARTICLES_PER_WIKI )
				->setQuery( $query )
				->setPage( 1 )
				->setRequestedFields( $requestedFields )
				->setDirectLuceneQuery(true)
				->setWikiId( $wikiId );

			$resultSet = (new Factory)->getFromConfig( $searchConfig )->search();

			$currentResults = $resultSet->toArray( $requestedFields );
			$articles = [];
			foreach ( $currentResults as $article ) {
				$articles[ $article[ 'pageid' ] ] = $this->processArticle($article);
				if ( sizeof($articles) >= self::TOP_ARTICLES_PER_WIKI ) {
					break;
				}
			}
			$result = [];
			foreach ( $topArticlesMap as $id => $a ) {
				if ( isset( $articles[ $id ] ) ) {
					$result[] = $articles[ $id ];
				}
			}

			$timer->stop();
			return $result;
		});
	}
}
