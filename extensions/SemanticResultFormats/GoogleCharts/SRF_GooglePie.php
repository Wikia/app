<?php
/**
 * A query printer for pie charts using the Google Chart API
 *
 * @note AUTOLOADED
 */

class SRFGooglePie extends SMWResultPrinter {
	
	protected $m_width = 250;
	protected $m_heighth = 100;

	/**
	 * (non-PHPdoc)
	 * @see SMWResultPrinter::handleParameters()
	 */
	protected function handleParameters( array $params, $outputmode ) {
		parent::handleParameters( $params, $outputmode );
		
		$this->m_width = $this->m_params['width'];
		$this->m_height = $this->m_params['height'];
	}

	public function getName() {
		return wfMsg( 'srf_printername_googlepie' );
	}

	protected function getResultText( SMWQueryResult $res, $outputmode ) {
		$this->isHTML = true;

		$t = "";
		$n = "";
		
		// if there is only one column in the results then stop right away
		if ($res->getColumnCount() == 1) return "";
		                
		// print all result rows
		$first = true;
		$max = 0; // the biggest value. needed for scaling
		
		while ( $row = $res->getNext() ) {
			$name = $row[0]->getNextDataValue()->getShortWikiText();
			
			foreach ( $row as $field ) {
				while ( ( $object = $field->getNextDataValue() ) !== false ) {
					// use numeric sortkey
					if ( $object->isNumeric() ) {
						$nr = $object->getDataItem()->getSortKey();
						
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
		$params = parent::getParameters();
		
		$params['height'] = new Parameter( 'height', Parameter::TYPE_INTEGER, 100 );
		$params['height']->setMessage( 'srf_paramdesc_chartheight' );
		
		$params['width'] = new Parameter( 'width', Parameter::TYPE_INTEGER, 250 );
		$params['width']->setMessage( 'srf_paramdesc_chartwidth' );
		
		return $params;
	}

}
