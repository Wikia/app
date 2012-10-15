<?php

/**
 * Class representing a date which can be formatted
 *
 * @ingroup Extensions
 * @author Rob Church <robchur@gmail.com>
 * Please see the LICENCE file for terms of use and redistribution
 */
class FormattableDate {

	private $lang = false;
	
	private $day = false;
	private $month = false;
	private $monthName = false;
	private $year = false;
	
	public function __construct( $lang, $details, $extract ) {
		$this->lang = $lang;
		$this->day = $this->loadDetail( 'd', $details, $extract );
		$this->month = $this->loadDetail( 'm', $details, $extract );
		$this->monthName = $this->loadDetail( 'F', $details, $extract );
		$this->year = $this->loadDetail( 'y', $details, $extract );
	}
	
	public function format( $pref ) {
		wfProfileIn( __METHOD__ );
		$this->resolveMonths();
		$format = $this->determineFormat( $pref );
		$format = str_replace( 'j', $this->day, $format ); # day w/o l.z.
		$format = str_replace( 'd', $this->pad( $this->day ), $format ); # day w/ l.z.
		$format = str_replace( 'n', $this->month, $format ); # month w/o l.z.
		$format = str_replace( 'm', $this->pad( $this->month ), $format ); # month w/ l.z.
		$format = str_replace( 'Y', $this->year, $format ); # year, 4 digit
		$format = str_replace( 'F', $this->monthName, $format ); # month text
		wfProfileOut( __METHOD__ );
		return $format;
	}
	
	private function pad( $value, $length = 2 ) {
		return str_pad( $value, $length, '0', STR_PAD_LEFT );
	}
	
	private function determineFormat( $pref ) {
		if( $this->day !== false && $this->month !== false && $this->year !== false ) {
			# Full date
			switch( $pref ) {
				case DateParser::PREF_DMY:
					return 'j F, Y';
				case DateParser::PREF_MDY:
					return 'F j, Y';
				case DateParser::PREF_YMD:
					return 'Y F j';
				case DateParser::PREF_ISO:
				default:
					return 'Y-m-d';
			}
		} elseif( $this->day !== false && $this->month !== false ) {
			# Day and month
			switch( $pref ) {
				case DateParser::PREF_DMY:
					return 'j F';
				case DateParser::PREF_MDY:
					return 'F j';
				case DateParser::PREF_YMD:
					return 'F j';
				case DateParser::PREF_ISO:
				default:
					return 'm-d';
			}
		} elseif( $this->month !== false && $this->year !== false ) {
			# Month and year
			switch( $pref ) {
				case DateParser::PREF_DMY:
					return 'F Y';
				case DateParser::PREF_MDY:
					return 'F Y';
				case DateParser::PREF_YMD:
					return 'Y, F';
				case DateParser::PREF_ISO:
				default:
					return 'y-m';
			}
		}
	}
	
	private function resolveMonths() {
		if( $this->month === false && $this->monthName !== false ) {		
			$this->month = $this->getMonthIndex( $this->monthName );
		} elseif( $this->monthName === false && $this->month !== false ) {
			$this->monthName = $this->lang->getMonthName( $this->month );
		}
	}
	
	/**
	 * Resolve a month name or abbreviation to numerical form,
	 * e.g. "Jan" => 1, "August" => 8, etc.
	 *
	 * @param $month Month name or abbreviation
	 * @return int
	 */
	private function getMonthIndex( $month ) {
		static $months = false;
		if( !$months ) {
			$months = array();
			for( $i = 1; $i <= 12; $i++ ) {
				$months[ $this->lang->getMonthName( $i ) ] = $i;
				$months[ $this->lang->getMonthAbbreviation( $i ) ] = $i;
			}
		}
		return $months[$month];
	}
	
	private function loadDetail( $name, $details, $extract ) {
		if( isset( $extract[$name] ) ) {
			$index = $extract[$name];
			return $details[$index];
		} else {
			return false;
		}
	}

}

