<?php

/**
 * Description of a geographical area defined by a coordinates set and a distance to the bounds.
 * The bounds are a 'rectangle' (but bend due to the earths curvature), as the resulting query
 * would otherwise be to resource intensive.
 *
 * @since 0.6
 *
 * @file SM_AreaValueDescription.php
 * @ingroup SemanticMaps
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com
 * 
 * TODO: would be awesome to use Spatial Extensions to select coordinates
 */
class SMAreaValueDescription extends SMWValueDescription {
	
	/**
	 * Associative array containing the bounds of the area, or false when not set.
	 * 
	 * @since 0.6
	 * 
	 * @var mixed
	 */
	protected $bounds = false;

	/**
	 * Constructor.
	 * 
	 * @since 0.6
	 * 
	 * @param SMWDataItem $dataItem
	 * @param string $comparator
	 * @param string $radius
	 * @param SMWDIProperty $property
	 */
	public function __construct( SMWDataItem $dataItem, $comparator, $radius, SMWDIProperty $property = null ) {
		parent::__construct( $dataItem, $property, $comparator );

		// Only if the MapsGeoFunctions class is  loaded, we can create the bounding box.
		if ( self::geoFunctionsAreAvailable() ) {
			$this->calculateBounds( $dataItem, $radius );
		}
	}

	/**
	 * Sets the bounds fields to an array returned by SMAreaValueDescription::getBoundingBox.
	 * 
	 * @since 0.6
	 * 
	 * @param SMWDIGeoCoord $dataItem
	 * @param string $radius
	 */
	protected function calculateBounds( SMWDIGeoCoord $dataItem, $radius ) {
		$this->bounds = self::getBoundingBox(
			array( 'lat' => $dataItem->getLatitude(), 'lon' => $dataItem->getLongitude() ),
			MapsDistanceParser::parseDistance( $radius )
		);		
	}
	
	/**
	 * @see SMWDescription:getQueryString
	 * 
	 * @since 0.6
	 * 
	 * @param Boolean $asValue
	 */
	public function getQueryString( $asValue = false ) {
		if ( $this->getDataItem() !== null ) {
			$queryString = SMWDataValueFactory::newDataItemValue( $this->getDataItem(), $this->m_property )->getWikiValue();
			return $asValue ? $queryString : "[[$queryString]]";
		} else {
			return $asValue ? '+' : '';
		}
	}

	/**
	 * @see SMWDescription:prune
	 * 
	 * @since 0.6
	 */
    public function prune( &$maxsize, &$maxdepth, &$log ) {
    	if ( ( $maxsize < $this->getSize() ) || ( $maxdepth < $this->getDepth() ) ) {
			$log[] = $this->getQueryString();
			
			$result = new SMWThingDescription();
			$result->setPrintRequests( $this->getPrintRequests() );
			
			return $result;
		} else {
			$maxsize = $maxsize - $this->getSize();
			$maxdepth = $maxdepth - $this->getDepth();
			return $this;
		}
    }
    
    /**
     * Returns the bounds of the area.
     * 
     * @since 0.6
     * 
     * @return array
     */
    public function getBounds() {
    	return $this->bounds;
    }    
	
	/**
	 * @see SMWDescription::getSQLCondition
	 * 
	 * @since 0.6
	 * 
	 * @param string $tableName
	 * @param array $fieldNames
	 * @param DatabaseBase or Database $dbs
	 * 
	 * @return string or false
	 */
	public function getSQLCondition( $tableName, array $fieldNames, $dbs ) {
		// Only execute the query when the description's type is geographical coordinates,
		// the description is valid, and the near comparator is used.
		if ( $this->getDataItem()->getDIType() != SMWDataItem::TYPE_GEO
			|| ( $this->getComparator() != SMW_CMP_EQ && $this->getComparator() != SMW_CMP_NEQ )
			) {
			return false;
		}
		
		$north = $dbs->addQuotes( $this->bounds['north'] );
		$east = $dbs->addQuotes( $this->bounds['east'] );
		$south = $dbs->addQuotes( $this->bounds['south'] );
		$west = $dbs->addQuotes( $this->bounds['west'] );

		$isEq = $this->getComparator() == SMW_CMP_EQ;
		
        $conditions = array();

        $smallerThen = $isEq ? '<' : '>=';
        $biggerThen = $isEq ? '>' : '<=';
        $joinCond = $isEq ? 'AND' : 'OR';

        $conditions[] = "{$tableName}.$fieldNames[0] $smallerThen $north";
        $conditions[] = "{$tableName}.$fieldNames[0] $biggerThen $south";
        $conditions[] = "{$tableName}.$fieldNames[1] $smallerThen $east";
        $conditions[] = "{$tableName}.$fieldNames[1] $biggerThen $west";

        $sql = implode( " $joinCond ", $conditions );

		return $sql;
	}

	/**
	 * Returns the lat and lon limits of a bounding box around a circle defined by the provided parameters.
	 * 
	 * @since 0.6
	 * 
	 * @param array $centerCoordinates Array containing non-directional float coordinates with lat and lon keys. 
	 * @param float $circleRadius The radius of the circle to create a bounding box for, in m.
	 * 
	 * @return An associative array containing the limits with keys north, east, south and west.
	 */
	protected static function getBoundingBox( array $centerCoordinates, $circleRadius ) {
		$north = MapsGeoFunctions::findDestination( $centerCoordinates, 0, $circleRadius );
		$east = MapsGeoFunctions::findDestination( $centerCoordinates, 90, $circleRadius );
		$south = MapsGeoFunctions::findDestination( $centerCoordinates, 180, $circleRadius );
		$west = MapsGeoFunctions::findDestination( $centerCoordinates, 270, $circleRadius );

		return array(
			'north' => $north['lat'],
			'east' => $east['lon'],
			'south' => $south['lat'],
			'west' => $west['lon'],
		);
	}
	
	/**
	 * Returns a boolean indicating if MapsGeoFunctions is available. 
	 * 
	 * @since 0.6
	 * 
	 * @return boolean
	 */
	protected static function geoFunctionsAreAvailable() {
		return class_exists( 'MapsGeoFunctions' );
	}	
	
}