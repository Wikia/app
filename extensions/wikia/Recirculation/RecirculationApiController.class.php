<?php

class RecirculationApiController extends WikiaApiController {
	const ALLOWED_TYPES = ['popular', 'shares', 'recent_popular', 'vertical', 'community', 'curated', 'e3', 'hero'];

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

		if ( $type === 'curated' ) {
			$dataService = new CuratedContentService();
		} elseif ( $type === 'hero' ) {
			$dataService = new FandomDataService( $cityId );
		} else {
			$dataService = new ParselyDataService( $cityId );
		}

		$posts = $dataService->getPosts( $type );

		$this->response->setCacheValidity( WikiaResponse::CACHE_VERY_SHORT );
		$this->response->setData( [
			'title' => wfMessage( 'recirculation-fandom-title' )->plain(),
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
		if ( RecirculationHooks::canShowDiscussions() ) {
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
}
