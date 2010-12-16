<?php

/**
 * Various mathematical functions - sum, average, min and max.
 *
 * @file
 * @ingroup SemanticResultFormats
 * @author Yaron Koren
 * @author Nathan Yergler
 */

if (!defined('MEDIAWIKI')) die();

class SRFMath extends SMWResultPrinter {

	public function getName() {
		wfLoadExtensionMessages('SemanticResultFormats');
		return wfMsg('srf_printername_' . $this->mFormat);
	}

	public function getResult($results, $params, $outputmode) {
		$this->readParameters($params, $outputmode);
		return $this->getResultText($results, SMW_OUTPUT_HTML);
	}

	protected function getResultText($res, $outputmode) {
		global $smwgIQRunningNumber, $wgUser;
		$skin = $wgUser->getSkin();

		// initialize all necessary variables
		$sum = 0;
		$count = 0;
		$min = '';
		$max = '';

		while ( $row = $res->getNext() ) {
			$last_col = array_pop($row);
			foreach ( $last_col->getContent() as $value ) {
				// handle each value only if it's of type Number or NAry
				if ( $value instanceof SMWNumberValue ) {
					$num = $value->getNumericValue();
				} elseif ( $value instanceof SMWNAryValue ) {
					$inner_values = $value->getDVs();
					// find the first inner value that's of
					// type Number, and use that; if none
					// are found, ignore this row
					$num = null;
					foreach ( $inner_values as $inner_value ) {
						if ( $inner_value instanceof SMWNumberValue ) {
							$num = $inner_value->getNumericValue();
							break;
						}
					}
					if ( is_null( $num ) )
						continue;
				} else {
					continue;
				}
				$count++;
				if ($this->mFormat == 'sum' || $this->mFormat == 'average') {
					$sum += $num;
				} elseif ($this->mFormat == 'min') {
					if ($min == '' || $num < $min)
						$min = $num;
				} elseif ($this->mFormat == 'max') {
					if ($max == '' || $num > $max)
						$max = $num;
				}
			}
		}
		// if there were no results, display a blank
		if ($count == 0) {
			$result = '';
		} elseif ($this->mFormat == 'sum') {
			$result = $sum;
		} elseif ($this->mFormat == 'average') {
			$result = $sum / $count;
		} elseif ($this->mFormat == 'min') {
			$result = $min;
		} elseif ($this->mFormat == 'max') {
			$result = $max;
		} else {
			$result = '';
		}

		return $result;
	}

        public function getParameters() {
                return array(
                        array('name' => 'limit', 'type' => 'int', 'description' => wfMsg('srf_paramdesc_limit')),
		);
	}

}
