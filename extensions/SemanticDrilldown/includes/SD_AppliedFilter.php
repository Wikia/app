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
	var $search_terms;
	var $lower_date;
	var $upper_date;
	var $lower_date_string;
	var $upper_date_string;

	static function create( $filter, $values, $search_terms = null, $lower_date = null, $upper_date = null ) {
		$af = new SDAppliedFilter();
		$af->filter = $filter;
		if ( $search_terms != null ) {
			$af->search_terms = array();
			foreach( $search_terms as $search_term ) {
				$af->search_terms[] = htmlspecialchars( str_replace( '_', ' ', $search_term ) );
			}
		}
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
			$filter_val = SDFilterValue::create( $val, $filter );
			$af->values[] = $filter_val;
		}
		return $af;
	}

	/**
	 * Returns a string that adds a check for this filter/value
	 * combination to an SQL "WHERE" clause.
	 */
	function checkSQL( $value_field ) {
		global $wgDBtype;
		$sql = "(";
		$dbr = wfGetDB( DB_SLAVE );
		if ( $this->search_terms != null ) {
			$quoteReplace = ( $wgDBtype == 'postgres' ? "''" : "\'");
			foreach ( $this->search_terms as $i => $search_term ) {
				$search_term = str_replace( "'", $quoteReplace, $search_term );
				if ( $i > 0 ) {
					$sql .= ' OR ';
				}
				if ( $this->filter->property_type === 'page' ) {
					// FIXME: 'LIKE' is supposed to be
					// case-insensitive, but it's not acting
					// that way here.
					//$search_term = strtolower( $search_term );
					$search_term = str_replace( ' ', '_', $search_term );
					$sql .= "$value_field " . $dbr->buildLike( $dbr->anyString(), $search_term, $dbr->anyString() );
				} else {
					//$search_term = strtolower( $search_term );
					$sql .= "$value_field " . $dbr->buildLike( $dbr->anyString(), $search_term, $dbr->anyString() );
				}
			}
		}
		if ( $this->lower_date != null ) {
			$date_string = $this->lower_date['year'] . "-" . $this->lower_date['month'] . "-" . $this->lower_date['day'];
			$sql .= "date($value_field) >= date({$dbr->addQuotes( $date_string )}) ";
		}
		if ( $this->upper_date != null ) {
			if ( $this->lower_date != null ) {
				$sql .= " AND ";
			}
			$date_string = $this->upper_date['year'] . "-" . $this->upper_date['month'] . "-" . $this->upper_date['day'];
			$sql .= "date($value_field) <= date({$dbr->addQuotes( $date_string )}) ";
		}
		foreach ( $this->values as $i => $fv ) {
			if ( $i > 0 ) { $sql .= " OR "; }
			if ( $fv->is_other ) {
				$checkNullOrEmptySql = "$value_field IS NULL " . ( $wgDBtype == 'postgres' ? '' : "OR $value_field = '' ");
				$notOperatorSql = ( $wgDBtype == 'postgres' ? "not" : "!" );
				$sql .= "($notOperatorSql ($checkNullOrEmptySql ";
				foreach ( $this->filter->possible_applied_filters as $paf ) {
					$sql .= " OR ";
					$sql .= $paf->checkSQL( $value_field );
				}
				$sql .= "))";
			} elseif ( $fv->is_none ) {
				$checkNullOrEmptySql = ( $wgDBtype == 'postgres' ? '' : "$value_field = '' OR ") . "$value_field IS NULL";
				$sql .= "($checkNullOrEmptySql) ";
			} elseif ( $fv->is_numeric ) {
				if ( $fv->lower_limit && $fv->upper_limit )
					$sql .= "($value_field >= {$dbr->addQuotes( $fv->lower_limit )} AND $value_field <= {$dbr->addQuotes( $fv->upper_limit )}) ";
				elseif ( $fv->lower_limit )
					$sql .= "$value_field > {$dbr->addQuotes( $fv->lower_limit )} ";
				elseif ( $fv->upper_limit )
					$sql .= "$value_field < {$dbr->addQuotes( $fv->upper_limit )} ";
			} elseif ( $this->filter->property_type == 'date' ) {
				$date_field = $this->filter->getDateField();
				if ( $fv->time_period == 'day' ) {
					$sql .= "YEAR($date_field) = {$dbr->addQuotes( $fv->year )} AND MONTH($date_field) = {$dbr->addQuotes( $fv->month )} AND DAYOFMONTH($date_field) = {$dbr->addQuotes( $fv->day )} ";
				} elseif ( $fv->time_period == 'month' ) {
					$sql .= "YEAR($date_field) = {$dbr->addQuotes( $fv->year )} AND MONTH($date_field) = {$dbr->addQuotes( $fv->month )} ";
				} elseif ( $fv->time_period == 'year' ) {
					$sql .= "YEAR($date_field) = {$dbr->addQuotes( $fv->year )} ";
				} else { // if ( $fv->time_period == 'year range' ) {
					$sql .= "YEAR($date_field) >= {$dbr->addQuotes( $fv->year )} ";
					$sql .= "AND YEAR($date_field) <= {$dbr->addQuotes( $fv->end_year )} ";
				}
			} else {
				$value = $fv->text;
				if ( $this->filter->property_type === 'page' ) {
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
		$property_table_name = $dbr->tableName( $this->filter->getTableName() );
		if ( $this->filter->property_type != 'date' ) {
			$value_field = $this->filter->getValueField();
		} else {
			// Is this necessary?
			$date_field = $this->filter->getDateField();
			if ( $this->filter->getTimePeriod() == 'month' ) {
				$value_field = "YEAR($date_field), MONTH($date_field)";
			} elseif ( $this->filter->getTimePeriod() == 'day' ) {
				$value_field = "YEAR($date_field), MONTH($date_field), DAYOFMONTH($date_field)";
			} elseif ( $this->filter->getTimePeriod() == 'year' ) {
				$value_field = "YEAR($date_field)";
			} else { // if ( $this->filter->getTimePeriod() == 'year range' ) {
				$value_field = "YEAR($date_field)";
			}
		}
		$smwIDs = $dbr->tableName( SDUtils::getIDsTableName() );
		$smwCategoryInstances = $dbr->tableName( SDUtils::getCategoryInstancesTableName() );
		$cat_ns = NS_CATEGORY;
		$sql = "	SELECT $value_field
	FROM $property_table_name p
	JOIN $smwIDs p_ids ON p.p_id = p_ids.smw_id\n";
		if ( $this->filter->property_type === 'page' ) {
			$sql .= "       JOIN $smwIDs o_ids ON p.o_id = o_ids.smw_id\n";
		}
		$sql .= "	JOIN $smwCategoryInstances insts ON p.s_id = insts.s_id
	JOIN $smwIDs cat_ids ON insts.o_id = cat_ids.smw_id
	WHERE p_ids.smw_title = '$property_value'
	AND cat_ids.smw_namespace = $cat_ns
	AND cat_ids.smw_title = {$dbr->addQuotes( $category )}
	GROUP BY $value_field
	ORDER BY $value_field";
		$res = $dbr->query( $sql );
		while ( $row = $dbr->fetchRow( $res ) ) {
			if ( $this->filter->property_type == 'date' && $this->filter->getTimePeriod() == 'month' ) {
				$value_string = SDUtils::monthToString( $row[1] ) . " " . $row[0];
			} else {
				// why is trim() necessary here???
				$value_string = str_replace( '_', ' ', trim( $row[0] ) );
			}
			$possible_values[] = $value_string;
		}
		$dbr->freeResult( $res );
		return $possible_values;
	}

}
