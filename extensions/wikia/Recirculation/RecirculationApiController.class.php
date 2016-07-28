<?php

class RecirculationApiController extends WikiaApiController {
	const ALLOWED_TYPES = ['recent_popular', 'vertical', 'community', 'curated', 'e3', 'hero', 'category'];
	const FANDOM_LIMIT = 5;

	/**
	 * @var CrossOriginResourceSharingHeaderHelper
	 */
	protected $cors;

	public function __construct(){
		parent::__construct();
		$this->cors = new CrossOriginResourceSharingHeaderHelper();
		$this->cors->setAllowOrigin( [ '*' ] );
	}

	public function getFandomPosts() {
		$this->cors->setHeaders($this->response);

		$type = $this->getParamType();
		$cityId = $this->getParamCityId();
		$limit = $this->getParamLimit();
		$fill = $this->getParamFill();

		$title = wfMessage( 'recirculation-fandom-title' )->plain();

		if ( $type === 'curated' ) {
			$dataService = new CuratedContentService();
		} elseif ( $type === 'hero' || $type === 'category' ) {
			$dataService = new FandomDataService( $cityId, $type );
		} else {
			$dataService = new ParselyDataService( $cityId );
		}

		$posts = $dataService->getPosts( $type, $limit );

		if ( $fill === 'true' && count( $posts ) < $limit ) {
			$ds = new ParselyDataService( $cityId );
			$posts = array_slice( array_merge( $posts, $ds->getPosts( 'recent_popular', $limit ) ), 0, $limit );
		}

		$this->response->setCacheValidity( WikiaResponse::CACHE_VERY_SHORT );
		$this->response->setData( [
			'title' => $title,
			'posts' => $posts,
		] );
	}

	public function getCakeRelatedContent() {
		$this->cors->setHeaders($this->response);

		$target = trim($this->request->getVal('relatedTo'));
		if (empty($target)) {
			throw new InvalidParameterApiException('relatedTo');
		}

		$limit = trim($this->request->getVal('limit'));
		$ignore = trim($this->request->getVal('ignore'));

		$this->response->setCacheValidity(WikiaResponse::CACHE_VERY_SHORT);
		$this->response->setData([
				'title' => wfMessage( 'recirculation-fandom-subtitle' )->plain(),
				'items' => (new CakeRelatedContentService())->getContentRelatedTo($target, $limit, $ignore),
		]);
	}

	public function getAllPosts() {
		$this->cors->setHeaders($this->response);

		$cityId = $this->getParamCityId();

		$parselyDataService = new ParselyDataService( $cityId );
		$fandom = [
			'title' => wfMessage( 'recirculation-fandom-title' )->plain(),
			'items' => $parselyDataService->getPosts( 'recent_popular', 12 )
		];

		$discussionsData = [];
		if ( RecirculationHooks::canShowDiscussions( $cityId ) ) {
			$discussionsDataService = new DiscussionsDataService( $cityId );
			$discussionsData = $discussionsDataService->getData();
			$discussionsData['title'] = wfMessage( 'recirculation-discussion-title' )->plain();
			$discussionsData['linkText'] = wfMessage( 'recirculation-discussion-link-text' )->plain();
		}

		$this->response->setCacheValidity( WikiaResponse::CACHE_VERY_SHORT );
		$this->response->setData( [
			'title' => wfMessage( 'recirculation-impact-footer-title' )->plain(),
			'fandom' => $fandom,
			'discussions' => $discussionsData,
		] );
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

	private function getParamFill() {
		$fill = $this->request->getVal( 'fill', false );

		if ( !empty( $fill ) && ( $fill !== 'true' && $fill !== 'false' ) ) {
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
