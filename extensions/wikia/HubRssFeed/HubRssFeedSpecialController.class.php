<?php
/**
 * Created by JetBrains PhpStorm.
 * User: krzychu
 * Date: 04.10.13
 * Time: 13:08
 * To change this template use File | Settings | File Templates.
 */

class HubRssFeedSpecialController extends WikiaSpecialPageController {

	const PARAM_VERTICAL_ID = 'vertical';

	const SPECIAL_NAME = 'HubRssFeed';
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
		$this->model = new HubRssFeedModel();
	}

	public function index() {

		$verticalId = $this->request->getInt( self::PARAM_VERTICAL_ID, WikiFactoryHub::CATEGORY_ID_ENTERTAINMENT );
		$title = SpecialPage::getTitleFor( self::SPECIAL_NAME );
		$service = new HubRssFeedService();

		if ( !$this->model->isValidVerticalId( $verticalId ) ) {
			throw new InvalidHubAttributeException(self::PARAM_VERTICAL_ID);
		}

		$data = $this->model->getDataFromModules( $verticalId );

		$xml = $service->dataToXml( $data, $verticalId, $title->getFullUrl() );

		$this->response->setFormat( WikiaResponse::FORMAT_RAW );
		$this->response->setBody( $xml );
		$this->response->setContentType( 'application/rss+xml' );
	}


}