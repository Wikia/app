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
			$number_value = array_pop($last_col->getContent());
			// if the property isn't of type Number, just ignore
			// this row
			if ( $number_value instanceof SMWNumberValue ) {
				$count++;
				$num = $number_value->getNumericValue();
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

		return array($result, 'noparse' => 'true', 'isHTML' => 'true');
	}

}
