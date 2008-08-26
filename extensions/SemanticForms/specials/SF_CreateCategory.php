<?php
/**
 * A special page holding a form that allows the user to create a category
 * page, with SF forms associated with it
 *
 * @author Yaron Koren
 */

if (!defined('MEDIAWIKI')) die();

class SFCreateCategory extends SpecialPage {

	/**
	 * Constructor
	 */
	function SFCreateCategory() {
		SpecialPage::SpecialPage('CreateCategory');
		wfLoadExtensionMessages('SemanticForms');
	}

	function execute() {
		$this->setHeaders();
		doSpecialCreateCategory();
	}
}

function createCategoryText($default_form, $category_name, $parent_category) {
	global $sfgContLang;

	if ($default_form == '') {
		$text = wfMsgForContent('sf_category_desc', $category_name);
	} else {
		$namespace_labels = $sfgContLang->getNamespaces();
		$form_label = $namespace_labels[SF_NS_FORM];
		$specprops = $sfgContLang->getSpecialPropertiesArray();
		$form_tag = "[[" . $specprops[SF_SP_HAS_DEFAULT_FORM] .
			"::$form_label:$default_form|$default_form]]";
		$text = wfMsgForContent('sf_category_hasdefaultform', $form_tag);
	}
	if ($parent_category != '') {
		global $wgContLang;
		$namespace_labels = $wgContLang->getNamespaces();
		$category_namespace = $namespace_labels[NS_CATEGORY];
		$text .= "\n\n[[$category_namespace:$parent_category]]";
	}
	return $text;
}

function doSpecialCreateCategory() {
	global $wgOut, $wgRequest, $wgUser, $sfgScriptPath;

	# cycle through the query values, setting the appropriate local variables
	$category_name = $wgRequest->getVal('category_name');
	$default_form = $wgRequest->getVal('default_form');
	$parent_category = $wgRequest->getVal('parent_category');

	$save_button_text = wfMsg('savearticle');
	$preview_button_text = wfMsg('preview');
	$category_name_error_str = '';
	$save_page = $wgRequest->getCheck('wpSave');
	$preview_page = $wgRequest->getCheck('wpPreview');
	if ($save_page || $preview_page) {
		# validate category name
		if ($category_name == '') {
			$category_name_error_str = wfMsg('sf_blank_error');
		} else {
			# redirect to wiki interface
			$namespace = NS_CATEGORY;
			$title = Title::newFromText($category_name, $namespace);
			$full_text = createCategoryText($default_form, $category_name, $parent_category);
			// HTML-encode
			$full_text = str_replace('"', '&quot;', $full_text);
			$text = sffPrintRedirectForm($title, $full_text, "", $save_page, $preview_page, false, false, false, null, null);
			$wgOut->addHTML($text);
			return;
		}
	}

	$all_forms = sffGetAllForms();

	// set 'title' as hidden field, in case there's no URL niceness
	global $wgContLang;
	$mw_namespace_labels = $wgContLang->getNamespaces();
	$special_namespace = $mw_namespace_labels[NS_SPECIAL];
	$name_label = wfMsg('sf_createcategory_name');
	$form_label = wfMsg('sf_createcategory_defaultform');
	$text =<<<END
	<form action="" method="get">
	<input type="hidden" name="title" value="$special_namespace:CreateCategory">
	<p>$name_label <input size="25" name="category_name" value="">
	<span style="color: red;">$category_name_error_str</span>
	$form_label
	<select id="form_dropdown" name="default_form">
	<option></option>

END;
	foreach ($all_forms as $form) {
		$text .= "	<option>$form</option>\n";
	}

	$subcategory_label = wfMsg('sf_createcategory_makesubcategory');
	$categories = sffGetCategoriesForArticle();
	$sk = $wgUser->getSkin();
	$cf = SpecialPage::getPage('CreateForm');
	$create_form_link = $sk->makeKnownLinkObj($cf->getTitle(), $cf->getDescription());
	$text .=<<<END
	</select>
	<p>$subcategory_label
	<select id="category_dropdown" name="parent_category">
	<option></option>

END;
	foreach ($categories as $category) {
		$category = str_replace('_', ' ', $category);
		$text .= "	<option>$category</option>\n";
	}
	$text .=<<<END
	</select>
	</p>
	<div class="editButtons">
	<input type="submit" id="wpSave" name="wpSave" value="$save_button_text"></p>
	<input type="submit" id="wpPreview" name="wpPreview" value="$preview_button_text"></p>
	</div>
	<br /><hr /<br />
	<p>$create_form_link.</p>

END;

	$text .= "	</form>\n";

	$wgOut->addLink( array(
		'rel' => 'stylesheet',
		'type' => 'text/css',
		'media' => "screen, projection",
		'href' => $sfgScriptPath . "/skins/SF_main.css"
	));
	$wgOut->addHTML($text);
}
