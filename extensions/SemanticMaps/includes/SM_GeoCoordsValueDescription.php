<?php

/**
 * Description of one data value of type Goegraphical Coordinates.
 * 
 * @since 0.6
 * @file SM_GeoCoordsValueDescription.php
 * @ingroup SemanticMaps
 * 
 * @author Jeroen De Dauw
 */
class SMGeoCoordsValueDescription extends SMWValueDescription {
	
	/**
	 * Constructor.
	 * 
	 * @since 0.8
	 * 
	 * @param SMWDataItem $dataItem
	 */
	public function __construct( SMWDataItem $dataItem, $comparator ) {
		parent::__construct( $dataItem, $comparator );	
	}

	/**
	 * @see SMWDescription::getQueryString
	 * 
	 * @since 0.6
	 * 
	 * @param Boolean $asvalue
	 */
	public function getQueryString( $asValue = false ) {
		if ( $this->m_dataItem !== null ) {
			$queryString = SMWDataValueFactory::newDataItemValue( $this->m_dataItem, $this->m_property )->getWikiValue();
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
		$dataItem = $this->getDataItem();
		
		// Only execute the query when the description's type is geographical coordinates,
		// the description is valid, and the near comparator is used.
		if ( $dataItem->getDIType() != SMWDataItem::TYPE_GEO ) return false;

		$comparator = false;
		
		switch ( $this->getComparator() ) {
			case SMW_CMP_EQ: $comparator = '='; break;
			case SMW_CMP_LEQ: $comparator = '<='; break;
			case SMW_CMP_GEQ: $comparator = '>='; break;
			case SMW_CMP_NEQ: $comparator = '!='; break;
		}
		
		if ( $comparator ) {
			$lat = $dbs->addQuotes( $dataItem->getLatitude() );
			$lon = $dbs->addQuotes( $dataItem->getLongitude() );
			
			$conditions = array();
				
            $conditions[] = "{$tableName}.$fieldNames[0] $comparator $lat";
            $conditions[] = "{$tableName}.$fieldNames[1] $comparator $lon";
			
			return implode( ' && ', $conditions );			
		}
		else {
			return false;
		}
	}
	
}