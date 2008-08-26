<?php
/**
 * Defines a class, SDAppliedFilter, that adds a value or a value range
 * onto a an SDFilter instance.
 *
 * @author Yaron Koren
 */

class SDAppliedFilter {
	var $filter;
	var $values;

	function create($filter, $values) {
		$af = new SDAppliedFilter();
		$af->filter = $filter;
		if (! is_array($values)) {
			$values = array($values);
		}
		foreach ($values as $val) {
			$filter_val = SDFilterValue::create($val, $filter->time_period);
			$af->values[] = $filter_val;
		}
		return $af;
	}

	/**
	 * Returns a string that adds a check for this filter/value
	 * combination to an SQL "WHERE" clause.
	 */
	function checkSQL($value_field) {
		$sql = "(";
		$dbr = wfGetDB( DB_SLAVE );
		foreach ($this->values as $i => $fv) {
			if ($i > 0) {$sql .= " OR ";}
			if ($fv->is_other) {
				$sql .= "(! ($value_field IS NULL OR $value_field = '' ";
				foreach ($this->filter->possible_applied_filters as $paf) {
					$sql .= " OR ";
					$sql .= $paf->checkSQL($value_field);
				}
				$sql .= "))";
			} elseif ($fv->is_none) {
				$sql .= "($value_field = '' OR $value_field IS NULL) ";
			} elseif ($fv->is_numeric) {
				if ($fv->lower_limit && $fv->upper_limit)
					$sql .= "($value_field >= {$fv->lower_limit} AND $value_field <= {$fv->upper_limit}) ";
				elseif ($fv->lower_limit)
					$sql .= "$value_field > {$fv->lower_limit} ";
				elseif ($fv->upper_limit)
					$sql .= "$value_field < {$fv->upper_limit} ";
			} elseif ($this->filter->time_period != NULL) {
				if ($this->filter->time_period == wfMsg('sd_filter_month')) {
					$sql .= "YEAR($value_field) = {$fv->year} AND MONTH($value_field) = {$fv->month} ";
				} else {
					$sql .= "YEAR($value_field) = {$fv->year} ";
				}
			} else {
				$value = $fv->text;
				if ($this->filter->is_relation) {
					$value = str_replace(' ', '_', $value);
				}
				$sql .= "$value_field = '{$dbr->strencode($value)}'";
			}
		}
		$sql .= ")";
		return $sql;
	}
}
