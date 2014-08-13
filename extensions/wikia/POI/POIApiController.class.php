<?php

use Wikia\Search\Services\NearbyPOISearchService;

class POIApiController extends WikiaApiController {

	const PI = 3.14;

	const EARTH_RADIUS = 6374;

	const DEGREES_PI = 180;

	/**
	 * @var QuestDetailsSolrHelper
	 */
	protected $solrHelper;

	/**
	 * @var Wikia\Search\Services\NearbyPOISearchService
	 */
	protected $nearbySearch;

	public function getNearbyQuests() {
		$lat = $this->getRequest()->getVal( 'location_x' );
		$long = $this->getRequest()->getVal( 'location_y' );
		$region = $this->getRequest()->getVal( 'region' );
		$radius = $this->getRequest()->getVal( 'radius' );
		$limit = $this->getRequest()->getVal( 'limit' );

		$this->validateParameters( $lat, $long, $radius, $limit );

		$radiusKilometers = $this->radiusDegreesToKilometers( $radius );

		$solrHelper = $this->getSolrHelper();
		$nearbySearch = $this->getNearbySearch();

		$solrResponse = $nearbySearch->newQuery()
			->latitude( $lat )
			->longitude( $long )
			->radius( $radiusKilometers )
			->region( $region )
			->setFields( $solrHelper->getRequiredSolrFields() )
			->limit( $limit )
			->search();

		$result = $solrHelper->consumeResponse( $solrResponse );

		if( empty( $result ) ) {
			throw new NotFoundApiException();
		}

		$this->setResponseData( $result );
	}

	protected function radiusDegreesToKilometers( $radiusDegrees ) {
		return $radiusDegrees * self::EARTH_RADIUS  / self::DEGREES_PI * self::PI;
	}

	/**
	 * @param \Wikia\Search\Services\NearbyPOISearchService $nearbySearch
	 */
	public function setNearbySearch( $nearbySearch ) {
		$this->nearbySearch = $nearbySearch;
	}

	/**
	 * @return \Wikia\Search\Services\NearbyPOISearchService
	 */
	public function getNearbySearch() {
		if( empty( $this->nearbySearch ) ) {
			$this->nearbySearch = new NearbyPOISearchService();
		}
		return $this->nearbySearch;
	}

	/**
	 * @param \QuestDetailsSolrHelper $solrHelper
	 */
	public function setSolrHelper( $solrHelper ) {
		$this->solrHelper = $solrHelper;
	}

	/**
	 * @return \QuestDetailsSolrHelper
	 */
	public function getSolrHelper() {
		if( empty( $this->solrHelper ) ) {
			$this->solrHelper = new QuestDetailsSolrHelper();
		}
		return $this->solrHelper;
	}

	protected function validateParameters( $lat, $long, $radius, $limit ) {
		// positive and negative floating numbers
		if ( !preg_match( '/^-?\d+(\.\d+)?$/i', $lat ) ) {
			throw new BadRequestApiException( "Parameter 'location_x' is invalid" );
		}

		// positive and negative floating numbers
		if ( !preg_match( '/^-?\d+(\.\d+)?$/i', $long ) ) {
			throw new BadRequestApiException( "Parameter 'location_y' is invalid" );
		}

		$lat = doubleval( $lat );
		if ( ( $lat < -90 ) || ( $lat > 90 ) ) {
			throw new BadRequestApiException( "Invalid latitude: latitudes are range -90 to 90: provided lat: ${lat}" );
		}

		$long = doubleval( $long );
		if ( ( $long < -180 ) || ( $long > 180 ) ) {
			throw new BadRequestApiException( "Invalid longitude: longitudes are range -180 to 180: provided lon: ${long}" );
		}

		// only positive floating numbers
		if ( !empty( $radius ) && !preg_match( '/^\d+(\.\d+)?$/i', $radius ) ) {
			throw new BadRequestApiException( "Parameter 'radius' is invalid" );
		}
		$radius = doubleval( $radius );
		if( $radius > 180 ) {
			throw new BadRequestApiException( "Invalid radius: radiuses are range 0 to 180: provided radius: ${radius}" );
		}

		// only positive integer numbers
		if ( !empty( $limit ) && !preg_match( '/^\d+$/i', $limit ) ) {
			throw new BadRequestApiException( "Parameter 'limit' is invalid" );
		}
	}
}