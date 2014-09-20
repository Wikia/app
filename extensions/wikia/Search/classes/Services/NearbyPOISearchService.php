<?php

namespace Wikia\Search\Services;

class NearbyPOISearchService extends EntitySearchService {

	const LOCATION_FIELD_NAME = "map_location_sr";

	const ARTICLE_METADATA_CORE = "article_metadata";

	const DEFAULT_MAX_RANGE = 300;

	const DEFAULT_MAX_ROWS = 200;

	private $fields;

	protected $latitude;

	protected $longitude;

	protected $radius;

	protected $region;

	protected $limit;

	protected $wikiaId;

	protected function getCore(){
		return self::ARTICLE_METADATA_CORE;
	}

	public function newQuery() {
		// default fields to fetch
		$this->fields = [ '*', 'score' ];
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

	public  function withWikiaId( $wikiaId ) {
		$this->wikiaId = $wikiaId;
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
		$conditions = [ ];
		$conditions[ ] = $this->getGeoQuery();
		if ( !empty( $this->region ) ) {
			$conditions[ ] = 'map_region_s:"' . $this->region . '"';
		}
		if( !empty( $this->wikiaId ) ) {
			$conditions[ ] = 'wid_i:"' . $this->wikiaId . '"';
		}
		return join( ' AND ', $conditions );
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
