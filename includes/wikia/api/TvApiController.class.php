<?php

use Wikia\Search\Config;
use Wikia\Search\QueryService\Factory;
use Wikia\Search\Services\TvSearchService;

class TvApiController extends WikiaApiController {

	const LANG_SETTING = 'en';
	const NAMESPACE_SETTING = 0;
	const API_URL = 'api/v1/Articles/AsSimpleJson?id=';
	const WIKIA_URL_REGEXP = '~^(http(s?)://)(([^\.]+)\.wikia\.com)~';
	const RESPONSE_CACHE_VALIDITY = 86400; /* 24h */
	const MOVIEPEDIA_WIKI = 559;
	/** @var Array wikis */
	protected $wikis = [];
	/** @var TvSearchService tvService */
	protected $tvService;

	public function getMovie() {
		$movieName = $this->getRequiredParam( 'movieName' );

		$result = $this->findMovie( $movieName );
		$output = $this->createOutput( $result );

		$response = $this->getResponse();
		$response->setValues( $output );

		$response->setCacheValidity(self::RESPONSE_CACHE_VALIDITY);
	}

	protected function getRequiredParam( $name ) {
		$query = $this->getRequest()->getVal( $name, null );
		if ( empty( $query ) || $query === null ) {
			throw new InvalidParameterApiException( $name );
		}
		return $query;
	}

	protected function findMovie( $movieName ) {
		$tvs = $this->getTvSearchService();

		$result = $tvs->queryMovie( $movieName, self::LANG_SETTING, $tvs::MOVIE_TYPE, null, 80 );
		if (!empty($result)) {
			return $result;
		}
		//else try moviepedia
//		$moviepediaResult = $tvs->queryMovie( $movieName, self::LANG_SETTING, null, self::MOVIEPEDIA_WIKI, 50 );

//		if ( !empty( $moviepediaResult ) ) {
//			return $moviepediaResult;
//		}

		//movie was not found
		throw new NotFoundApiException();
	}

	public function getEpisode() {
		$request = $this->getRequest();
		$seriesName = $this->getRequiredParam( 'seriesName' );
		$episodeName = $this->getRequiredParam( 'episodeName' );
		$lang = $request->getVal( 'lang', static::LANG_SETTING );
		$minQuality = $request->getVal( 'minArticleQuality', null );
		if ( $minQuality !== null ) {
			$minQuality = (int)$minQuality;
		}

		$result = $this->findEpisode( $seriesName, $episodeName, $lang, $minQuality );
		$output = $this->createOutput( $result );

		$response = $this->getResponse();
		$response->setValues( $output );

		$response->setCacheValidity(self::RESPONSE_CACHE_VALIDITY);
	}

	protected function findEpisode( $seriesName, $episodeName, $lang, $quality = null ) {
		$tvs = $this->getTvSearchService();
		$wikis = $tvs->queryXWiki( $seriesName, $lang );
		if ( !empty( $wikis ) ) {
			$result = null;
			foreach( $wikis as $wiki ) {
				$result = $tvs->queryMain( $episodeName, $lang, $tvs::EPISODE_TYPE, $wiki[ 'id' ], $quality );
				if ( $result === null ) {
					$result = $this->getTitle( $episodeName, $wiki['id'] );
				}
				if ( $result !== null ) {
					if ( ( $quality == null ) || ( $result[ 'quality' ] !== null && $result[ 'quality' ] >= $quality ) ) {
						return array_merge( $wiki, $result );
					}
				}
			}
		}
		//episode was not found
		throw new NotFoundApiException();
	}

	protected function getTvSearchService() {
		if ( !isset( $this->tvService ) ) {
			$this->tvService = new TvSearchService();
		}
		return $this->tvService;
	}

	protected function getTitle( $text, $wikiId ) {
		//try exact phrase
		$underscoredText = str_replace( ' ', '_', $text );
		$title = $this->createTitle( $underscoredText, $wikiId );
		if ( !$title->exists() ) {
			$serializedText = str_replace( ' ', '_', ucwords( strtolower( $text ) ) );
			$title = $this->createTitle( $serializedText, $wikiId );
		}
		if ( $title->isRedirect() ) {
			$title = $title->getRedirectTarget();
		}
		if ( $title->exists() ) {
			$articleId = (int)$title->getArticleID();
			return [
				'articleId' => $articleId,
				'title' => $title->getText(),
				'url' => $title->getFullURL(),
				'quality' => $this->getArticleQuality( $wikiId, $articleId )
			];
		}
		return null;
	}

	protected function createTitle($text, $wikiId) {
		return GlobalTitle::newFromText( $text, NS_MAIN, $wikiId );
	}

	protected function getArticleQuality( $wikiId, $articleId ) {
		$responseValues = $this->getQualityFromSolr( $wikiId, $articleId );
		if ( !empty( $responseValues ) && isset( $responseValues[ 0 ][ 'quality' ] ) ) {
			return $responseValues[ 0 ][ 'quality' ];
		}

		return null;
	}

	protected function getQualityFromSolr( $wikiId, $articleId ) {
		$config = $this->getConfigById( $wikiId, $articleId );
		return ( new Factory )->getFromConfig( $config )->searchAsApi( ['article_quality_i' => 'quality'  ], false );
	}

	protected function getConfigById( $wikiId, $articleId ) {
		$searchConfig = new Config();
		$searchConfig->setQuery( '*' )
			->setLimit( 1 )
			->setPage( 1 )
			->setWikiId( (int)$wikiId )
			->setVideoSearch( false )
			->setOnWiki( true )
			->setPageId( (int)$articleId )
			->setNamespaces( [ static::NAMESPACE_SETTING ] );
		return $searchConfig;
	}

	protected function createOutput( $data ) {
		global $wgStagingEnvironment, $wgDevelEnvironment;

		$data[ 'contentUrl' ] = 'http://' . $data[ 'wikiHost' ] . '/' . self::API_URL . $data[ 'articleId' ];
		unset( $data['wikiHost'] );

		if ( $wgStagingEnvironment || $wgDevelEnvironment ) {
			$data[ 'contentUrl' ] = preg_replace_callback( self::WIKIA_URL_REGEXP, array( $this, 'replaceHost' ), $data[ "contentUrl" ] );
			$data[ 'url' ] = preg_replace_callback( self::WIKIA_URL_REGEXP, array( $this, 'replaceHost' ), $data[ "url" ] );
		}

		return $data;
	}

	protected function replaceHost( $details ) {
		return $details[ 1 ] . WikiFactory::getCurrentStagingHost( $details[ 4 ], $details[ 3 ] );
	}
}
