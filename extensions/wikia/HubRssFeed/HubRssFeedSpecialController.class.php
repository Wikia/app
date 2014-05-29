<?php

class HubRssFeedSpecialController extends WikiaSpecialPageController {
	const SPECIAL_NAME = 'HubRssFeed';
	const CACHE_KEY = 'HubRssFeed';
	const CACHE_TIME = 3600;
	const DAY_QUARTER = 21600;
	const CACHE_10MIN = 600;
	/** Use it after release to generate new memcache keys. */
	const CACHE_BUST = 26;
	const RSS_CONTENT_TYPE = 'text/xml; charset=utf-8';

	protected $customFeeds = [
		TvRssModel::FEED_NAME=>true,
		GamesRssModel::FEED_NAME=>true,
		LifestyleHubOnlyRssModel::FEED_NAME => true,
		EntertainmentHubOnlyRssModel::FEED_NAME => true
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

		foreach ( $this->customFeeds as $k => $v ) {
			$links[ ] = $url . '/' . ucfirst( $k );
		}

		$this->setVal( 'links', $links );
		$this->wg->SupressPageSubtitle = true;

	}


	public function index() {
		$params = $this->request->getParams();
		$hubName = strtolower( (string)$params[ 'par' ] );
		if ( !isset( $this->customFeeds[ $hubName ] ) ) {
			return $this->forward( 'HubRssFeedSpecial', 'notfound' );
		}
		$this->response->setCacheValidity( self::CACHE_TIME );

		$service = new RssFeedService();
		$model = BaseRssModel::newFromName( $hubName );
		$service->setFeedLang( $model->getFeedLanguage() );
		$service->setFeedTitle( $model->getFeedTitle() );
		$service->setFeedDescription( $model->getFeedDescription() );
		$service->setFeedUrl( RequestContext::getMain()->getRequest()->getFullRequestURL() );
		$service->setData( $model->getFeedData() );
		$this->response->setFormat( WikiaResponse::FORMAT_RAW );
		$this->response->setBody( $service->toXml() );
		$this->response->setContentType( self::RSS_CONTENT_TYPE );
	}

}
