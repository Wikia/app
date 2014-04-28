<?php

use Wikia\Search\Services\TvSearchService;

class MoviesApiController extends WikiaApiController {

	const LANG_SETTING = 'en';
	const API_URL = 'api/v1/Articles/AsSimpleJson?id=';
	const WIKIA_URL_REGEXP = '~^(http(s?)://)(([^\.]+)\.wikia\.com)~';
	const RESPONSE_CACHE_VALIDITY = 86400; /* 24h */
	const DEFAULT_MOVIE_QUALITY = 80;
	/** @var TvSearchService tvService */
	protected $tvService;

	public function getMovie() {
		$movieName = $this->getRequiredParam( 'movieName' );
		$lang = $this->getRequest()->getVal( 'lang', static::LANG_SETTING );

		$result = $this->findMovie( $movieName, $lang );
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

	protected function findMovie( $movieName, $lang, $minQuality = self::DEFAULT_MOVIE_QUALITY ) {
		$tvs = $this->getTvSearchService();

		$result = $tvs->queryMovie( $movieName, $lang, $tvs::MOVIE_TYPE, null, $minQuality );
		if (!empty($result)) {
			return $result;
		}

		//movie was not found
		throw new NotFoundApiException();
	}

	protected function getTvSearchService() {
		if ( !isset( $this->tvService ) ) {
			$this->tvService = new TvSearchService();
		}
		return $this->tvService;
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