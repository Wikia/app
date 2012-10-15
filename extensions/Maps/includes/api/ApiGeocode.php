<?php

/**
 * API module for geocoding.
 *
 * @since 1.0.3
 *
 * @file ApiGeocode.php
 * @ingroup Maps
 * @ingroup API
 *
 * @licence GNU GPL v3+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class ApiGeocode extends ApiBase {
	
	public function __construct( $main, $action ) {
		parent::__construct( $main, $action );
	}
	
	public function execute() {
		global $wgUser;
		
		if ( !$wgUser->isAllowed( 'geocode' ) || $wgUser->isBlocked() ) {
			$this->dieUsageMsg( array( 'badaccess-groups' ) );
		}			
		
		$params = $this->extractRequestParams();
		
		$results = array();
		
		foreach ( array_unique( $params['locations'] ) as $location ) {
			$result = MapsGeocoders::geocode( $location, $params['service'] );
			
			$results[$location] = array(
				'count' => $result === false ? 0 : 1,
				'locations' => array()
			);
			
			if ( $result !== false ) {
				$results[$location]['locations'][] = $result;
			}
			
			$this->getResult()->setIndexedTagName( $results[$location]['locations'], 'location' );
		}
		
		$this->getResult()->addValue(
			null,
			'results',
			$results
		);
	}

	public function getAllowedParams() {
		return array(
			'locations' => array(
				ApiBase::PARAM_TYPE => 'string',
				ApiBase::PARAM_REQUIRED => true,
				ApiBase::PARAM_ISMULTI => true,
			),
			'service' => array(
				ApiBase::PARAM_TYPE => MapsGeocoders::getAvailableGeocoders(),
			),
			'props' => array(
				ApiBase::PARAM_ISMULTI => true,
				ApiBase::PARAM_TYPE => array( 'lat', 'lon', 'alt' ),
				ApiBase::PARAM_DFLT => 'lat|lon',
			),
		);
	}
	
	public function getParamDescription() {
		return array(
			'locations' => 'The locations to geocode',
			'service' => 'The geocoding service to use',
		);
	}
	
	public function getDescription() {
		return array(
			'API module for geocoding.'
		);
	}
	
	public function getPossibleErrors() {
		return array_merge( parent::getPossibleErrors(), array(
			array( 'missingparam', 'locations' ),
		) );
	}

	protected function getExamples() {
		return array(
			'api.php?action=geocode&locations=new york',
			'api.php?action=geocode&locations=new york|brussels|london',
			'api.php?action=geocode&locations=new york&service=geonames',
		);
	}	
	
	public function getVersion() {
		return __CLASS__ . ': $Id: ApiGeocode.php 95376 2011-08-24 06:29:50Z jeroendedauw $';
	}		
	
}
