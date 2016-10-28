<?php

/**
 * Class InspectletService
 * This service provides interface to add Inspectlet integrations to parts of the product
 */
class InspectletService extends WikiaService {
	const MAIN_PAGE = 'MainPage';

	private static $applicationIds = [
		/**
		 * @see https://wikia-inc.atlassian.net/browse/WW-437
		 *
		 * In inspectlet targeting is set to Main pages on:
		 * - marvel.wikia.com
		 * - harrypotter.wikia.com
		 * - arrow.wikia.com
		 * - westworld.wikia.com
		 * - titanfall.wikia.com
		 * - overwatch.wikia.com
		 */
		self::MAIN_PAGE => 1469642463
	];

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
