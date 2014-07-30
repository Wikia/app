<?php

namespace Wikia\Search\Services;

class NearbyPOISearchService extends EntitySearchService {
	const LOCATION_FIELD_NAME = "metadata_map_location_sr";
	const MAX_RANGE = 300; // This is spartaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa
	const MAX_ROWS = 300;
	const LATITUDE = "lat";
	const LONGITUDE = "long";
	private $fields = [ 'id' ];

	public function queryLocation( $lat, $long ) {
		return $this->query( [ self::LATITUDE => $lat, self::LONGITUDE => $long ] );
	}

	public function setFields( $fields ) {
		$this->fields = $fields;
	}

	protected function prepareQuery( $phrase ) {
		if ( !array_key_exists( self::LATITUDE, $phrase ) or !array_key_exists( self::LONGITUDE, $phrase ) ) {
			throw new \Exception( "Nearby POI search query is not an array of lat, long" );
		}
		$lat = $this->sanitizeQuery( $phrase[self::LATITUDE] );
		$long = $this->sanitizeQuery( $phrase[self::LONGITUDE] );

		$select = $this->getSelect();
		$select->setFields( array_merge( $this->fields, [ "score" ] ) );

		$sfield = self::LOCATION_FIELD_NAME;
		$distance = self::MAX_RANGE;

		$select->setQuery( "{!geofilt score=distance sfield=${sfield} pt=${lat},${long} d=${distance}}" );
		$select->setRows( self::MAX_ROWS );

		$select->addSort( "score", \Solarium_Query_Select::SORT_DESC );

		return $select;
	}

	protected function consumeResponse( $response ) {
		return $response;
	}
}