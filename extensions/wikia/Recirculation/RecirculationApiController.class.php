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
			$svg = '<svg width="85" height="14" viewBox="0 0 85 14" xmlns="http://www.w3.org/2000/svg"><title>3216B25B-5B57-41DF-B996-91D3F5256E0E</title><g fill-rule="evenodd"><path fill="#BE1E2C" d="M64.093 13.104h5.313V.124h-5.313z"/><path d="M44.285 13.104h5.313V.124h-5.313zM32.26.124v12.98h4.776V8.552h5.278V5.558h-5.278v-2.25h6.369V.124z"/><path d="M22.393.124l-5.543 12.98h4.245l.865-2.025h6.039l.864 2.025h4.246L27.565.124h-5.172zM24.98 4.01l1.74 4.075h-3.48l1.74-4.075zM54.245.124l-5.544 12.98h4.246l.865-2.025h6.038l.865 2.025h4.246L59.417.124h-5.172zm2.586 3.886l1.74 4.075h-3.48l1.74-4.075z"/><path d="M11.732.124L8.817 6.95 5.9.124H0v12.98h4.013v-7.53l3.187 7.53.028-.032.014.032h3.151l.008-.017.033.017 3.188-7.534v7.534h4.013V.124z"/><path fill="#BE1E2C" d="M71.187 13.104H76.5V.124h-5.313zM78.281.124v12.98h5.313V1.457L84.887.124z"/></g></svg>';
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
