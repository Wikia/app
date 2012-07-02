<?php
/**
 * This query adds an <coordinates> subelement to all pages with the list of coordinated present on those pages.
 */
class ApiQueryCoordinates extends ApiQueryBase {

	public function __construct( $query, $moduleName ) {
		parent::__construct( $query, $moduleName, 'co' );
	}

	public function execute() {
		$titles = $this->getPageSet()->getGoodTitles();
		if ( count( $titles ) == 0 ) {
			return;
		}

		$params = $this->extractRequestParams();
		$this->addTables( 'geo_tags' );
		$this->addFields( array( 'gt_id', 'gt_page_id', 'gt_lat', 'gt_lon', 'gt_primary' ) );
		foreach( $params['prop'] as $prop ) {
			if ( isset( Coord::$fieldMapping[$prop] ) ) {
				$this->addFields( Coord::$fieldMapping[$prop] );
			}
		}
		$this->addWhereFld( 'gt_page_id', array_keys( $titles ) );
		$primary = array_flip( $params['primary'] );
		$this->addWhereIf( array( 'gt_primary' => 1 ), isset( $primary['yes'] ) && !isset( $primary['no'] )	);
		$this->addWhereIf( array( 'gt_primary' => 0 ), !isset( $primary['yes'] ) && isset( $primary['no'] )	);

		if ( isset( $params['continue'] ) ) {
			$parts = explode( '|', $params['continue'] );
			if ( count( $parts ) != 2 || !is_numeric( $parts[0] ) || !is_numeric( $parts[0] ) ) {
				$this->dieUsage( "Invalid continue parameter. You should pass the " .
					"original value returned by the previous query", "_badcontinue" );
			}
			$parts[0] = intval( $parts[0] );
			$parts[1] = intval( $parts[1] );
			$this->addWhere( "gt_page_id > {$parts[0]} OR ( gt_page_id = {$parts[0]} AND gt_id > {$parts[1]} )" );
		} else {
			$this->addOption( 'USE INDEX', 'gt_page_id' );
		}
		
		$this->addOption( 'ORDER BY', array( 'gt_page_id', 'gt_id' ) );
		$this->addOption( 'LIMIT', $params['limit'] + 1 );

		$res = $this->select( __METHOD__ );

		$count = 0;
		foreach ( $res as $row ) {
			if ( ++$count > $params['limit'] ) {
				$this->setContinueEnumParameter( 'continue', $row->gt_page_id . '|' . $row->gt_id );
				break;
			}
			$vals = array(
				'lat' => floatval( $row->gt_lat ),
				'lon' => floatval( $row->gt_lon ),
			);
			if ( $row->gt_primary )	{
				$vals['primary'] = '';
			}
			foreach( $params['prop'] as $prop ) {
				if ( isset( Coord::$fieldMapping[$prop] ) && isset( $row->{Coord::$fieldMapping[$prop]} ) ) {
					$field = Coord::$fieldMapping[$prop];
					$vals[$prop] = $row->$field;
				}
			}
			$fit = $this->addPageSubItem( $row->gt_page_id, $vals );
			if ( !$fit ) {
				$this->setContinueEnumParameter( 'continue', $row->gt_page_id . '|' . $row->gt_id );
			}
		}
	}

	public function getCacheMode( $params ) {
		return 'public';
	}

	public function getAllowedParams() {
		return array(
			'limit' => array(
				ApiBase::PARAM_DFLT => 10,
				ApiBase::PARAM_TYPE => 'limit',
				ApiBase::PARAM_MIN => 1,
				ApiBase::PARAM_MAX => ApiBase::LIMIT_BIG1,
				ApiBase::PARAM_MAX2 => ApiBase::LIMIT_BIG2
			),
			'continue' => array(
				ApiBase::PARAM_TYPE => 'string',
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
		return array(
			'limit' => 'How many coordinates to return',
			'continue' => 'When more results are available, use this to continue',
			'prop' => 'What additional coordinate properties to return',
			'primary' => "Whether to return only primary coordinates (``yes''), secondary (``no'') or both (``yes|no'')",
		);
	}

	public function getDescription() {
		return 'Returns coordinates of the given page(s)';
	}

	public function getPossibleErrors() {
		return array_merge( parent::getPossibleErrors(), array(
			array( 'code' => '_badcontinue', 'info' => 'Invalid continue param. You should pass the original value returned by the previous query' ),
		) );
	}

	public function getExamples() {
		return array(
			'Get a list of coordinates of the [[Main Page]]:',
			'  api.php?action=query&prop=coordinates&titles=Main%20Page',
		);
	}


	public function getHelpUrls() {
		return 'https://www.mediawiki.org/wiki/Extension:GeoData#prop.3Dcoordinates';
	}

	public function getVersion() {
		return __CLASS__ . ': $Id: ApiQueryCoordinates.php 110649 2012-02-03 10:18:20Z maxsem $';
	}
}
