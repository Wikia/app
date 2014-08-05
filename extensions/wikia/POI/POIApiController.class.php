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

		$solrHelper = $this->getSolrHelper();
		$nearbySearch = $this->getNearbySearch();

		$nearbySearch->setFields( $solrHelper->getRequiredSolrFields() );
		$solrResponse = $nearbySearch->query( [
			NearbyPOISearchService::LATITUDE => $lat,
			NearbyPOISearchService::LONGITUDE => $long,
			NearbyPOISearchService::RADIUS => $radius,
			NearbyPOISearchService::REGION => $region,
			NearbyPOISearchService::LIMIT => $limit
		] );
		$result = $solrHelper->consumeResponse( $solrResponse );

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
}