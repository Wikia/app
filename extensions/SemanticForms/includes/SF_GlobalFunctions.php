<?php
/**
 * Global functions and constants for Semantic Forms.
 *
 * @author Yaron Koren
 * @author Harold Solbrig
 * @author Louis Gerbarg
 */

if ( !defined( 'MEDIAWIKI' ) ) die();

define('SF_VERSION','1.2.6');

// constants for special properties
define('SF_SP_HAS_DEFAULT_FORM', 1);
define('SF_SP_HAS_ALTERNATE_FORM', 2);

$wgExtensionFunctions[] = 'sfgSetupExtension';
$wgExtensionFunctions[] = 'sfgParserFunctions';

$wgHooks['LanguageGetMagic'][] = 'sffLanguageGetMagic';
$wgHooks['BrokenLink'][] = 'sffSetBrokenLink';
$wgHooks['UnknownAction'][] = 'sffEmbeddedEditForm';

$wgAPIModules['sfautocomplete'] = 'SFAutocompleteAPI';

// register all special pages and other classes
$wgSpecialPages['Forms'] = 'SFForms';
$wgAutoloadClasses['SFForms'] = $sfgIP . '/specials/SF_Forms.php';
$wgSpecialPages['CreateForm'] = 'SFCreateForm';
$wgAutoloadClasses['SFCreateForm'] = $sfgIP . '/specials/SF_CreateForm.php';
$wgSpecialPages['Templates'] = 'SFTemplates';
$wgAutoloadClasses['SFTemplates'] = $sfgIP . '/specials/SF_Templates.php';
$wgSpecialPages['CreateTemplate'] = 'SFCreateTemplate';
$wgAutoloadClasses['SFCreateTemplate'] = $sfgIP . '/specials/SF_CreateTemplate.php';
$wgSpecialPages['CreateProperty'] = 'SFCreateProperty';
$wgAutoloadClasses['SFCreateProperty'] = $sfgIP . '/specials/SF_CreateProperty.php';
$wgSpecialPages['CreateCategory'] = 'SFCreateCategory';
$wgAutoloadClasses['SFCreateCategory'] = $sfgIP . '/specials/SF_CreateCategory.php';
$wgSpecialPages['AddPage'] = 'SFAddPage';
$wgAutoloadClasses['SFAddPage'] = $sfgIP . '/specials/SF_AddPage.php';
$wgSpecialPages['AddData'] = 'SFAddData';
$wgAutoloadClasses['SFAddData'] = $sfgIP . '/specials/SF_AddData.php';
$wgSpecialPages['EditData'] = 'SFEditData';
$wgAutoloadClasses['SFEditData'] = $sfgIP . '/specials/SF_EditData.php';
$wgSpecialPages['UploadWindow'] = 'SFUploadWindow';
$wgAutoloadClasses['SFUploadWindow'] = $sfgIP . '/specials/SF_UploadWindow.php';

$wgAutoloadClasses['SFTemplateField'] = $sfgIP . '/includes/SF_TemplateField.inc';
$wgAutoloadClasses['SFForm'] = $sfgIP . '/includes/SF_FormClasses.inc';
$wgAutoloadClasses['SFTemplateInForm'] = $sfgIP . '/includes/SF_FormClasses.inc';
$wgAutoloadClasses['SFFormTemplateField'] = $sfgIP . '/includes/SF_FormClasses.inc';
$wgAutoloadClasses['SFFormInputs'] = $sfgIP . '/includes/SF_FormInputs.inc';
// SFFormPrinter is not autoloaded because it's needed right away, for the
// $sfgFormPrinter variable
//$wgAutoloadClasses['SFFormPrinter'] = $sfgIP . '/includes/SF_FormPrinter.inc';
$wgAutoloadClasses['SFAutocompleteAPI'] = $sfgIP . '/includes/SF_AutocompleteAPI.php';

require_once($sfgIP . '/includes/SF_FormPrinter.inc');
require_once($sfgIP . '/includes/SF_ParserFunctions.php');
require_once($sfgIP . '/languages/SF_Language.php');

$wgExtensionMessagesFiles['SemanticForms'] = $sfgIP . '/languages/SF_Messages.php';

/**
 *  Do the actual intialization of the extension. This is just a delayed init that makes sure
 *  MediaWiki is set up properly before we add our stuff.
 */
function sfgSetupExtension() {
	global $sfgIP, $wgExtensionCredits;

	require_once($sfgIP . '/includes/SF_FormEditTab.php');

	wfLoadExtensionMessages('SemanticForms');

	$wgExtensionCredits['specialpage'][]= array(
		'name' => 'Semantic Forms',
		'version' => SF_VERSION,
		'author' => 'Yaron Koren and others',
		'url' => 'http://www.mediawiki.org/wiki/Extension:Semantic_Forms',
		'description' => 'Forms for adding and editing semantic data',
	);

	// this global variable is needed so that other extensions (such
	// as Semantic Google Maps) can hook into to add their own input
	// types
	global $sfgFormPrinter;
	$sfgFormPrinter = new SFFormPrinter();
}

/**********************************************/
/***** namespace settings                 *****/
/**********************************************/

/**
 * Init the additional namespaces used by Semantic Forms. The
 * parameter denotes the least unused even namespace ID that is
 * greater or equal to 100.
 */
function sffInitNamespaces() {
	global $sfgNamespaceIndex, $wgExtraNamespaces, $wgNamespaceAliases, $wgNamespacesWithSubpages, $wgLanguageCode, $sfgContLang;

	if (!isset($sfgNamespaceIndex)) {
		$sfgNamespaceIndex = 106;
	}

	define('SF_NS_FORM',       $sfgNamespaceIndex);
	define('SF_NS_FORM_TALK',  $sfgNamespaceIndex+1);

	sffInitContentLanguage($wgLanguageCode);

	// Register namespace identifiers
	if (!is_array($wgExtraNamespaces)) { $wgExtraNamespaces=array(); }
	$wgExtraNamespaces = $wgExtraNamespaces + $sfgContLang->getNamespaces();
	$wgNamespaceAliases = $wgNamespaceAliases + $sfgContLang->getNamespaceAliases();

	// Support subpages only for talk pages by default
	$wgNamespacesWithSubpages = $wgNamespacesWithSubpages + array(
		      SF_NS_FORM_TALK => true
	);
}

/**********************************************/
/***** language settings                  *****/
/**********************************************/

/**
 * Initialise a global language object for content language. This
 * must happen early on, even before user language is known, to
 * determine labels for additional namespaces. In contrast, messages
 * can be initialised much later when they are actually needed.
 */
function sffInitContentLanguage($langcode) {
	global $sfgIP, $sfgContLang;

	if (!empty($sfgContLang)) { return; }

	$sfContLangClass = 'SF_Language' . str_replace( '-', '_', ucfirst( $langcode ) );
	if (file_exists($sfgIP . '/languages/'. $sfContLangClass . '.php')) {
		include_once( $sfgIP . '/languages/'. $sfContLangClass . '.php' );
	}

	// fallback if language not supported
	if ( !class_exists($sfContLangClass)) {
		include_once($sfgIP . '/languages/SF_LanguageEn.php');
		$sfContLangClass = 'SF_LanguageEn';
	}

	$sfgContLang = new $sfContLangClass();
}

/**
 * Initialise the global language object for user language. This
 * must happen after the content language was initialised, since
 * this language is used as a fallback.
 */
function sffInitUserLanguage($langcode) {
	global $sfgIP, $sfgLang;

	if (!empty($sfgLang)) { return; }

	$sfLangClass = 'SF_Language' . str_replace( '-', '_', ucfirst( $langcode ) );

	if (file_exists($sfgIP . '/languages/'. $sfLangClass . '.php')) {
		include_once( $sfgIP . '/languages/'. $sfLangClass . '.php' );
	}

	// fallback if language not supported
	if ( !class_exists($sfLangClass)) {
		global $sfgContLang;
		$sfgLang = $sfgContLang;
	} else {
		$sfgLang = new $sfLangClass();
	}
}

/**********************************************/
/***** other global helpers               *****/
/**********************************************/

/**
 * Creates HTML linking to a wiki page
 */
function sffLinkText($namespace, $name, $text = NULL) {
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
 * Creates the name of the page that appears in the URL;
 * this method is necessary because Title::getPartialURL(), for
 * some reason, doesn't include the namespace
 */
function sffTitleURLString($title) {
	global $wgCapitalLinks;

	$namespace = wfUrlencode( $title->getNsText() );
	if ( '' != $namespace ) {
		$namespace .= ':';
	}
	if ($wgCapitalLinks) {
		return $namespace . ucfirst($title->getPartialURL());
	} else {
		return $namespace . $title->getPartialURL();
	}
}

/**
 * A very similar function, to get the non-URL-encoded title string
 */
function sffTitleString($title) {
	$namespace = $title->getNsText();
	if ( '' != $namespace ) {
		$namespace .= ':';
	}
	return ($namespace . ucfirst($title->getText()));
}

/**
 * Prints the mini-form contained at the bottom of various pages, that
 * allows pages to spoof a normal edit page, that can preview, save,
 * etc.
 */
function sffPrintRedirectForm($title, $page_contents, $edit_summary, $is_save, $is_preview, $is_diff, $is_minor_edit, $watch_this, $start_time, $edit_time) {
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

	$text =<<<END
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
	document.editform.submit();
	</script>

END;
	return $text;
}

/**
 * Gets the default form specified, if any, for a specific page
 * (which should be a category, relation, or namespace page)
 */
function sffGetDefaultForm($page_title, $page_namespace) {
	if ($page_title == NULL)
		return null;

	global $sfgContLang;
	$store = smwfGetStore();
	$title = Title::newFromText($page_title, $page_namespace);
	$sf_props = $sfgContLang->getSpecialPropertiesArray();
	$default_form_property = str_replace(' ', '_', $sf_props[SF_SP_HAS_DEFAULT_FORM]);
	$property = Title::newFromText($default_form_property, SMW_NS_PROPERTY);
	$res = $store->getPropertyValues($title, $property);
	$num = count($res);
	if ($num > 0) {
		// make sure it's in the form namespace
		if ($res[0]->getNamespace() == SF_NS_FORM) {
			$form_name = $res[0]->getTitle()->getText();
			return $form_name;
		}
	}
	// if that didn't work, try any aliases that may exist
	// for SF_SP_HAS_DEFAULT_FORM
	$sf_props_aliases = $sfgContLang->getSpecialPropertyAliases();
	foreach ($sf_props_aliases as $alias => $prop_code) {
		if ($prop_code == SF_SP_HAS_DEFAULT_FORM) {
			$property = Title::newFromText($alias, SMW_NS_PROPERTY);
			$res = $store->getPropertyValues($title, $property);
			$num = count($res);
			if ($num > 0) {
				// make sure it's in the form namespace
				if ($res[0]->getNamespace() == SF_NS_FORM) {
					$form_name = $res[0]->getTitle()->getText();
					return $form_name;
				}
			}
		}
	}
	return null;
}

/**
 * Gets the alternate forms specified, if any, for a specific page
 * (which, for now, should always be a relation)
 */
function sffGetAlternateForms($page_title, $page_namespace) {
	if ($page_title == NULL)
		return null;

	global $sfgContLang;
	$store = smwfGetStore();
	$title = Title::newFromText($page_title, $page_namespace);
	$sf_props = $sfgContLang->getSpecialPropertiesArray();
	$alternate_form_property = str_replace(' ', '_', $sf_props[SF_SP_HAS_ALTERNATE_FORM]);
	$property = Title::newFromText($alternate_form_property, SMW_NS_PROPERTY);
	$prop_vals = $store->getPropertyValues($title, $property);
	$form_names = array();
	foreach ($prop_vals as $prop_val) {
		// make sure it's in the form namespace
		if ($prop_val->getNamespace() == SF_NS_FORM) {
			$form_names[] = str_replace(' ', '_', $prop_val->getTitle()->getText());
		}
	}
	// try the English version too, if this isn't in English
	if ($alternate_form_property != "Has_alternate_form") {
		$property = Title::newFromText("Has_alternate_form", SMW_NS_PROPERTY);
		$prop_vals = $store->getPropertyValues($title, $property);
		foreach ($prop_vals as $prop_val) {
			if ($prop_val->getNamespace() == SF_NS_FORM) {
				$form_names[] = str_replace(' ', '_', $prop_val->getTitle()->getText());
			}
		}
	}
	return $form_names;
}

/**
 * Helper function for sffAddDataLink() - gets 'default form' and
 * 'alternate form' relations/properties, and creates the
 * corresponding 'add data' link, for a page, if any such
 * relation/properties are defined
 */
function sffGetAddDataLinkForPage($target_page_title, $page_title, $page_namespace) {
	$form_name = sffGetDefaultForm($page_title, $page_namespace);
	$alt_forms = sffGetAlternateForms($page_title, $page_namespace);
	if (! $form_name && count($alt_forms) == 0)
		return null;
	$ad = SpecialPage::getPage('AddData');
	if ($form_name)
		$add_data_url = $ad->getTitle()->getFullURL() . "/" . $form_name . "/" . sffTitleURLString($target_page_title);
	else
		$add_data_url = $ad->getTitle()->getFullURL() . "/" . sffTitleURLString($target_page_title);
	foreach ($alt_forms as $i => $alt_form) {
		$add_data_url .= ($i == 0) ? "?" : "&";
		$add_data_url .= "alt_form[$i]=$alt_form";
	}
	return $add_data_url;
}

/**
 * Sets the URL for form-based adding of a nonexistent (broken-linked, AKA
 * red-linked) page
 */
function sffSetBrokenLink(&$linker, $title, $query, &$u, &$style, &$prefix, &$text, &$inside, &$trail) {
	$link = sffAddDataLink($title);
	if ($link != '')
		$u = $link;
	return true;
}

function sffAddDataLink($title) {
	// get all properties pointing to this page, and if
	// sffGetAddDataLinkForPage() returns a value with any of
	// them, return that
	$store = smwfGetStore();
	$title_text = sffTitleString($title);
	$value = SMWDataValueFactory::newTypeIDValue('_wpg', $title_text);
	$incoming_properties = $store->getInProperties($value);
	foreach ($incoming_properties as $property) {
		if ($add_data_link = sffGetAddDataLinkForPage($title, $property->getText(), SMW_NS_PROPERTY)) {
			return $add_data_link;
		}
	}

	// if that didn't work, check if this page's namespace
	// has a default form specified
	$namespace = $title->getNsText();
	if ('' === $namespace) {
		// if it's in the main (blank) namespace, check for the file
		// named with the word for "Main" in this language
		$namespace = wfMsgForContent('sf_blank_namespace');
	}
	if ($add_data_link = sffGetAddDataLinkForPage($title, $namespace, NS_PROJECT)) {
		return $add_data_link;
	}
	// if nothing found still, return null
	return null;
}

/**
 * The function called if we're in index.php (as opposed to one of the special
 * pages)
 */
function sffEmbeddedEditForm($action, $article) {
	global $sfgIP;

	// for some reason, the code calling the 'UnknownAction' hook wants
	// "true" if the hook failed, and "false" otherwise... this is
	// probably a bug, but we'll just work with it
	if ($action != 'formedit') {
		return true;
	}

	$form_name = sffGetFormForArticle($article);
	if ($form_name == '') {
		return true;
	}

	$target_title = $article->getTitle();
	$target_name = sffTitleString($target_title);
	if ($target_title->exists()) {
		require_once($sfgIP . '/specials/SF_EditData.php');
		printEditForm($form_name, $target_name);
	} else {
		require_once($sfgIP . '/specials/SF_AddData.php');
		printAddForm($form_name, $target_name, array());
	}
	return false;
}

/**
 * Helper function - gets names of categories for a page;
 * based on Title::getParentCategories(), but simpler
 * - this function doubles as a function to get all categories on the
 * the site, if no article is specified
 */
function sffGetCategoriesForArticle($article = NULL) {
	$fname = 'sffGetCategoriesForArticle()';
	$categories = array();
	$db = wfGetDB( DB_SLAVE );
	$conditions = null;
	if ($article != NULL) {
		$titlekey = $article->mTitle->getArticleId();
		$conditions = "cl_from='$titlekey'";
	}
	$res = $db->select( $db->tableName('categorylinks'),
		'distinct cl_to', $conditions, $fname);
	if ($db->numRows( $res ) > 0) {
		while ($row = $db->fetchRow($res)) {
			$categories[] = $row[0];
		}
	}
	$db->freeResult($res);
	return $categories;
}

/**
 * Get the form used to edit this article: either the default form for a
 * category that this article belongs to (if there is one), or the default
 * form for the article's namespace, if there is one
 */
function sffGetFormForArticle($obj) {
	$categories = sffGetCategoriesForArticle($obj);
	foreach ($categories as $category) {
		if ($form_name = sffGetDefaultForm($category, NS_CATEGORY)) {
			return $form_name;
		}
	}
	// if we're still here, just return the default form for the namespace,
	// which may well be null
	return sffGetDefaultForm($obj->mTitle->getNsText(), NS_PROJECT);
}

/**
 * Return an array of all form names on this wiki
 */
function sffGetAllForms() {
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

function sffFormDropdownHTML() {
	// create a dropdown of possible form names
	global $sfgContLang;
	$namespace_labels = $sfgContLang->getNamespaces();
	$form_label = $namespace_labels[SF_NS_FORM];
	$str = <<<END
		$form_label:
			<select name="form">

END;
	$form_names = sffGetAllForms();
	foreach ($form_names as $form_name) {
		$str .= "			<option>$form_name</option>\n";
	}
	$str .= "			</select>\n";
	return $str;
}

function sffGetMonthNames() {
	return array(
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
}

function sffGetAllPagesForProperty_orig($is_relation, $property_name, $substring = null) {
  global $sfgMaxAutocompleteValues;

  $fname = "sffGetAllPagesForProperty_orig";
  $pages = array();
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
    if ($substring != null)
      $pages[] = array('title' => str_replace('_', ' ', $row[0]));
    else {
      $cur_value = str_replace("'", "\'", $row[0]);
      $pages[] = str_replace('_', ' ', $cur_value);
    }
  }
  $db->freeResult($res);
  return $pages;
}

function sffGetAllPagesForProperty_1_2($property_name, $substring = null) {
	global $sfgMaxAutocompleteValues;

	$store = smwfGetStore();
	$requestoptions = new SMWRequestOptions();
	$requestoptions->limit = $sfgMaxAutocompleteValues;
	if ($substring != null) {
		$requestoptions->addStringCondition($substring, SMWStringCondition::STRCOND_PRE);
	}
	$property = Title::newFromText($property_name, SMW_NS_PROPERTY);
	$data_values = $store->getPropertyValues(null, $property, $requestoptions);
	$pages = array();
	foreach ($data_values as $dv) {
		// getPropertyValues() gets many repeat values - we want
		// only one of each value
		$string_value = str_replace('_', ' ', $dv->getXSDValue());
		$string_value = str_replace("'", "\'", $string_value);
		if (array_search($string_value, $pages) === false)
			$pages[] = $string_value;
	}
	// if there was a substring specified, also find values that have
	// it after a space, not just at the beginning of the value
	if ($substring != null) {
		$requestoptions2 = new SMWRequestOptions();
		$requestoptions2->limit = $sfgMaxAutocompleteValues;
		$requestoptions2->addStringCondition(" $substring", SMWStringCondition::STRCOND_MID);
		$data_values = $store->getPropertyValues(null, $property, $requestoptions2);
		foreach ($data_values as $dv) {
			$pages[] = $dv->getXSDValue();
		}
	}
	return $pages;
}

/*
 * Get all the pages that belong to a category and all its subcategories,
 * down a certain number of levels - heavily based on SMW's
 * SMWInlineQuery::includeSubcategories()
 */
function sffGetAllPagesForCategory($top_category, $num_levels, $substring = null) {
  if (0 == $num_levels) return $top_category;
  global $sfgMaxAutocompleteValues;

  $db = wfGetDB( DB_SLAVE );
  $fname = "sffGetAllPagesForCategory";
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
        $conditions = 'cl_to = '. $db->addQuotes($category) . " AND (LOWER(page_title) LIKE '" . $substring . "%' OR LOWER(page_title) LIKE '%\_" . $substring . "%')";
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
                $pages[] = str_replace("'", "\'", $cur_value);
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

function sffGetAllPagesForNamespace($namespace_name, $substring = null) {
  // cycle through all the namespace names for this language, and if
  // one matches the namespace specified in the form, add the names
  // of all the pages in that namespace to $names_array
  global $wgContLang;
  $namespaces = $wgContLang->getNamespaces();
  $db = wfGetDB( DB_SLAVE );
  $fname = "sffGetAllPagesForNamespace";
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

// Custom sort function, used in sffGetAllProperties()
function cmp($a, $b) {
	if ($a == $b) {
		return 0;
	} elseif ($a < $b) {
		return -1;
	} else {
		return 1;
	}
}

function sffGetAllProperties() {
	$all_properties = array();

	// set limit on results - a temporary fix until SMW's getProperties()
	// functions stop requiring a limit
	global $smwgIP;
	include_once($smwgIP . '/includes/storage/SMW_Store.php');
	$options = new SMWRequestOptions();
	$options->limit = 10000;
	$used_properties = smwfGetStore()->getPropertiesSpecial($options);
	foreach ($used_properties as $property) {
		$property_name = $property[0]->getText();
		$all_properties[$property_name . "::"] = $property_name;
	}
	$unused_properties = smwfGetStore()->getUnusedPropertiesSpecial($options);
	foreach ($unused_properties as $property) {
		$property_name = $property->getText();
		$all_properties[$property_name . "::"] = $property_name;
	}

	// sort properties list alphabetically - custom sort function is needed
	// because the regular sort function destroys the "keys" of the array
	uasort($all_properties, "cmp");
	return $all_properties;
}
