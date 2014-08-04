<?php

namespace Wikia\Search\Services;

class NearbyPOISearchService extends EntitySearchService {

	// Criteria fields
	const LATITUDE = "lat";
	const LONGITUDE = "long";
	const REGION = "region";
	const RADIUS = "radius";
	const LIMIT = "limit";

	// Internal constants
	const LOCATION_FIELD_NAME = "metadata_map_location_sr";
	const DEFAULT_MAX_RANGE = 300;
	const DEFAULT_MAX_ROWS = 200;

	private $fields = [ 'id', 'metadata_*' ]; // default fields to fetch

	public function setFields( $fields ) {
		$this->fields = $fields;
	}

	protected function prepareQuery( $phrase ) {

		$select = $this->getSelect();
		$select->setFields( array_merge( $this->fields, [ "score" ] ) );

		$query = $this->constructQuery( $phrase );

		$select->setQuery( $query );

		if( !empty( $phrase[ self::LIMIT ] ) ) {
			$select->setRows( $phrase[ self::LIMIT ] );
		} else {
			$select->setRows( self::DEFAULT_MAX_ROWS );
		}

		//since score is distance so lower score means less distance
		$select->addSort( "score", \Solarium_Query_Select::SORT_ASC );
		return $select;
	}

	/**
	 * @param $phrase
	 * @return string
	 */
	protected function constructQuery( $phrase ) {
		$conditions = [ ];

		$conditions[ ] = $this->getGeoQuery( $phrase );

		if ( !empty( $phrase[ self::REGION ] ) ) {
			$conditions[ ] = 'metadata_map_region_s:"' . $phrase[ self::REGION ] . '"';
		}

		$query = join( ' AND ', $conditions );
		return $query;
	}

	/**
	 * @param $phrase
	 * @return string
	 * @throws \Exception
	 */
	protected function getGeoQuery( $phrase ) {
		if ( !array_key_exists( self::LATITUDE, $phrase ) or !array_key_exists( self::LONGITUDE, $phrase ) ) {
			throw new \Exception( "Nearby POI search query is not an array of lat, long" );
		}
		$lat = doubleval( $phrase[ self::LATITUDE ] );
		$long = doubleval( $phrase[ self::LONGITUDE ] );

		$distance = self::DEFAULT_MAX_RANGE;
		if ( !empty( $phrase[ self::RADIUS ] ) ) {
			$distance = doubleval( $phrase[ self::RADIUS ] );
		}

		$sfield = self::LOCATION_FIELD_NAME;

		$geoQuery = "({!geofilt score=distance sfield=${sfield} pt=${lat},${long} d=${distance}})";

		return $geoQuery;
	}

	protected function consumeResponse( $solrResponse ) {
		$cleanedResponse = [ ];
		foreach ( $solrResponse as $item ) {
			$cleanedItem = [ ];
			foreach ( $item as $fieldName => $field ) {
				$cleanedItem[$fieldName] = $field;
			}
			$cleanedResponse [] = $cleanedItem;
		}
		return $cleanedResponse;
	}
}
