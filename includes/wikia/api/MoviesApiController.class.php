<?php

use Wikia\Search\Services\TvSearchService;

class MoviesApiController extends WikiaApiController {

	const LANG_SETTING = 'en';
	const RESPONSE_CACHE_VALIDITY = 86400; /* 24h */
	const DEFAULT_MOVIE_QUALITY = 80;
	/** @var TvSearchService tvService */
	protected $tvService;

	public function getMovie() {
		$movieName = $this->getRequiredParam( 'movieName' );
		$lang = $this->getRequest()->getVal( 'lang', static::LANG_SETTING );

		$result = $this->findMovie( $movieName, $lang );

		$response = $this->getResponse();
		$response->setValues( $result );

		$response->setCacheValidity(self::RESPONSE_CACHE_VALIDITY);
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

}