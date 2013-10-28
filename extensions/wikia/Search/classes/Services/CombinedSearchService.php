<?php

namespace Wikia\Search\Services;
use Wikia\Search\Config;
use Wikia\Search\Field\Field;
use Wikia\Search\QueryService\Factory;
use Wikia\Search\Utilities;

class CombinedSearchService {
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

	public function search($query, $langs, $hubs) {

		$wikias = [];
		foreach ( $langs as $lang ) {
			$crossWikiSearchConfig = new Config;
			$crossWikiSearchConfig->setQuery( $query )
				->setLimit( 5 )
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
			if ( sizeof( $wikias) >= 3 ) {
				break;
			}
		}
		$wikias = array_slice( $wikias, 0, 3 );

		$articles = [];
		foreach ( $wikias as $wiki ) {
			$requestedFields = ["title", "url", "id", "score", "pageid", "lang", "wid", Utilities::field('html', $wiki['lang'])];
			$searchConfig = new Config;
			$searchConfig->setQuery( $query )
				->setLimit( 2 )
				->setPage( 1 )
				->setOnWiki(true)
				->setRequestedFields( $requestedFields )
				->setWikiId( $wiki['wikiId'] )
				->setNamespaces( [ NS_MAIN ] )
				->setRank( 'default' );
			$resultSet = (new Factory)->getFromConfig( $searchConfig )->search();
			$currentResults = $resultSet->toArray( $requestedFields );
			foreach ( $currentResults as $article ) {
				$articles[] = $this->processArticle($article);
			}
		}

		return [
			"wikias" => $wikias,
			"articles" => $articles,
		];
	}

	private function processWiki( $wikiInfo ) {
		$outputModel = [];
		$outputModel['wikiId'] = $wikiInfo['id'];
		$outputModel['name'] = $wikiInfo['sitename_txt'][0];
		$outputModel['url'] = $wikiInfo['url'];
		$outputModel['lang'] = $wikiInfo['lang_s'];
		$outputModel['snippet'] = $wikiInfo['description_txt'];

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
			$outputModel['snippet'] = trim( wfShortenText( $fullText, 200, true ) );
		}
		return $outputModel;
	}

	private function getTopArticles( $wikiId, $lang ) {
		return \WikiaDataAccess::cache( wfSharedMemcKey( "CombinedSearchService", $wikiId, $lang ), 60 * 60 * 24 * 7, function() use( $wikiId, $lang ) {
			$requestedFields = [ "title", "url", "id", "score", "pageid", "lang", "wid", Utilities::field('html', $lang) ];
			$topArticlesMap = \DataMartService::getTopArticlesByPageview(
				$wikiId,
				null,
				[0],
				false,
				5
			);

			$query = " +(" . Utilities::valueForField("wid", $wikiId) . ") ";
			$query .= " +( " . implode( " OR ", array_map(function( $x ) { return Utilities::valueForField("pageid", $x); }, array_keys($topArticlesMap)) ) . ") ";

			$searchConfig = new Config;
			$searchConfig
				->setLimit( 5 )
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

			return $articles;
		});
	}
}
