<?php

/**
 * Class InspectletService
 * This service provides interface to add Inspectlet integrations to parts of the product
 */
class InspectletService extends WikiaService {
	const COMMUNITY_PAGE = 'CommunityPage';
	const CREATE_NEW_WIKI = 'CreateNewWiki';

	private static $applicationIds = [
		self::CREATE_NEW_WIKI => 55883171,
		// @see https://wikia-inc.atlassian.net/browse/WW-111
		self::COMMUNITY_PAGE => 1280339383
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
