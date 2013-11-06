<?php

namespace Wikia\Search\Services;
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
		$timer = Time::start(["CombinedSearchService", "search"]);
		$wikias = [];
		foreach ( $langs as $lang ) {
			$crossWikiSearchConfig = new Config;
			$crossWikiSearchConfig->setQuery( $query )
				->setLimit( self::CROSS_WIKI_RESULTS )
				->setPage( 1 )
				->setRank( 'default' )
				->setInterWiki( true )
				->setCommercialUse( $this->getHideNonCommercialContent() )
				->setLanguageCode( $lang );
			if ( !empty($hubs) ) {
				$crossWikiSearchConfig->setHubs( $hubs );
			}
			$crossWikiResultSet = (new Factory)->getFromConfig( $crossWikiSearchConfig )->search();
			$crossWikiResults = $crossWikiResultSet->toArray( ["sitename_txt", "url", "id", "description_txt", "lang_s", "score", "description_txt"] );
			foreach ( $crossWikiResults as $wiki ) {
				$wikias[] = $this->processWiki( $wiki );
			}
			if ( sizeof( $wikias) >= self::CROSS_WIKI_RESULTS ) {
				break;
			}
		}
		$wikias = array_slice( $wikias, 0, self::CROSS_WIKI_RESULTS );
		$total = ( $limit !== null ) ? $limit : self::MAX_TOTAL_ARTICLES;
		$articlesPerWiki = min ( (int)ceil( $total / count( $wikias ) ), self::MAX_ARTICLES_PER_WIKI );

		$articles = [];
		foreach ( $wikias as $wiki ) {
			$requestedFields = ["title", "url", "id", "score", "pageid", "lang", "wid", Utilities::field('html', $wiki['lang'])];
			$searchConfig = new Config;
			$searchConfig->setQuery( $query )
				->setLimit( $articlesPerWiki )
				->setPage( 1 )
				->setOnWiki(true)
				->setRequestedFields( $requestedFields )
				->setWikiId( $wiki['wikiId'] )
				->setNamespaces( $namespaces )
				->setFilterQuery( "is_main_page:false" )
				->setRank( 'default' );
			$resultSet = (new Factory)->getFromConfig( $searchConfig )->search();
			$currentResults = $resultSet->toArray( $requestedFields );
			foreach ( $currentResults as $article ) {
				$articles[] = $this->processArticle($article);
			}
		}
		$timer->stop();
		return [
			"wikias" => $wikias,
			"articles" => array_slice( $articles, 0, $total )
		];
	}

	private function processWiki( $wikiInfo ) {
		$wikiService = new \WikiService();

		$outputModel = [];
		$outputModel['wikiId'] = $wikiInfo['id'];
		$outputModel['name'] = $wikiInfo['sitename_txt'][0]; // this is multivalue field
		$outputModel['url'] = $wikiInfo['url'];
		$outputModel['lang'] = $wikiInfo['lang_s'];
		$outputModel['snippet'] = $wikiInfo['description_txt'];
		$outputModel['wordmark'] = $wikiService->getWikiWordmark( $outputModel['wikiId'] );

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

		// try set $outputModel['image']
		$dbName = '';
		try {
			$row = \WikiFactory::getWikiByID( $outputModel['wikiId'] );
			if ( $row ) {
				$dbName = $row->city_dbname;
				if ( !empty( $dbName ) ) {
					$db = wfGetDB( DB_SLAVE, [], $dbName ); // throws if database does not exits.
					$imageServing = new \ImageServing(
						[ $outputModel['articleId'] ],
						self::IMAGE_SIZE,
						self::IMAGE_SIZE,
						$db
					);
					$images = $imageServing->getImages(1)[$outputModel['articleId']];
					if ( $images && sizeof( $images ) > 0 ) {
						$imageName = $images[0]['name'];
						$file = \GlobalFile::newFromText( $imageName, $outputModel['wikiId'] );
						if ( $file->exists() ) {
							$outputModel['image'] = ( $imageServing->getUrl($file, $file->getWidth(), $file->getHeight()) );
						}
					}
				}
			}
		} catch ( \DBConnectionError $ex ) {
			// Swallow this exception. there is no simple way of telling if database does not exist other than catching exception.
			// Or am I wrong ?
			\Wikia::log(__METHOD__, false, "Cannot get database connection to " . $dbName );
		}
		return $outputModel;
	}

	private function getTopArticles( $wikiId, $lang ) {
		return \WikiaDataAccess::cache( wfSharedMemcKey( "CombinedSearchService", $wikiId, $lang ), self::TOP_ARTICLES_CACHE_TIME, function() use( $wikiId, $lang ) {
			$timer = Time::start(["CombinedSearchService", "getTopArticles"]);
			$requestedFields = [ "title", "url", "id", "score", "pageid", "lang", "wid", Utilities::field('html', $lang) ];
			$topArticlesMap = \DataMartService::getTopArticlesByPageview(
				$wikiId,
				null,
				[ NS_MAIN ],
				false,
				self::TOP_ARTICLES_PER_WIKI
			);

			$query = " +(" . Utilities::valueForField("wid", $wikiId) . ") ";
			$query .= " +( " . implode( " OR ", array_map(function( $x ) { return Utilities::valueForField("pageid", $x); }, array_keys($topArticlesMap)) ) . ") ";

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
				$articles[] = $this->processArticle($article);
			}
			$timer->stop();
			return $articles;
		});
	}
}
