<?php

/**
 * @author Jakub Kurcek
 */

class GoogleAnalyticsSamplingController extends WikiaController {

	const TIME = 'time';
	const SAMPLING_RATE = 'samplingRate';

	protected function getSamplingHistory(){
		return array(
			0 => array(
				self::TIME => 20110516,
				self::SAMPLING_RATE => 20
			),
			1 => array(
				self::TIME => 20110520,
				self::SAMPLING_RATE => 10
			)
		);
	}

	public function getSamplingRate(){

		$date = $this->getVal( 'date', false );
		if ( empty( $date ) ) {
			$iDate = date('Ymd');
		} else {
			$iDate = date('Ymd', $date );
		}

		$iSample = 100;
		foreach( $this->getSamplingHistory() as $sampling ){
			if ( $iDate > $sampling[ self::TIME ] ){
				$iSample = $sampling[ self::SAMPLING_RATE ];
			}
		}
		$this->setVal( self::SAMPLING_RATE, $iSample );
	}
}
