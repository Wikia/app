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
	var $escaped_property;
	var $is_relation;
	var $is_boolean;
	var $is_date;
	var $category;
	var $time_period = null;
	var $input_type = null;
	var $allowed_values;
	var $possible_applied_filters = array();

	static function loadAllFromPageSchema( $psSchemaObj ){
		$filters_ps = array();
		$template_all = $psSchemaObj->getTemplates();
		foreach ( $template_all as $template ) {
			$field_all = $template->getFields();
			foreach( $field_all as $fieldObj ) {
				$f = new SDFilter();
				$filter_array = $fieldObj->getObject( 'semanticdrilldown_Filter' );
				if ( is_null( $filter_array ) ) {
					continue;
				}
				if ( array_key_exists( 'name', $filter_array ) ) {
					$f->name = $filter_array['name'];
				} else {
					$f->name = $fieldObj->getName();
				}
				$prop_array = $fieldObj->getObject('semanticmediawiki_Property');
				$f->property = $prop_array['name'];
				$f->escaped_property = str_replace( array( ' ', "'" ), array( '_', "\'" ), $f->property );
				$f->is_relation = true;
				if ( array_key_exists( 'Type', $prop_array ) && $prop_array['Type'] != 'Page' ) {
					$f->is_relation = false;
				}
				if ( array_key_exists( 'InputType', $filter_array ) ) {
					$f->input_type = $filter_array['InputType'];
				}
				if ( array_key_exists( 'ValuesFromCategory', $filter_array ) ) {
					$f->category = $filter_array['ValuesFromCategory'];
					$f->allowed_values = SDUtils::getCategoryChildren( $f->category, false, 5 );
				} elseif ( array_key_exists( 'TimePeriod', $filter_array ) ) {
					$f->time_period = $filter_array['TimePeriod'];
					$f->allowed_values = array();
				} elseif ( $f->is_boolean ) {
					$f->allowed_values = array( '0', '1' );
				} elseif ( array_key_exists( 'Values', $filter_array ) ) {
					$f->allowed_values = $filter_array['Values'];
				} else {
					$f->allowed_values = array();
				}
				$filters_ps[] = $f ;
			}
		}
		return $filters_ps;
	}

	static function load( $filter_name ) {
		$f = new SDFilter();
		$f->name = $filter_name;
		$properties_used = SDUtils::getValuesForProperty( $filter_name, SD_NS_FILTER, '_SD_CP', SD_SP_COVERS_PROPERTY, SMW_NS_PROPERTY );
		if ( count( $properties_used ) > 0 ) {
			$f->property = $properties_used[0];
			$f->escaped_property = str_replace( array( ' ', "'" ), array( '_', "\'" ), $f->property );
		}
		$f->is_relation = true;
		$proptitle = Title::newFromText( $f->property, SMW_NS_PROPERTY );
		if ( $proptitle != null ) {
			$store = smwfGetStore();
			if ( class_exists( 'SMWDIProperty' ) ) {
				// SMW 1.6
				$propPage = new SMWDIWikiPage( $f->escaped_property, SMW_NS_PROPERTY, null );
				$types = $store->getPropertyValues( $propPage, new SMWDIProperty( '_TYPE' ) );
			} elseif ( class_exists( 'SMWPropertyValue' ) ) {
				$types = $store->getPropertyValues( $proptitle, SMWPropertyValue::makeUserProperty( 'Has type' ) );
			} else {
				$types = $store->getSpecialValues( $proptitle, SMW_SP_HAS_TYPE );
			}
			global $smwgContLang;
			$datatypeLabels =  $smwgContLang->getDatatypeLabels();
			if ( count( $types ) > 0 ) {
				if ( $types[0] instanceof SMWDIWikiPage ) {
					// SMW 1.6
					$typeValue = $types[0]->getDBkey();
				} elseif ( $types[0] instanceof SMWDIURI ) {
					// A bit inefficient, but it's the
					// simplest approach.
					$typeID = $types[0]->getFragment();
					$typeValue = $datatypeLabels[$typeID];
				} else {
					$typeValue = $types[0]->getWikiValue();
				}
				if ( $typeValue != $datatypeLabels['_wpg'] ) {
					$f->is_relation = false;
				}
				if ( $typeValue == $datatypeLabels['_boo'] ) {
					$f->is_boolean = true;
				}
				if ( $typeValue == $datatypeLabels['_dat'] ) {
					$f->is_date = true;
				}
			}
		}
		$categories = SDUtils::getValuesForProperty( $filter_name, SD_NS_FILTER, '_SD_VC', SD_SP_GETS_VALUES_FROM_CATEGORY, NS_CATEGORY );
		$time_periods = SDUtils::getValuesForProperty( $filter_name, SD_NS_FILTER, '_SD_TP', SD_SP_USES_TIME_PERIOD, null );
		if ( count( $categories ) > 0 ) {
			$f->category = $categories[0];
			$f->allowed_values = SDUtils::getCategoryChildren( $f->category, false, 5 );
		} elseif ( count( $time_periods ) > 0 ) {
			$f->time_period = $time_periods[0];
			$f->allowed_values = array();
		} elseif ( $f->is_boolean ) {
			$f->allowed_values = array( '0', '1' );
		} else {
			$values = SDUtils::getValuesForProperty( $filter_name, SD_NS_FILTER, '_SD_V', SD_SP_HAS_VALUE, null );
			$f->allowed_values = $values;
		}
		$input_types = SDUtils::getValuesForProperty( $filter_name, SD_NS_FILTER, '_SD_IT', SD_SP_HAS_INPUT_TYPE, null );
		if ( count( $input_types ) > 0 ) {
			$f->input_type = $input_types[0];
		}
		// set list of possible applied filters if allowed values
		// array was set
		foreach ( $f->allowed_values as $allowed_value ) {
			$f->possible_applied_filters[] = SDAppliedFilter::create( $f, $allowed_value );
		}
		return $f;
	}

	/**
	 * Gets an array of the possible time period values (e.g., years,
	 * years and months) for this filter, and, for each one,
	 * the number of pages that match that time period.
	 */
	function getTimePeriodValues() {
		$possible_dates = array();
		$property_value = $this->escaped_property;
		$dbr = wfGetDB( DB_SLAVE, 'smw' );
		if ( $this->time_period == wfMsg( 'sd_filter_month' ) ) {
			$fields = "YEAR(value_xsd), MONTH(value_xsd)";
		} else {
			$fields = "YEAR(value_xsd)";
		}
		$smw_attributes = $dbr->tableName( 'smw_atts2' );
		$smw_ids = $dbr->tableName( 'smw_ids' );
		$sql = <<<END
	SELECT $fields, count(*)
	FROM semantic_drilldown_values sdv
	JOIN $smw_attributes a ON sdv.id = a.s_id
	JOIN $smw_ids p_ids ON a.p_id = p_ids.smw_id
	WHERE p_ids.smw_title = '$property_value'
	GROUP BY $fields
	ORDER BY $fields

END;
		$res = $dbr->query( $sql );
		while ( $row = $dbr->fetchRow( $res ) ) {
			if ( $this->time_period == wfMsg( 'sd_filter_month' ) ) {
				global $sdgMonthValues;
				$date_string = SDUtils::monthToString( $row[1] ) . " " . $row[0];
				$possible_dates[$date_string] = $row[2];
			} else {
				$date_string = $row[0];
				$possible_dates[$date_string] = $row[1];
			}
		}
		$dbr->freeResult( $res );
		return $possible_dates;
	}

	/**
	 * Gets an array of all values that the property belonging to this
	 * filter has, and, for each one, the number of pages
	 * that match that value.
	 */
	function getAllValues() {
		if ( $this->time_period != null )
			return $this->getTimePeriodValues();

		$possible_values = array();
		$property_value = $this->escaped_property;
		$dbr = wfGetDB( DB_SLAVE, 'smw' );
		if ( $this->is_relation ) {
			$property_table_name = $dbr->tableName( 'smw_rels2' );
			$property_table_nickname = "r";
			$value_field = 'o_ids.smw_title';
		} else {
			$property_table_name = $dbr->tableName( 'smw_atts2' );
			$property_table_nickname = "a";
			$value_field = 'value_xsd';
		}
		$smw_ids = $dbr->tableName( 'smw_ids' );
		$prop_ns = SMW_NS_PROPERTY;
		$sql = <<<END
	SELECT $value_field, count(DISTINCT sdv.id)
	FROM semantic_drilldown_values sdv
	JOIN $property_table_name $property_table_nickname ON sdv.id = $property_table_nickname.s_id

END;
		if ( $this->is_relation ) {
			$sql .= "	JOIN $smw_ids o_ids ON r.o_id = o_ids.smw_id";
		}
		$sql .= <<<END
	JOIN $smw_ids p_ids ON $property_table_nickname.p_id = p_ids.smw_id
	WHERE p_ids.smw_title = '$property_value'
	AND p_ids.smw_namespace = $prop_ns
	AND $value_field != ''
	GROUP BY $value_field
	ORDER BY $value_field

END;
		$res = $dbr->query( $sql );
		while ( $row = $dbr->fetchRow( $res ) ) {
			$value_string = str_replace( '_', ' ', $row[0] );
			$possible_values[$value_string] = $row[1];
		}
		$dbr->freeResult( $res );
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
		$dbr = wfGetDB( DB_SLAVE, 'smw' );
		$smw_ids = $dbr->tableName( 'smw_ids' );
		if ( $this->is_relation ) {
			$table_name = $dbr->tableName( 'smw_rels2' );
			$property_field = 'p_id';
			$value_field = 'o_ids.smw_title';
		} else {
			$table_name = $dbr->tableName( 'smw_atts2' );
			$property_field = 'p_id';
			$value_field = 'value_xsd';
		}
		$query_property = $this->escaped_property;
		$sql = <<<END
	CREATE TEMPORARY TABLE semantic_drilldown_filter_values
	AS SELECT s_id AS id, $value_field AS value
	FROM $table_name
	JOIN $smw_ids p_ids ON $table_name.p_id = p_ids.smw_id

END;
		if ( $this->is_relation ) {
			$sql .= "	JOIN $smw_ids o_ids ON $table_name.o_id = o_ids.smw_id\n";
		}
		$sql .= "	WHERE p_ids.smw_title = '$query_property'";
		$dbr->query( $sql );
	}

	/**
	 * Deletes the temporary table.
	 */
	function dropTempTable() {
		$dbr = wfGetDB( DB_SLAVE, 'smw' );
		// DROP TEMPORARY TABLE would be marginally safer, but it's
		// not supported on all RDBMS's.
		$sql = "DROP TABLE semantic_drilldown_filter_values";
		$dbr->query( $sql );
	}
}
