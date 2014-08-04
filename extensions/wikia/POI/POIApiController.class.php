<?php

use Wikia\Search\Services\NearbyPOISearchService;

class POIApiController extends WikiaApiController {

	const LOCATION_X_REQUEST_PARAM = 'location_x';

	const LOCATION_Y_REQUEST_PARAM = 'location_y';

	const REGION_REQUEST_PARAM = 'region';

	const RADIUS_REQUEST_PARAM = 'radius';

	const LIMIT_REQUEST_PARAM = 'limit';

	/**
	 * @var QuestDetailsSolrHelper
	 */
	protected $solrHelper;

	/**
	 * @var Wikia\Search\Services\NearbyPOISearchService
	 */
	protected $nearbySearch;

	public function getNearbyQuests() {
		$lat = $this->getRequest()->getVal( self::LOCATION_X_REQUEST_PARAM );
		$long = $this->getRequest()->getVal( self::LOCATION_Y_REQUEST_PARAM );
		$region = $this->getRequest()->getVal( self::REGION_REQUEST_PARAM );
		$radius = $this->getRequest()->getVal( self::RADIUS_REQUEST_PARAM );
		$limit = $this->getRequest()->getVal( self::LIMIT_REQUEST_PARAM );

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