<?php
/**
 * Defines a class, SDFilter, that holds the information in a filter,
 * i.e. a single page in the "Filter:" namespace
 *
 * @author Yaron Koren
 */

class SDFilter {
	var $name;
	var $property;
	var $is_relation;
	var $is_boolean;
	var $category;
	var $time_period = null;
	var $input_type = null;
	var $allowed_values;
	var $possible_applied_filters = array();

	function load($filter_name) {
		$f = new SDFilter();
		$f->name = $filter_name;
		$properties_used = SDUtils::getValuesForProperty($filter_name, SD_NS_FILTER, '_SD_CP', SD_SP_COVERS_PROPERTY, SMW_NS_PROPERTY);
		if (count($properties_used) > 0) {
			$f->property = $properties_used[0];
		}
		$f->is_relation = false;
		$proptitle = Title::newFromText($f->property, SMW_NS_PROPERTY);
		if ($proptitle != NULL) {
			$store = smwfGetStore();
			if (class_exists('SMWPropertyValue')) {
				$types = $store->getPropertyValues($proptitle, SMWPropertyValue::makeUserProperty('Has type'));
			} else {
				$types = $store->getSpecialValues($proptitle, SMW_SP_HAS_TYPE);
			}
			global $smwgContLang;
			$datatypeLabels =  $smwgContLang->getDatatypeLabels();
			if (count($types) > 0) {
				if ($types[0]->getWikiValue() == $datatypeLabels['_wpg']) {
					$f->is_relation = true;
				} elseif ($types[0]->getWikiValue() == $datatypeLabels['_boo']) {
					$f->is_boolean = true;
				}
			}
		}
		$categories = SDUtils::getValuesForProperty($filter_name, SD_NS_FILTER, '_SD_VC', SD_SP_GETS_VALUES_FROM_CATEGORY, NS_CATEGORY);
		$time_periods = SDUtils::getValuesForProperty($filter_name, SD_NS_FILTER, '_SD_TP', SD_SP_USES_TIME_PERIOD, null);
		if (count($categories) > 0) {
			$f->category = $categories[0];
			$f->allowed_values = SDUtils::getCategoryChildren($f->category, false, 5);
		} elseif (count($time_periods) > 0) {
			$f->time_period = $time_periods[0];
			$f->allowed_values = array();
		} elseif ($f->is_boolean) {
			$f->allowed_values = array('0', '1');
		} else {
			$values = SDUtils::getValuesForProperty($filter_name, SD_NS_FILTER, '_SD_V', SD_SP_HAS_VALUE, null);
			$f->allowed_values = $values;
		}
		$input_types = SDUtils::getValuesForProperty($filter_name, SD_NS_FILTER, '_SD_IT', SD_SP_HAS_INPUT_TYPE, null);
		if (count($input_types) > 0) {
			$f->input_type = $input_types[0];
		}
		// set list of possible applied filters if allowed values
		// array was set
		foreach($f->allowed_values as $allowed_value) {
			$f->possible_applied_filters[] = SDAppliedFilter::create($f, $allowed_value);
		}
		return $f;
	}


	/**
	 * Gets an array of the possible time period values (e.g., years,
	 * years and months) for this filter, and, for each one,
	 * the number of pages that match that time period.
	 */
	function getTimePeriodValues() {
		global $smwgDefaultStore;

		$possible_dates = array();
		$property_value = str_replace(' ', '_', $this->property);
		$dbr = wfGetDB( DB_SLAVE );
		if ($this->time_period == wfMsg('sd_filter_month')) {
			$fields = "YEAR(value_xsd), MONTH(value_xsd)";
		} else {
			$fields = "YEAR(value_xsd)";
		}
		if ($smwgDefaultStore == 'SMWSQLStore2') {
			$smw_attributes = $dbr->tableName( 'smw_atts2' );
			$smw_ids = $dbr->tableName( 'smw_ids' );
			$sql =<<<END
	SELECT $fields, count(*)
	FROM semantic_drilldown_values sdv
	JOIN $smw_attributes a ON sdv.id = a.s_id
	JOIN $smw_ids p_ids ON a.p_id = p_ids.smw_id
	WHERE p_ids.smw_title = '$property_value'
	GROUP BY $fields
	ORDER BY $fields

END;
		} else {
			$smw_attributes = $dbr->tableName( 'smw_attributes' );
			$sql =<<<END
	SELECT $fields, count(*)
	FROM semantic_drilldown_values sdv
	JOIN $smw_attributes a ON sdv.id = a.subject_id
	WHERE a.attribute_title = '$property_value'
	GROUP BY $fields
	ORDER BY $fields

END;
		}
		$res = $dbr->query($sql);
		while ($row = $dbr->fetchRow($res)) {
			if ($this->time_period == wfMsg('sd_filter_month')) {
				global $sdgMonthValues;
				$date_string = SDUtils::monthToString($row[1]) . " " . $row[0];
				$possible_dates[$date_string] = $row[2];
			} else {
				$date_string = $row[0];
				$possible_dates[$date_string] = $row[1];
			}
		}
		$dbr->freeResult($res);
		return $possible_dates;
	}

	/**
	 * Gets an array of all values that the property belonging to this
	 * filter has, and, for each one, the number of pages
	 * that match that value.
	 */
	function getAllValues() {
		global $smwgDefaultStore;
		if ($this->time_period != NULL) {
			return $this->getTimePeriodValues();
		} elseif ($smwgDefaultStore == 'SMWSQLStore2') {
			return $this->getAllValues_2();
		} else {
			return $this->getAllValues_orig();
		}
	}

	function getAllValues_orig() {
		$possible_values = array();
		$property_value = str_replace(' ', '_', $this->property);
		$dbr = wfGetDB( DB_SLAVE );
		if ($this->is_relation) {
			$property_table_name = $dbr->tableName('smw_relations');
			$property_table_nickname = "r";
			$property_field = 'relation_title';
			$value_field = 'object_title';
		} else {
			$property_table_name = $dbr->tableName('smw_attributes');
			$property_table_nickname = "a";
			$property_field = 'attribute_title';
			$value_field = 'value_xsd';
		}
		$sql = "SELECT $value_field, count(*)
			FROM semantic_drilldown_values sdv
			JOIN $property_table_name $property_table_nickname
			ON sdv.id = $property_table_nickname.subject_id
			WHERE $property_table_nickname.$property_field = '$property_value'
			AND $value_field != ''
			GROUP BY $value_field
			ORDER BY $value_field";
		$res = $dbr->query($sql);
		while ($row = $dbr->fetchRow($res)) {
			$value_string = str_replace('_', ' ', $row[0]);
			$possible_values[$value_string] = $row[1];
		}
		$dbr->freeResult($res);
		return $possible_values;
	}

	function getAllValues_2() {
		$possible_values = array();
		$property_value = str_replace(' ', '_', $this->property);
		$dbr = wfGetDB( DB_SLAVE );
		if ($this->is_relation) {
			$property_table_name = $dbr->tableName('smw_rels2');
			$property_table_nickname = "r";
			$value_field = 'o_ids.smw_title';
		} else {
			$property_table_name = $dbr->tableName('smw_atts2');
			$property_table_nickname = "a";
			$value_field = 'value_xsd';
		}
		$smw_ids = $dbr->tableName( 'smw_ids' );
		$prop_ns = SMW_NS_PROPERTY;
		$sql =<<<END
	SELECT $value_field, count(*)
	FROM semantic_drilldown_values sdv
	JOIN $property_table_name $property_table_nickname ON sdv.id = $property_table_nickname.s_id

END;
		if ($this->is_relation) {
			$sql .= "	JOIN $smw_ids o_ids ON r.o_id = o_ids.smw_id";
		}
		$sql .=<<<END
	JOIN $smw_ids p_ids ON $property_table_nickname.p_id = p_ids.smw_id
	WHERE p_ids.smw_title = '$property_value'
	AND p_ids.smw_namespace = $prop_ns
	AND $value_field != ''
	GROUP BY $value_field
	ORDER BY $value_field

END;
		$res = $dbr->query($sql);
		while ($row = $dbr->fetchRow($res)) {
			$value_string = str_replace('_', ' ', $row[0]);
			$possible_values[$value_string] = $row[1];
		}
		$dbr->freeResult($res);
		return $possible_values;
	}



	/**
	 * Creates a temporary database table, semantic_drilldown_filter_values,
	 * that holds every value held by any page in the wiki that matches
	 * the property associated with this filter. This table is useful
	 * both for speeding up later queries (at least, that's the hope)
	 * and for getting the set of 'None' values.
	 */
	function createTempTable() {
		global $smwgDefaultStore;
		if ($smwgDefaultStore == 'SMWSQLStore2') {
			$this->createTempTable_2();
		} else {
			$this->createTempTable_orig();
		}
	}

	function createTempTable_orig() {
		$dbr = wfGetDB( DB_SLAVE );
		if ($this->is_relation) {
			$table_name = $dbr->tableName( 'smw_relations' );
			$property_field = 'relation_title';
			$value_field = 'object_title';
		} else {
			$table_name = $dbr->tableName( 'smw_attributes' );
			$property_field = 'attribute_title';
			$value_field = 'value_xsd';
		}
		$query_property = str_replace(' ', '_', $this->property);
		$sql =<<<END
	CREATE TEMPORARY TABLE semantic_drilldown_filter_values (
		id INT NOT NULL,
		value VARCHAR(200) NOT NULL,
		INDEX sdfv_id_index(id)
	) ENGINE=MyIsam AS SELECT subject_id AS id, $value_field AS value
	FROM $table_name
	WHERE $property_field = '$query_property'
END;
		$dbr->query($sql);
	}

	function createTempTable_2() {
		$dbr = wfGetDB( DB_SLAVE );
		$smw_ids = $dbr->tableName( 'smw_ids' );
		if ($this->is_relation) {
			$table_name = $dbr->tableName( 'smw_rels2' );
			$property_field = 'p_id';
			$value_field = 'o_ids.smw_title';
		} else {
			$table_name = $dbr->tableName( 'smw_atts2' );
			$property_field = 'p_id';
			$value_field = 'value_xsd';
		}
		$query_property = str_replace(' ', '_', $this->property);
		$sql =<<<END
	CREATE TEMPORARY TABLE semantic_drilldown_filter_values ENGINE=MyIsam
	AS SELECT s_id AS id, $value_field AS value
	FROM $table_name
	JOIN $smw_ids p_ids ON $table_name.p_id = p_ids.smw_id

END;
		if ($this->is_relation) {
			$sql .= "	JOIN $smw_ids o_ids ON $table_name.o_id = o_ids.smw_id\n";
		}
		$sql .= "	WHERE p_ids.smw_title = '$query_property'";
		$dbr->query($sql);
	}

	/**
	 * Deletes the temporary table.
	 */
	function dropTempTable() {
		$dbr = wfGetDB( DB_SLAVE );
		$sql = "DROP TEMPORARY TABLE semantic_drilldown_filter_values";
		$dbr->query($sql);
	}
}
