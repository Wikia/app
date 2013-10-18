<?php
/**
 * Created by JetBrains PhpStorm.
 * User: krzychu
 * Date: 04.10.13
 * Time: 13:08
 * To change this template use File | Settings | File Templates.
 */

class HubRssFeedSpecialController extends WikiaSpecialPageController {
	const SPECIAL_NAME = 'HubRssFeed';
	const CACHE_KEY = 'HubRssFeed';
	const CACHE_TIME = 3600;
	/** Use it after release to generate new memcache keys. */
	const CACHE_BUST = 7;

	protected $hubs = [
		'gaming' => WikiFactoryHub::CATEGORY_ID_GAMING,
		'entertainment' => WikiFactoryHub::CATEGORY_ID_ENTERTAINMENT,
		'lifestyle' => WikiFactoryHub::CATEGORY_ID_LIFESTYLE
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
		$params = $this->request->getParams();

		$hubName = strtolower( (string)$params[ 'par' ] );

		if ( !isset($this->hubs[ $hubName ]) ) {
			return $this->forward( 'HubRssFeedSpecial', 'notfound' );
		}

		$langCode = $this->app->wg->ContLang->getCode();
		$this->model = new HubRssFeedModel($langCode);

		$memcKey = wfMemcKey( self::CACHE_KEY, $hubName, self::CACHE_BUST, $langCode );

		$xml = $this->wg->memc->get( $memcKey );

		if ( $xml === false ) {
			$service = new HubRssFeedService($langCode, $this->currentTitle->getFullUrl() . '/' . ucfirst( $hubName ));
			$verticalId = $this->hubs[ $hubName ];
			$data = $this->model->getRealData( $verticalId );
			$xml = $service->dataToXml( $data, $verticalId );
			$this->wg->memc->set( $memcKey, $xml, self::CACHE_TIME );
		}

		$this->response->setFormat( WikiaResponse::FORMAT_RAW );
		$this->response->setBody( $xml );
		$this->response->setContentType( 'application/rss+xml' );
	}


}
