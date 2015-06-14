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
		return wfMessage( 'srf_printername_googlepie' )->text();
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
		
		$params['height'] = array(
			'type' => 'integer',
			'default' => 100,
			'message' => 'srf_paramdesc_chartheight',
		);

		$params['width'] = array(
			'type' => 'integer',
			'default' => 250,
			'message' => 'srf_paramdesc_chartwidth',
		);
		
		return $params;
	}

}
