<?php
/**
 * A query printer using the Google Chart API
 *
 * @note AUTOLOADED
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	die( 'Not an entry point.' );
}

class SRFGoogleBar extends SMWResultPrinter {
	protected $m_width = '250';

	protected function readParameters( $params, $outputmode ) {
		SMWResultPrinter::readParameters( $params, $outputmode );
		if ( array_key_exists( 'width', $this->m_params ) ) {
			$this->m_width = $this->m_params['width'];
		}
	}

	public function getName() {
		return wfMsg( 'srf_printername_googlebar' );
	}

	protected function getResultText( $res, $outputmode ) {
		global $smwgIQRunningNumber;
		$this->isHTML = true;

		$t = "";
		// print all result rows
		$first = true;
		$count = 0; // How many bars will they be? Needed to calculate the height of the image
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

						$count++;
						$max = max( $max, $nr );

						if ( $first ) {
							$first = false;
							$t .= $nr;
							$n = $name;
						} else {
							$t = $nr . ',' . $t;
							$n .= '|' . $name; // yes, this is correct, it needs to be the other way
						}
					}
				}
			}
		}
		$barwidth = 20; // width of each bar
		$bardistance = 4; // distance between two bars
		$height = $count * ( $barwidth + $bardistance ) + 15; // calculates the height of the image
		return 	'<img src="http://chart.apis.google.com/chart?cht=bhs&chbh=' . $barwidth . ',' . $bardistance . '&chs=' . $this->m_width . 'x' . $height . '&chds=0,' . $max . '&chd=t:' . $t . '&chxt=y&chxl=0:|' . $n . '" width="' . $this->m_width . '" height="' . $height . '" />';

	}

	public function getParameters() {
		return array(
			array( 'name' => 'limit', 'type' => 'int', 'description' => wfMsg( 'smw_paramdesc_limit' ) ),
			array( 'name' => 'height', 'type' => 'int', 'description' => wfMsg( 'srf_paramdesc_chartheight' ) ),
			array( 'name' => 'width', 'type' => 'int', 'description' => wfMsg( 'srf_paramdesc_chartwidth' ) ),
		);
	}

}

