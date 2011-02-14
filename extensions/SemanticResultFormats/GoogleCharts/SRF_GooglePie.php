<?php
/**
 * A query printer for pie charts using the Google Chart API
 *
 * @note AUTOLOADED
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	die( 'Not an entry point.' );
}

class SRFGooglePie extends SMWResultPrinter {
	protected $m_width = 250;
	protected $m_heighth = 250;

	protected function readParameters( $params, $outputmode ) {
		SMWResultPrinter::readParameters( $params, $outputmode );
		if ( array_key_exists( 'width', $this->m_params ) ) {
			$this->m_width = $this->m_params['width'];
		}
		if ( array_key_exists( 'height', $this->m_params ) ) {
			$this->m_height = $this->m_params['height'];
		} else {
			$this->m_height = $this->m_width * 0.4;
		}
	}

	public function getName() {
		return wfMsg( 'srf_printername_googlepie' );
	}

	protected function getResultText( $res, $outputmode ) {
		global $smwgIQRunningNumber;
		$this->isHTML = true;

		$t = "";
		// print all result rows
		$first = true;
		$max = 0; // the biggest value. needed for scaling
		while ( $row = $res->getNext() ) {
			$name = $row[0]->getNextObject()->getShortWikiText();
			foreach ( $row as $field ) {
					while ( ( $object = $field->getNextObject() ) !== false ) {
					if ( $object->isNumeric() ) { // use numeric sortkey
						if ( method_exists( $object, 'getValueKey' ) ) {
							$nr = $object->getValueKey();
						}
						else {
							$nr = $object->getNumericValue();
						}
						$max = max( $max, $nr );
						if ( $first ) {
							$first = false;
							$t .= $nr;
							$n = $name;
						} else {
							$t = $nr . ',' . $t;
							$n = $name . '|' . $n;
						}
					}
				}
			}
		}
		return 	'<img src="http://chart.apis.google.com/chart?cht=p3&chs=' . $this->m_width . 'x' . $this->m_height . '&chds=0,' . $max . '&chd=t:' . $t . '&chl=' . $n . '" width="' . $this->m_width . '" height="' . $this->m_height . '"  />';
	}

	public function getParameters() {
		return array(
			array( 'name' => 'limit', 'type' => 'int', 'description' => wfMsg( 'smw_paramdesc_limit' ) ),
			array( 'name' => 'height', 'type' => 'int', 'description' => wfMsg( 'srf_paramdesc_chartheight' ) ),
			array( 'name' => 'width', 'type' => 'int', 'description' => wfMsg( 'srf_paramdesc_chartwidth' ) ),
		);
	}

}
