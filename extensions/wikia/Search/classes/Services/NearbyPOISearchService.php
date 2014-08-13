<?php

namespace Wikia\Search\Services;

class NearbyPOISearchService extends EntitySearchService {

	const LOCATION_FIELD_NAME = "metadata_map_location_sr";

	const DEFAULT_MAX_RANGE = 300;

	const DEFAULT_MAX_ROWS = 200;

	private $fields;

	protected $latitude;

	protected $longitude;

	protected $radius;

	protected $region;

	protected $limit;

	public function newQuery() {
		// default fields to fetch
		$this->fields = [ 'id', 'metadata_*', 'score' ];
		$this->limit = self::DEFAULT_MAX_ROWS;
		$this->radius = self::DEFAULT_MAX_RANGE;
		$this->region = null;
		$this->latitude = 0;
		$this->longitude = 0;
		return $this;
	}

	public function latitude( $lat ) {
		if( !empty( $lat ) ) {
			$this->latitude = $lat;
		}
		return $this;
	}

	public function longitude( $long ) {
		if( !empty( $long ) ) {
			$this->longitude = $long;
		}
		return $this;
	}

	public function radius( $radius ) {
		if( !empty( $radius ) ) {
			$this->radius = $radius;
		}
		return $this;
	}

	public function region( $region ) {
		if( !empty( $region ) ) {
			$this->region = $region;
		}
		return $this;
	}

	public function limit( $limit ) {
		if( !empty( $limit ) ) {
			$this->limit = $limit;
		}
		return $this;
	}

	public function setFields( $fields ) {
		if( !empty( $fields ) ) {
			$this->fields = $fields;
			$this->fields = array_merge( $this->fields, [ 'score' ] );
		}
		return $this;
	}

	public function search() {
		$query = $this->constructQuery();
		return $this->query( $query );
	}

	protected function constructQuery() {
		if ( empty( $this->region ) ) {
			return $this->getGeoQuery();
		} else {
			return $this->getGeoQuery() . ' AND metadata_map_region_s:"' . $this->region . '"';
		}
	}

	protected function getGeoQuery() {
		$lat = $this->latitude;
		$long = $this->longitude;
		$distance = $this->radius;
		$sfield = self::LOCATION_FIELD_NAME;
		$geoQuery = "({!geofilt score=distance sfield=${sfield} pt=${lat},${long} d=${distance}})";
		return $geoQuery;
	}

	protected function prepareQuery( $query ) {
		$select = $this->getSelect();

		$select->setQuery( $query );
		$select->setFields( $this->fields );
		$select->setRows( $this->limit );

		//since score is distance so lower score means less distance
		$select->addSort( 'score', \Solarium_Query_Select::SORT_ASC );

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
