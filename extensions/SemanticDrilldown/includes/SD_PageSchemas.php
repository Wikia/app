<?php
/**
 * Static functions for Semantic Drilldown, for use by the Page Schemas
 * extension.
 *
 * @author Yaron Koren
 * @author Ankit Garg
 */

class SDPageSchemas extends PSExtensionHandler {
	public static function registerClass() {
		global $wgPageSchemasHandlerClasses;
		$wgPageSchemasHandlerClasses[] = 'SDPageSchemas';
		return true;
	}

	/**
	 * Returns an object containing information on a filter, based on XML
	 * from the Page Schemas extension.
	*/
	public static function createPageSchemasObject( $tagName, $xml ) {
		$sd_array = array();
		if ( $tagName != "semanticdrilldown_Filter" ) {
			return null;
		}

		foreach ( $xml->children() as $tag => $child ) {
			if ( $tag != $tagName ) {
				continue;
			}
			$filterName = $child->attributes()->name;
			if ( !is_null( $filterName ) ) {
				$sd_array['name'] = (string)$filterName;
			}
			foreach ( $child->children() as $prop => $value) {
				if( $prop == "Values" ){
					$l_values = array();
					foreach ( $value->children() as $val ) {
						$l_values[] = (string)$val;
					}
					$sd_array['Values'] = $l_values;
				} else {
					$sd_array[$prop] = (string)$value;
				}
			}
			return $sd_array;
		}
		return null;
	}

	public static function getDisplayColor() {
		return '#FDD';
	}

	public static function getFieldDisplayString() {
		return wfMsg( 'sd-pageschemas-filter' );
	}

	/**
	 * Returns the HTML for setting the filter options, for the
	 * Semantic Drilldown section in Page Schemas' "edit schema" page
	 */
	public static function getFieldEditingHTML( $psField ){
		//$require_filter_label = wfMsg( 'sd_createfilter_requirefilter' );

		$filter_array = array();
		$hasExistingValues = false;
		if ( !is_null( $psField ) ) {
			$filter_array = $psField->getObject( 'semanticdrilldown_Filter' );
			if ( !is_null( $filter_array ) ) {
				$hasExistingValues = true;
			}
		}

		$filterName = PageSchemas::getValueFromObject( $filter_array, 'name' );
		$selectedCategory = PageSchemas::getValueFromObject( $filter_array, 'ValuesFromCategory' );
		$fromCategoryAttrs = array();
		if ( !is_null( $selectedCategory ) ) {
			$fromCategoryAttrs['checked'] = true;
		}
		$dateRangesAttrs = array();
		$year_value = wfMsgForContent( 'sd_filter_year' );
		$yearOptionAttrs = array( 'value' => $year_value );
		$month_value = wfMsgForContent( 'sd_filter_month' );
		$monthOptionAttrs = array( 'value' => $month_value );
		$filterTimePeriod = PageSchemas::getValueFromObject( $filter_array, 'TimePeriod' );
		if ( !is_null( $filterTimePeriod ) ) {
			$dateRangesAttrs['checked'] = true;
			if ( $filterTimePeriod == $year_value ) {
				$yearOptionAttrs['selected'] = true;
			} else {
				$monthOptionAttrs['selected'] = true;
			}
		}
		$manualSourceAttrs = array();
		$filterValuesAttrs = array( 'size' => 40 );
		$values_array = PageSchemas::getValueFromObject( $filter_array, 'Values' );
		if ( !is_null( $values_array ) ) {
			$manualSourceAttrs['checked'] = true;
			$filterValuesStr = implode( ', ', $values_array );
		} else {
			$filterValuesStr = '';
		}
		// Have the first radiobutton ("Use all values of this
		// property for the filter") checked if none of the other
		// options have been selected - unlike the others, there's
		// no XML to define this option.
		$usePropertyValuesAttr = array();
		if ( empty( $selectedCategory ) && empty( $filterTimePeriod ) && empty( $filterValuesStr ) ) {
			$usePropertyValuesAttr['checked'] = true;
		}

		// The "input type" field.
		$combo_box_value = wfMsgForContent( 'sd_filter_combobox' );
		$date_range_value = wfMsgForContent( 'sd_filter_daterange' );
		$valuesListAttrs = array( 'value' => '' );
		$comboBoxAttrs = array( 'value' => $combo_box_value );
		$dateRangeAttrs = array( 'value' => $date_range_value );
		$input_type_val = PageSchemas::getValueFromObject( $filter_array, 'InputType' );
		if ( $input_type_val == $combo_box_value ) {
			$comboBoxAttrs['selected'] = true;
		} elseif ( $input_type_val == $date_range_value ) {
			$dateRangeAttrs['selected'] = true;
		} else {
			$valuesListAttrs['selected'] = true;
		}

		$html_text = '<p>' . wfMsg( 'ps-optional-name' ) . ' ';
		$html_text .= Html::input( 'sd_filter_name_num', $filterName, 'text', array( 'size' => 25 ) ) . "</p>\n";
		$html_text .= '<fieldset><legend>' . wfMsg( 'sd-pageschemas-values' ) . '</legend>' . "\n";
		$html_text .= '<p>' . Html::input( 'sd_values_source_num', 'property', 'radio', $usePropertyValuesAttr ) . ' ';
		$html_text .= wfMsg( 'sd_createfilter_usepropertyvalues' ) . "</p>\n";
		$html_text .= "\t<p>\n";
		$html_text .= Html::input( 'sd_values_source_num', 'category', 'radio', $fromCategoryAttrs ) . "\n";
		$html_text .= "\t" . wfMsg( 'sd_createfilter_usecategoryvalues' ) . "\n";
		$categories = SDUtils::getTopLevelCategories();
		$categoriesHTML = "";
		foreach ( $categories as $category ) {
			$categoryOptionAttrs = array();
			$category = str_replace( '_', ' ', $category );
			if ( $category == $selectedCategory) {
				$categoryOptionAttrs['selected'] = true;
			}
			$categoriesHTML .= "\t" . Html::element( 'option', $categoryOptionAttrs, $category ) . "\n";
		}
		$html_text .= "\t" . Html::rawElement( 'select', array( 'id' => 'category_dropdown', 'name' => 'sd_category_name_num' ), "\n" . $categoriesHTML ) . "\n";
		$html_text .= "\t</p>\n";

		$html_text .= "\t<p>\n";
		$html_text .= "\t" . Html::input( 'sd_values_source_num', 'dates', 'radio', $dateRangesAttrs ) . "\n";
		$html_text .= "\t" . wfMsg( 'sd_createfilter_usedatevalues' ) . "\n";
		$dateRangeDropdown = Html::element( 'option', $yearOptionAttrs, wfMsg( 'sd_filter_year' ) ) . "\n";
		$dateRangeDropdown .= Html::element( 'option', $monthOptionAttrs, wfMsg( 'sd_filter_month' ) ) . "\n";
		$html_text .= Html::rawElement( 'select', array( 'name' => 'sd_time_period_num', 'id' => 'time_period_dropdown' ), "\n" . $dateRangeDropdown ) . "\n";
		$html_text .= "</p>\n<p>\n";
		$html_text .= "\t" . Html::input( 'sd_values_source_num', 'manual', 'radio', $manualSourceAttrs ) . "\n";
		$html_text .= "\t" . wfMsg( 'sd_createfilter_entervalues' ) . "\n";
		$html_text .= "\t" . Html::input( 'sd_filter_values_num', $filterValuesStr, 'text', $filterValuesAttrs ) . "\n";
		$html_text .= "\t</p>\n";
		$html_text .= "</fieldset>\n";

		$html_text .= '<p>' . wfMsg( 'sd_createfilter_inputtype' ) . "\n";
		$inputTypeOptionsHTML = "\t" . Html::element( 'option', $valuesListAttrs, wfMsg( 'sd_createfilter_listofvalues' ) ) . "\n";
		$inputTypeOptionsHTML .= "\t" . Html::element( 'option', $comboBoxAttrs, wfMsg( 'sd_filter_combobox' ) ) . "\n";
		$inputTypeOptionsHTML .= "\t" . Html::element( 'option', $dateRangeAttrs, wfMsg( 'sd_filter_daterange' ) ) . "\n";
		$html_text .= Html::rawElement( 'select', array( 'name' => 'sd_input_type_num', 'id' => 'input_type_dropdown' ), $inputTypeOptionsHTML ) . "\n";
		$html_text .= "</p>\n";

		return array( $html_text, $hasExistingValues );
	}

	public static function createFieldXMLFromForm() {
		global $wgRequest;

		$fieldNum = -1;
		$xmlPerField = array();
		foreach ( $wgRequest->getValues() as $var => $val ) {
			if ( substr( $var, 0, 15 ) == 'sd_filter_name_' ) {
				$xml = '<semanticdrilldown_Filter';
				$fieldNum = substr( $var, 15 );
				if ( !empty( $val ) ) {
					$xml .= ' name="' . $val . '"';
				}
				$xml .= '>';
			} elseif ( substr( $var, 0, 17 ) == 'sd_values_source_') {
				if ( $val == 'category' ) {
					$xml .= '<ValuesFromCategory>' . $wgRequest->getText('sd_category_name_' . $fieldNum) . '</ValuesFromCategory>';
				} elseif ( $val == 'dates' ) {
					 $xml .= '<TimePeriod>' . $wgRequest->getText('sd_time_period_' . $fieldNum) . '</TimePeriod>';
				} elseif ( $val == 'manual' ) {
					$filter_manual_values_str = $wgRequest->getText('sd_filter_values_' . $fieldNum);
					// replace the comma substitution character that has no chance of
					// being included in the values list - namely, the ASCII beep
					$listSeparator = ',';
					$filter_manual_values_str = str_replace( "\\$listSeparator", "\a", $filter_manual_values_str );
					$filter_manual_values_array = explode( $listSeparator, $filter_manual_values_str );
					$xml .= '<Values>';
					foreach ( $filter_manual_values_array as $i => $value ) {
						// replace beep back with comma, trim
						$value = str_replace( "\a", $listSeparator, trim( $value ) );
						$xml .= '<Value>'.$value.'</Value>';
					}
					$xml .= '</Values>';
				}
			} elseif ( substr( $var, 0, 14 ) == 'sd_input_type_' ) {
				if ( !empty( $val ) ) {
					$xml .= '<InputType>' . $val . '</InputType>';
				}
				$xml .= '</semanticdrilldown_Filter>';
				$xmlPerField[$fieldNum] = $xml;
			}
		}

		return $xmlPerField;
	}

	/**
	 * Displays the information about the filter (if any exists)
	 * for one field in the Page Schemas XML.
	 */
	public static function getFieldDisplayValues( $field_xml ) {
		foreach ( $field_xml->children() as $tag => $child ) {
			if ( $tag == "semanticdrilldown_Filter" ) {
				$filterName = $child->attributes()->name;
				$values = array();
				foreach ( $child->children() as $prop => $value) {
					if ( $prop == "Values" ) {
						$filterValues = array();
						foreach ( $value->children() as $valTag ) {
							$filterValues[] = (string)$valTag;
						}
						$valuesStr = implode( ', ', $filterValues );
						$values[wfMsg( 'sd-pageschemas-values' )] = $valuesStr;
					} else {
						$values[$prop] = $value;
					}
				}
				return array( $filterName, $values );
			}
		}
		return null;
	}
}
