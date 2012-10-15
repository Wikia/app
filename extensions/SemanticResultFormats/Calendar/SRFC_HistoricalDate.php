<?php

/**
 * SRFC_HistoricalDate.php
 *
 * This code is lifted from Terry Hurlbut's 'SMW_DV_HxDate.php' class;
 * that code was itself adapted from the Fourmilab Calendar Converter
 * Javascripts by John Walker, who wrote them in 1999 and released them
 * to the public domain.
 *
 * The internal value, unlike that of the standard SMW Date type, is a
 * 64-bit PHP float. The characteristic gives the days since
 * the epoch.
 *
 * Technically, the Julian calendar is valid only beginning January 1, 45 BC,
 * when Julius Caesar established it as per a formal Senatus consultum. But
 * currently this is the only calendar currently projectible to earlier times;
 * therefore Julian dates are valid for any year in the Julian Period.
 *
 * @author Terry A. Hurlbut
 * @author Yaron Koren
 */
class SRFCHistoricalDate {

	const GREGORIAN_EPOCH = 1721425.5; // equivalent to 1 AD

	protected $m_date; // the Julian day

	function create( $year, $month, $day ) {
		if ( $year < 1582 ||
			( $year == 1582 && ( $month < 10 || ( $month == 10 && $day < 15 ) ) ) ) {
			$this->createFromJulian( $year, $month, $day );
		} else {
			$this->createFromGregorian( $year, $month, $day );
		}
	}

	static protected function leap_gregorian( $year ) {
		return ( ( $year % 4 ) == 0 ) && ( !( ( ( $year % 100 ) == 0 ) && ( ( $year % 400 ) != 0 ) ) );
	}

	static protected function leap_julian( $year ) {
		return ( ( $year % 4 ) == ( ( $year > 0 ) ? 0 : 3 ) );
	}

	static protected function leap_jul_greg( $year ) {
		return ( ( $year < 1582 ) ? SRFCHistoricalDate::leap_julian( $year ) : SRFCHistoricalDate::leap_gregorian( $year ) );
	}

	protected function createFromGregorian( $year, $month, $day ) {
		$this->m_date = ( self::GREGORIAN_EPOCH - 1 ) +
			( 365 * ( $year - 1 ) ) +
			floor( ( $year - 1 ) / 4 ) +
			( - floor( ( $year - 1 ) / 100 ) ) +
			floor( ( $year - 1 ) / 400 ) +
			floor( ( ( ( 367 * $month ) - 362 ) / 12 ) +
			( ( $month <= 2 ) ? 0 :
				( SRFCHistoricalDate::leap_gregorian( $year ) ? - 1 : - 2 )
			) + $day );
	}

	protected function createFromJulian( $year, $month, $day ) {

		/* Adjust negative common era years to the zero-based notation we use.  */
		if ( $year < 1 ) {
			$year++;
		}

		/* Algorithm as given in Meeus, Astronomical Algorithms, Chapter 7, page 61 */
		if ( $month <= 2 ) {
			$year--;
			$month += 12;
		}

		$this->m_date = ( ( floor( ( 365.25 * ( $year + 4716 ) ) ) +
			floor( ( 30.6001 * ( $month + 1 ) ) ) +
			$day ) - 1524.5 );
	}

	public function getDayOfWeek() {
		return ( floor( $this->m_date + 1.5 ) % 7 );
	}

	static function daysInMonth( $year, $month ) {
		if ( $month == 4 || $month == 6 || $month == 9 || $month == 11 )
			return 30;
		if ( $month == 2 )
			return ( SRFCHistoricalDate::leap_jul_greg( $year ) ) ? 29 : 28;
		return 31;
	}

}
