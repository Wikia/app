<?php
/**
 * A query printer using the Plotters extension
 * 
 * @note AUTOLOADED
 * @author Ryan Lane
 */

/**
 * Result printer to plot and process query results using admin installed javascript
 *
 * @ingroup SMWQuery
 */

if( !defined( 'MEDIAWIKI' ) ) { 
	die( 'Not an entry point.' );
}

class SRFPlotters extends SMWResultPrinter {
	protected $pParser, $pPlotter;
	protected $params;

	protected function readParameters($params, $outputmode) {
		$this->params = $params;
	}

	public function getResult($results, $params, $outputmode) {
		$this->isHTML = false;
		$this->hasTemplates = false;

		// skip checks, results with 0 entries are normal
		$this->readParameters($params, $outputmode);
		return $this->getResultText($results, SMW_OUTPUT_HTML);
	}

	protected function getResultText($res, $outputmode) {
		global $wgParser;

		$dataArray = array();
		while ( $row = $res->getNext() ) {
			$values = array();
			foreach ($row as $i => $field) {
				while ( ($object = $field->getNextObject()) !== false ) {
					if ($object->getTypeID() == '_dat') {
						$values[] = SRFCalendar::formatDateStr($object);
					} elseif ($object->getTypeID() == '_wpg') { // use shorter "LongText" for wikipage
						$values[] = $object->getLongText($outputmode, null);
					} else {
						$values[] = $object->getShortText($outputmode, null);
					}
				}
			}
			$dataArray[] = $values;
		}
		$pParser = new PlottersParser();
		$pParser->setData( $dataArray );
		$pParser->parseArguments( $this->params );

		$pPlotter = new Plotters( $pParser, $wgParser );

		$pPlotter->checkForErrors();
		if ( $pPlotter->hasErrors() ) {
			$results = $pPlotter->getErrors();
		} else {
			$results = $pPlotter->toHTML();
		}
		if (is_null($wgParser->getTitle()))
			return $results;
		else   
			return array($results, 'noparse' => 'true', 'isHTML' => 'true');
	}
}
