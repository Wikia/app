<?php

/**
 * Class InspectletService
 * This service provides interface to add Inspectlet integrations to parts of the product
 *
 * NOTE! This service is disabled! If you want to use it, load it in `DefaultSettings.php` file.
 */
class InspectletService extends WikiaService {

	private static $applicationIds = [];

	private $inspectletExperimentId;

	/**
	 * @param $pageName
	 */
	public function __construct( $pageName ) {
		if ( !empty( static::$applicationIds[$pageName] ) ) {
			$this->inspectletExperimentId = static::$applicationIds[$pageName];
		} else {
			throw new RuntimeException( "$pageName is not configured in InspectletService" );
		}
	}

	public function getInspectletCode() {
		return ( new \Wikia\Template\MustacheEngine() )
			->setVal( 'inspectletExperimentId', $this->inspectletExperimentId )
			->setPrefix( __DIR__ . '/templates' )
			->render( 'inspectletCode.mustache' );
	}
}
