<?php

class HubRssFeedSpecialController extends WikiaSpecialPageController {
	const SPECIAL_NAME = 'HubRssFeed';
	const CACHE_TIME = 3600;
	const RSS_CONTENT_TYPE = 'text/xml; charset=utf-8';

	/**
	 * @var HubRssFeedModel
	 */
	protected $model;

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
	}


	public function notfound() {
		$url = $this->getContext()->getTitle()->getFullUrl();
		$links = [ ];

		foreach ( $this->wg->HubRssFeeds as  $feedName ) {
			$links[ ] = $url . '/'. $feedName;
		}

		$this->setVal( 'links', $links );
		$this->wg->SupressPageSubtitle = true;

	}


	public function index() {

		$hubName = $this->request->getVal( 'par' ) . $this->wg->LanguageCode;

		$ref = (string)$this->request->getVal( 'ref' );

		$model = BaseRssModel::newFromName( $hubName );
		if(!$model instanceof BaseRssModel){
			return $this->forward( 'HubRssFeedSpecial', 'notfound' );
		}
		$this->response->setCacheValidity( self::CACHE_TIME );

		$service = new RssFeedService();
		$service->setRef( $ref );

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
