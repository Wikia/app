<?php

namespace Maps\Api;

use ApiBase;

/**
 * API module for geocoding.
 *
 * @since 1.0.3
 *
 * @ingroup API
 *
 * @licence GNU GPL v2++
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class Geocode extends ApiBase {

	public function __construct( $main, $action ) {
		parent::__construct( $main, $action );
	}

	public function execute() {
		global $wgUser;

		if ( !$wgUser->isAllowed( 'geocode' ) || $wgUser->isBlocked() ) {
			$this->dieUsageMsg( [ 'badaccess-groups' ] );
		}

		$params = $this->extractRequestParams();

		$results = [];

		foreach ( array_unique( $params['locations'] ) as $location ) {
			$result = \Maps\Geocoders::geocode( $location, $params['service'] );

			$results[$location] = [
				'count' => $result === false ? 0 : 1,
				'locations' => []
			];

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
		return [
			'locations' => [
				ApiBase::PARAM_TYPE => 'string',
				ApiBase::PARAM_REQUIRED => true,
				ApiBase::PARAM_ISMULTI => true,
			],
			'service' => [
				ApiBase::PARAM_TYPE => \Maps\Geocoders::getAvailableGeocoders(),
			],
			'props' => [
				ApiBase::PARAM_ISMULTI => true,
				ApiBase::PARAM_TYPE => [ 'lat', 'lon', 'alt' ],
				ApiBase::PARAM_DFLT => 'lat|lon',
			],
		];
	}

	public function getParamDescription() {
		return [
			'locations' => 'The locations to geocode',
			'service' => 'The geocoding service to use',
		];
	}

	public function getDescription() {
		return [
			'API module for geocoding.'
		];
	}

	public function getExamples() {
		return [
			'api.php?action=geocode&locations=new york',
			'api.php?action=geocode&locations=new york|brussels|london',
			'api.php?action=geocode&locations=new york&service=geonames',
		];
	}

	/**
	 * Wikia change
	 * MAIN-8474: In new version of MediaWiki and Maps extension ApiBase::getVersion method does not exist
	 * However it still does in our 1.19 version and we need to implement it to prevent PHP fatal
	 * @return string
	 */
	public function getVersion() {
		return __CLASS__ . '-' . Maps_VERSION;
	}
}
