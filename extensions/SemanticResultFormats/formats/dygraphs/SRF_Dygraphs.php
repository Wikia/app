<?php

/**
 * A query printer that uses the dygraphs JavaScript library
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
 * @see http://www.semantic-mediawiki.org/wiki/Help:Flot_timeseries_chart
 *
 * @file
 * @ingroup SemanticResultFormats
 * @licence GNU GPL v2 or later
 *
 * @since 1.8
 *
 * @author mwjames
 */
class SRFDygraphs extends SMWResultPrinter {

	/**
	 * @see SMWResultPrinter::getName
	 * @return string
	 */
	public function getName() {
		return wfMessage( 'srf-printername-dygraphs' )->text();
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

		// Output mode is fixed
		$outputMode = SMW_OUTPUT_HTML;

		// Data processing
		$data = $this->getResultData( $result, $outputMode );

		// Post-data processing check
		if ( $data === array() ) {
			return $result->addErrors( array( wfMessage( 'srf-warn-empy-chart' )->inContentLanguage()->text() ) );
		} else {
			$options['sask'] = SRFUtils::htmlQueryResultLink( $this->getLink( $result, SMW_OUTPUT_HTML ) );
			return $this->getFormatOutput( $data, $options );
		}
	}

	/**
	 * Returns an array with numerical data
	 *
	 * @since 1.8
	 *
	 * @param SMWQueryResult $result
	 * @param $outputMode
	 *
	 * @return array
	 */
	protected function getResultData( SMWQueryResult $result, $outputMode ) {
		$aggregatedValues = array();
		
		while ( $rows = $result->getNext() ) { // Objects (pages)
			$annotation = array();
			$dataSource = false;

			/**
			 * @var SMWResultArray $field
			 * @var SMWDataValue $dataValue
			 */
			foreach ( $rows as $field ) {

				// Use the subject marker to identify a possible data file
				$subject = $field->getResultSubject(); 
				if ( $this->params['datasource'] === 'file' && $subject->getTitle()->getNamespace() === NS_FILE && !$dataSource ){
					$aggregatedValues['subject'] = SMWWikiPageValue::makePageFromTitle( $subject->getTitle() )->getLongHTMLText( $this->getLinker( $field->getResultSubject() ) );
					$aggregatedValues['url'] = wfFindFile( $subject->getTitle() )->getUrl();
					$dataSource = true;
				}

				// Proceed only where a label is known otherwise items are of no use
				// for being a potential object identifier
				if ( $field->getPrintRequest()->getLabel() !== '' ){
					$propertyLabel = $field->getPrintRequest()->getLabel();
				}else{
					continue;
				}

				while ( ( $dataValue = $field->getNextDataValue() ) !== false ) { // Data values

					// Jump the column (indicated by continue) because we don't want the data source being part of the annotation array
					if ( $dataValue->getDataItem()->getDIType() == SMWDataItem::TYPE_WIKIPAGE && $this->params['datasource'] === 'raw' && !$dataSource ){
						// Support data source = raw which pulls the url from a wikipage in raw format
						$aggregatedValues['subject'] = SMWWikiPageValue::makePageFromTitle( $dataValue->getTitle() )->getLongHTMLText( $this->getLinker( $field->getResultSubject() ) );
						$aggregatedValues['url'] = $dataValue->getTitle()->getLocalURL( 'action=raw' );
						$dataSource = true;
						continue;
					} elseif ( $dataValue->getDataItem()->getDIType() == SMWDataItem::TYPE_WIKIPAGE && $this->params['datasource'] === 'file' && $dataValue->getTitle()->getNamespace() === NS_FILE && !$dataSource ) {
						// Support data source = file which pulls the url from a uploaded file
						$aggregatedValues['subject'] = SMWWikiPageValue::makePageFromTitle( $dataValue->getTitle() )->getLongHTMLText( $this->getLinker( $field->getResultSubject() ) );
						$aggregatedValues['url'] = wfFindFile( $dataValue->getTitle() )->getUrl();
						$dataSource = true;
						continue;
					} elseif ( $dataValue->getDataItem()->getDIType() == SMWDataItem::TYPE_URI && $this->params['datasource'] === 'url'  && !$dataSource ){
						// Support data source = url, pointing to an url data source
						$aggregatedValues['link'] = $dataValue->getShortHTMLText( $this->getLinker( false ) );
						$aggregatedValues['url'] = $dataValue->getURL();
						$dataSource = true;
						continue;
					}

					// The annotation should adhere outlined conventions as the label identifies the array object key
					// series -> Required The name of the series to which the annotated point belongs
					// x -> Required The x value of the point
					// shortText -> Text that will appear as annotation flag
					// text -> A longer description of the annotation
					// @see  http://dygraphs.com/annotations.html
					if ( in_array( $propertyLabel, array( 'series', 'x', 'shortText', 'text' ) ) ){
						if ( $dataValue->getDataItem()->getDIType() == SMWDataItem::TYPE_NUMBER ){
							// Set unit if available
							$dataValue->setOutputFormat( $this->params['unit'] );
							// Check if unit is available
							$annotation[$propertyLabel] = $dataValue->getUnit() !== '' ? $dataValue->getShortWikiText() : $dataValue->getNumber() ;
						} else {
							$annotation[$propertyLabel] = $dataValue->getWikiValue();
						}
					}
				}
			}
			// Sum-up collected row items in a single array
			if ( $annotation !== array() ){
				$aggregatedValues['annotation'][] =  $annotation;
			}
		}
		return $aggregatedValues;
	}

	/**
	 * Prepare data for the output
	 *
	 * @since 1.8
	 *
	 * @param array $data
	 *
	 * @return string
	 */
	protected function getFormatOutput( $data, $options ) {

		// Object count
		static $statNr = 0;
		$chartID = 'srf-dygraphs-' . ++$statNr;

		$this->isHTML = true;

		// Reorganize the raw data
		if ( $this->params['datasource'] === 'page' ){
			foreach ( $data as $key => $values ) {
				$dataObject[] = array ( 'label' => $key, 'data' => $values );
			}
		}else{
				$dataObject['source'] = $data;
		}

		// Prepare transfer array
		$chartData = array (
			'data' => $dataObject,
			'sask' => $options['sask'],
			'parameters' => array (
				'width'        => $this->params['width'],
				'height'       => $this->params['height'],
				'xlabel'       => $this->params['xlabel'],
				'ylabel'       => $this->params['ylabel'],
				'charttitle'   => $this->params['charttitle'],
				'charttext'    => $this->params['charttext'],
				'infotext'     => $this->params['infotext'],
				'datasource'   => $this->params['datasource'],
				'rollerperiod' => $this->params['mavg'],
				'gridview'    => $this->params['gridview'],
				'errorbar'     => $this->params['errorbar'],
			)
		);

		// Array encoding and output
		$requireHeadItem = array ( $chartID => FormatJson::encode( $chartData ) );
		SMWOutputs::requireHeadItem( $chartID, Skin::makeVariablesScript( $requireHeadItem ) );

		SMWOutputs::requireResource( 'ext.srf.dygraphs' );

		if ( $this->params['gridview'] === 'tabs' ) {
			SMWOutputs::requireResource( 'ext.srf.util.grid' );
		}

		// Chart/graph placeholder
		$chart = Html::rawElement(
			'div',
			array('id' => $chartID, 'class' => 'container', 'style' => "display:none;" ),
			null
		);

		// Processing/loading image
		$processing = SRFUtils::htmlProcessingElement( $this->isHTML );

		// Beautify class selector
		$class = $this->params['class'] ? ' ' . $this->params['class'] : ' dygraphs-common';

		// General output marker
		return Html::rawElement(
			'div',
			array( 'class' => 'srf-dygraphs' . $class	),
			$processing . $chart
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

		$params['datasource'] = array(
			'message' => 'srf-paramdesc-datasource',
			'default' => 'file',
			'values' => array( 'file', 'raw', 'url' ),
		);

		$params['errorbar'] = array(
			'message' => 'srf-paramdesc-errorbar',
			'default' => '',
			'values' => array( 'fraction', 'sigma', 'range' ),
		);

		$params['min'] = array(
			'type' => 'integer',
			'message' => 'srf-paramdesc-minvalue',
			'default' => '',
		);

		$params['mavg'] = array(
			'type' => 'integer',
			'message' => 'srf-paramdesc-movingaverage',
			'default' => 14,
			'lowerbound' => 0,
		);

		$params['gridview'] = array(
			'message' => 'srf-paramdesc-gridview',
			'default' => 'none',
			'values' => array( 'none' , 'tabs' ),
		);

		$params['infotext'] = array(
			'message' => 'srf-paramdesc-infotext',
			'default' => '',
		);

		$params['unit'] = array(
			'message' => 'srf-paramdesc-unit',
			'default' => '',
		);

		$params['height'] = array(
			'type' => 'integer',
			'message' => 'srf_paramdesc_chartheight',
			'default' => 400,
			'lowerbound' => 1,
		);

		$params['width'] = array(
			'message' => 'srf_paramdesc_chartwidth',
			'default' => '100%',
		);

		$params['charttitle'] = array(
			'message' => 'srf_paramdesc_charttitle',
			'default' => '',
		);

		$params['charttext'] = array(
			'message' => 'srf-paramdesc-charttext',
			'default' => '',
		);

		$params['infotext'] = array(
			'message' => 'srf-paramdesc-infotext',
			'default' => '',
		);

		$params['ylabel'] = array(
			'message' => 'srf-paramdesc-yaxislabel',
			'default' => '',
		);

		$params['xlabel'] = array(
			'message' => 'srf-paramdesc-xaxislabel',
			'default' => '',
		);

		$params['class'] = array(
			'message' => 'srf-paramdesc-class',
			'default' => '',
		);

		return $params;
	}
}