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
		if (array_key_exists(SF_SP_HAS_DEFAULT_FORM, $sf_props))
			SMWPropertyValue::registerProperty('_SF_DF', '__spf', $sf_props[SF_SP_HAS_DEFAULT_FORM], true);
		if (array_key_exists(SF_SP_HAS_ALTERNATE_FORM, $sf_props))
			SMWPropertyValue::registerProperty('_SF_AF', '__spf', $sf_props[SF_SP_HAS_ALTERNATE_FORM], true);
		if (array_key_exists(SF_SP_CREATES_PAGES_WITH_FORM, $sf_props))
			SMWPropertyValue::registerProperty('_SF_CP', '__spf', $sf_props[SF_SP_CREATES_PAGES_WITH_FORM], true);
		if (array_key_exists(SF_SP_PAGE_HAS_DEFAULT_FORM, $sf_props))
			SMWPropertyValue::registerProperty('_SF_PDF', '__spf', $sf_props[SF_SP_PAGE_HAS_DEFAULT_FORM], true);
		if (array_key_exists(SF_SP_HAS_FIELD_LABEL_FORMAT, $sf_props))
			SMWPropertyValue::registerProperty('_SF_FLF', '_str', $sf_props[SF_SP_HAS_FIELD_LABEL_FORMAT], true);
		// also initialize hardcoded English values, if it's a non-English-language wiki
		SMWPropertyValue::registerProperty('_SF_DF_BACKUP', '__spf', 'Has default form', true);
		SMWPropertyValue::registerProperty('_SF_AF_BACKUP', '__spf', 'Has alternate form', true);
		SMWPropertyValue::registerProperty('_SF_CP_BACKUP', '__spf', 'Creates pages with form', true);
		SMWPropertyValue::registerProperty('_SF_PDF_BACKUP', '__spf', 'Page has default form', true);
		SMWPropertyValue::registerProperty('_SF_FLF_BACKUP', '_str', 'Has field label format', true);

		return true;
	}

	/**
	 * Creates HTML linking to a wiki page
	 */
	static function linkText($namespace, $name, $text = NULL) {
		global $wgContLang;

		$title = Title::makeTitleSafe( $namespace, $name );
		if ($title === NULL) {
			return $name; // TODO maybe report an error here?
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
		if ($title instanceof Title)
			$new_url = $title->getLocalURL('action=submit');
		else
			$new_url = $title;
		global $wgUser;
		if ( $wgUser->isLoggedIn() )
			$token = htmlspecialchars($wgUser->editToken());
		else
			$token = EDIT_TOKEN_SUFFIX;

		$edit_summary = htmlspecialchars($edit_summary);
		if ($is_save)
			$action = "wpSave";
		elseif ($is_preview)
			$action = "wpPreview";
		else // $is_diff
			$action = "wpDiff";

		global $sfgScriptPath;
		$text =<<<END
	<p style="position: absolute; left: 45%; top: 45%;"><img src="$sfgScriptPath/skins/loading.gif" /></p>

END;
		$form_body = '	' . Xml::element('input', array('type' => 'hidden', 'name' => 'wpTextbox1', 'id' => 'wpTextbox1', 'value' => $page_contents), null) . "\n";
		$form_body .= '	' . Xml::element('input', array('type' => 'hidden', 'name' => 'wpSummary', 'value' => $edit_summary), null) . "\n";
		$form_body .= '	' . Xml::element('input', array('type' => 'hidden', 'name' => 'wpStarttime', 'value' => $start_time), null) . "\n";
		$form_body .= '	' . Xml::element('input', array('type' => 'hidden', 'name' => 'wpEdittime', 'value' => $edit_time), null) . "\n";
		$form_body .= '	' . Xml::element('input', array('type' => 'hidden', 'name' => 'wpEditToken', 'value' => $token), null) . "\n";
		$form_body .= '	' . Xml::element('input', array('type' => 'hidden', 'name' => $action), null) . "\n";

		if ($is_minor_edit)
			$form_body .= '	' . Xml::element('input', array('type' => 'hidden', 'name' => 'wpMinorEdit'), null) . "\n";
		if ($watch_this)
			$form_body .= '	' . Xml::element('input', array('type' => 'hidden', 'name' => 'wpWatchthis'), null) . "\n";
		$text .= Xml::tags('form', array('id' => 'editform', 'name' => 'editform', 'method' => 'post', 'action' => $new_url), $form_body);

		$text .=<<<END
	<script type="text/javascript">
	window.onload = function() {
		document.editform.submit();
	}
	</script>

END;
		wfRunHooks('sfPrintRedirectForm', array($is_save, $is_preview, $is_diff, &$text));
		return $text;
	}

	/**
	 * Includes the necessary Javascript and CSS files for the form
	 * to display and work correctly
	 * 
	 * Accepts an optional Parser instance, or uses $wgOut if omitted.
	 */
	static function addJavascriptAndCSS($parser = NULL) {
		global $wgOut, $sfgScriptPath, $sfgYUIBase, $smwgScriptPath, $wgScriptPath, $wgFCKEditorDir, $wgJsMimeType, $sfgUseFormEditPage;

		$links = array(
			array(
				'rel' => 'stylesheet',
				'type' => 'text/css',
				'media' => "screen",
				'href' => $sfgScriptPath . '/skins/SF_main.css'
			),
			array(
				'rel' => 'stylesheet',
				'type' => 'text/css',
				'media' => "screen",
				'href' => $sfgYUIBase . "autocomplete/assets/skins/sam/autocomplete.css"
			),
			array(
				'rel' => 'stylesheet',
				'type' => 'text/css',
				'media' => "screen",
				'href' => $sfgScriptPath . '/skins/SF_yui_autocompletion.css'
			),
			array(
				'rel' => 'stylesheet',
				'type' => 'text/css',
				'media' => "screen",
				'href' => $sfgScriptPath . '/skins/floatbox.css'
			),
			array(
				'rel' => 'stylesheet',
				'type' => 'text/css',
				'media' => "screen",
				'href' => $smwgScriptPath . '/skins/SMW_custom.css'
			),
		);
		foreach( $links as $link ) {
			if ( $parser )
				$parser->getOutput()->addHeadItem(Xml::element( 'link', $link ));
			else
				$wgOut->addLink($link);
		}
		
		
		$scripts = array();
		$scripts[] = "{$sfgYUIBase}yahoo/yahoo-min.js";
		$scripts[] = "{$sfgYUIBase}dom/dom-min.js";
		$scripts[] = "{$sfgYUIBase}event/event-min.js";
		$scripts[] = "{$sfgYUIBase}get/get-min.js";
		$scripts[] = "{$sfgYUIBase}connection/connection-min.js";
		$scripts[] = "{$sfgYUIBase}json/json-min.js";
		$scripts[] = "{$sfgYUIBase}datasource/datasource-min.js";
		$scripts[] = "{$sfgYUIBase}autocomplete/autocomplete-min.js";
		$scripts[] = "$sfgScriptPath/libs/SF_yui_autocompletion.js";
		if ( !$sfgUseFormEditPage )
			$scripts[] = "$sfgScriptPath/libs/SF_ajax_form_preview.js";
		$scripts[] = "$sfgScriptPath/libs/floatbox.js";
		$scripts[] = "$smwgScriptPath/skins/SMW_tooltip.js";
		$scripts[] = "$smwgScriptPath/skins/SMW_sorttable.js";
		if ($wgFCKEditorDir)
			$scripts[] = "$wgScriptPath/$wgFCKEditorDir/fckeditor.js";
		foreach( $scripts as $js ) {
			$script = "<script type=\"$wgJsMimeType\" src=\"$js\"></script>\n";
			if ( $parser )
				$parser->getOutput()->addHeadItem($script);
			else
				$wgOut->addScript($script);
		}
		if ( !$parser )
			$wgOut->addMeta('robots','noindex,nofollow');
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
		$form_names = SFUtils::getAllForms();
		$select_body = "";
		foreach ($form_names as $form_name) {
			$select_body .= '	' . Xml::element('option', null, $form_name) . "\n";
		}
		$str = "	$form_label:" . Xml::tags('select', array('name' => 'form'), $select_body) . "\n";
		return $str;
	}

	/*
	 * This function, unlike the others, doesn't take in a substring
	 * because it uses the SMW data store, which can't perform
	 * case-insensitive queries; for queries with a substring, the
	 * function SFAutocompletAPI::getAllValuesForProperty() exists.
	 */
	static function getAllValuesForProperty($property_name) {
		global $sfgMaxAutocompleteValues;

		$store = smwfGetStore();
		$requestoptions = new SMWRequestOptions();
		$requestoptions->limit = $sfgMaxAutocompleteValues;
		$property = SMWPropertyValue::makeProperty($property_name);
		$data_values = $store->getPropertyValues(null, $property, $requestoptions);
		$values = array();
		foreach ($data_values as $dv) {
			// getPropertyValues() gets many repeat values - we want
			// only one of each value
			$string_value = str_replace('_', ' ', $dv->getWikiValue());
			if (array_search($string_value, $values) === false)
				$values[] = $string_value;
		}
		return $values;
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
		$top_category = str_replace(' ', '_', $top_category);
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
					$conditions = 'cl_to = '. $db->addQuotes($category) . " AND (LOWER(CONVERT(`page_title` USING utf8)) LIKE '" . $substring . "%' OR LOWER(CONVERT(`page_title` USING utf8)) LIKE '%\_" . $substring . "%' OR page_namespace = " . NS_CATEGORY . ")";
				} else {
					$conditions = 'cl_to = '. $db->addQuotes($category);
				}
				$res = $db->select( // make the query
					array('categorylinks', 'page'),
					array('page_title', 'page_namespace'),
					array('cl_from = page_id', $conditions),
					__METHOD__,
					'SORT BY cl_sortkey');
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
								if (! in_array($cur_value, $pages)) {
									if ($substring == null)
										$pages[] = $cur_value;
									else
										$pages[] = array('title' => $cur_value);
								}
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
				return $pages;
			} else {
				$categories = array_merge($categories, $newcategories);
			}
			$checkcategories = array_diff($newcategories, array());
		}
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
		$concept = Title::makeTitleSafe(SMW_NS_CONCEPT, $concept_name);
		// escape if there's a problem
		if ($concept == null)
			return array();
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
		sort($pages);
		return $pages;
	}

	static function getAllPagesForNamespace($namespace_name, $substring = null) {
		// cycle through all the namespace names for this language, and
		// if one matches the namespace specified in the form, add the
		// names of all the pages in that namespace to $names_array
		global $wgContLang;
		$namespaces = $wgContLang->getNamespaces();
		$db = wfGetDB( DB_SLAVE );
		$pages = array();
		foreach ($namespaces as $ns_code => $ns_name) {
			if ($ns_name == $namespace_name) {
				$conditions = "page_namespace = $ns_code";
				if ($substring != null) {
					$substring = str_replace(' ', '_', strtolower($substring));
					$substring = str_replace('_', '\_', $substring);
					$substring = str_replace("'", "\'", $substring);
					$conditions .= " AND (LOWER(CONVERT(`page_title` USING utf8)) LIKE '$substring%' OR LOWER(CONVERT(`page_title` USING utf8)) LIKE '%\_$substring%')";
				}
				$sql_options['ORDER BY'] = 'page_title';
				$res = $db->select( $db->tableNames('page'),
					'page_title',
					$conditions, __METHOD__, $sql_options);
				while ($row = $db->fetchRow($res)) {
					$cur_value = str_replace('_', ' ', $row[0]);
					if ($substring == null) {
						$pages[] = $cur_value;
					} else {
						$pages[] = array('title' => $cur_value);
					}
				}
				$db->freeResult($res);
			}
		}
		return $pages;
	}

	static function getValuesFromExternalURL($external_url_alias, $substring) {
		global $sfgAutocompletionURLs;
		if (empty($sfgAutocompletionURLs)) return array();
		$url = $sfgAutocompletionURLs[$external_url_alias];
		if (empty($url)) return array();
		$url = str_replace('<substr>', $substring, $url);
		$page_contents = Http::get($url);
		if (empty($page_contents)) return array();
		$data = json_decode($page_contents);
		if (empty($data)) return array();
		$return_values = array();
		foreach ($data->sfautocomplete as $val) {
			$return_values[] = (array)$val;
		}
		return $return_values;
	}

	/**
	 * Parse the form definition and store the resulting HTML in the
	 * page_props table, if caching has been specified in LocalSettings.php
	 */
	function cacheFormDefinition($parser, $text) {
		global $sfgCacheFormDefinitions;
		if (! $sfgCacheFormDefinitions)
			return true;

		if ($parser->getTitle()->getNamespace() != SF_NS_FORM) return true;
		// Remove <noinclude> sections and <includeonly> tags from form definition
		$form_def = StringUtils::delimiterReplace('<noinclude>', '</noinclude>', '', $text);
		$form_def = strtr($form_def, array('<includeonly>' => '', '</includeonly>' => ''));

		// parse wiki-text
		// add '<nowiki>' tags around every triple-bracketed form definition
		// element, so that the wiki parser won't touch it - the parser will
		// remove the '<nowiki>' tags, leaving us with what we need
		$form_def = "__NOEDITSECTION__" . strtr($form_def, array('{{{' => '<nowiki>{{{', '}}}' => '}}}</nowiki>'));
		$dummy_title = Title::newFromText('Form definition title for caching purposes');
		$form_def = $parser->parse($form_def, $dummy_title, $parser->mOptions)->getText();

		$parser->mOutput->setProperty( 'formdefinition', $form_def );
		return true;
	}

}
