<?php

class ApiQueryGeoSearch extends ApiQueryGeneratorBase {
	const MIN_RADIUS = 10;

	public function __construct( $query, $moduleName ) {
		parent::__construct( $query, $moduleName, 'gs' );
	}

	public function execute() {
		$this->run();
	}

	public function getCacheMode( $params ) {
		return 'public';
	}

	public function executeGenerator( $resultPageSet ) {
		$this->run( $resultPageSet );
	}

	/**
	 * @param ApiPageSet $resultPageSet
	 * @return
	 */
	private function run( $resultPageSet = null ) {
		$params = $this->extractRequestParams();
		$exclude = false;

		$this->requireOnlyOneParameter( $params, 'coord', 'page' );
		if ( isset( $params['coord'] ) ) {
			$arr = explode( '|', $params['coord'] );
			if ( count( $arr ) != 2 || !GeoData::validateCoord( $arr[0], $arr[1], $params['globe'] ) ) {
				$this->dieUsage( 'Invalid coordinate provided', '_invalid-coord' );
			}
			$lat = $arr[0];
			$lon = $arr[1];
		} elseif ( isset( $params['page'] ) ) {
			$t = Title::newFromText( $params['page'] );
			if ( !$t || !$t->canExist() ) {
				$this->dieUsage( "Invalid page title ``{$params['page']}'' provided", '_invalid-page' );
			}
			if ( !$t->exists() ) {
				$this->dieUsage( "Page ``{$params['page']}'' does not exist", '_nonexistent-page' );
			}
			$coord = GeoData::getPageCoordinates( $t );
			if ( !$coord ) {
				$this->dieUsage( 'Page coordinates unknown', '_no-coordinates' );
			}
			$lat = $coord->lat;
			$lon = $coord->lon;
			$exclude = $t->getArticleID();
		}
		$lat = floatval( $lat );
		$lon = floatval( $lon );
		$radius = intval( $params['radius'] );
		$rect = GeoMath::rectAround( $lat, $lon, $radius );

		$dbr = wfGetDB( DB_SLAVE );
		$this->addTables( array( 'page', 'geo_tags' ) );
		$this->addFields( array( 'gt_lat', 'gt_lon', 'gt_primary' ) );
		// retrieve some fields only if page set needs them
		if ( is_null( $resultPageSet ) ) {
			$this->addFields( array( 'page_id', 'page_namespace', 'page_title' ) );
		} else {
			$this->addFields( WikiPage::selectFields() );
		}
		foreach( $params['prop'] as $prop ) {
			if ( isset( Coord::$fieldMapping[$prop] ) ) {
				$this->addFields( Coord::$fieldMapping[$prop] );
			}
		}
		$this->addWhereFld( 'gt_globe', $params['globe'] );
		$this->addWhereFld( 'gt_lat_int', self::intRange( $rect["minLat"], $rect["maxLat"] ) );
		$this->addWhereFld( 'gt_lon_int', self::intRange( $rect["minLon"], $rect["maxLon"] ) );

		$this->addWhereRange( 'gt_lat', 'newer', $rect["minLat"], $rect["maxLat"], false );
		if ( $rect["minLon"] > $rect["maxLon"] ) {
			$this->addWhere( "gt_lon < {$rect['maxLon']} OR gt_lon > {$rect['minLon']}" );
		} else {
			$this->addWhereRange( 'gt_lon', 'newer', $rect["minLon"], $rect["maxLon"], false );
		}
		$this->addWhereFld( 'page_namespace', $params['namespace'] );
		$this->addWhere( 'gt_page_id = page_id' );
		if ( $exclude ) {
			$this->addWhere( "gt_page_id <> {$exclude}" );
		}
		if ( isset( $params['maxdim'] ) ) {
			$this->addWhere( 'gt_dim < ' . intval( $params['maxdim'] ) ); 
		}
		$primary = array_flip( $params['primary'] );
		$this->addWhereIf( array( 'gt_primary' => 1 ), isset( $primary['yes'] ) && !isset( $primary['no'] )	);
		$this->addWhereIf( array( 'gt_primary' => 0 ), !isset( $primary['yes'] ) && isset( $primary['no'] )	);
		$this->addOption( 'USE INDEX', 'gt_spatial' );

		$limit = $params['limit'];
		
		$res = $this->select( __METHOD__ );

		$rows = array();
		foreach ( $res as $row ) {
			$row->dist = GeoMath::distance( $lat, $lon, $row->gt_lat, $row->gt_lon );
			$rows[] = $row;
		}
		// sort in PHP because sorting via SQL involves a filesort
		usort( $rows, 'ApiQueryGeoSearch::compareRows' );
		$result = $this->getResult();
		foreach ( $rows as $row ) {
			if ( !$limit-- ) {
				break;
			}
			if ( is_null( $resultPageSet ) ) {
				$title = Title::newFromRow( $row );
				$vals = array(
					'pageid' => intval( $row->page_id ),
					'ns' => intval( $title->getNamespace() ),
					'title' => $title->getPrefixedText(),
					'lat' => floatval( $row->gt_lat ),
					'lon' => floatval( $row->gt_lon ),
					'dist' => round( $row->dist, 1 ),
				);
				if ( $row->gt_primary ) {
					$vals['primary'] = '';
				}
				foreach( $params['prop'] as $prop ) {
					if ( isset( Coord::$fieldMapping[$prop] ) && isset( $row->{Coord::$fieldMapping[$prop]} ) ) {
						$field = Coord::$fieldMapping[$prop];
						$vals[$prop] = $row->$field;
					}
				}	
				$fit = $result->addValue( array( 'query', $this->getModuleName() ), null, $vals );
				if ( !$fit ) {
					break;
				}
			} else {
				$resultPageSet->processDbRow( $row );
			}
		}
		if ( is_null( $resultPageSet ) ) {
			$result->setIndexedTagName_internal(
				 array( 'query', $this->getModuleName() ), $this->getModulePrefix() );
		}
	}

	private static function compareRows( $row1, $row2 ) {
		if ( $row1->dist < $row2->dist ) {
			return -1;
		} elseif ( $row1->dist > $row2->dist ) {
			return 1;
		}
		return 0;
	}

	/**
	 * Returns a range of tenths of degree
	 * @param float $start
	 * @param float $end
	 * @return Array 
	 */
	public static function intRange( $start, $end ) {
		$start = round( $start * 10 );
		$end = round( $end * 10 );
		// @todo: works only on Earth
		if ( $start > $end ) {
			return array_merge(
				range( -1800, $end ),
				range( $start, 1800 )
			);
		} else {
			return range( $start, $end );
		}
	}

	public function getAllowedParams() {
		global $wgMaxGeoSearchRadius, $wgDefaultGlobe;
		return array (
			'coord' => array(
				ApiBase::PARAM_TYPE => 'string',
			),
			'page' => array(
				ApiBase::PARAM_TYPE => 'string',
			),
			'radius' => array(
				ApiBase::PARAM_TYPE => 'integer',
				ApiBase::PARAM_REQUIRED => true,
				ApiBase::PARAM_MIN => self::MIN_RADIUS,
				ApiBase::PARAM_MAX => $wgMaxGeoSearchRadius,
				ApiBase::PARAM_RANGE_ENFORCE => true,
			),
			'maxdim' => array(
				ApiBase::PARAM_TYPE => 'integer',
			),
			'limit' => array(
				ApiBase::PARAM_DFLT => 10,
				ApiBase::PARAM_TYPE => 'limit',
				ApiBase::PARAM_MIN => 1,
				ApiBase::PARAM_MAX => ApiBase::LIMIT_BIG1,
				ApiBase::PARAM_MAX2 => ApiBase::LIMIT_BIG2
			),
			// @todo: globe selection disabled until we have a real use case
			'globe' => array(
				ApiBase::PARAM_TYPE => (array)$wgDefaultGlobe,
				ApiBase::PARAM_DFLT => $wgDefaultGlobe,
			),
			'namespace' => array(
				ApiBase::PARAM_TYPE => 'namespace',
				ApiBase::PARAM_DFLT => NS_MAIN,
				ApiBase::PARAM_ISMULTI => true,
			),
			'prop' => array(
				ApiBase::PARAM_TYPE => array( 'type', 'name', 'dim', 'country', 'region' ),
				ApiBase::PARAM_DFLT => '',
				ApiBase::PARAM_ISMULTI => true,
			),
			'primary' => array(
				ApiBase::PARAM_TYPE => array( 'yes', 'no' ),
				ApiBase::PARAM_ISMULTI => true,
				ApiBase::PARAM_DFLT => 'yes',
			),
		);
	}

	public function getParamDescription() {
		global $wgDefaultGlobe;
		return array(
			'coord' => 'Coordinate around which to search: two floating-point values separated by pipe (|)',
			'page' => 'Title of page around which to search',
			'radius' => 'Search radius in meters',
			'maxdim' => 'Restrict search to objects no larger than this, in meters',
			'limit' => 'Maximum number of pages to return',
			'globe' => "Globe to search on (by default ``{$wgDefaultGlobe}'')",
			'namespace' => 'Namespace(s) to search',
			'prop' => 'What additional coordinate properties to return',
			'primary' => "Whether to return only primary coordinates (``yes''), secondary (``no'') or both (``yes|no'')",
		);
	}

	public function getDescription() {
		return 'Returns pages around the given point';
	}

	public function getPossibleErrors() {
		return array_merge( parent::getPossibleErrors(), array(
			array( 'code' => '_invalid-page', 'info' => "Invalid page title provided" ),
			array( 'code' => '_nonexistent-page', 'info' => "Page does not exist" ),
			array( 'code' => '_no-coordinates', 'info' => 'Page coordinates unknown' ),
		) );
	}

	public function getExamples() {
		return array(
			"api.php?action=query&list=geosearch&gsradius=10000&gscoord=37.786971|-122.399677" => 
				"Search around the point with coordinates 37° 47′ 13.1″ N, 122° 23′ 58.84″ W",
		);
	}

	public function getHelpUrls() {
		return 'https://www.mediawiki.org/wiki/Extension:GeoData#list.3Dgeosearch';
	}

	public function getVersion() {
		return __CLASS__ . ': $Id: ApiQueryGeoSearch.php 110860 2012-02-07 18:16:19Z maxsem $';
	}
}
