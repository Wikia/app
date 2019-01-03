<?php

class RecirculationApiController extends WikiaApiController {
	const ALLOWED_TYPES = ['recent_popular', 'vertical', 'community', 'curated', 'hero', 'category', 'latest', 'posts', 'all', 'stories'];

	/**
	 * @var CrossOriginResourceSharingHeaderHelper
	 */
	protected $cors;

	public function __construct() {
		parent::__construct();
		$this->cors = new CrossOriginResourceSharingHeaderHelper();
		$this->cors->setAllowAllOrigins();
	}

	public function getPopularWikiArticles() {
		$this->response->setCacheValidity( WikiaResponse::CACHE_STANDARD );
		$this->response->setData( WikiRecommendations::getPopularArticles() );
	}

	public function getDiscussions() {
		$this->cors->setHeaders( $this->response );

		$cityId = $this->getParamCityId();
		$type = $this->getParamType();

		if ( !RecirculationHooks::canShowDiscussions( $cityId ) ) {
			return;
		}

		$dataService = new DiscussionsDataService( $cityId );

		$data = $dataService->getData( $type );

		$this->response->setCacheValidity( WikiaResponse::CACHE_VERY_SHORT );
		$this->response->setData( $data );
	}

	private function getParamCityId() {
		$cityId = $this->request->getVal( 'cityId', 0 );

		if ( !empty( $cityId ) && !is_numeric( $cityId ) ) {
			throw new InvalidParameterApiException( 'cityId' );
		}

		return $cityId;
	}

	private function getParamType() {
		$type = $this->request->getVal( 'type', null );

		if ( !$type || !in_array( $type, self::ALLOWED_TYPES ) ) {
			throw new InvalidParameterApiException( 'type' );
		}

		return $type;
	}
}
