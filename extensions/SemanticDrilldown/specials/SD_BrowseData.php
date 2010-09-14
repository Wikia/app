<?php
/**
 * Displays an interface to let the user drill down through all data on
 * the wiki, using categories and custom-defined filters that have
 * previously been created.
 *
 * @author Yaron Koren
 */

if (!defined('MEDIAWIKI')) die();

class SDBrowseData extends SpecialPage {

	/**
	 * Constructor
	 */
	public function SDBrowseData() {
		SpecialPage::SpecialPage('BrowseData');
		wfLoadExtensionMessages('SemanticDrilldown');
	}

	function execute( $query ) {
		$this->setHeaders();
		doSpecialBrowseData( $query );
	}
}

class BrowseDataPage extends QueryPage {
	var $category = "";
	var $subcategory = "";
	var $next_level_subcategories = array();
	var $all_subcategories = array();
	var $applied_filters = array();
	var $remaining_filters = array();
	var $browse_data_title;
	var $show_single_cat = false;

	/**
	 * Initialize the variables of this page
	 */
	function BrowseDataPage($category, $subcategory, $applied_filters, $remaining_filters) {
		$this->category = $category;
		$this->subcategory = $subcategory;
		$this->applied_filters = $applied_filters;
		$this->remaining_filters = $remaining_filters;
		$this->browse_data_title = Title::newFromText('BrowseData', NS_SPECIAL);

		$dbr = wfGetDB( DB_SLAVE );
		$categorylinks = $dbr->tableName( 'categorylinks' );
		$page = $dbr->tableName( 'page' );
		$cat_ns = NS_CATEGORY;
		if ($this->subcategory)
			$actual_cat = str_replace(' ', '_', $this->subcategory);
		else
			$actual_cat = str_replace(' ', '_', $this->category);
		// get the two arrays for subcategories - one for only the
		// immediate subcategories, for display, and the other for
		// all subcategories, sub-subcategories, etc., for querying
		$this->next_level_subcategories = SDUtils::getCategoryChildren($actual_cat, true, 1);
		$this->all_subcategories = SDUtils::getCategoryChildren($actual_cat, true, 10);
	}

	function makeBrowseURL($category, $applied_filters = array(), $subcategory = null) {
		$url = $this->browse_data_title->getFullURL() . '/' . $category;
		if ($this->show_single_cat) {
			$url .= (strpos($url, '?')) ? '&' : '?';
			$url .= "_single";
		}
		if ($subcategory) {
			$url .= (strpos($url, '?')) ? '&' : '?';
			$url .= "_subcat=" . $subcategory;
		}
		foreach ($applied_filters as $i => $af) {
			if (count($af->values) == 0) {
				// do nothing
			} elseif (count($af->values) == 1) {
				$url .= (strpos($url, '?')) ? '&' : '?';
				$url .= urlencode(str_replace(' ', '_', $af->filter->name)) . "=" . urlencode(str_replace(' ', '_', $af->values[0]->text));
			} else {
				usort($af->values, array("SDFilterValue", "compare"));
				foreach ($af->values as $j => $fv) {
					$url .= (strpos($url, '?')) ? '&' : '?';
					$url .= urlencode(str_replace(' ', '_', $af->filter->name)) . "[$j]=" . urlencode(str_replace(' ', '_', $fv->text));
				}
			}
			if ($af->search_term != null) {
				$url .= (strpos($url, '?')) ? '&' : '?';
				$url .= '_search_' . urlencode(str_replace(' ', '_', $af->filter->name)) . "=" . urlencode(str_replace(' ', '_', $af->search_term));
			}
		}
		return $url;
	}

	/**
	 * Creates a temporary database table of values that match the current
	 * set of filters selected by the user - used for displaying
	 * all remaining filters
	 */
	function createTempTable($category, $subcategory, $subcategories, $applied_filters) {
		global $smwgDefaultStore;

		$dbr = wfGetDB( DB_SLAVE );
		$sql =<<<END
	CREATE TEMPORARY TABLE semantic_drilldown_values (
		id INT NOT NULL,
		INDEX id_index (id)
	) Engine=MEMORY AS SELECT
END;
		if ($smwgDefaultStore == 'SMWSQLStore2') {
			$sql .= " ids.smw_id AS id ";
			$sql .= $this->getSQLFromClause_2($category, $subcategory, $subcategories, $applied_filters);
		} else {
			$sql .= " p.page_id AS id ";
			$sql .= $this->getSQLFromClause_orig($category, $subcategory, $subcategories, $applied_filters);
		}
		$dbr->query($sql);
	}

	/**
	 * Creates a SQL statement, lacking only the initial "SELECT"
	 * clause, to get all the pages that match all the previously-
	 * selected filters, plus the one new filter (with value) that
	 * was passed in to this function.
	 */
	function getSQLFromClauseForField($new_filter) {
		$sql = "FROM semantic_drilldown_values sdv
			LEFT OUTER JOIN semantic_drilldown_filter_values sdfv
			ON sdv.id = sdfv.id
			WHERE ";
		$sql .= $new_filter->checkSQL("sdfv.value");
		return $sql;
	}

	/**
	 * Very similar to getSQLFromClauseForField(), except that instead
	 * of a new filter passed in, it's a subcategory, plus all that
	 * subcategory's child subcategories, to ensure completeness.
	 */
	function getSQLFromClauseForCategory($subcategory, $child_subcategories) {
		global $smwgDefaultStore;
		if ($smwgDefaultStore == 'SMWSQLStore2') {
			return $this->getSQLFromClauseForCategory_2($subcategory, $child_subcategories);
		} else {
			return $this->getSQLFromClauseForCategory_orig($subcategory, $child_subcategories);
		}
	}

	function getSQLFromClauseForCategory_orig($subcategory, $child_subcategories) {
		$dbr = wfGetDB( DB_SLAVE );
		$categorylinks = $dbr->tableName( 'categorylinks' );
		$subcategory = str_replace("'", "\'", $subcategory);
		$sql = "FROM semantic_drilldown_values sdv
			JOIN $categorylinks c
			ON sdv.id = c.cl_from
			WHERE (c.cl_to = '$subcategory' ";
		foreach ($child_subcategories as $i => $subcat) {
			$subcat = str_replace("'", "\'", $subcat);
			$sql .= "OR c.cl_to = '$subcat' ";
		}
		$sql .= ") ";
		return $sql;
	}

	function getSQLFromClauseForCategory_2($subcategory, $child_subcategories) {
		$dbr = wfGetDB( DB_SLAVE );
		$smw_insts = $dbr->tableName( 'smw_inst2' );
		$smw_ids = $dbr->tableName( 'smw_ids' );
		$ns_cat = NS_CATEGORY;
		$subcategory = str_replace("'", "\'", $subcategory);
		$sql = "FROM semantic_drilldown_values sdv
	JOIN $smw_insts inst
	ON sdv.id = inst.s_id
	WHERE inst.o_id IN
		(SELECT smw_id FROM $smw_ids
		WHERE smw_namespace = $ns_cat AND (smw_title = '$subcategory' ";
		foreach ($child_subcategories as $i => $subcat) {
			$subcat = str_replace("'", "\'", $subcat);
			$sql .= "OR smw_title = '$subcat' ";
		}
		$sql .= ")) ";
		return $sql;
	}

	/**
	 * Returns everything from the FROM clause onward for a SQL statement
	 * to get all pages that match a certain set of criteria for
	 * category, subcategory and filters
	 */
	function getSQLFromClause($category, $subcategory, $subcategories, $applied_filters) {
		global $smwgDefaultStore;
		if ($smwgDefaultStore == 'SMWSQLStore2') {
			return $this->getSQLFromClause_2($category, $subcategory, $subcategories, $applied_filters);
		} else {
			return $this->getSQLFromClause_orig($category, $subcategory, $subcategories, $applied_filters);
		}
	}

	function getSQLFromClause_orig($category, $subcategory, $subcategories, $applied_filters) {
		$dbr = wfGetDB( DB_SLAVE );
		$page = $dbr->tableName( 'page' );
		$smw_relations = $dbr->tableName( 'smw_relations' );
		$smw_attributes = $dbr->tableName( 'smw_attributes' );
		$categorylinks = $dbr->tableName( 'categorylinks' );

		$sql = "FROM $page p
			JOIN $categorylinks c
			ON p.page_id = c.cl_from ";
		$cat_ns = NS_CATEGORY;
		$sql .= "AND p.page_namespace != $cat_ns ";
		foreach ($applied_filters as $i => $af) {
			// if any of this filter's values is 'none',
			// include another table to get this information
			$includes_none = false;
			foreach ($af->values as $fv) {
				if ($fv->text === '_none' || $fv->text === ' none') {
					$includes_none = true;
					break;
				}
			}
			if ($includes_none) {
				if ($af->filter->is_relation) {
					$property_table_name = $smw_relations;
					$property_table_nickname = "nr$i";
					$property_field = 'relation_title';
					$value_field = 'object_title';
				} else {
					$property_table_name = $smw_attributes;
					$property_table_nickname = "na$i";
					$property_field = 'attribute_title';
					$value_field = 'value_xsd';
				}
				$property_value = str_replace(' ', '_', $af->filter->property);
				$property_value = str_replace("'", "\'", $property_value);
				$sql .= "LEFT OUTER JOIN
	(SELECT subject_id, $value_field
	FROM $property_table_name
	WHERE $property_field = '$property_value') $property_table_nickname
	ON p.page_id = $property_table_nickname.subject_id ";
			}
		}
		foreach ($applied_filters as $i => $af) {
			if ($af->filter->is_relation) {
				$sql .= "LEFT OUTER JOIN $smw_relations r$i
	ON p.page_id = r$i.subject_id ";
			} else {
				$sql .= "JOIN $smw_attributes a$i
	ON p.page_id = a$i.subject_id ";
			}
		}
		if ($subcategory)
			$actual_cat = str_replace(' ', '_', $subcategory);
		else
			$actual_cat = str_replace(' ', '_', $category);
		$actual_cat = str_replace("'", "\'", $actual_cat);
		$sql .= "WHERE (c.cl_to = '$actual_cat' ";
		foreach ($subcategories as $i => $subcat) {
			$subcat = str_replace("'", "\'", $subcat);
			$sql .= "OR c.cl_to = '{$subcat}' ";
		}
		$sql .= ") ";
		foreach ($applied_filters as $i => $af) {
			if ($af->filter->is_relation) {
				$property_field = "r$i.relation_title";
				$value_field = "r$i.object_title";
			} else {
				$property_field = "a$i.attribute_title";
				$value_field = "a$i.value_xsd";
			}
			$property_value = str_replace(' ', '_', $af->filter->property);
			$sql .= "AND $property_field = '$property_value' AND ";
			$sql .= $af->checkSQL($value_field);
		}
		return $sql;
	}

	function getSQLFromClause_2($category, $subcategory, $subcategories, $applied_filters) {
		$dbr = wfGetDB( DB_SLAVE );
		$smw_ids = $dbr->tableName( 'smw_ids' );
		$smw_insts = $dbr->tableName( 'smw_inst2' );
		$smw_rels = $dbr->tableName( 'smw_rels2' );
		$smw_atts = $dbr->tableName( 'smw_atts2' );
		$cat_ns = NS_CATEGORY;
		$prop_ns = SMW_NS_PROPERTY;

		$sql = "FROM $smw_ids ids
	JOIN $smw_insts insts
	ON ids.smw_id = insts.s_id
	AND ids.smw_namespace != $cat_ns ";
		foreach ($applied_filters as $i => $af) {
			// if any of this filter's values is 'none',
			// include another table to get this information
			$includes_none = false;
			foreach ($af->values as $fv) {
				if ($fv->text === '_none' || $fv->text === ' none') {
					$includes_none = true;
					break;
				}
			}
			if ($includes_none) {
				if ($af->filter->is_relation) {
					$property_table_name = $smw_rels;
					$property_table_nickname = "nr$i";
					$property_field = 'p_id';
				} else {
					$property_table_name = $smw_atts;
					$property_table_nickname = "na$i";
					$property_field = 'p_id';
				}
				$property_value = str_replace(' ', '_', $af->filter->property);
				$property_value = str_replace("'", "\'", $property_value);
				$sql .= "LEFT OUTER JOIN
	(SELECT s_id
	FROM $property_table_name
	WHERE $property_field = (SELECT smw_id FROM $smw_ids WHERE smw_title = '$property_value' AND smw_namespace = $prop_ns)) $property_table_nickname
	ON ids.smw_id = $property_table_nickname.s_id ";
			}
		}
		foreach ($applied_filters as $i => $af) {
			$sql .= "\n	";
			if ($af->filter->is_relation) {
				if ($includes_none) {
					$sql .= "LEFT OUTER ";
				}
				$sql .= "JOIN $smw_rels r$i ON ids.smw_id = r$i.s_id\n	";
				if ($includes_none) {
					$sql .= "LEFT OUTER ";
				}
				$sql .= "JOIN $smw_ids o_ids$i ON r$i.o_id = o_ids$i.smw_id ";
			} else {
				$sql .= "JOIN $smw_atts a$i ON ids.smw_id = a$i.s_id ";
			}
		}
		if ($subcategory)
			$actual_cat = str_replace(' ', '_', $subcategory);
		else
			$actual_cat = str_replace(' ', '_', $category);
		$actual_cat = str_replace("'", "\'", $actual_cat);
		$sql .= "WHERE insts.o_id IN
	(SELECT smw_id FROM $smw_ids cat_ids
	WHERE smw_namespace = $cat_ns AND (smw_title = '$actual_cat'";
		foreach ($subcategories as $i => $subcat) {
			$subcat = str_replace("'", "\'", $subcat);
			$sql .= " OR smw_title = '{$subcat}'";
		}
		$sql .= ")) ";
		foreach ($applied_filters as $i => $af) {
			$property_value = str_replace(' ', '_', $af->filter->property);
			if ($af->filter->is_relation) {
				$property_field = "r$i.p_id";
				$sql .= "\n	AND ($property_field = (SELECT smw_id FROM $smw_ids WHERE smw_title = '$property_value' AND smw_namespace = $prop_ns)";
				if ($includes_none) {
					$sql .= " OR $property_field IS NULL";
				}
				$sql .= ")\n	AND ";
				$value_field = "o_ids$i.smw_title";
			} else {
				$property_field = "a$i.p_id";
				$sql .= "\n	AND $property_field = (SELECT smw_id FROM $smw_ids WHERE smw_title = '$property_value' AND smw_namespace = $prop_ns) AND ";
				$value_field = "a$i.value_xsd";
			}
			$sql .= $af->checkSQL($value_field);
		}
		return $sql;
	}

	/**
	 * Gets the number of pages matching both the currently-selected
	 * set of filters and either a new subcategory or a new filter.
	 */
	function getNumResults($subcategory, $subcategories, $new_filter = null) {
		$dbr = wfGetDB( DB_SLAVE );
		$sql = "SELECT COUNT(*) ";
		if ($new_filter)
			$sql .= $this->getSQLFromClauseForField($new_filter);
		else
			$sql .= $this->getSQLFromClauseForCategory($subcategory, $subcategories);
		$res = $dbr->query($sql);
		$row = $dbr->fetchRow($res);
		$dbr->freeResult($res);
		return $row[0];
	}

	function getName() {
		return "BrowseData";
	}

	function isExpensive() { return false; }

	function isSyndicated() { return false; }

	function printCategoriesList($categories) {
		$choose_category_text = wfMsg('sd_browsedata_choosecategory');
		$text =<<<END

				<div class="drilldown-categories-wrapper">
					<div class="drilldown-categories">
						<div class="drilldown-categories-header">$choose_category_text:</div>

END;
		foreach ($categories as $i => $category) {
			$category_children = SDUtils::getCategoryChildren($category, false, 5);
			$category_str = $category . " (" . count($category_children) . ")";
			if (str_replace('_', ' ', $this->category) == $category) {
				$text .= '						<div class="drilldown-category selected-category">';
				$text .= $category_str;
			} else {
				$text .= '						<div class="drilldown-category">';
				$category_url = $this->makeBrowseURL($category);
				$text .= "<a href=\"$category_url\" title=\"$choose_category_text\">$category_str</a>";
			}
			$text .= "</div>\n";
		}
		$text .=<<<END
					</div>
				</div>

END;
		return $text;
	}

	function printFilterLabel($filter_name) {
		$labels_for_filter = SDUtils::getValuesForProperty($filter_name, SD_NS_FILTER, '_SD_L', SD_SP_HAS_LABEL, NS_MAIN);
		if (count($labels_for_filter) > 0) {
			$filter_label = $labels_for_filter[0];
		} else {
			$filter_label = str_replace('_', ' ', $filter_name);
		}
		return $filter_label;
	}

	/**
	 * Print the line showing 'OR' values for a filter that already has
	 * at least one value set
	 */
	function printAppliedFilterLine($af) {
		global $sdgScriptPath;

		$results_line = "";
		$filter_label = $this->printFilterLabel($af->filter->name);
		foreach ($this->applied_filters as $af2) {
			if ($af->filter->name == $af2->filter->name)
				$current_filter_values = $af2->values;
		}
		if ($af->filter->allowed_values != null)
			$or_values = $af->filter->allowed_values;
		else
			$or_values = $af->getAllOrValues($this->category);
		if ($af->search_term != null) {
			// HACK - printFreeTextInput() needs values as the
			// *keys* of the array
			$filter_values = array();
			foreach ($or_values as $or_value) {
				$filter_values[$or_value] = '';
			}
			$results_line = "<div class=\"drilldown-filter-label\">$filter_label:</div> " . $this->printFreeTextInput($af->filter->name, $filter_values, $af->search_term);
			return $results_line;
		} elseif ($af->lower_date != null || $af->upper_date != null) {
			$results_line = "<div class=\"drilldown-filter-label\">$filter_label:</div> " . $this->printDateRangeInput($af->filter->name, $af->lower_date, $af->upper_date);
			return $results_line;
		}
		// add 'Other' and 'None', regardless of whether either has
		// any results - add 'Other' only if it's not a date field
		if ($af->filter->time_period == null)
			$or_values[] = '_other';
		$or_values[] = '_none';
		foreach ($or_values as $i => $value) {
			if ($i > 0) { $results_line .= " &middot; "; }
			$value = str_replace('_', ' ', $value);
			// if it's boolean, display something nicer than "0" or "1"
			if ($value === ' other')
				$filter_text = wfMsg('sd_browsedata_other');
			elseif ($value === ' none')
				$filter_text = wfMsg('sd_browsedata_none');
			elseif ($af->filter->is_boolean)
				$filter_text = SDUtils::booleanToString($value);
			else
				$filter_text = $value;
			$applied_filters = $this->applied_filters;
			foreach ($applied_filters as $af2) {
				if ($af->filter->name == $af2->filter->name) {
					$or_fv = SDFilterValue::create($value, $af->filter->time_period);
					$af2->values = array_merge($current_filter_values, array($or_fv));
				}
			}
			// show the list of OR values, only linking
			// the ones that haven't been used yet
			$found_match = false;
			foreach ($current_filter_values as $fv) {
				if ($value == $fv->text) {
					$found_match = true;
					break;
				}
			}
			if ($found_match) {
				$results_line .= "\n				$filter_text";
			} else {
				$filter_url = $this->makeBrowseURL($this->category, $applied_filters, $this->subcategory);
				$results_line .= "\n						" . '<a href="' . $filter_url . '" title="' . wfMsg('sd_browsedata_filterbyvalue') . '">' . $filter_text . '</a>';
			}
			foreach ($applied_filters as $af2) {
				if ($af->filter->name == $af2->filter->name) {
					$af2->values = $current_filter_values;
				}
			}
		}
		$add_another_str = wfMsg('sd_browsedata_addanothervalue');
		$results_div_id = strtolower(str_replace(' ', '_', $filter_label)) . "_values";
		$text =<<<END
					<div class="drilldown-filter-label">
						<a onclick="toggleFilterDiv('$results_div_id', this)" style="cursor: default;"><img src="$sdgScriptPath/skins/right-arrow.png"></a>
						$filter_label: <span class="drilldown-filter-notes">($add_another_str)</span>
					</div>
					<div class="drilldown-filter-values" id="$results_div_id" style="display: none;">$results_line
					</div>

END;
		return $text;
	}

	function printUnappliedFilterValues($cur_url, $f, $filter_values) {
		global $sdgFiltersSmallestFontSize, $sdgFiltersLargestFontSize;

		$results_line = "";
		// set font-size values for filter "tag cloud", if the
		// appropriate global variables are set
		if ($sdgFiltersSmallestFontSize > 0 && $sdgFiltersLargestFontSize > 0) {
			$lowest_num_results = min($filter_values);
			$highest_num_results = max($filter_values);
			$num_results_midpoint = ($lowest_num_results + $highest_num_results) / 2;
			$font_size_midpoint = ($sdgFiltersSmallestFontSize + $sdgFiltersLargestFontSize) / 2;
			$num_results_per_font_pixel = ($highest_num_results + 1 - $lowest_num_results) / ($sdgFiltersLargestFontSize + 1 - $sdgFiltersSmallestFontSize);
		}
		// now print the values
		$num_printed_values = 0;
		foreach ($filter_values as $value_str => $num_results) {
			if ($num_printed_values++ > 0) { $results_line .= " &middot; "; }
			// if it's boolean, display something nicer than "0" or "1"
			if ($value_str === '_other')
				$filter_text = wfMsg('sd_browsedata_other');
			elseif ($value_str === '_none')
				$filter_text = wfMsg('sd_browsedata_none');
			elseif ($f->is_boolean)
				$filter_text = SDUtils::booleanToString($value_str);
			else
				$filter_text = str_replace('_', ' ', $value_str);
			$filter_text .= " ($num_results)";
			$filter_url = $cur_url . urlencode(str_replace(' ', '_', $f->name)) . '=' . urlencode(str_replace(' ', '_', $value_str));
			if ($sdgFiltersSmallestFontSize > 0 && $sdgFiltersLargestFontSize > 0) {
				$font_size = round($font_size_midpoint + (($num_results - $num_results_midpoint) / $num_results_per_font_pixel));
				$results_line .= "\n						" . '<a href="' . $filter_url . '" title="' . wfMsg('sd_browsedata_filterbyvalue') . '" style="font-size: ' . $font_size . 'px">' . $filter_text . '</a>';
			} else {
				$results_line .= "\n						" . '<a href="' . $filter_url . '" title="' . wfMsg('sd_browsedata_filterbyvalue') . '">' . $filter_text . '</a>';
			}
		}
		return $results_line;
	}

	function printFreeTextInput($filter_name, $filter_values, $cur_value = null) {
		global $wgRequest;

		$input_id = "_search_$filter_name";
		$text =<<<END

<script>
Ext.onReady(function(){
	var {$filter_name}_values = [

END;
		foreach ($filter_values as $value => $num_instances) {
			if ($value != '_other' && $value != '_none') {
				$display_value = str_replace('_', ' ', $value);
				$display_value = str_replace('\'', '\\\'', $display_value);
				$text .= "		['$display_value', '$display_value'],\n";
			}
		}
		$text .=<<<END
	]

	var comboFromArray = new Ext.form.ComboBox({
		store: {$filter_name}_values,
		emptyText: '$cur_value',
		applyTo: '$input_id'
	});
});
</script>
<form method="get">
<input type="text" name="$input_id" id="$input_id" value="">

END;

		foreach ($wgRequest->getValues() as $key => $val) {
			if ($key != $input_id)
				$text .=<<<END
<input type="hidden" name="$key" value="$val" />

END;
		}
		$search_label = wfMsg('searchresultshead');
		$text .=<<<END
<input type="submit" value="$search_label" />
</form>

END;
		return $text;
	}

	function printDateInput($input_name, $cur_value = null) {
		global $wgAmericanDates;

		$month_names = array(
			wfMsgForContent('january'),
			wfMsgForContent('february'),
			wfMsgForContent('march'),
			wfMsgForContent('april'),
			wfMsgForContent('may'),
			wfMsgForContent('june'),
			wfMsgForContent('july'),
			wfMsgForContent('august'),
			wfMsgForContent('september'),
			wfMsgForContent('october'),
			wfMsgForContent('november'),
			wfMsgForContent('december')
		);

		if (is_array($cur_value) && array_key_exists('month', $cur_value))
			$selected_month = $cur_value['month'];
		else
			$selected_month = null;
		$text = '   <select name="' . $input_name . "[month]\">\n";
		foreach ($month_names as $i => $name) {
			// pad out month to always be two digits
			$month_value = ($wgAmericanDates == true) ? $name : str_pad($i + 1, 2, "0", STR_PAD_LEFT);
			$selected_str = ($i + 1 == $selected_month) ? "selected" : "";
			$text .= "        <option value=\"$month_value\" $selected_str>$name</option>\n";
		}
		$text .= "  </select>\n";
		$text .= '  <input name="' . $input_name . '[day]" type="text" size="2" value="' . $cur_value['day'] . '" />' . "\n";
		$text .= '  <input name="' . $input_name . '[year]" type="text" size="4" value="' . $cur_value['year'] . '" />' . "\n";
		return $text;
	}

	function printDateRangeInput($filter_name, $lower_date = null, $upper_date = null) {
		global $wgRequest;

		$start_label = wfMsg('sd_browsedata_daterangestart');
		$end_label = wfMsg('sd_browsedata_daterangeend');
		$start_month_input = $this->printDateInput("_lower_$filter_name", $lower_date);
		$end_month_input = $this->printDateInput("_upper_$filter_name", $upper_date);
		$text =<<<END
<form method="get">
<p>$start_label $start_month_input
$end_label $end_month_input</p>

END;
		foreach ($wgRequest->getValues() as $key => $val) {
			$text .=<<<END
<input type="hidden" name="$key" value="$val" />

END;
		}
		$search_label = wfMsg('searchresultshead');
		$text .=<<<END
<p><input type="submit" value="$search_label" /></p>
</form>

END;
		return $text;
	}

	/**
	 * Print the line showing 'AND' values for a filter that has not
	 * been applied to the drilldown
	 */
	function printUnappliedFilterLine($f, $cur_url) {
		global $sdgScriptPath;
		global $sdgFiltersSmallestFontSize, $sdgFiltersLargestFontSize;

		$f->createTempTable();
		$found_results_for_filter = false;
		if (count($f->allowed_values) == 0) {
			$filter_values = $f->getAllValues();
			if (count($filter_values) > 0)
				$found_results_for_filter = true;
		} else {
			$filter_values = array();
			foreach ($f->allowed_values as $value) {
				$new_filter = SDAppliedFilter::create($f, $value);
				$num_results = $this->getNumResults($this->subcategory, $this->all_subcategories, $new_filter);
				if ($num_results > 0) {
					$filter_values[$value] = $num_results;
				}
			}
		}
		// now get values for 'Other' and 'None', as well
		// - don't show 'Other' if filter values were
		// obtained dynamically
		if (count($f->allowed_values) > 0) {
			$other_filter = SDAppliedFilter::create($f, ' other');
			$num_results = $this->getNumResults($this->subcategory, $this->all_subcategories, $other_filter);
			if ($num_results > 0) {
				$filter_values['_other'] = $num_results;
			}
		}
		// show 'None' only if any other results have been found
		if (count($f->allowed_values) > 0) {
			$none_filter = SDAppliedFilter::create($f, ' none');
			$num_results = $this->getNumResults($this->subcategory, $this->all_subcategories, $none_filter);
			if ($num_results > 0) {
				$filter_values['_none'] = $num_results;
			}
		}
		// escape here if there are no values
		if (count($filter_values) == 0) {
			$f->dropTempTable();
			return "";
		}

		$filter_name = urlencode(str_replace(' ', '_', $f->name));
		$normal_filter = true;
		if ($f->input_type == wfMsgForContent('sd_filter_freetext')) {
			$results_line = $this->printFreeTextInput($filter_name, $filter_values);
			$normal_filter = false;
		} elseif ($f->input_type == wfMsgForContent('sd_filter_daterange')) {
			$results_line = $this->printDateRangeInput($filter_name);
			$normal_filter = false;
		} else
			$results_line = $this->printUnappliedFilterValues($cur_url, $f, $filter_values);

		$text = "";
		// TODO - this check might no longer be necessary
		if ($results_line != "") {
			$filter_label = $this->printFilterLabel($f->name);
			$results_div_id = strtolower(str_replace(' ', '_', $filter_label)) . "_values";
			$text .=<<<END
					<div class="drilldown-filter-label">

END;
			// no point showing "minimize" arrow if it's just a
			// single text or date input
			if ($normal_filter) {
				$text .=<<<END
					<a onclick="toggleFilterDiv('$results_div_id', this)" style="cursor: default;"><img src="$sdgScriptPath/skins/down-arrow.png"></a>

END;
			}
			$text .=<<<END
					$filter_label:
					</div>
					<div class="drilldown-filter-values" id="$results_div_id">$results_line
					</div>

END;
		}
		$f->dropTempTable();
		return $text;
	}

	function getPageHeader() {
		global $wgUser, $wgRequest;
		global $sdgContLang, $sdgScriptPath;
		global $sdgFiltersSmallestFontSize, $sdgFiltersLargestFontSize;

		$skin = $wgUser->getSkin();
		$browse_data_title = Title::newFromText('BrowseData', NS_SPECIAL);
		$categories = SDUtils::getTopLevelCategories();
		// if there are no categories, escape quickly
		if (count($categories) == 0) {
			return "";
		}
		$subcategory_text = wfMsg('sd_browsedata_subcategory');

		$header = "";
		$this->show_single_cat = $wgRequest->getCheck('_single');
		if (! $this->show_single_cat) {
			$header .= $this->printCategoriesList($categories);
		}
		// if there are no subcategories or filters for this
		// category, escape now that we've (possibly) printed the
		// categories list
		if ((count($this->next_level_subcategories) == 0) &&
		    (count($this->applied_filters) == 0) &&
		    (count($this->remaining_filters) == 0)) {
			return $header;
		}
		$header .= '				<div class="drilldown-header">' . "\n";
		if (count ($this->applied_filters) > 0 || $this->subcategory) {
			$category_url = $this->makeBrowseURL($this->category);
			$header .= '<a href="' . $category_url . '" title="' . wfMsg('sd_browsedata_resetfilters') . '">' . str_replace('_', ' ', $this->category) . '</a>';
		} else
			$header .= str_replace('_', ' ', $this->category);
		if ($this->subcategory) {
			$header .= " > ";
			$header .= "$subcategory_text: ";
			$subcat_string = str_replace('_', ' ', $this->subcategory);
			$remove_filter_url = $this->makeBrowseURL($this->category, $this->applied_filters);
			$header .= "\n" . '				<span class="drilldown-header-value">' . $subcat_string . '</span> <a href="' . $remove_filter_url . '" title="' . wfMsg('sd_browsedata_removesubcategoryfilter') . '"><img src="' . $sdgScriptPath . '/skins/filter-x.png" /></a>';
		}
		foreach ($this->applied_filters as $i => $af) {
			$header .= (! $this->subcategory && $i == 0) ? " > " : "\n					<span class=\"drilldown-header-value\">&</span> ";
			$filter_label = $this->printFilterLabel($af->filter->name);
			// add an "x" to remove this filter, if it has more
			// than one value
			if (count($this->applied_filters[$i]->values) > 1) {
				$temp_filters_array = $this->applied_filters;
				array_splice($temp_filters_array, $i, 1);
				$remove_filter_url = $this->makeBrowseURL($this->category, $temp_filters_array, $this->subcategory);
				array_splice($temp_filters_array, $i, 0);
				$header .= $filter_label . ' <a href="' . $remove_filter_url . '" title="' . wfMsg('sd_browsedata_removefilter') . '"><img src="' . $sdgScriptPath . '/skins/filter-x.png" /></a> : ';
			} else {
				$header .= "$filter_label: ";
			}
			foreach ($af->values as $j => $fv) {
				if ($j > 0) {$header .= ' <span class="drilldown-or">' . wfMsg('sd_browsedata_or') . '</span> ';}
				if ($fv->text == ' other')
					$filter_text = wfMsg('sd_browsedata_other');
				elseif ($fv->text == ' none')
					$filter_text = wfMsg('sd_browsedata_none');
				elseif ($af->filter->is_boolean)
					$filter_text = SDUtils::booleanToString($fv->text);
				else
					$filter_text = $fv->text;
				$temp_filters_array = $this->applied_filters;
				$removed_values = array_splice($temp_filters_array[$i]->values, $j, 1);
				$remove_filter_url = $this->makeBrowseURL($this->category, $temp_filters_array, $this->subcategory);
				array_splice($temp_filters_array[$i]->values, $j, 0, $removed_values);
				$header .= "\n	" . '				<span class="drilldown-header-value">' . $filter_text . '</span> <a href="' . $remove_filter_url . '" title="' . wfMsg('sd_browsedata_removefilter') . '"><img src="' . $sdgScriptPath . '/skins/filter-x.png" /></a>';
			}
			if ($af->search_term != null) {
				$temp_filters_array = $this->applied_filters;
				$removed_search_term = $temp_filters_array[$i]->search_term;
				$temp_filters_array[$i]->search_term = null;
				$remove_filter_url = $this->makeBrowseURL($this->category, $temp_filters_array, $this->subcategory);
				$temp_filters_array[$i]->search_term = $removed_search_term;
				$header .= "\n  " . '                           <span class="drilldown-header-value">~ \'' . $af->search_term . '\'</span> <a href="' . $remove_filter_url . '" title="' . wfMsg('sd_browsedata_removefilter') . '"><img src="' . $sdgScriptPath . '/skins/filter-x.png" /></a>';
			} elseif ($af->lower_date != null || $af->upper_date != null) {
				$header .= "\n <span class=\"drilldown-header-value\">" . $af->lower_date_string . " - " . $af->upper_date_string . "</span>";
			}
		}
		$header .= "</div>\n";
		$drilldown_description = wfMsg('sd_browsedata_docu');
		$header .= "				<p>$drilldown_description</p>\n";
		// display the list of subcategories on one line, and below
		// it every filter, each on its own line; each line will
		// contain the possible values, and, in parentheses, the
		// number of pages that match that value
		$header .= "				<div class=\"drilldown-filters\">\n";
		$cur_url = $this->makeBrowseURL($this->category, $this->applied_filters, $this->subcategory);
		$cur_url .= (strpos($cur_url, '?')) ? '&' : '?';
		$this->createTempTable($this->category, $this->subcategory, $this->all_subcategories, $this->applied_filters);
		$num_printed_values = 0;
		if (count($this->next_level_subcategories) > 0) {
			$results_line = "";
			// loop through to create an array of subcategory
			// names and their number of values, then loop through
			// the array to print them - we loop through twice,
			// instead of once, to be able to print a tag-cloud
			// display if necessary
			$subcat_values = array();
			foreach ($this->next_level_subcategories as $i => $subcat) {
				$further_subcats = SDUtils::getCategoryChildren($subcat, true, 10);
				$num_results = $this->getNumResults($subcat, $further_subcats);
				$subcat_values[$subcat] = $num_results;
			}
			// get necessary values for creating the tag cloud,
			// if appropriate
			if ($sdgFiltersSmallestFontSize > 0 && $sdgFiltersLargestFontSize > 0) {
				$lowest_num_results = min($subcat_values);
				$highest_num_results = max($subcat_values);
				$num_results_midpoint = ($lowest_num_results + $highest_num_results) / 2;
				$font_size_midpoint = ($sdgFiltersSmallestFontSize + $sdgFiltersLargestFontSize) / 2;
				$num_results_per_font_pixel = ($highest_num_results + 1 - $lowest_num_results) / 						($sdgFiltersLargestFontSize + 1 - $sdgFiltersSmallestFontSize);
			}

			foreach ($subcat_values as $subcat => $num_results) {
				if ($num_results > 0) {
					if ($num_printed_values++ > 0) { $results_line .= " &middot; "; }
					$filter_text = str_replace('_', ' ', $subcat) . " ($num_results)";
					$filter_url = $cur_url . '_subcat=' . urlencode($subcat);
					if ($sdgFiltersSmallestFontSize > 0 && $sdgFiltersLargestFontSize > 0) {
						$font_size = round($font_size_midpoint + (($num_results - $num_results_midpoint) / $num_results_per_font_pixel));
						$results_line .= "\n					" . '<a href="' . $filter_url . '" title="' . wfMsg('sd_browsedata_filterbysubcategory') . '" style="font-size: ' . $font_size . 'px">' . $filter_text . '</a>';
					} else {
						$results_line .= "\n					" . '<a href="' . $filter_url . '" title="' . wfMsg('sd_browsedata_filterbysubcategory') . '">' . $filter_text . '</a>';
					}
				}
			}
			if ($results_line != "") {
				$header .= "					<p><strong>$subcategory_text:</strong> $results_line</p>\n";
			}
		}
		$filters = SDUtils::loadFiltersForCategory($this->category);
		foreach ($filters as $f) {
			foreach ($this->applied_filters as $af) {
				if ($af->filter->name == $f->name)
					$header .= $this->printAppliedFilterLine($af);
			}
			foreach ($this->remaining_filters as $rf) {
				if ($rf->name == $f->name)
					$header .= $this->printUnappliedFilterLine($rf, $cur_url);
			}
		}
		$header .= "				</div> <!-- drilldown-filters -->\n";
		return $header;
	}

	/*
	 * Used to set URL for additional pages of results
	 */
	function linkParameters() {
		$params = array();
		if ($this->show_single_cat)
			$params['_single'] = NULL;
		$params['_cat'] = $this->category;
		if ($this->subcategory)
			$params['_subcat'] = $this->subcategory;
		foreach ($this->applied_filters as $i => $af) {
			if (count($af->values) == 1) {
				$key_string = str_replace(' ', '_', $af->filter->name);
				$value_string = str_replace(' ', '_', $af->values[0]->text);
				$params[$key_string] = $value_string;
			} else {
				// HACK - QueryPage's pagination-URL code,
				// which uses wfArrayToCGI(), doesn't support
				// two-dimensional arrays, which is what we
				// need - instead, add the brackets directly
				// to the key string
				foreach ($af->values as $i => $value) {
					$key_string = str_replace(' ', '_', $af->filter->name . "[$i]");
					$value_string = str_replace(' ', '_', $value->text);
					$params[$key_string] = $value_string;
				}
			}
		}
		return $params;
	}

	function getSQL() {
		// QueryPage uses the value from this SQL in an ORDER clause,
		// so return page_title as title.
		global $smwgDefaultStore;
		if ($smwgDefaultStore == 'SMWSQLStore2') {
			$sql = "SELECT DISTINCT ids.smw_title AS title,
	ids.smw_title AS value,
	ids.smw_namespace AS namespace,
	ids.smw_sortkey AS sortkey\n";
		} else {
			$sql = "SELECT DISTINCT p.page_title AS title,
	p.page_title AS value,
	p.page_namespace AS namespace,
	c.cl_sortkey AS sortkey\n";
		}
		$sql .= $this->getSQLFromClause($this->category, $this->subcategory, $this->all_subcategories, $this->applied_filters);
		return $sql;
	}

	function getOrder() {
		return ' ORDER BY sortkey ';
	}

	function formatResult($skin, $result) {
		$title = Title::makeTitle( $result->namespace, $result->value );
		return $skin->makeLinkObj( $title, $title->getText() );
	}

	/**
	 * Format and output report results using the given information plus
	 * OutputPage
	 *
	 * @param OutputPage $out OutputPage to print to
	 * @param Skin $skin User skin to use
	 * @param Database $dbr Database (read) connection to use
	 * @param int $res Result pointer
	 * @param int $num Number of available result rows
	 * @param int $offset Paging offset
	 */
	protected function outputResults( $out, $skin, $dbr, $res, $num, $offset ) {
		global $wgContLang, $sdgNumResultsColumns;

		if( $num > 0 ) {
			$html = array();
			if( !$this->listoutput )
				$html[] = $this->openList( $offset );

			$prev_first_char = "";
			// default to 3 columns, like with categories
			if ($sdgNumResultsColumns == null)
				$sdgNumResultsColumns = 3;
			$rows_per_column = ceil($num / $sdgNumResultsColumns);
			// column width is a percentage
			$column_width = floor(100 / $sdgNumResultsColumns);
			// code borrowed heavily from QueryPage.php
			for ($i = 0; $i < $num && $row = $dbr->fetchObject( $res ); $i++) {
				$line = $this->formatResult( $skin, $row );
				if ($line) {
					$cur_first_char = $row->sortkey{0};
					if ($i % $rows_per_column == 0) {
						$html[] = "\n			<div style=\"float: left; width: $column_width%;\">\n";
						if ($cur_first_char == $prev_first_char)
							$html[] = "				<h3>$cur_first_char " . wfMsg('listingcontinuesabbrev') . "</h3>\n				<ul>\n";
					}
					// if we're at a new first letter, end
					// the last list and start a new one
					if ($cur_first_char != $prev_first_char) {
						if ($i % $rows_per_column > 0)
							$html[] = "				</ul>\n";
						$html[] = "				<h3>$cur_first_char</h3>\n				<ul>\n";
					}
					$prev_first_char = $cur_first_char;
					$html[] = "					<li>$line</li>\n";
				}
				// end list if we're at the end of the column
				// or the page
				if (($i + 1) % $rows_per_column == 0 || ($i + 1) == $num)
					$html[] = "				</ul>\n			</div> <!-- end column -->";
			}

			# Flush the final result
			if( $this->tryLastResult() ) {
				$row = null;
				$line = $this->formatResult( $skin, $row );
				if( $line ) {
					$html[] = "				<li>$line</li>\n";
				}
			}
		}

		if( !$this->listoutput )
			$html[] = $this->closeList();

		$html = $this->listoutput
			? $wgContLang->listToText( $html )
			: implode( '', $html );

		$out->addHTML( $html );
	}

	function openList( $offset ) {
	}

	function closeList() {
		return "\n			<br style=\"clear: both\" />\n";
	}
}

function doSpecialBrowseData($query) {
	global $wgRequest, $wgOut, $sdgScriptPath, $sdgContLang, $sdgNumResultsPerPage;
	$mainCssDir = $sdgScriptPath . '/skins/';
	$wgOut->addLink( array(
		'rel' => 'stylesheet',
		'type' => 'text/css',
		'media' => "screen, projection",
		'href' => $mainCssDir . 'SD_main.css'
	));
	$wgOut->addLink( array(
		'rel' => 'stylesheet',
		'type' => 'text/css',
		'media' => "screen, projection",
		'href' => $mainCssDir . 'ext-all.css'
	));
	$wgOut->addLink( array(
		'rel' => 'stylesheet',
		'type' => 'text/css',
		'media' => "screen, projection",
		'href' => $mainCssDir . 'xtheme-gray.css'
	));
	$wgOut->addLink( array(
		'rel' => 'stylesheet',
		'type' => 'text/css',
		'media' => "screen, projection",
		'href' => $mainCssDir . 'combos.css'
	));
	// overwrite style from ext-all.css, to set the correct image for
	// the combobox arrow
	$wgOut->addScript("<style>.x-form-field-wrap .x-form-trigger{background:transparent url($sdgScriptPath/skins/trigger.gif) no-repeat 0 0;}</style>\n");
	$wgOut->addScript('<script type="text/javascript" src="' . $sdgScriptPath . '/libs/ext-base.js"></script>' . "\n");
	$wgOut->addScript('<script type="text/javascript" src="' . $sdgScriptPath . '/libs/ext-all.js"></script>' . "\n");
	$javascript_text =<<<END
function toggleFilterDiv(element_id, label_element) {
	element = document.getElementById(element_id);
	if (element.style.display == "none") {
		element.style.display = "block";
		label_element.innerHTML = "<img src=\"$sdgScriptPath/skins/down-arrow.png\">";
	} else {
		element.style.display = "none";
		label_element.innerHTML = "<img src=\"$sdgScriptPath/skins/right-arrow.png\">";
	}
}

function highlightRemoveDiv(element) {
	element.innerHTML = "<img src=\"$sdgScriptPath/skins/filter-x-active.png\">";
}
function unhighlightRemoveDiv(element) {
	element.innerHTML = "<img src=\"$sdgScriptPath/skins/filter-x.png\">";
}

END;
	$wgOut->addScript('	     <script type="text/javascript">' . "\n" . $javascript_text . '</script>' . "\n");

	// set default
	if ($sdgNumResultsPerPage == null)
		$sdgNumResultsPerPage = 250;
	list( $limit, $offset ) = wfCheckLimits($sdgNumResultsPerPage, 'sdlimit');
	$filters = array();

	// get information on current category, subcategory and filters that
	// have already been applied from the query string
	$category = str_replace('_', ' ', $wgRequest->getVal('_cat'));
	// if query string did not contain this variables, try the URL
	if (! $category) {
		$queryparts = explode('/', $query, 1);
		$category = isset($queryparts[0]) ? $queryparts[0] : '';
	}
	if (! $category) {
		$category_title = wfMsg('browsedata');
	} else {
		$titles_for_category = SDUtils::getValuesForProperty($category, NS_CATEGORY, '_SD_DT', SD_SP_HAS_DRILLDOWN_TITLE, NS_MAIN);
		if (count($titles_for_category) > 0) {
			$category_title = str_replace('_', ' ', $titles_for_category[0]);
		} else {
			$category_title = wfMsg( 'browsedata' ) . html_entity_decode( wfMsg( 'colon-separator' ) ) . str_replace( '_', ' ', $category );
		}
	}
	// if no category was specified, go with the first
	// category on the site, alphabetically
	if (! $category) {
		$categories = SDUtils::getTopLevelCategories();
		if (count($categories) > 0) {
			$category = $categories[0];
		}
	}

	$wgOut->setPageTitle($category_title);
	$subcategory = $wgRequest->getVal('_subcat');

	$filters = SDUtils::loadFiltersForCategory($category);

	$filters_used = array();
	foreach ($filters as $i => $filter)
		$filter_used[] = false;
	$applied_filters = array();
	$remaining_filters = array();
	foreach ($filters as $i => $filter) {
		$filter_name = str_replace(' ', '_', $filter->name);
		$search_term = $wgRequest->getVal('_search_' . $filter_name);
		$lower_date = $wgRequest->getArray('_lower_' . $filter_name);
		$upper_date = $wgRequest->getArray('_upper_' . $filter_name);
		if ($vals_array = $wgRequest->getArray($filter_name)) {
			foreach ($vals_array as $j => $val) {
				$vals_array[$j] = str_replace('_', ' ', $val);
			}
			$applied_filters[] = SDAppliedFilter::create($filter, $vals_array);
			$filter_used[$i] = true;
		} elseif ($search_term != null) {
			$applied_filters[] = SDAppliedFilter::create($filter, array(), $search_term);
			$filter_used[$i] = true;
		} elseif ($lower_date != null || $upper_date != null) {
			$applied_filters[] = SDAppliedFilter::create($filter, array(), null, $lower_date, $upper_date);
			$filter_used[$i] = true;
		}
	}
	// add every unused filter to the $remaining_filters array, unless
	// it requires some other filter that hasn't been applied
	foreach ($filters as $i => $filter) {
		$required_filters = SDUtils::getValuesForProperty($filter->name, SD_NS_FILTER, '_SD_RF', SD_SP_REQUIRES_FILTER, SD_NS_FILTER);
		$matched_all_required_filters = true;
		foreach ($required_filters as $required_filter) {
			$found_match = false;
			foreach ($applied_filters as $af) {
				if ($af->filter->name == $required_filter) {
					$found_match = true;
				}
			}
			if (! $found_match) {
				$matched_all_required_filters = false;
				continue;
			}
		}
		if ($matched_all_required_filters) {
			if (! $filter_used[$i])
				$remaining_filters[] = $filter;
		}
	}

	$wgOut->addHTML("\n			<div class=\"drilldown-results\">\n");
	$rep = new BrowseDataPage($category, $subcategory, $applied_filters, $remaining_filters);
	$num = $rep->doQuery( $offset, $limit );
	$wgOut->addHTML("\n			</div> <!-- drilldown-results -->\n");
	return $num;
}
