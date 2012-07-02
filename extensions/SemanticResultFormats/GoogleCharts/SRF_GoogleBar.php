<?php
/**
 * A query printer using the Google Chart API
 *
 * @note AUTOLOADED
 */

class SRFGoogleBar extends SMWResultPrinter {
	
	protected $m_width;

	/**
	 * (non-PHPdoc)
	 * @see SMWResultPrinter::handleParameters()
	 */
	protected function handleParameters( array $params, $outputmode ) {
		parent::handleParameters( $params, $outputmode );
		
		$this->m_width = $this->m_params['width'];
	}

	public function getName() {
		return wfMsg( 'srf_printername_googlebar' );
	}

	protected function getResultText( SMWQueryResult $res, $outputmode ) {
		$this->isHTML = true;

		$t = "";
		$n = "";

		// if there is only one column in the results then stop right away
		if ($res->getColumnCount() == 1) return "";

		// print all result rows
		$first = true;
		$count = 0; // How many bars will they be? Needed to calculate the height of the image
		$max = 0; // the biggest value. needed for scaling
		
		while ( $row = $res->getNext() ) {
			$name = $row[0]->getNextDataValue()->getShortWikiText();
			foreach ( $row as $field ) {
				while ( ( $object = $field->getNextDataValue() ) !== false ) {
					
					// use numeric sortkey
					if ( $object->isNumeric() ) {
						$nr = $object->getDataItem()->getSortKey();

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
		$params = parent::getParameters();
		
//		$params['height'] = new Parameter( 'height', Parameter::TYPE_INTEGER, 250 );
//		$params['height']->setMessage( 'srf_paramdesc_chartheight' );
		
		$params['width'] = new Parameter( 'width', Parameter::TYPE_INTEGER, 250 );
		$params['width']->setMessage( 'srf_paramdesc_chartwidth' );		
		
		return $params;
	}

}
