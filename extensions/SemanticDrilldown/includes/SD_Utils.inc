<?php
/**
 * A class for static helper functions for Semantic Drilldown
 *
 * @author Yaron Koren
 */

if (!defined('MEDIAWIKI')) die();

class SDUtils {

	/**
	 * Based on Semantic Forms' SFUtils::createProperty()
	 */
	function createProperty($property_name) {
		if (method_exists('SMWPropertyValue', 'makeProperty'))
			return SMWPropertyValue::makeProperty($property_name);
		else
			return Title::newFromText($property_name, SMW_NS_PROPERTY);
	}

	/**
	 * Based on Semantic Forms' SFUtils::getPropertyName()
	 */
	function getPropertyName($property) {
		if ($property instanceof Title)
			return $property->getText();
		else // $property instanceof SMWPropertyValue
			return $property->getWikiValue();
	}

	/**
	 * Gets a list of the names of all categories in the wiki that aren't
	 * children of some other category
	 */
	function getTopLevelCategories() {
		$categories = array();
		$dbr = wfGetDB( DB_SLAVE );
		extract($dbr->tableNames('page', 'categorylinks'));
		$cat_ns = NS_CATEGORY;
		$sql = "SELECT page_title FROM $page p LEFT OUTER JOIN $categorylinks cl ON p.page_id = cl.cl_from WHERE p.page_namespace = $cat_ns AND cl.cl_to IS NULL";
		$res = $dbr->query($sql);
		if ($dbr->numRows( $res ) > 0) {
			while ($row = $dbr->fetchRow($res)) {
				$categories[] = str_replace('_', ' ', $row[0]);
			}
		}
		$dbr->freeResult($res);
		return $categories;
	}

	/**
	 * Gets a list of the names of all properties in the wiki
	 */
	function getSemanticProperties() {
		global $smwgContLang;
		$smw_namespace_labels = $smwgContLang->getNamespaces();
		$all_properties = array();

		// set limit on results - a temporary fix until SMW's getProperties()
		// functions stop requiring a limit
		global $smwgIP;
		include_once($smwgIP . '/includes/storage/SMW_Store.php');
		$options = new SMWRequestOptions();
		$options->limit = 10000;
		$used_properties = smwfGetStore()->getPropertiesSpecial($options);
		foreach ($used_properties as $property) {
			$property_name = SDUtils::getPropertyName($property[0]);
			$all_properties[$property_name] = $smw_namespace_labels[SMW_NS_PROPERTY];
		}
		$unused_properties = smwfGetStore()->getUnusedPropertiesSpecial($options);
		foreach ($unused_properties as $property) {
			$property_name = SDUtils::getPropertyName($property);
			$all_properties[$property_name] = $smw_namespace_labels[SMW_NS_PROPERTY];
		}
		// remove the special properties of Semantic Drilldown from this list...
		global $sdgContLang;
		$sd_props = $sdgContLang->getPropertyLabels();
		$sd_prop_aliases = $sdgContLang->getPropertyAliases();
		foreach (array_keys($all_properties) as $prop_name) {
			foreach ($sd_props as $prop => $label) {
				if ($prop_name == $label) {
					unset($all_properties[$prop_name]);
				}
			}
			foreach ($sd_prop_aliases as $alias => $cur_prop) {
				if ($prop_name == $alias) {
					unset($all_properties[$prop_name]);
				}
			}
		}

		// sort properties array by the key, which is the property name
		ksort($all_properties);
		return $all_properties;
	}

	/**
	 * Gets the names of all the filter pages, i.e. pages in the Filter
	 * namespace
	 */
	function getFilters() {
		$filters = array();
		$filter_ns = SD_NS_FILTER;
		$dbr = wfGetDB( DB_SLAVE );
		$page = $dbr->tableName( 'page' );
		$sql = "SELECT page_title FROM $page
			WHERE page_namespace = $filter_ns";
		$res = $dbr->query($sql);
		while ($row = $dbr->fetchRow($res)) {
			$filters[] = $row[0];
		}
		$dbr->freeResult($res);
		return $filters;
	}

	/**
	 * Generic function - gets all the values that a specific page
	 * points to with a specific property
	 * ($special_prop and $prop represent the same value, depending on
	 * whether we're using SMW 1.4 or an earlier version)
	 */
	function getValuesForProperty($subject, $subject_namespace, $special_prop, $prop, $object_namespace) {
		$store = smwfGetStore();
		$subject_title = Title::newFromText($subject, $subject_namespace);

		// we can do this easily if we're using SMW 1.4 or higher
		if (class_exists('SMWPropertyValue')) {
			$property = SMWPropertyValue::makeProperty($special_prop);
			$res = $store->getPropertyValues($subject_title, $property);
			// there could be multiple alternate forms
			$values = array();
				foreach ($res as $prop_val) {
				$values[] = html_entity_decode(str_replace('_', ' ', $prop_val->getXSDValue()));
			}
			return $values;
		}

		// otherwise, it's a bit more complicated
		global $sdgContLang;

		$sd_props = $sdgContLang->getPropertyLabels();
		$values = array();
		if (array_key_exists($prop, $sd_props)) {
			$property = $sd_props[$prop];
		} else {
			$property = "";
		}
		if ($property != '') {
			$prop = SDUtils::createProperty($property, SMW_NS_PROPERTY);
			$prop_vals = $store->getPropertyValues($subject_title, $prop);
			foreach ($prop_vals as $prop_val) {
				$values[] = html_entity_decode(str_replace('_', ' ', $prop_val->getXSDValue()));
			}
		}
		// try aliases as well
		foreach ($sdgContLang->getPropertyAliases() as $alias => $cur_prop) {
			// make sure alias doesn't match actual property name - this
			// is an issue for English, since the English-language values
			// are used for aliases
			if (($alias != $property) && (! $prop instanceof Title) && ($cur_prop == $prop)) {
				$prop = SDUtils::createProperty($alias, SMW_NS_PROPERTY);
				$prop_vals = $store->getPropertyValues($subject_title, $prop);
				foreach ($prop_vals as $prop_val) {
					// make sure it's in the right namespace
					if ($prop_val->getNamespace() == $object_namespace) {
						$values[] = $prop_val->getTitle()->getText();
					}
				}
			}
		}
		return $values;
	}

	/**
	 * Gets all the filters specified for a category.
	 */
	function loadFiltersForCategory($category) {
		$filters = array();
		$filter_names = SDUtils::getValuesForProperty(str_replace(' ', '_', $category), NS_CATEGORY, '_SD_F', SD_SP_HAS_FILTER, SD_NS_FILTER);
		foreach ($filter_names as $filter_name) {
			$filters[] = SDFilter::load($filter_name);
		}
		return $filters;
	}

	function getCategoryChildren($category_name, $get_categories, $levels) {
		if ($levels == 0) {
			return array();
		}
		$pages = array();
		$subcategories = array();
		$dbr = wfGetDB( DB_SLAVE );
		extract($dbr->tableNames('page', 'categorylinks'));
		$cat_ns = NS_CATEGORY;
		$query_category = str_replace(' ', '_', $category_name);
		$query_category = str_replace("'", "\'", $query_category);
		$sql = "SELECT p.page_title, p.page_namespace FROM $categorylinks cl
	JOIN $page p on cl.cl_from = p.page_id
	WHERE cl.cl_to = '$query_category'\n";
		if ($get_categories)
			$sql .= "AND p.page_namespace = $cat_ns\n";
		$sql .= "ORDER BY cl.cl_sortkey";
		$res = $dbr->query($sql);
		while ($row = $dbr->fetchRow($res)) {
			if ($get_categories) {
				$subcategories[] = $row[0];
				$pages[] = $row[0];
			} else {
				if ($row[1] == $cat_ns)
					$subcategories[] = $row[0];
				else
					$pages[] = $row[0];
			}
		}
		$dbr->freeResult($res);
		foreach ($subcategories as $subcategory) {
			$pages = array_merge($pages, SDUtils::getCategoryChildren($subcategory, $get_categories, $levels - 1));
		}
		return $pages;
	}

	function monthToString($month) {
		if ($month == 1) {
			return wfMsg('january');
		} elseif ($month == 2) {
			return wfMsg('february');
		} elseif ($month == 3) {
			return wfMsg('march');
		} elseif ($month == 4) {
			return wfMsg('april');
		} elseif ($month == 5) {
			return wfMsg('may');
		} elseif ($month == 6) {
			return wfMsg('june');
		} elseif ($month == 7) {
			return wfMsg('july');
		} elseif ($month == 8) {
			return wfMsg('august');
		} elseif ($month == 9) {
			return wfMsg('september');
		} elseif ($month == 10) {
			return wfMsg('october');
		} elseif ($month == 11) {
			return wfMsg('november');
		} else { //if ($month == 12) {
			return wfMsg('december');
		}
	}

	function stringToMonth($str) {
		if ($str == wfMsg('january')) {
			return 1;
		} elseif ($str == wfMsg('february')) {
			return 2;
		} elseif ($str == wfMsg('march')) {
			return 3;
		} elseif ($str == wfMsg('april')) {
			return 4;
		} elseif ($str == wfMsg('may')) {
			return 5;
		} elseif ($str == wfMsg('june')) {
			return 6;
		} elseif ($str == wfMsg('july')) {
			return 7;
		} elseif ($str == wfMsg('august')) {
			return 8;
		} elseif ($str == wfMsg('september')) {
			return 9;
		} elseif ($str == wfMsg('october')) {
			return 10;
		} elseif ($str == wfMsg('november')) {
			return 11;
		} else { //if ($strmonth == wfMsg('december')) {
			return 12;
		}
	}

	function booleanToString($bool_value) {
		$words_field_name = ($bool_value == true) ? 'smw_true_words' : 'smw_false_words';
		$words_array = explode(',', wfMsgForContent($words_field_name));
		// go with the value in the array that tends to be "yes" or
		// "no", which is the 3rd
		$index_of_word = 2;
		// capitalize first letter of word
		if (count($words_array) > $index_of_word) {
			$string_value = ucwords($words_array[$index_of_word]);
		} elseif (count($words_array) == 0) {
			$string_value = $bool_value; // a safe value if no words are found
		} else {
			$string_value = ucwords($words_array[0]);
		}
		return $string_value;
	}

	/**
	 * Prints the mini-form contained at the bottom of various pages, that
	 * allows pages to spoof a normal edit page, that can preview, save,
	 * etc.
	 */
	function printRedirectForm($title, $page_contents, $edit_summary, $is_save, $is_preview, $is_diff, $is_minor_edit, $watch_this) {
		$article = new Article($title);
		$new_url = $title->getLocalURL('action=submit');
		$starttime = wfTimestampNow();
		$edittime = $article->getTimestamp();
		global $wgUser;
		if ( $wgUser->isLoggedIn() )
			$token = htmlspecialchars($wgUser->editToken());
		else
			$token = EDIT_TOKEN_SUFFIX;

		if ($is_save)
			$action = "wpSave";
		elseif ($is_preview)
			$action = "wpPreview";
		else // $is_diff
			$action = "wpDiff";

		$text =<<<END
	<form id="editform" name="editform" method="post" action="$new_url">
	<input type="hidden" name="wpTextbox1" id="wpTextbox1" value="$page_contents" />
	<input type="hidden" name="wpSummary" value="$edit_summary" />
	<input type="hidden" name="wpStarttime" value="$starttime" />
	<input type="hidden" name="wpEdittime" value="$edittime" />
	<input type="hidden" name="wpEditToken" value="$token" />
	<input type="hidden" name="$action" />

END;
		if ($is_minor_edit)
			$text .= '    <input type="hidden" name="wpMinoredit">' . "\n";
		if ($watch_this)
			$text .= '    <input type="hidden" name="wpWatchthis">' . "\n";
		$text .=<<<END
	</form>
	<script type="text/javascript">
	document.editform.submit();
	</script>

END;
		return $text;
	}

}
