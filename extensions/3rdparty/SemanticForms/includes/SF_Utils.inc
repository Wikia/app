<?php
/**
 * Helper functions for the Semantic Forms extension.
 *
 * @author Yaron Koren
 */

if ( !defined( 'MEDIAWIKI' ) ) die();

class SFUtils {

	static function initProperties() {
		global $sfgContLang;
		$sf_props = $sfgContLang->getPropertyLabels();
		SMWPropertyValue::registerProperty('_SF_DF', '__spf', $sf_props[SF_SP_HAS_DEFAULT_FORM], true);
		SMWPropertyValue::registerProperty('_SF_AF', '__spf', $sf_props[SF_SP_HAS_ALTERNATE_FORM], true);
		return true;
	}

	/**
	 * Creates HTML linking to a wiki page
	 */
	static function linkText($namespace, $name, $text = NULL) {
		global $wgContLang;

		$inText = $wgContLang->getNsText($namespace) . ':' . $name;
		$title = Title::newFromText( $inText );
		if ($title === NULL) {
			return $inText; // TODO maybe report an error here?
		}
		if ( NULL === $text ) $text = $title->getText();
		$l = new Linker();
		return $l->makeLinkObj($title, $text);
	}

	/**
	 * Prints the mini-form contained at the bottom of various pages, that
	 * allows pages to spoof a normal edit page, that can preview, save,
	 * etc.
	 */
	static function printRedirectForm($title, $page_contents, $edit_summary, $is_save, $is_preview, $is_diff, $is_minor_edit, $watch_this, $start_time, $edit_time) {
		$article = new Article($title);
		$new_url = $title->getLocalURL('action=submit');
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

		global $sfgScriptPath;
		$text =<<<END
	<p style="position: absolute; left: 45%; top: 45%;"><img src="$sfgScriptPath/skins/loading.gif" /></p>
	<form id="editform" name="editform" method="post" action="$new_url">
	<input type="hidden" name="wpTextbox1" id="wpTextbox1" value="$page_contents" />
	<input type="hidden" name="wpSummary" value="$edit_summary" />
	<input type="hidden" name="wpStarttime" value="$start_time" />
	<input type="hidden" name="wpEdittime" value="$edit_time" />
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
	window.onload = function() {
		document.editform.submit();
	}
	</script>

END;
		return $text;
	}

	/**
	 * A helper function to generate a property object given its name,
	 * since the class for properties changed from Title to
	 * SMWPropertyValue in SMW 1.4
	 */
	static function createProperty($property_name) {
		if (class_exists('SMWPropertyValue'))
			return SMWPropertyValue::makeProperty($property_name);
		else
			return Title::newFromText($property_name, SMW_NS_PROPERTY);
	}

	/**
	 * Same idea as createProperty()
	 */
	static function getPropertyName($property) {
		if ($property instanceof Title)
			return $property->getText();
		else // $property instanceof SMWPropertyValue
			return $property->getWikiValue();
	}

	/**
	 * Return an array of all form names on this wiki
 	*/
	static function getAllForms() {
		$dbr = wfGetDB( DB_SLAVE );
		$query = "SELECT page_title FROM " . $dbr->tableName( 'page' ) .
			" WHERE page_namespace = " . SF_NS_FORM .
			" AND page_is_redirect = 0" .
			" ORDER BY page_title";
		$res = $dbr->query($query);
		$form_names = array();
		while ($row = $dbr->fetchRow($res)) {
			$form_names[] = str_replace('_', ' ', $row[0]);
		}
		$dbr->freeResult($res);
		return $form_names;
	}

	static function formDropdownHTML() {
		// create a dropdown of possible form names
		global $sfgContLang;
		$namespace_labels = $sfgContLang->getNamespaces();
		$form_label = $namespace_labels[SF_NS_FORM];
		$str = <<<END
		$form_label:
			<select name="form">

END;
		$form_names = SFUtils::getAllForms();
		foreach ($form_names as $form_name) {
			$str .= "			<option>$form_name</option>\n";
		}
		$str .= "			</select>\n";
		return $str;
	}


	static function getAllValuesForProperty_orig($is_relation, $property_name, $substring = null) {
		global $sfgMaxAutocompleteValues;

		$fname = "getAllValuesForProperty_orig";
		$values = array();
		$db = wfGetDB( DB_SLAVE );
		$sql_options = array();
		$sql_options['LIMIT'] = $sfgMaxAutocompleteValues;
		$property_field = ($is_relation) ? 'relation_title' : 'attribute_title';
		$value_field = ($is_relation) ? 'object_title' : 'value_xsd';
		$property_table = ($is_relation) ? 'smw_relations' : 'smw_attributes';
		$conditions = "$property_field = '$property_name'";
		if ($substring != null) {
			$substring = str_replace(' ', '_', strtolower($substring));
			$substring = str_replace('_', '\_', $substring);
			$substring = str_replace("'", "\'", $substring);
			$conditions .= " AND (LOWER($value_field) LIKE '" . $substring . "%' OR LOWER($value_field) LIKE '%\_" . $substring . "%')";
		}
		$sql_options['ORDER BY'] = $value_field;
		$res = $db->select( $db->tableName($property_table),
			"DISTINCT $value_field",
			$conditions, $fname, $sql_options);
		while ($row = $db->fetchRow($res)) {
			if ($substring != null) {
				$values[] = array('title' => str_replace('_', ' ', $row[0]));
			} else {
				$cur_value = str_replace("'", "\'", $row[0]);
				$values[] = str_replace('_', ' ', $cur_value);
			}
		}
		$db->freeResult($res);
		return $values;
	}

	static function getAllValuesForProperty_1_2($property_name, $substring = null) {
		global $sfgMaxAutocompleteValues;

		$store = smwfGetStore();
		$requestoptions = new SMWRequestOptions();
		$requestoptions->limit = $sfgMaxAutocompleteValues;
		if ($substring != null) {
			$requestoptions->addStringCondition($substring, SMWStringCondition::STRCOND_PRE);
		}
		$property = SFUtils::createProperty($property_name);
		$data_values = $store->getPropertyValues(null, $property, $requestoptions);
		$values = array();
		foreach ($data_values as $dv) {
			// getPropertyValues() gets many repeat values - we want
			// only one of each value
			$string_value = str_replace('_', ' ', $dv->getXSDValue());
			$string_value = str_replace("'", "\'", $string_value);
			if (array_search($string_value, $values) === false)
				$values[] = $string_value;
		}
		// if there was a substring specified, also find values that
		// have it after a space, not just at the beginning of the value
		if ($substring != null) {
			$requestoptions2 = new SMWRequestOptions();
			$requestoptions2->limit = $sfgMaxAutocompleteValues;
			$requestoptions2->addStringCondition(" $substring", SMWStringCondition::STRCOND_MID);
			$data_values = $store->getPropertyValues(null, $property, $requestoptions2);
			foreach ($data_values as $dv) {
				$string_value = str_replace('_', ' ', $dv->getXSDValue());
				if (array_search($string_value, $values) === false)
					$values[] = $string_value;
			}
		}
		if ($substring == null)
			return $values;
		else {
			$autocomplete_vals = array();
			foreach ($values as $value) {
				// if these values are being returned for remote
				// autocompletion, undo the apostrophe-escaping
				$value = str_replace("\'", "'", $value);
				$autocomplete_vals[] = array('title' => $value);
			}
			return $autocomplete_vals;
		}
	}

	/*
	 * Get all the pages that belong to a category and all its
	 * subcategories, down a certain number of levels - heavily based on
	 * SMW's SMWInlineQuery::includeSubcategories()
	 */
	static function getAllPagesForCategory($top_category, $num_levels, $substring = null) {
		if (0 == $num_levels) return $top_category;
		global $sfgMaxAutocompleteValues;

		$db = wfGetDB( DB_SLAVE );
		$fname = "getAllPagesForCategory";
		$categories = array($top_category);
		$checkcategories = array($top_category);
		$pages = array();
		for ($level = $num_levels; $level > 0; $level--) {
			$newcategories = array();
			foreach ($checkcategories as $category) {
				if ($substring != null) {
					$substring = str_replace(' ', '_', strtolower($substring));
					$substring = str_replace('_', '\_', $substring);
					$substring = str_replace("'", "\'", $substring);
					$conditions = 'cl_to = '. $db->addQuotes($category) . " AND (LOWER(page_title) LIKE '" . $substring . "%' OR LOWER(page_title) LIKE '%\_" . $substring . "%' OR page_namespace = " . NS_CATEGORY . ")";
				} else {
					$conditions = 'cl_to = '. $db->addQuotes($category);
				}
				$res = $db->select( // make the query
					array('categorylinks', 'page'),
					array('page_title', 'page_namespace'),
					array('cl_from = page_id', $conditions),
					$fname);
				if ($res) {
					while ($res && $row = $db->fetchRow($res)) {
						if (array_key_exists('page_title', $row)) {
							$page_namespace = $row['page_namespace'];
							if ($page_namespace == NS_CATEGORY) {
								$new_category = $row[ 'page_title' ];
								if (!in_array($new_category, $categories)) {
									$newcategories[] = $new_category;
								}
							} else {
								$cur_value = str_replace("_", " ", $row['page_title']);
								if ($substring == null)
									$pages[] = $cur_value;
								else
									$pages[] = array('title' => $cur_value);
								// return if we've reached the maximum number of allowed values
								if (count($pages) > $sfgMaxAutocompleteValues)
									return $pages;
							}
						}
					}
					$db->freeResult( $res );
				}
			}
			if (count($newcategories) == 0) {
				sort($pages);
				return $pages;
			} else {
				$categories = array_merge($categories, $newcategories);
			}
			$checkcategories = array_diff($newcategories, array());
		}
		sort($pages);
		return $pages;
	}

	static function getAllPagesForConcept($concept_name, $substring = null) {
		global $sfgMaxAutocompleteValues;

		// TODO - substring isn't being handled. Is there a way to
		// include it through the API?
		$store = smwfGetStore();
/*
		$requestoptions = new SMWRequestOptions();
		if ($substring != null) {
			$requestoptions->addStringCondition($substring, SMWStringCondition::STRCOND_PRE);
		}
*/
		$concept = Title::newFromText($concept_name, SMW_NS_CONCEPT);
		$desc = new SMWConceptDescription($concept);
		$printout = new SMWPrintRequest(SMWPrintRequest::PRINT_THIS, "");
		$desc->addPrintRequest($printout);
		$query = new SMWQuery($desc);
		$query->setLimit($sfgMaxAutocompleteValues);
		$query_result = $store->getQueryResult($query);
		$pages = array();
		while ($res = $query_result->getNext()) {
			$pages[] = $res[0]->getNextText(SMW_OUTPUT_WIKI);
		}
		return $pages;
	}

	static function getAllPagesForNamespace($namespace_name, $substring = null) {
		// cycle through all the namespace names for this language, and
		// if one matches the namespace specified in the form, add the
		// names of all the pages in that namespace to $names_array
		global $wgContLang;
		$namespaces = $wgContLang->getNamespaces();
		$db = wfGetDB( DB_SLAVE );
		$fname = "getAllPagesForNamespace";
		$pages = array();
		foreach ($namespaces as $ns_code => $ns_name) {
			if ($ns_name == $namespace_name) {
				$conditions = "page_namespace = $ns_code";
				if ($substring != null) {
					$substring = str_replace(' ', '_', strtolower($substring));
					$substring = str_replace('_', '\_', $substring);
					$substring = str_replace("'", "\'", $substring);
					$conditions .= " AND (LOWER(page_title) LIKE '$substring%' OR LOWER(page_title) LIKE '%\_$substring%')";
				}
				$sql_options['ORDER BY'] = 'page_title';
				$res = $db->select( $db->tableNames('page'),
					'page_title',
					$conditions, $fname, $sql_options);
				while ($row = $db->fetchRow($res)) {
					$cur_value = str_replace('_', ' ', $row[0]);
					if ($substring == null) {
						$pages[] = str_replace("'", "\'", $cur_value);
					} else {
						$pages[] = array('title' => $cur_value);
					}
				}
				$db->freeResult($res);
			}
		}
		return $pages;
	}

}
