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
		return wfMessage( 'sd-pageschemas-filter' )->text();
	}

	/**
	 * Returns the HTML for setting the filter options, for the
	 * Semantic Drilldown section in Page Schemas' "edit schema" page
	 */
	public static function getFieldEditingHTML( $psField ){
		//$require_filter_label = wfMessage( 'sd_createfilter_requirefilter' )->text();

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

		// Have the first radiobutton ("Use all values of this
		// property for the filter") checked if none of the other
		// options have been selected - unlike the others, there's
		// no XML to define this option.
		$usePropertyValuesAttr = array();
		if ( empty( $selectedCategory ) ) {
			$usePropertyValuesAttr['checked'] = true;
		}

		$html_text = '<div class="editSchemaMinorFields">' . "\n";
		$html_text .= '<p>' . wfMessage( 'ps-optional-name' )->text() . ' ';
		$html_text .= Html::input( 'sd_filter_name_num', $filterName, 'text', array( 'size' => 25 ) ) . "</p>\n";
		$html_text .= wfMessage( 'sd-pageschemas-values' )->text() . ":\n";
		$html_text .= Html::input( 'sd_values_source_num', 'property', 'radio', $usePropertyValuesAttr ) . ' ';
		$html_text .= wfMessage( 'sd_createfilter_usepropertyvalues' )->text() . "\n";
		$html_text .= Html::input( 'sd_values_source_num', 'category', 'radio', $fromCategoryAttrs ) . "\n";
		$html_text .= "\t" . wfMessage( 'sd_createfilter_usecategoryvalues' )->text() . "\n";
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
		$html_text .= "\t</div>\n";

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
						$values[wfMessage( 'sd-pageschemas-values' )->text()] = $valuesStr;
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
