<?php

class MetadataSpecialController extends WikiaSpecialPageController {
	const SPECIAL_NAME = 'Metadata';
	const CACHE_TIME = 3600;


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


	public function index() {
		if ( !$this->checkAccess() ) {
			$this->forward( "MetadataSpecialController", "noperms" );
		} else {
			try {
				$response = $this->getResponse();
				$service = new MetaCSVService();
				$file = $service->getUploadedFileFromRequest();
				if ( $file ) {
					$data = $service->LoadDataFromFile( $file );
					$results = $service->storeMetaInDb( $data );
					$csv = $service->generateOutputCsv( $data, $results );

					$response->setFormat( WikiaResponse::FORMAT_RAW );
					$response->setCacheValidity( WikiaResponse::CACHE_DISABLED );
					$response->setContentType( "text/csv" );
					$response->setHeader( "Content-Disposition", " attachment; filename=\"metadata.csv\"" );
					$response->setBody( $csv );
				}
			} catch ( MetaException $e ) {
				$response->setVal( "errMsg", $e->getMessage() );
			}
		}
	}

	public function noperms() {	}

	protected function checkAccess() {
		return ( $this->wg->User->isLoggedIn() && $this->wg->User->isAllowed( 'metadata' ) );
	}

}
