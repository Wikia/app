<?php

namespace Wikia\Search\Services;

class NearbyPOISearchService extends EntitySearchService {
	const LOCATION_FIELD_NAME = "metadata_map_location_sr";
	const DEFAULT_MAX_RANGE = 300;
	const DEFAULT_MAX_ROWS = 200;
	const LATITUDE = "lat";
	const LONGITUDE = "long";
	private $fields = [ 'id', 'metadata_*' ]; // default fields to fetch
	private $maxRows = self::DEFAULT_MAX_ROWS;
	private $maxRange = self::DEFAULT_MAX_RANGE;

	public function queryLocation( $lat, $long ) {
		return $this->query( [ self::LATITUDE => $lat, self::LONGITUDE => $long ] );
	}

	public function setFields( $fields ) {
		$this->fields = $fields;
	}

	public function setMaxRows( $maxRows ) {
		$this->maxRows = $maxRows;
	}

	public function setMaxRange( $maxRange ) {
		$this->maxRange = $maxRange;
	}

	protected function prepareQuery( $phrase ) {
		if ( !array_key_exists( self::LATITUDE, $phrase ) or !array_key_exists( self::LONGITUDE, $phrase ) ) {
			throw new \Exception( "Nearby POI search query is not an array of lat, long" );
		}
		$lat = doubleval( $phrase[self::LATITUDE] );
		$long = doubleval( $phrase[self::LONGITUDE] );

		$select = $this->getSelect();
		$select->setFields( array_merge( $this->fields, [ "score" ] ) );

		$sfield = self::LOCATION_FIELD_NAME;
		$distance = $this->maxRange;

		$select->setQuery( "{!geofilt score=distance sfield=${sfield} pt=${lat},${long} d=${distance}}" );
		$select->setRows( $this->maxRows );

		//since score is distance so lower score means less distance
		$select->addSort( "score", \Solarium_Query_Select::SORT_ASC );
		return $select;
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
