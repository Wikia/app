<?php
/**
 * Defines a class, SDAppliedFilter, that adds a value or a value range
 * onto a an SDFilter instance.
 *
 * @author Yaron Koren
 */

class SDAppliedFilter {
	var $filter;
	var $values = array();
	var $search_term;
	var $lower_date;
	var $upper_date;
	var $lower_date_string;
	var $upper_date_string;

	static function create( $filter, $values, $search_term = null, $lower_date = null, $upper_date = null ) {
		$af = new SDAppliedFilter();
		$af->filter = $filter;
		$af->search_term = htmlspecialchars( str_replace( '_', ' ', $search_term ) );
		if ( $lower_date != null ) {
			$af->lower_date = $lower_date;
			$af->lower_date_string = SDUtils::monthToString( $lower_date['month'] ) . " " . $lower_date['day'] . ", " . $lower_date['year'];
		}
		if ( $upper_date != null ) {
			$af->upper_date = $upper_date;
			$af->upper_date_string = SDUtils::monthToString( $upper_date['month'] ) . " " . $upper_date['day'] . ", " . $upper_date['year'];
		}
		if ( ! is_array( $values ) ) {
			$values = array( $values );
		}
		foreach ( $values as $val ) {
			$filter_val = SDFilterValue::create( $val, $filter->time_period );
			$af->values[] = $filter_val;
		}
		return $af;
	}

	/**
	 * Returns a string that adds a check for this filter/value
	 * combination to an SQL "WHERE" clause.
	 */
	function checkSQL( $value_field ) {
		$sql = "(";
		$dbr = wfGetDB( DB_SLAVE );
		if ( $this->search_term != null ) {
			$search_term = str_replace( "'", "\'", $this->search_term );
			if ( $this->filter->is_relation ) {
				// FIXME: 'LIKE' is supposed to be
				// case-insensitive, but it's not acting
				// that way here.
				//$search_term = strtolower( $search_term );
				$search_term = str_replace( ' ', '\_', $search_term );
				$sql .= "$value_field LIKE '%{$search_term}%'";
			} else {
				//$search_term = strtolower( $search_term );
				$sql .= "$value_field LIKE '%{$search_term}%'";
			}
		}
		if ( $this->lower_date != null ) {
			$date_string = $this->lower_date['year'] . "-" . $this->lower_date['month'] . "-" . $this->lower_date['day'];
			$sql .= "date($value_field) >= date('$date_string') ";
		}
		if ( $this->upper_date != null ) {
			if ( $this->lower_date != null ) {
				$sql .= " AND ";
			}
			$date_string = $this->upper_date['year'] . "-" . $this->upper_date['month'] . "-" . $this->upper_date['day'];
			$sql .= "date($value_field) <= date('$date_string') ";
		}
		foreach ( $this->values as $i => $fv ) {
			if ( $i > 0 ) { $sql .= " OR "; }
			if ( $fv->is_other ) {
				$sql .= "(! ($value_field IS NULL OR $value_field = '' ";
				foreach ( $this->filter->possible_applied_filters as $paf ) {
					$sql .= " OR ";
					$sql .= $paf->checkSQL( $value_field );
				}
				$sql .= "))";
			} elseif ( $fv->is_none ) {
				$sql .= "($value_field = '' OR $value_field IS NULL) ";
			} elseif ( $fv->is_numeric ) {
				if ( $fv->lower_limit && $fv->upper_limit )
					$sql .= "($value_field >= {$fv->lower_limit} AND $value_field <= {$fv->upper_limit}) ";
				elseif ( $fv->lower_limit )
					$sql .= "$value_field > {$fv->lower_limit} ";
				elseif ( $fv->upper_limit )
					$sql .= "$value_field < {$fv->upper_limit} ";
			} elseif ( $this->filter->time_period != null ) {
				if ( $this->filter->time_period == wfMsg( 'sd_filter_month' ) ) {
					$sql .= "YEAR($value_field) = {$fv->year} AND MONTH($value_field) = {$fv->month} ";
				} else {
					$sql .= "YEAR($value_field) = {$fv->year} ";
				}
			} else {
				$value = $fv->text;
				if ( $this->filter->is_relation ) {
					$value = str_replace( ' ', '_', $value );
				}
				$sql .= "$value_field = '{$dbr->strencode($value)}'";
			}
		}
		$sql .= ")";
		return $sql;
	}


	/**
	 * Gets an array of all values that the property belonging to this
	 * filter has, for pages in the passed-in category.
	 */
	function getAllOrValues( $category ) {
		$possible_values = array();
		$property_value = $this->filter->escaped_property;
		$dbr = wfGetDB( DB_SLAVE, 'smw' );
		if ( $this->filter->is_relation ) {
			$property_table_name = $dbr->tableName( 'smw_rels2' );
			$property_table_nickname = "r";
			$value_field = 'o_ids.smw_title';
		} else {
			$property_table_name = $dbr->tableName( 'smw_atts2' );
			$property_table_nickname = "a";
			$value_field = 'value_xsd';
		}
		if ( $this->filter->time_period != null ) {
			if ( $this->filter->time_period == wfMsg( 'sd_filter_month' ) ) {
				$value_field = "YEAR(value_xsd), MONTH(value_xsd)";
			} else {
				$value_field = "YEAR(value_xsd)";
			}
		}
		$smw_insts = $dbr->tableName( 'smw_inst2' );
		$smw_ids = $dbr->tableName( 'smw_ids' );
		$cat_ns = NS_CATEGORY;
		$sql = "	SELECT $value_field
	FROM $property_table_name $property_table_nickname
	JOIN $smw_ids p_ids ON $property_table_nickname.p_id = p_ids.smw_id\n";
		if ( $this->filter->is_relation ) {
			$sql .= "       JOIN $smw_ids o_ids ON $property_table_nickname.o_id = o_ids.smw_id\n";
		}
		$sql .= "	JOIN $smw_insts insts ON $property_table_nickname.s_id = insts.s_id
	JOIN $smw_ids cat_ids ON insts.o_id = cat_ids.smw_id
	WHERE p_ids.smw_title = '$property_value'
	AND cat_ids.smw_namespace = $cat_ns
	AND cat_ids.smw_title = '$category'
	GROUP BY $value_field
	ORDER BY $value_field";
		$res = $dbr->query( $sql );
		while ( $row = $dbr->fetchRow( $res ) ) {
			if ( $this->filter->time_period == wfMsg( 'sd_filter_month' ) )
				$value_string = SDUtils::monthToString( $row[1] ) . " " . $row[0];
			else
				// why is trim() necessary here???
				$value_string = str_replace( '_', ' ', trim( $row[0] ) );
			$possible_values[] = $value_string;
		}
		$dbr->freeResult( $res );
		return $possible_values;
	}

}
