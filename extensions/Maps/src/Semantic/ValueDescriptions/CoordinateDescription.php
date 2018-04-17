<?php

namespace Maps\Semantic\ValueDescriptions;

use DatabaseBase;
use SMW\DataValueFactory;
use SMW\Query\Language\ValueDescription;
use SMWDIGeoCoord;

/**
 * Description of one data value of type Geographical Coordinates.
 *
 * @author Jeroen De Dauw
 */
class CoordinateDescription extends ValueDescription {

	/**
	 * @see SMWDescription::getQueryString
	 *
	 * @since 0.6
	 *
	 * @param boolean $asValue
	 *
	 * @return string
	 */
	public function getQueryString( $asValue = false ) {
		$queryString = DataValueFactory::newDataItemValue( $this->getDataItem(), $this->getProperty() )->getWikiValue();
		return $asValue ? $queryString : "[[$queryString]]";
	}

	/**
	 * @see SMWDescription::getSQLCondition
	 *
	 * FIXME: store specific code should be in the store component
	 *
	 * @since 0.6
	 *
	 * @param string $tableName
	 * @param array $fieldNames
	 * @param DatabaseBase $dbs
	 *
	 * @return string|false
	 */
	public function getSQLCondition( $tableName, array $fieldNames, DatabaseBase $dbs ) {
		$dataItem = $this->getDataItem();

		// Only execute the query when the description's type is geographical coordinates,
		// the description is valid, and the near comparator is used.
		if ( $dataItem instanceof SMWDIGeoCoord ) {
			switch ( $this->getComparator() ) {
				case SMW_CMP_EQ:
					$comparator = '=';
					break;
				case SMW_CMP_LEQ:
					$comparator = '<=';
					break;
				case SMW_CMP_GEQ:
					$comparator = '>=';
					break;
				case SMW_CMP_NEQ:
					$comparator = '!=';
					break;
				default:
					return false;
			}

			$lat = $dbs->addQuotes( $dataItem->getLatitude() );
			$lon = $dbs->addQuotes( $dataItem->getLongitude() );

			$conditions = [];

			$conditions[] = "{$tableName}.$fieldNames[1] $comparator $lat";
			$conditions[] = "{$tableName}.$fieldNames[2] $comparator $lon";

			return implode( ' AND ', $conditions );
		}

		return false;
	}

}