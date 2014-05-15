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

	protected $customRss = [
		'gameofthrones' => -1,
		'elderscrolls' => -2,
		'marvel' => -3
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
		$service = new HubRssFeedService('en', $this->currentTitle->getFullUrl() . '/' . ucfirst( $hubName ));

		if(isset($this->customRss[$hubName])){
			$quarter = 0;
			if(isset($params['q'])){
				$quarter = (int) $params['q'];
			}
			$data = $this->mixedData($hubName, $quarter);
			$xml =  $service->dataToXml( $data, $this->customRss[$hubName] );
			$this->response->setCacheValidity( self::CACHE_10MIN );
		}else{
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
				$cityId = isset( $wgHubRssFeedCityIds[ $hubName ] ) ? $wgHubRssFeedCityIds[ $hubName ] : 0;
				$data = array_merge( $this->model->getRealDataV3( $cityId ), $this->model->getRealDataV2( $verticalId ) );
				$xml = $service->dataToXml( $data, $verticalId );
				$this->wg->memc->set( $memcKey, $xml, self::CACHE_TIME );

			}
		}
		$this->response->setFormat( WikiaResponse::FORMAT_RAW );
		$this->response->setBody( $xml );
		$this->response->setContentType( 'text/xml' );
	}

	private function mixedData( $kind, $quarter = 0 ) {
		$mixedModel = new MixedFeedModel();
		if ( $quarter ) {
			$mixedModel->setQuarter( $quarter );
		}
		$dayQuarter = $mixedModel->getQuarter();

		$memcKey = wfMemcKey( self::CACHE_KEY, $kind, $dayQuarter, self::CACHE_BUST );
		$result = $this->wg->memc->get( $memcKey );
		if ( !$result ) {
			switch ( $kind ) {
				case 'gameofthrones':
					$result = $mixedModel->GOTWikiaData();
					break;
				case 'elderscrolls':
					$result = $mixedModel->ESWikiaData();
					break;
				case 'marvel':
					$result = $mixedModel->MarvelWikiaData();
					break;
				default:
					return [ ];
			}
			$this->wg->memc->set( $memcKey, $result, self::DAY_QUARTER );
		}

		$data = [ ];
		foreach ( $result as $item ) {
			$ids = explode( '_', $item[ 'id' ] );
			$item[ 'img' ] = $mixedModel->getArticleThumbnail( $item[ 'host' ], $ids[ 0 ], $ids[ 1 ] );
			$item[ 'description' ] = $mixedModel->getArticleDescription( $item[ 'host' ], $ids[ 1 ] );

			$data[ $item[ 'url' ] ] = $item;
		}
		return $data;
	}


}
