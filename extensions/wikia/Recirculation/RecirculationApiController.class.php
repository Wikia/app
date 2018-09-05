<?php

class RecirculationApiController extends WikiaApiController {
	const ALLOWED_TYPES = ['recent_popular', 'vertical', 'community', 'curated', 'hero', 'category', 'latest', 'posts', 'all', 'stories'];
	const FANDOM_LIMIT = 5;

	/**
	 * @var CrossOriginResourceSharingHeaderHelper
	 */
	protected $cors;

	public function __construct() {
		parent::__construct();
		$this->cors = new CrossOriginResourceSharingHeaderHelper();
		$this->cors->setAllowAllOrigins();
	}

	public function getFandomPosts() {
		$this->cors->setHeaders( $this->response );

		$type = $this->getParamType();
		$cityId = $this->getParamCityId();
		$limit = $this->getParamLimit();
		$fill = $this->getParamFill();
		$slug = $this->getParamSlug();

		$title = wfMessage( 'recirculation-fandom-title' )->plain();
		$dataService = $this->getDataServiceInstance($type, $cityId);
		$posts = $dataService->getPosts( $type === 'stories' ? $slug : $type, $limit );

		if ( $fill === 'true' && count( $posts ) < $limit ) {
			$ds = new ParselyDataService( $cityId );
			$posts = array_slice( array_merge( $posts, $ds->getPosts( 'recent_popular', $limit ) ), 0, $limit );
		}

		$this->response->setCacheValidity( WikiaResponse::CACHE_STANDARD );
		$this->response->setData( [
			'title' => $title,
			'posts' => $posts,
		] );
	}

	public function getPopularWikiArticles() {
		$this->response->setCacheValidity( WikiaResponse::CACHE_STANDARD );
		$this->response->setData( WikiRecommendations::getPopularArticles() );
	}

	private function getDataServiceInstance($type, $cityId) {
		if ( $type === 'curated' ) {
			$dataService = new CuratedContentService();
		} elseif ( $type === 'hero' || $type === 'category' || $type === 'latest' ) {
			$dataService = new FandomDataService( $cityId, $type );
		} elseif ( $type === 'stories' ) {
			$dataService = new CurationCMSService();
		} else {
			$dataService = new ParselyDataService( $cityId );
		}

		return $dataService;
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

	private function getParamSlug() {
		return $this->request->getVal( 'slug', null );
	}

	private function getParamFill() {
		$fill = $this->request->getVal( 'fill', 'false' );

		if ( $fill !== 'true' && $fill !== 'false' ) {
			throw new InvalidParameterApiException( 'fill' );
		}

		return $fill;
	}

	private function getParamLimit() {
		$limit = $this->request->getVal( 'limit', self::FANDOM_LIMIT );

		if ( !empty( $limit ) && !is_numeric( $limit ) ) {
			throw new InvalidParameterApiException( 'limit' );
		}

		return $limit;
	}
}
