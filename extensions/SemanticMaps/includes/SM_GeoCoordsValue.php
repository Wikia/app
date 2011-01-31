<?php

/**
 * Implementation of datavalues that are geographic coordinates.
 * 
 * @since 0.6
 * 
 * @file SM_GeoCoordsValue.php
 * @ingroup SemanticMaps
 * @ingroup SMWDataValues
 * 
 * @author Jeroen De Dauw
 * @author Markus Krötzsch
 */
class SMGeoCoordsValue extends SMWDataValue {

	protected $coordinateSet;
	protected $wikiValue;

	/**
	 * Set the default format to 'map' when the requested properties are
	 * of type geographic coordinates.
	 * 
	 * TODO: have a setting to turn this off and have it off by default for #show
	 * 
	 * @since 0.6.5
	 * 
	 * @param $format Mixed: The format (string), or false when not set yet 
	 * @param $printRequests Array: The print requests made
	 * @param $params Array: The parameters for the query printer
	 * 
	 * @return true
	 */
	public static function addGeoCoordsDefaultFormat( &$format, array $printRequests, array $params ) {
		// Only set the format when not set yet. This allows other extensions to override the Semantic Maps behaviour. 
		if ( $format === false ) {
			// Only apply when there is more then one print request.
			// This way requests comming from #show are ignored. 
			if ( count( $printRequests ) > 1 ) {
				$allCoords = true;
				$first = true;
				
				// Loop through the print requests to determine their types.
				foreach( $printRequests as $printRequest ) {
					// Skip the first request, as it's the object.
					if ( $first ) {
						$first = false;
						continue;
					}
					
					$typeId = $printRequest->getTypeID();
						
					if ( $typeId != '_geo' ) {
						$allCoords = false;
						break;
					}
				}
	
				// If they are all coordinates, set the result format to 'map'.
				if ( $allCoords ) {
					$format = 'map';
				}				
			}

		}
		
		return true;
	}
	
	/**
	 * Adds support for the geographical coordinate data type to Semantic MediaWiki.
	 * 
	 * @since 0.6
	 * 
	 * TODO: i18n keys still need to be moved
	 * 
	 * @return true
	 */
	public static function initGeoCoordsType() {
		SMWDataValueFactory::registerDatatype( '_geo', __CLASS__, 'Geographic coordinate' );
		return true;
	}
	
	/**
	 * Defines the signature for geographical fields needed for the smw_coords table.
	 * 
	 * @since 0.6
	 * 
	 * @param array $fieldTypes The field types defined by SMW, passed by reference.
	 * 
	 * @return true
	 */
	public static function initGeoCoordsFieldTypes( array $fieldTypes ) {
		global $smgUseSpatialExtensions;

		// Only add the table when the SQL store is not a postgres database, and it has not been added by SMW itself.
		if ( $smgUseSpatialExtensions && !array_key_exists( 'c', $fieldTypes ) ) {
			$fieldTypes['c'] = 'Point NOT NULL';
		}
		
		return true;
	}
	
	/**
	 * Defines the layout for the smw_coords table which is used to store value of the GeoCoords type.
	 * 
	 * @since 0.6
	 * 
	 * @param array $propertyTables The property tables defined by SMW, passed by reference.
	 */
	public static function initGeoCoordsTable( array $propertyTables ) {
		global $smgUseSpatialExtensions;
		
		// No spatial extensions support for postgres yet, so just store as 2 float fields.
		$signature = $smgUseSpatialExtensions ? array( 'point' => 'c' ) : array( 'lat' => 'f', 'lon' => 'f' );
		$indexes = $smgUseSpatialExtensions ? array( array( 'point', 'SPATIAL INDEX' ) ) : array_keys( $signature );
		
		$propertyTables['smw_coords'] = new SMWSQLStore2Table(
			'sm_coords',
			$signature,
			$indexes // These are the fields that should be indexed.
		);
		
		return true;
	}
	
	/**
	 * @see SMWDataValue::parseUserValue
	 * 
	 * @since 0.6
	 */
	protected function parseUserValue( $value ) {
		$this->parseUserValueOrQuery( $value );
	}
	
	/**
	 * Overwrite SMWDataValue::getQueryDescription() to be able to process
	 * comparators between all values.
	 * 
	 * @since 0.6
	 * 
	 * @param string $value
	 * 
	 * @return SMWDescription
	 */
	public function getQueryDescription( $value ) {
		return $this->parseUserValueOrQuery( $value, true );
	}	
	
	/**
	 * Parses the value into the coordinates and any meta data provided, such as distance.
	 * 
	 * @since 0.6
	 * 
	 * @param $value String
	 * @param $asQuery Boolean
	 */
	protected function parseUserValueOrQuery( $value, $asQuery = false ) {
		$this->wikiValue = $value;
		
		$comparator = SMW_CMP_EQ;
		
		if ( $value == '' ) {
			$this->addError( wfMsg( 'smw_novalues' ) );
		} else {
			SMWDataValue::prepareValue( $value, $comparator );					

			$parts = explode( '(', $value );
			
			$coordinates = trim( array_shift( $parts ) );
			$distance = count( $parts ) > 0 ? trim( array_shift( $parts ) ) : false;

			if ( $distance !== false ) {
				$distance = substr( trim( $distance ), 0, -1 );
				
				if ( !MapsDistanceParser::isDistance( $distance ) ) {
					$this->addError( wfMsgExt( 'semanticmaps-unrecognizeddistance', array( 'parsemag' ), $distance ) );
					$distance = false;							
				}
			}

			$parsedCoords = MapsCoordinateParser::parseCoordinates( $coordinates );
			if ( $parsedCoords ) {
				$this->coordinateSet = $parsedCoords;
				
				if ( $this->m_caption === false && !$asQuery ) {
					global $smgQPCoodFormat, $smgQPCoodDirectional;
					$this->m_caption = MapsCoordinateParser::formatCoordinates( $parsedCoords, $smgQPCoodFormat, $smgQPCoodDirectional );
        		}
			} else {
				$this->addError( wfMsgExt( 'maps_unrecognized_coords', array( 'parsemag' ), $coordinates, 1 ) );
			}
		}

		if ( $asQuery ) {
			$this->setUserValue( $value );
			
			switch ( true ) {
				case !$this->isValid() :
					return new SMWThingDescription();
					break;
				case $distance !== false :
					return new SMAreaValueDescription( $this, $comparator, $distance );
					break;
				default :
					return new SMGeoCoordsValueDescription( $this, $comparator );
					break;										
			}			
		}
	}
	
	/**
	 * @see SMWDataValue::parseDBkeys
	 * 
	 * @since 0.6
	 */
	protected function parseDBkeys( $args ) {
		global $smgUseSpatialExtensions, $smgQPCoodFormat, $smgQPCoodDirectional;
		
		if ( $smgUseSpatialExtensions ) {
			// var_dump($args);exit;
		}
		else {
			$this->coordinateSet['lat'] = (float)$args[0];
			$this->coordinateSet['lon'] = (float)$args[1];
		}
		
		$this->m_caption = MapsCoordinateParser::formatCoordinates(
			$this->coordinateSet,
			$smgQPCoodFormat,
			$smgQPCoodDirectional
		);
		
		$this->wikiValue = $this->m_caption;
	}
	
	/**
	 * @see SMWDataValue::getDBkeys
	 * 
	 * @since 0.6
	 */
	public function getDBkeys() {
		global $smgUseSpatialExtensions;
		
		$this->unstub();
		
		if ( $smgUseSpatialExtensions ) {
			// TODO: test this
			$point = str_replace( ',', '.', " POINT({$this->coordinateSet['lat']} {$this->coordinateSet['lon']}) " );
			
			$dbr = wfGetDB( DB_SLAVE );
			$row = $dbr->selectRow( 'page', "GeomFromText('$point') AS geom", '' );
			
			return array( $row->geom );
		}
		else {
			return array(
				$this->coordinateSet['lat'],
				$this->coordinateSet['lon']
			);			
		}
	}
	
	/**
	 * @see SMWDataValue::getSignature
	 * 
	 * @since 0.6
	 */	
	public function getSignature() {
		global $smgUseSpatialExtensions;
		return $smgUseSpatialExtensions ? 'c' : 'ff';
	}	

	/**
	 * @see SMWDataValue::getShortWikiText
	 * 
	 * @since 0.6
	 */
	public function getShortWikiText( $linked = null ) {
		if ( $this->isValid() && ( $linked !== null ) && ( $linked !== false ) ) {
			SMWOutputs::requireHeadItem( SMW_HEADER_TOOLTIP );
			
			// TODO: fix lang keys so they include the space and coordinates.
			
			return '<span class="smwttinline">' . htmlspecialchars( $this->m_caption ) . '<span class="smwttcontent">' .
		        htmlspecialchars ( wfMsgForContent( 'maps-latitude' ) . ' ' . $this->coordinateSet['lat'] ) . '<br />' .
		        htmlspecialchars ( wfMsgForContent( 'maps-longitude' ) . ' ' . $this->coordinateSet['lon'] ) .
		        '</span></span>';
		}
		else {
			return htmlspecialchars( $this->m_caption );
		}
	}
	
	/**
	 * @see SMWDataValue::getShortHTMLText
	 * 
	 * @since 0.6
	 */
	public function getShortHTMLText( $linker = null ) {
		return $this->getShortWikiText( $linker );
	}
	
	/**
	 * @see SMWDataValue::getLongWikiText
	 * 
	 * @since 0.6
	 */
	public function getLongWikiText( $linked = null ) {
		if ( !$this->isValid() ) {
			return $this->getErrorText();
		}
		else {
			global $smgQPCoodFormat, $smgQPCoodDirectional;
			return MapsCoordinateParser::formatCoordinates( $this->coordinateSet, $smgQPCoodFormat, $smgQPCoodDirectional );
		}
	}

	/**
	 * @see SMWDataValue::getLongHTMLText
	 * 
	 * @since 0.6
	 */
	public function getLongHTMLText( $linker = null ) {
		return $this->getLongWikiText( $linker );
	}

	/**
	 * @see SMWDataValue::getWikiValue
	 * 
	 * @since 0.6
	 */
	public function getWikiValue() {
		$this->unstub();
		return $this->wikiValue;
	}

	/**
	 * @see SMWDataValue::getExportData
	 * 
	 * @since 0.6
	 */
	public function getExportData() {
		if ( $this->isValid() ) {
			global $smgQPCoodFormat, $smgQPCoodDirectional;
			$lit = new SMWExpLiteral(
				MapsCoordinateParser::formatCoordinates( $this->coordinateSet, $smgQPCoodFormat, $smgQPCoodDirectional ),
				$this,
				'http://www.w3.org/2001/XMLSchema#string'
			);
			return new SMWExpData( $lit );
		} else {
			return null;
		}
	}

	/**
	 * Create links to mapping services based on a wiki-editable message. The parameters
	 * available to the message are:
	 * 
	 * $1: The location in non-directional float notation.
	 * $2: The location in directional DMS notation.
	 * $3: The latitude in non-directional float notation.
	 * $4 The longitude in non-directional float notation.
	 * 
	 * @since 0.6.4
	 * 
	 * @return array
	 */
	protected function getServiceLinkParams() {
		return array(
			MapsCoordinateParser::formatCoordinates( $this->coordinateSet, 'float', false ),
			MapsCoordinateParser::formatCoordinates( $this->coordinateSet, 'dms', true ),
			$this->coordinateSet['lat'],
			$this->coordinateSet['lon']
		);
	}
	
	/**
	 * @since 0.6
	 * 
	 * @return array
	 */
	public function getCoordinateSet() {
		return $this->coordinateSet;
	}
	
	/**
	 * @see SMWDataValue::getValueIndex
	 * 
	 * @since 0.6
	 * 
	 * @return integer
	 */	
	public function getValueIndex() {
		return 0;
	}

	/**
	 * @see SMWDataValue::getLabelIndex
	 * 
	 * @since 0.6
	 * 
	 * @return integer
	 */		
	public function getLabelIndex() {
		return 0;
	}	

}