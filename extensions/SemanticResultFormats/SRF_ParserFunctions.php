<?php

/**
 * Parser functions for the Semantic Result Formats extension.
 *
 * Two parser functions are defined, both for use by the Calendar format:
 *
 * #calendarstartdate returns the start date for the set of dates being
 *    displayed on the screen, according to the query string.
 *
 * #calendarenddate returns the *day after* the end date for the set of dates
 *    being displayed on the screen, according to the query string.
 *
 * @file
 * @ingroup SemanticResultFormats
 * @author David Loomer
 */

if ( !defined( 'MEDIAWIKI' ) ) die();

class SRFParserFunctions {

	static function registerFunctions( &$parser ) {
		$parser->setFunctionHook( 'calendarstartdate', array( 'SRFParserFunctions', 'runCalendarStartDate' ) );
		$parser->setFunctionHook( 'calendarenddate', array( 'SRFParserFunctions', 'runCalendarEndDate' ) );
		return true;
	}

	// FIXME: Can be removed when new style magic words are used (introduced in r52503)
	static function languageGetMagic( &$magicWords, $langCode = "en" ) {
		switch ( $langCode ) {
			default:
			$magicWords['calendarstartdate']  = array ( 0, 'calendarstartdate' );
			$magicWords['calendarenddate']	  = array ( 0, 'calendarenddate' );
		}
		return true;
	}

	static function runCalendarStartDate( &$parser, $calendar_type = 'month', $calendar_start_day = null, $calendar_days = 7, $default_year = null, $default_month = null, $default_day = null ) {
		if ( $calendar_type == '' ) $calendar_type = 'month';
		list( $lower_date, $upper_date, $query_date ) =
			SRFParserFunctions::getBoundaryDates( $calendar_type, $calendar_start_day, $calendar_days, $default_year, $default_month, $default_day );
		return date( "Y", $lower_date ) . '-' . date( "m", $lower_date ) . '-' . date( "d", $lower_date );
	}

	static function runCalendarEndDate( &$parser, $calendar_type = 'month', $calendar_start_day = null, $calendar_days = 7, $default_year = null, $default_month = null, $default_day = null ) {
		if ( $calendar_type == '' ) $calendar_type = 'month';
		list( $lower_date, $upper_date, $query_date ) =
			SRFParserFunctions::getBoundaryDates( $calendar_type, $calendar_start_day, $calendar_days, $default_year, $default_month, $default_day );
		return date( "Y", $upper_date ) . '-' . date( "m", $upper_date ) . '-' . date( "d", $upper_date );
	}

	/**
	 * Obtain both a lower- and upper- bound date to be used for querying.
	 *
	 * @param $calendar_type string Values: 'month' (the default) for monthly
	 *	calendar such as SRF Calendar; others not yet defined.
	 * @param $calendar_start_day int Optionally force the lower bound date to be a certain
	 *	day of the week (0 for Sunday, 6 for Saturday).  If using a $calendar_type
	 *	of 'month' this parameter is ignored, as the start day of week for a monthly
	 *	calendar is currently always set as Sunday.  Ohterwise defaults to either the day
	 *	supplied in the query string, or the current day.
	 * @param $calendar_days int The number of days to display.  Ignored if using a
	 *	$calendar_type of 'month'; otherwise defaults to 7.
	 * @param $default_year int (Optional) Default year if none is specified in
	 *	the query string.  If parameter is not supplied, will fall back to current year.
	 * @param $default_month int (Optional) Default month if none is specified in
	 *	the query string.  If parameter is not supplied, will fall back to current month.
	 * @param $default_day int (Optional) Default day of month if none is specified in
	 *	the query string.  If parameter is not supplied, will fall back to current day of month.
	 * @return array First element contains the lower bound date, second
	 *	element contains the upper bound, third element contains a date indicating
	 *	the year/month/day to be queried.
	 *
	 */
	static function getBoundaryDates( $calendar_type = 'month', $calendar_start_day = null, $calendar_days = 7, $default_year = null, $default_month = null, $default_day = null ) {
 		if ( $calendar_type == 'month' ) $calendar_start_day = 0;

		if ( $default_year == null ) $default_year = date( "Y", mktime() );
		if ( $default_month == null ) $default_month = date( "n", mktime() );
		if ( $default_day == null ) $default_day = date( "j", mktime() );

		global $wgRequest;

		// Set the lower bound based on query string parameters if provided;
		// otherwise fall back to defaults.
		if ( $wgRequest->getCheck( 'year' ) && $wgRequest->getCheck( 'month' ) ) {
			$query_year = $wgRequest->getVal( 'year' );
			if ( is_numeric( $query_year ) && ( intval( $query_year ) == $query_year ) )
				$lower_year = $query_year;
			else
				$lower_year = $default_year;

			$query_month = $wgRequest->getVal( 'month' );
			if ( is_numeric( $query_month ) && ( intval( $query_month ) == $query_month ) && $query_month >= 1 && $query_month <= 12 )
				$lower_month = $query_month;
			else
				$lower_month = $default_month;

			if ( $wgRequest->getCheck( 'day' ) ) {
				$query_day = $wgRequest->getVal( 'day' );
				if ( is_numeric( $query_day ) && ( intval( $query_day ) == $query_day ) && $query_day >= 1 && $query_day <= 31 )
					$lower_day = $query_day;
				else
					$lower_day = '1';
				$lower_day = $wgRequest->getVal( 'day' );
			} elseif ( $calendar_type != 'month'
				&& (int)$lower_year == (int)$default_year
				&& (int)$lower_month == (int)$default_month )
				$lower_day = $default_day;
			else
				$lower_day = '1';
		} else {
			$lower_year = $default_year;
			$lower_month = $default_month;
			if ( $calendar_type == 'month' )
				$lower_day = 1;
			else
				$lower_month = $default_day;
		}
		$lower_date = mktime( 0, 0, 0, $lower_month, $lower_day, $lower_year );

		// Date to be queried
		$return_date = $lower_date;

		// Set the upper bound based on calendar type or number of days.
		if ( $calendar_type == 'month' ) {
			$upper_year = date( "Y", $lower_date );
			$upper_month = date( "n", $lower_date ) + 1;
			if ( $upper_month == 13 ) {
				$upper_month = 1;
				$upper_year = $upper_year + 1;
			}
			// One second before start of next month.
			$upper_date = mktime( 0, 0, 0, $upper_month, 1, $upper_year ) - 1;
		} else {
			// One second before start of first day outside our range.
			$upper_date = $lower_date + $calendar_days * 86400 - 1;
		}

		// If necessary, adjust bounds to comply with required days of week for each.
		if ( $calendar_type == 'month' || $calendar_start_day >= 0 ) {
			$lower_offset = date( "w", $lower_date ) - $calendar_start_day;
			if ( $lower_offset < 0 ) $lower_offset += 7;
			if ( $calendar_type == 'month' ) {
				$upper_offset = $calendar_start_day + 6 - date( "w", $upper_date );
				if ( $upper_offset > 6 ) $upper_offset -= 7;
			} else {
				$upper_offset = 0 - $lower_offset;
			}
			$lower_date = $lower_date - 86400 * $lower_offset;
			$upper_date = $upper_date + 86400 * $upper_offset;
		}

		// Add a day since users will need to use < operator for upper date.
		$upper_date += 86400;

		return array( $lower_date, $upper_date, $return_date );
	}
}
