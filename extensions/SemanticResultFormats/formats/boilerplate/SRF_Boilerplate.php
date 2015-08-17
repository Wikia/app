<?php

/**
 * Boilerplate query printer
 *
 * Add your description here ...
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along
 * with this program; if not, write to the Free Software Foundation, Inc.,
 * 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA.
 * http://www.gnu.org/copyleft/gpl.html
 *
 * @see http://www.semantic-mediawiki.org/wiki/Writing_result_printers
 *
 * @file
 * @ingroup SemanticResultFormats
 *
 * @since 1.8
 *
 * @licence GNU GPL v2 or later
 * @author mwjames
 */

/**
 * Description ... this part is used for the doxygen processor
 *
 * @ingroup SemanticResultFormats
 */
class SRFBoilerplate extends SMWResultPrinter {

	/**
	 * @see SMWResultPrinter::getName
	 * @return string
	 */
	public function getName() {
		// Add your result printer name here
		return wfMessage( 'srf-printername-boilerplate' )->text();
	}

	/**
	 * @see SMWResultPrinter::getResultText
	 *
	 * @param SMWQueryResult $result
	 * @param $outputMode
	 *
	 * @return string
	 */
	protected function getResultText( SMWQueryResult $result, $outputMode ) {

		// Data processing
		// It is advisable to separate data processing from output logic
		$data = $this->getResultData( $result, $outputMode );

		// Check if the data processing returned any results otherwise just bailout
		if ( $data === array() ) {
			// Add an error message to return method
			return $result->addErrors( array( wfMessage( 'srf-no-results' )->inContentLanguage()->text() ) );
		} else {
			// Add options if needed to format the output

			// $outputMode can be specified as
			// SMW_OUTPUT_HTML
			// SMW_OUTPUT_FILE
			// SMW_OUTPUT_WIKI

			// For implementing template support this options has to be set but if you
			// manipulate data via jQuery/JavaScript it is less likely that you need
			// this option since templates will influence how wiki text is parsed
			// but will have no influence in how a HTML representation is altered
			// $this->hasTemplates = true;

			$options = array(
				'mode' => $outputMode
			);

			// Return formatted results
			return $this->getFormatOutput( $data, $options );
		}
	}

	/**
	 * Returns an array with data
	 *
	 * @since 1.8
	 *
	 * @param SMWQueryResult $result
	 * @param $outputMode
	 *
	 * @return array
	 */
	protected function getResultData( SMWQueryResult $result, $outputMode ) {

		$data = array();

		// This is an example implementation on how to select available data from
		// a result set. Please make appropriate adoptions necessary for your
		// application.

		// Some methods are declared as private to show case which objects are
		// directly accessible within SMWQueryResult

		// Get all SMWDIWikiPage objects that make up the results
		// $subjects = $this->getSubjects( $result->getResults() );

		// Get all print requests property labels
		// $labels = $this->getLabels( $result->getPrintRequests() );

		/**
		 * Get all values for all rows that belong to the result set
		 * @var SMWResultArray $rows
		 */
		while ( $rows = $result->getNext() ) {

			/**
			 * @var SMWResultArray $field
			 * @var SMWDataValue $dataValue
			 */
			foreach ( $rows as $field ) {

				// Initialize the array each time it passes a new row to avoid data from
				// a previous row is remaining
				$rowData = array();

				// Get the label for the current property
				$propertyLabel = $field->getPrintRequest()->getLabel();

				// Get the label for the current subject
				// getTitle()->getText() will return only the main text without the
				// fragment(#) which can be arbitrary in case subobjects are involved

				// getTitle()->getFullText() will return the text with the fragment(#)
				// which is important when using subobjects
				$subjectLabel = $field->getResultSubject()->getTitle()->getFullText();

				while ( ( $dataValue = $field->getNextDataValue() ) !== false ) {

					// Get the data value item
					$rowData[] = $this->getDataValueItem( $dataValue->getDataItem()->getDIType(), $dataValue );
				}

			// Example how to build a hierarchical array by collecting all values
			// belonging to one subject/row using labels as array key representation
			$data[$subjectLabel][$propertyLabel][] = $rowData;
			}
		}

		// Return the data
		// return array( 'labels' => $labels, 'subjects' => $subjects, 'data' => $data );
		return $data;
	}

	/**
	 * A quick getway method to find all SMWDIWikiPage objects that make up the results
	 *
	 * @since 1.8
	 *
	 * @param SMWQueryResult $result
	 *
	 * @return array
	 */
	private function getSubjects( $result ) {
		$subjects = array();

		foreach ( $result as $wikiDIPage ) {
			$subjects[] = $wikiDIPage->getTitle()->getText();
		}
		return $subjects;
	}

	/**
	 * Get all print requests property labels
	 *
	 * @since 1.8
	 *
	 * @param SMWQueryResult $result
	 *
	 * @return array
	 */
	private function getLabels( $result ) {
		$printRequestsLabels = array();

		foreach ( $result as $printRequests ) {
			$printRequestsLabels[] = $printRequests->getLabel();
		}
		return $printRequestsLabels;
	}

	/**
	 * Get a single data value item
	 *
	 * @since 1.8
	 *
	 * @param integer $type
	 * @param SMWDataValue $dataValue
	 *
	 * @return mixed
	 */
	private function getDataValueItem( $type, SMWDataValue $dataValue ) {

		if ( $type == SMWDataItem::TYPE_NUMBER ){

			// Set unit if available
			$dataValue->setOutputFormat( $this->params['unit'] );

			// Check if unit is available and return the converted value otherwise
			// just return a plain number
			return $dataValue->getUnit() !== '' ? $dataValue->getShortWikiText() : $dataValue->getNumber() ;
		} else {

			// For all other data types return the wikivalue
			return $dataValue->getWikiValue();
		}
	}

	/**
	 * Prepare data for the output
	 *
	 * @since 1.8
	 *
	 * @param array $data
	 * @param array $options
	 *
	 * @return string
	 */
	protected function getFormatOutput( $data, $options ) {

		// The generated ID is to distinguish similar instances of the same
		// printer that can appear within the same page
		static $statNr = 0;
		$ID = 'srf-boilerplate-' . ++$statNr;

		// or use the PHP uniqid() to generate an unambiguous ID
		// $ID = uniqid();

		// Used to set that the output and being treated as HTML (opposed to plain wiki text)
		$this->isHTML = true;

		// Correct escaping is vital to minimize possibilites of malicious code snippets
		// and also a coherent string evalution therefore it is recommended
		// that data transferred to the JS plugin is JSON encoded

		// Assign the ID to make a data instance readly available and distinguishable
		// from other content within the same page
		$requireHeadItem = array ( $ID => FormatJson::encode( $data ) );
		SMWOutputs::requireHeadItem( $ID, Skin::makeVariablesScript( $requireHeadItem ) );

		// Add resource definitions that has been registered with SRF_Resource.php
		// Resource definitions contain scripts, styles, messages etc.
		// SMWOutputs::requireResource( 'ext.srf.boilerplate.namespace' );
		SMWOutputs::requireResource( 'ext.srf.boilerplate.simple' );

		// Prepares an HTML element showing a rotating spinner indicating that something
		// will appear at this placeholder. The element will be visible as for as
		// long as jquery is not loaded and the JS plugin did not hide/removed the element.
		$processing = SRFUtils::htmlProcessingElement();

		// Add two elements a outer wrapper that is assigned a class which the JS plugin
		// can select and will fetch all instances of the same result printer and an innner
		// container which is set invisible (display=none) for as long as the JS plugin
		// holds the content hidden. It is normally the place where the "hard work"
		// is done hidden from the user until it is ready.
		// The JS plugin can prepare the output within this container without presenting
		// unfinished visual content, to avoid screen clutter and improve user experience.
		return Html::rawElement(
			'div',
			array(
				'class' => 'srf-boilerplate'
			),
			$processing . Html::element(
				'div',
				array(
					'id' => $ID,
					'class' => 'container',
					'style' => 'display:none;'
				),
				null
			)
		);
	}

	/**
	 * @see SMWResultPrinter::getParamDefinitions
	 *
	 * @since 1.8
	 *
	 * @param $definitions array of IParamDefinition
	 *
	 * @return array of IParamDefinition|array
	 */
	public function getParamDefinitions( array $definitions ) {
		$params = parent::getParamDefinitions( $definitions );

		// Add your parameters here

		// Example of a unit paramter
		$params['unit'] = array(
			'message' => 'srf-paramdesc-unit',
			'default' => '',
		);

		return $params;
	}
}