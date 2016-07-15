<?php

class RecirculationApiController extends WikiaApiController {
	const ALLOWED_TYPES = ['recent_popular', 'vertical', 'community', 'curated', 'e3', 'hero', 'category'];

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

		$title = wfMessage( 'recirculation-fandom-title' )->plain();

		if ( $type === 'curated' ) {
			$dataService = new CuratedContentService();
		} elseif ( $type === 'hero' || $type === 'category' ) {
			$dataService = new FandomDataService( $cityId );
		} else {
			$dataService = new ParselyDataService( $cityId );
		}

		if ( $type === 'category') {
			$svg = '<svg xmlns="http://www.w3.org/2000/svg" width="47" height="11" viewBox="0 0 47 11"><g><path d="M46.02 4.19C45.46 3.6 44.67 3.29 43.74 3.29 42.79 3.29 42.02 3.72 41.54 4.5 41.06 3.72 40.28 3.29 39.33 3.29 38.4 3.29 37.62 3.6 37.06 4.19 36.54 4.74 36.25 5.51 36.25 6.35L36.25 9.86 38.01 9.86 38.01 6.35C38.01 5.41 38.49 4.86 39.33 4.86 40.18 4.86 40.66 5.41 40.66 6.35L40.66 9.86 42.42 9.86 42.42 6.35C42.42 5.41 42.9 4.86 43.74 4.86 44.58 4.86 45.07 5.41 45.07 6.35L45.07 9.86 46.83 9.86 46.83 6.35C46.83 5.51 46.54 4.74 46.02 4.19"/><path d="M4.12 0.16C3.97 0.14 3.83 0.12 3.67 0.12 1.57 0.12 0.15 1.45 0.15 3.44L0.15 9.86 1.91 9.86 1.91 5.14 3.75 5.14 3.75 3.57 1.91 3.57 1.91 3.43C1.91 2.31 2.53 1.74 3.76 1.74 3.88 1.74 3.99 1.76 4.11 1.78 4.16 1.78 4.2 1.79 4.25 1.8L4.34 1.81 4.34 0.19 4.27 0.18C4.22 0.17 4.17 0.16 4.12 0.16"/><path d="M9.71 6.61C9.71 7.75 9.12 8.35 8.01 8.35 6.49 8.35 6.26 7.26 6.26 6.61 6.26 5.5 6.9 4.86 8.01 4.86 9.1 4.86 9.65 5.43 9.71 6.61M11.47 6.93C11.47 6.81 11.47 6.7 11.47 6.6 11.38 4.56 10.06 3.29 8.01 3.29 6.95 3.29 6.06 3.63 5.42 4.26 4.83 4.85 4.5 5.68 4.5 6.59 4.5 8.49 5.93 9.92 7.82 9.92 8.72 9.92 9.46 9.6 9.95 8.98 10.02 9.27 10.12 9.55 10.25 9.82L10.27 9.86 12.04 9.86 11.99 9.75C11.5 8.71 11.48 7.64 11.47 6.93"/><path d="M16.23 3.29C15.22 3.29 14.37 3.63 13.76 4.26 13.2 4.85 12.88 5.69 12.88 6.61L12.88 9.86 14.64 9.86 14.64 6.61C14.64 5.5 15.22 4.86 16.23 4.86 17.25 4.86 17.83 5.5 17.83 6.61L17.83 9.86 19.58 9.86 19.58 6.61C19.58 5.69 19.27 4.85 18.7 4.26 18.1 3.63 17.24 3.29 16.23 3.29"/><path d="M25.79 6.61C25.79 7.75 25.2 8.35 24.09 8.35 22.56 8.35 22.33 7.26 22.33 6.61 22.33 5.5 22.97 4.86 24.09 4.86 25.18 4.86 25.73 5.43 25.79 6.61M27.3 6.61L27.3 1.04 25.6 1.04 25.6 3.66C25.06 3.43 24.67 3.29 24 3.29 21.92 3.29 20.53 4.62 20.53 6.59 20.53 8.49 21.97 9.92 23.88 9.92 24.85 9.92 25.55 9.65 26.01 9.08 26.09 9.38 26.2 9.7 26.33 10L26.35 10.05 28.12 10.05 28.07 9.95C27.5 8.72 27.3 7.28 27.3 6.61"/><path d="M33.62 6.61C33.62 7.72 32.99 8.35 31.9 8.35 30.8 8.35 30.17 7.72 30.17 6.61 30.17 5.5 30.8 4.86 31.9 4.86 32.99 4.86 33.62 5.5 33.62 6.61M31.9 3.29C29.84 3.29 28.41 4.66 28.41 6.61 28.41 8.56 29.84 9.92 31.9 9.92 33.95 9.92 35.38 8.56 35.38 6.61 35.38 4.66 33.95 3.29 31.9 3.29"/></g></svg>';
			$title = "Fandom @ <strong>Comic-Con</strong><br /><span>Presented by $svg</span>";
		}

		$posts = $dataService->getPosts( $type );

		if ( $type === 'category' && count( $posts) < 5) {
			$ds = new FandomDataService( $cityId );
			$posts = array_merge( $posts, $ds->getPosts( $type, true ) );
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
