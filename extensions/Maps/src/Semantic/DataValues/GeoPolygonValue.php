<?php

namespace Maps\Semantic\DataValues;

use PolygonHandler;
use SMWDataItem;
use SMWDataValue;
use SMWDIBlob;

/**
 * Implementation of datavalues that are geographic shapes.
 *
 * @author Nischay Nahata
 */
class GeoPolygonValue extends SMWDataValue {

	/**
	 * @see SMWDataValue::getShortHTMLText
	 *
	 * @since 2.0
	 */
	public function getShortHTMLText( $linker = null ) {
		return $this->getShortWikiText( $linker );
	}

	/**
	 * @see SMWDataValue::getShortWikiText
	 *
	 * @since 2.0
	 */
	public function getShortWikiText( $linked = null ) {
		if ( $this->isValid() ) {
			return $this->m_dataitem->getString();
		}

		return $this->getErrorText();
	}

	/**
	 * @see SMWDataValue::getLongHTMLText
	 *
	 * @since 2.0
	 */
	public function getLongHTMLText( $linker = null ) {
		return $this->getLongWikiText( $linker );
	}

	/**
	 * @see SMWDataValue::getLongWikiText
	 *
	 * @since 2.0
	 */
	public function getLongWikiText( $linker = null ) {
		return $this->getShortWikiText( $linker );
	}

	/**
	 * @see SMWDataValue::getWikiValue
	 *
	 * @since 2.0
	 */
	public function getWikiValue() {
		return $this->m_dataitem->getString();
	}

	/**
	 * @see SMWDataValue::getExportData
	 *
	 * @since 2.0
	 */
	public function getExportData() {
		return null;
	}

	/**
	 * @see SMWDataValue::setDataItem()
	 *
	 * @param $dataitem SMWDataItem
	 *
	 * @return boolean
	 */
	protected function loadDataItem( SMWDataItem $dataItem ) {
		if ( $dataItem instanceof SMWDIBlob ) {
			$this->m_dataitem = $dataItem;
			return true;
		}

		return false;
	}

	/**
	 * NOTE: Do param validation.
	 * TODO: Stores as a Blob, use better data structure
	 *
	 * @see SMWDataValue::parseUserValue
	 *
	 * @since 2.0
	 */
	protected function parseUserValue( $value ) {
		if ( $value === '' ) {
			$this->addError( wfMessage( 'smw_emptystring' )->inContentLanguage()->text() );
		}

		foreach ( ( new PolygonHandler( $value ) )->getValidationErrors() as $errMsg ) {
			$this->addError( $errMsg );
		}

		$this->m_dataitem = new SMWDIBlob( $value, $this->m_typeid );
	}
}
