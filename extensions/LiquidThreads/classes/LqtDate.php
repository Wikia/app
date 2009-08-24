<?php
if ( !defined( 'MEDIAWIKI' ) ) die;

class Date {
	public $year, $month, $day, $hour, $minute, $second;

	// ex. "20070530033751"
	function __construct( $text ) {
		if ( !strlen( $text ) == 14 || !ctype_digit( $text ) ) {
			$this->isValid = false;
			return null;
		}
		$this->year = intval( substr( $text, 0, 4 ) );
		$this->month = intval( substr( $text, 4, 2 ) );
		$this->day = intval( substr( $text, 6, 2 ) );
		$this->hour = intval( substr( $text, 8, 2 ) );
		$this->minute = intval( substr( $text, 10, 2 ) );
		$this->second = intval( substr( $text, 12, 2 ) );
	}

	function lastMonth() {
		return $this->moved( '-1 month' );
	}

	function nextMonth() {
		return $this->moved( '+1 month' );
	}

	function moved( $str ) {
		// Try to set local timezone to attempt to avoid E_STRICT errors.
		global $wgLocaltimezone;
		if ( isset( $wgLocaltimezone ) ) {
			$oldtz = getenv( "TZ" );
			putenv( "TZ=$wgLocaltimezone" );
		}
		// Suppress warnings for installations without a set timezone.
		wfSuppressWarnings();
		// Make the date string.
		$date = date( 'YmdHis', strtotime( $this->text() . ' ' . $str ) );
		// Restore warnings, date no loner an issue.
		wfRestoreWarnings();
		// Generate the date object,
		$date = new Date( $date );
		// Restore the old timezone if needed.
		if ( isset( $wgLocaltimezone ) ) {
			putenv( "TZ=$oldtz" );
		}
		// Return the generated date object.
		return $date;
	}

	static function monthString( $text ) {
		return substr( $text, 0, 6 );
	}

	function delta( $o ) {
		$t = clone $this;
		$els = array( 'year', 'month', 'day', 'hour', 'minute', 'second' );
		$deltas = array();
		foreach ( $els as $e ) { $deltas[$e] = $t->$e - $o->$e;
			$t->$e += $t->$e - $o->$e;
		}

		// format in style of date().
		$result = "";
		foreach ( $deltas as $name => $val ) {
			$result .= "$val $name ";
		}
		return $result;
	}

	static function beginningOfMonth( $yyyymm ) { return $yyyymm . '00000000'; }

	static function endOfMonth( $yyyymm ) { return $yyyymm . '31235959'; }

	function text() {
		return sprintf( '%04d%02d%02d%02d%02d%02d', $this->year, $this->month, $this->day,
			$this->hour, $this->minute, $this->second );
	}

	static function now() {
		return new Date( wfTimestampNow() );
	}

	function nDaysAgo( $n ) {
		return $this->moved( "-$n days" );
	}

	function midnight() {
		$d = clone $this;
		$d->hour = $d->minute = $d->second = 0;
		return $d;
	}

	function isBefore( $d ) {
		foreach ( array( 'year', 'month', 'day', 'hour', 'minute', 'second' ) as $part ) {
			if ( $this->$part < $d->$part ) return true;
			if ( $this->$part > $d->$part ) return false;
		}
		return true; // exactly the same time; arguable.
	}
}
