<?php

/**
 * File holding the SMGeoCoordsValueDescription class.
 * 
 * @file SM_GeoCoordsValueDescription.php
 * @ingroup SemanticMaps
 * 
 * @author Jeroen De Dauw
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	die( 'Not an entry point.' );
}

/**
 * Description of one data value of type Goegraphical Coordinates.
 *
 * @author Jeroen De Dauw
 * 
 * @since 0.6
 * 
 * @ingroup SemanticMaps
 */
class SMGeoCoordsValueDescription extends SMWValueDescription {
	
	/**
	 * Constructor.
	 * 
	 * @since 0.6
	 * 
	 * @param SMGeoCoordsValue $dataValue
	 */
	public function __construct( SMGeoCoordsValue $dataValue, $comparator ) {
		parent::__construct( $dataValue, $comparator );	
	}

	/**
	 * @see SMWDescription::getQueryString
	 * 
	 * @since 0.6
	 * 
	 * @param Boolean $asvalue
	 */
	public function getQueryString( $asValue = false ) {
		if ( $this->m_datavalue !== null ) {
			$queryString = $this->m_datavalue->getWikiValue();
			return $asValue ? $queryString : "[[$queryString]]";
		} else {
			return $asValue ? '+' : '';
		}
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
	 * @return true
	 */
	public function getSQLCondition( $tableName, array $fieldNames, $dbs ) {
		global $smgUseSpatialExtensions;
		
		$dataValue = $this->getDatavalue();
		
		// Only execute the query when the description's type is geographical coordinates,
		// the description is valid, and the near comparator is used.
		if ( $dataValue->getTypeID() != '_geo' || !$dataValue->isValid() ) return false;

		$comparator = false;
		
		switch ( $this->getComparator() ) {
			case SMW_CMP_EQ: $comparator = '='; break;
			case SMW_CMP_LEQ: $comparator = '<='; break;
			case SMW_CMP_GEQ: $comparator = '>='; break;
			case SMW_CMP_NEQ: $comparator = '!='; break;
		}
		
		if ( $comparator ) {
			$coordinates = $dataValue->getCoordinateSet();
			
			$lat = $dbs->addQuotes( $coordinates['lat'] );
			$lon = $dbs->addQuotes( $coordinates['lon'] );
			
			$conditions = array();
			
			if ( $smgUseSpatialExtensions ) {
				// TODO
			}
			else {		
				$conditions[] = "{$tableName}.$fieldNames[0] $comparator $lat";
				$conditions[] = "{$tableName}.$fieldNames[1] $comparator $lon";				
			}	
			
			return implode( ' && ', $conditions );			
		}
		else {
			return false;
		}
	}
	
}