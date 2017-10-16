<?php
/**
 * Defines a class, SDFilterValue, representing a single value of an
 * applied filter (i.e., an instance of the SDAppliedFilter class).
 *
 * @author Yaron Koren
 */

class SDFilterValue {
	var $text;
	var $is_none = false;
	var $is_other = false;
	var $is_numeric = false;
	var $lower_limit = null;
	var $upper_limit = null;
	var $year = null;
	var $month = null;
	var $day = null;
	var $end_year = null;

	static function create( $actual_val, $filter = null ) {
		$fv = new SDFilterValue();
		$fv->text = str_replace( '_', ' ', $actual_val );

		if ( $fv->text == ' none' ) {
			$fv->is_none = true;
		} elseif ( $fv->text == ' other' ) {
			$fv->is_other = true;
		}
		// set other fields, if it's a date or number range
		if ( $filter != null && $filter->property_type == 'date' ) {
			// @TODO - this should ideally be handled via query
			// string arrays - and this code merged in with
			// date-range handling - instead of just doing string
			// parsing on one string.
			if ( strpos( $fv->text, ' - ' ) > 0 ) {
				// If there's a dash, assume it's a year range
				$years = explode( ' - ', $fv->text );
				$fv->year = $years[0];
				$fv->end_year = $years[1];
				$fv->time_period = 'year range';
			} else {
				$date_parts = explode( ' ', $fv->text );
				if ( count( $date_parts ) == 3 ) {
					list( $month_str, $day_str, $year ) = explode( ' ', $fv->text );
					$fv->month = SDUtils::stringToMonth( $month_str );
					$fv->day = str_replace( ',', '', $day_str );
					$fv->year = $year;
					$fv->time_period = 'day';
				} elseif ( count( $date_parts ) == 2 ) {
					list( $month_str, $year ) = explode( ' ', $fv->text );
					$fv->month = SDUtils::stringToMonth( $month_str );
					$fv->year = $year;
					$fv->time_period = 'month';
				} else {
					$fv->month = null;
					$fv->year = $fv->text;
					$fv->time_period = 'year';
				}
			}
		} else {
			if ( $fv->text == '' ) {
				// do nothing
			} elseif ( $fv->text { 0 } == '<' ) {
				$possible_number = str_replace( ',', '', trim( substr( $fv->text, 1 ) ) );
				if ( is_numeric( $possible_number ) ) {
					$fv->upper_limit = $possible_number;
					$fv->is_numeric = true;
				}
			} elseif ( $fv->text { 0 } == '>' ) {
				$possible_number = str_replace( ',', '', trim( substr( $fv->text, 1 ) ) );
				if ( is_numeric( $possible_number ) ) {
					$fv->lower_limit = $possible_number;
					$fv->is_numeric = true;
				}
			} else {
				$elements = explode( '-', $fv->text );
				if ( count( $elements ) == 2 ) {
					$first_elem = str_replace( ',', '', trim( $elements[0] ) );
					$second_elem = str_replace( ',', '', trim( $elements[1] ) );
					if ( is_numeric( $first_elem ) && is_numeric( $second_elem ) ) {
						$fv->lower_limit = $first_elem;
						$fv->upper_limit = $second_elem;
						$fv->is_numeric = true;
					}
				}
			}
		}
		return $fv;
	}

	/**
	 * Used in sorting, when BrowseDataPage creates a new URL.
	 */
	public static function compare( $fv1, $fv2 ) {
		if ( $fv1->is_none ) return 1;
		if ( $fv2->is_none ) return - 1;
		if ( $fv1->is_other ) return 1;
		if ( $fv2->is_other ) return - 1;

		if ( $fv1->year != null && $fv2->year != null ) {
			if ( $fv1->year == $fv2->year ) {
				if ( $fv1->month == $fv1->month ) return 0;
				return ( $fv1->month > $fv2->month ) ? 1 : - 1;
			}

			return ( $fv1->year > $fv2->year ) ? 1 : - 1;
		}

		if ( $fv1->is_numeric ) {
			if ( $fv1->lower_limit == null ) return - 1;
			return ( $fv1->lower_limit > $fv2->lower_limit ) ? 1 : - 1;
		}

		if ( $fv1->text == $fv2->text ) return 0;

		return ( $fv1->text > $fv2->text ) ? 1 : - 1;
	}

}
