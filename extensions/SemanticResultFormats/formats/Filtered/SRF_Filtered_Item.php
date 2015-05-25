<?php

/**
 * File holding the SRF_Filtered_Item class
 *
 * @author Stephan Gambke
 * @file
 * @ingroup SemanticResultFormats
 */

/**
 * The SRF_Filtered_Item class.
 *
 * @ingroup SemanticResultFormats
 */
class SRF_Filtered_Item {

	private $mResultArray;
	private $mItemData = array();
	private $mQueryPrinter;

	public function __construct( $resultArray, SRFFiltered &$queryPrinter ) {
		$this->mResultArray = $resultArray;
		$this->mQueryPrinter = $queryPrinter;
	}

	public function setData ( $viewOrFilterId, $data ) {
		$this->mItemData[$viewOrFilterId] = $data;
	}

	public function unsetData ( $viewOrFilterId ) {
		unset( $this->mItemData[$viewOrFilterId] );
	}

	public function getData ( $viewOrFilterId ) {
		return $this->mItemData[$viewOrFilterId];
	}

	public function getValue() {
		return $this->mResultArray;
	}

	public function getArrayRepresentation() {

		$printouts = array();
		$isFirstColumn = true;

		foreach ( $this->mResultArray as $field ) {

			$printRequest = $field->getPrintRequest();

			$label = $printRequest->getLabel();
			$type = $printRequest->getTypeID();
			$params = $printRequest->getParameters();

			$values = array(); // contains plain text
			$formatted = array(); // may contain links

			$field->reset();
			while ( ( $value = $field->getNextDataValue() ) !== false ) {
				$values[] = $value->getShortHTMLText() ;
				$formatted[] = $value->getShortHTMLText( $this->mQueryPrinter->getLinker( $isFirstColumn ) );
			}

			$printouts[ md5( $printRequest->getHash() ) ] = array(
				'label' => $label,
				'type' => $type,
				'params' => $params,
				'values' => $values,
				'formatted values' => $formatted,
			);

			$isFirstColumn = false;
		}

		return array(
			'printouts' => $printouts,
			'data' => $this->mItemData,
		);
	}
}
