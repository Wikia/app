<?php

use Wikia\Search\Services\NearbyPOISearchService;

class POIApiController extends WikiaApiController {

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

		$solrHelper = $this->getSolrHelper();
		$nearbySearch = $this->getNearbySearch();

		$solrResponse = $nearbySearch->newQuery()
			->latitude( $lat )
			->longitude( $long )
			->radius( $radius )
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
		if ( !preg_match( '/^-?\d+(\.\d+)?$/i', $lat ) ) {
			throw new BadRequestApiException( "Parameter 'location_x' is invalid" );
		}

		if ( !preg_match( '/^-?\d+(\.\d+)?$/i', $long ) ) {
			throw new BadRequestApiException( "Parameter 'location_y' is invalid" );
		}

		$lat = doubleval( $lat );
		if ( ( $lat < -90 ) || ( $lat > 90 ) ) {
			throw new BadRequestApiException( "Invalid latitude: latitudes are range -90 to 90: provided lat: ${lat}" );
		}

		$long = doubleval( $long );
		if ( ( $lat < -180 ) || ( $lat > 180 ) ) {
			throw new BadRequestApiException( "Invalid longitude: longitudes are range -90 to 90: provided lon: ${long}" );
		}

		if ( !empty( $radius ) && !preg_match( '/^\d+(\.\d+)?$/i', $radius ) ) {
			throw new BadRequestApiException( "Parameter 'radius' is invalid" );
		}

		if ( !empty( $limit ) && !preg_match( '/^\d+$/i', $limit ) ) {
			throw new BadRequestApiException( "Parameter 'limit' is invalid" );
		}
	}
}