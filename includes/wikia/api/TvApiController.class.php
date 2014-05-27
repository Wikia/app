<?php

use Wikia\Search\Config;
use Wikia\Search\QueryService\Factory;
use Wikia\Search\Services\SeriesEntitySearchService;
use Wikia\Search\Services\EpisodeEntitySearchService;


class TvApiController extends WikiaApiController {

	const LANG_SETTING = 'en';
	const NAMESPACE_SETTING = 0;
	const RESPONSE_CACHE_VALIDITY = 86400; /* 24h */
	const DEFAULT_QUALITY = 20;

	const WG_EXTRA_LOCAL_NAMESPACES_KEY = 'wgExtraNamespacesLocal';
	const WG_CONTENT_NAMESPACES_KEY = 'wgContentNamespaces';
	/** @var Array wikis */
	protected $wikis = [ ];
	/** @var SeriesEntitySearchService seriesService */
	protected $seriesService;
	/** @var EpisodeEntitySearchService episodeService */
	protected $episodeService;

	public function getEpisode() {
		$request = $this->getRequest();
		$seriesName = $this->getRequiredParam( 'seriesName' );
		$episodeName = $this->getRequiredParam( 'episodeName' );
		$lang = $request->getVal( 'lang', static::LANG_SETTING );
		$minQuality = $request->getVal( 'minArticleQuality', null );
		if ( $minQuality !== null ) {
			$minQuality = (int)$minQuality;
		}

		$episodes = explode( ';', $episodeName );
		$result = null;
		foreach ( $episodes as $episode ) {
			$result = $this->findEpisode( $seriesName, trim($episode), $lang, $minQuality );
			if( $result ) break;
		}
		if (!$result) {
			throw new NotFoundApiException();
		}

		$response = $this->getResponse();
		$response->setValues( $result );

		$response->setCacheValidity( self::RESPONSE_CACHE_VALIDITY );
	}

	protected function findEpisode( $seriesName, $episodeName, $lang, $quality = null ) {

		// TODO: this is a workaround to not alter schema of main index too much
		// once the next gen search is implemented such workarounds would not be needed hopefully

		// this replaces american right apostrophe with normal one
		$episodeName = str_replace("’", "'", $episodeName);

		$seriesService = $this->getSeriesService();
		$seriesService->setLang( $lang );
		$wikis = $seriesService->query( $seriesName );
		if ( !empty( $wikis ) ) {
			$episodeService = $this->getEpisodeService();
			$episodeService->setLang( $lang )
				->setQuality( ($quality !== null ) ? $quality : static::DEFAULT_QUALITY );
			$result = null;
			foreach ( $wikis as $wiki ) {
				$episodeService->setWikiId( $wiki[ 'id' ] );
				$namespaces = WikiFactory::getVarValueByName( self::WG_CONTENT_NAMESPACES_KEY, $wiki[ 'id' ] );
				$episodeService->setNamespace( $namespaces );
				$result = $episodeService->query( $episodeName );
				if ( $result === null ) {
					$result = $this->getTitle( $episodeName, $wiki[ 'id' ] );
				}
				if ( $result === null ) {
					$namespaceNames = WikiFactory::getVarValueByName( self::WG_EXTRA_LOCAL_NAMESPACES_KEY, $wiki[ 'id' ] );
					if ( is_array( $namespaces ) ) {
						foreach ( $namespaces as $ns ) {
							if ( !MWNamespace::isTalk($ns) && isset( $namespaceNames[ $ns ] ) ) {
								$result = $episodeService->query( $namespaceNames[ $ns ].":".$episodeName );
								if ( $result !== null ) break;
							}
						}
					}
				}
				if ( $result !== null ) {
					if ( ( $quality == null ) || ( $result[ 'quality' ] !== null && $result[ 'quality' ] >= $quality ) ) {
						return $result;
					}
				}
			}
		}
		return false;
	}

	protected function getSeriesService() {
		if ( !isset( $this->seriesService ) ) {
			$this->seriesService = new SeriesEntitySearchService();
		}
		return $this->seriesService;
	}

	protected function getEpisodeService() {
		if ( !isset( $this->episodeService ) ) {
			$this->episodeService = new EpisodeEntitySearchService();
		}
		return $this->episodeService;
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
				'wikiId' => $wikiId,
				'articleId' => $articleId,
				'title' => $title->getText(),
				'url' => $title->getFullURL(),
				'quality' => $this->getArticleQuality( $wikiId, $articleId ),
				'contentUrl' => $this->getContentUrl( $wikiId, $articleId )
			];
		}
		return null;
	}

	protected function getContentUrl( $wikiId, $articleId ) {
		return $this->getEpisodeService()->replaceHostUrl(
			WikiFactory::DBtoUrl( WikiFactory::IDtoDB( $wikiId ) )
			. EpisodeEntitySearchService::API_URL . $articleId
		);
	}

	protected function createTitle( $text, $wikiId ) {
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
		return ( new Factory )->getFromConfig( $config )->searchAsApi( [ 'article_quality_i' => 'quality' ], false );
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
}
