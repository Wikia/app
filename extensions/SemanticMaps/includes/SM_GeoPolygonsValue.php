<?php

/**
 * Implementation of datavalues that are geographic shapes.
 *
 * @since sm.polygons
 *
 * @file SM_GeoPolgonValue.php
 * @ingroup SemanticMaps
 * @ingroup SMWDataValues
 *
 * @author Nischay Nahata
 */
class SMGeoPolygonsValue extends SMWDataValue {

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
		} else {
			return false;
		}
	}

	/**
	 * NOTE: Do param validation.
	 * TODO: Stores as a Blob, use better data structure
	 * @see SMWDataValue::parseUserValue
	 *
	 * @since sm.polygons
	 */
	protected function parseUserValue( $value ) {
		if ( $value === '' ) {
			$this->addError( wfMsgForContent( 'smw_emptystring' ) );
		}
		$polyHandler = new PolygonHandler ( $value );
		foreach( $polyHandler->getValidationErrors() as $errMsg ) {
			$this->addError( $errMsg );
		}
		$this->m_dataitem = new SMWDIBlob( $value, $this->m_typeid );
	}

	/**
	 * @see SMWDataValue::getShortWikiText
	 *
	 * @since sm.polygons
	 */
	public function getShortWikiText( $linked = null ) {
		if ( $this->isValid() ) {
			return $this->m_dataitem->getString();
		} else {
			return $this->getErrorText();
		}
	}

	/**
	 * @see SMWDataValue::getShortHTMLText
	 *
	 * @since sm.polygons
	 */
	public function getShortHTMLText( $linker = null ) {
		return $this->getShortWikiText( $linker );
	}

	/**
	 * @see SMWDataValue::getLongWikiText
	 *
	 * @since sm.polygons
	 */
	public function getLongWikiText( $linker = null ) {
		return $this->getShortWikiText( $linker );
	}

	/**
	 * @see SMWDataValue::getLongHTMLText
	 *
	 * @since sm.polygons
	 */
	public function getLongHTMLText( $linker = null ) {
		return $this->getLongWikiText( $linker );
	}

	/**
	 * @see SMWDataValue::getWikiValue
	 *
	 * @since sm.polygons
	 */
	public function getWikiValue() {
		return $this->m_dataitem->getString();
	}

	/**
	 * @see SMWDataValue::getExportData
	 *
	 * @since sm.polygons
	 */
	public function getExportData() {
		return null;
	}
}
