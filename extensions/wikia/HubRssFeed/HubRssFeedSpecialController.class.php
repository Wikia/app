<?php

class HubRssFeedSpecialController extends WikiaSpecialPageController {
	const SPECIAL_NAME = 'HubRssFeed';
	const CACHE_KEY = 'HubRssFeed';
	const CACHE_TIME = 3600;
	const DAY_QUARTER = 21600;
	const CACHE_10MIN = 600;
	/** Use it after release to generate new memcache keys. */
	const CACHE_BUST = 26;

	protected $hubs = [
		'gaming' => WikiFactoryHub::CATEGORY_ID_GAMING,
		'entertainment' => WikiFactoryHub::CATEGORY_ID_ENTERTAINMENT,
		'lifestyle' => WikiFactoryHub::CATEGORY_ID_LIFESTYLE
	];

	protected $customFeeds = [
		TvRssModel::FEED_NAME=>true,
		GamesRssModel::FEED_NAME=>true
	];

	/**
	 * @var HubRssFeedModel
	 */
	protected $model;

	/**
	 * @var Title
	 */
	protected $currentTitle;

	/**
	 * @param \HubRssFeedModel $model
	 */
	public function setModel( $model ) {
		$this->model = $model;
	}

	/**
	 * @return \HubRssFeedModel
	 */
	public function getModel() {
		return $this->model;
	}


	public function __construct() {
		parent::__construct( self::SPECIAL_NAME, self::SPECIAL_NAME, false );
		$this->currentTitle = SpecialPage::getTitleFor( self::SPECIAL_NAME );
	}


	public function notfound() {
		$url = $this->currentTitle->getFullUrl();
		$links = [];

		foreach ( $this->hubs as $k => $v ) {
			$links[ ] = $url . '/' . ucfirst( $k );
		}

		$this->setVal( 'links', $links );
		$this->wg->SupressPageSubtitle = true;

	}


	public function index() {
		global $wgHubRssFeedCityIds;

		$params = $this->request->getParams();

		$hubName = strtolower( (string)$params[ 'par' ] );

		if ( !isset( $this->hubs[ $hubName ] ) ) {
			if ( isset( $this->customFeeds[$hubName] ) ) {
				return $this->forward( 'HubRssFeedSpecial', 'customRss' );
			}
			return $this->forward( 'HubRssFeedSpecial', 'notfound' );
		}

		$langCode = $this->app->wg->ContLang->getCode();
		$this->model = new HubRssFeedModel($langCode);

		$memcKey = wfMemcKey( self::CACHE_KEY, $hubName, self::CACHE_BUST, $langCode );

		$xml = $this->wg->memc->get( $memcKey );
		if ( $xml === false ) {
			$service = new HubRssFeedService($langCode, RequestContext::getMain()->getRequest()->getFullRequestURL() );
			$verticalId = $this->hubs[ $hubName ];
			$cityId = isset( $wgHubRssFeedCityIds[ $hubName ] ) ? $wgHubRssFeedCityIds[ $hubName ] : 0;
			$data = array_merge( $this->model->getRealDataV3( $cityId ), $this->model->getRealDataV2( $verticalId ) );
			$xml = $service->dataToXml( $data, $verticalId );
			$this->wg->memc->set( $memcKey, $xml, self::CACHE_TIME );
		}

		$this->response->setFormat( WikiaResponse::FORMAT_RAW );
		$this->response->setBody( $xml );
		$this->response->setContentType( 'text/xml' );
	}

	public function customRss() {
		$this->response->setCacheValidity( self::CACHE_TIME );
		$service = new RssFeedService();
		$par = $this->request->getVal( 'par' );
		$model = BaseRssModel::newFromName( $par );
		$service->setFeedLang( $model->getFeedLanguage() );
		$service->setFeedTitle( $model->getFeedTitle() );
		$service->setFeedDescription( $model->getFeedDescription() );
		$service->setFeedUrl( RequestContext::getMain()->getRequest()->getFullRequestURL() );
		$service->setData( $model->getFeedData() );
		$this->response->setFormat( WikiaResponse::FORMAT_RAW );
		$this->response->setBody( $service->toXml() );
		$this->response->setContentType( 'text/xml' );
	}

}
