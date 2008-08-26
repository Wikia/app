<?php
/**
 * A special page holding a form that allows the user to create a semantic
 * property (an attribute or relation).
 *
 * @author Yaron Koren
 */

if (!defined('MEDIAWIKI')) die();

class SFCreateProperty extends SpecialPage {

	/**
	 * Constructor
	 */
	function SFCreateProperty() {
		SpecialPage::SpecialPage('CreateProperty');
		wfLoadExtensionMessages('SemanticForms');
	}

	function execute() {
		$this->setHeaders();
		doSpecialCreateProperty();
	}
}

function createPropertyText($property_type, $allowed_values_str) {
	global $smwgContLang;

	$namespace_labels = $smwgContLang->getNamespaces();
	if ($property_type == $namespace_labels[SMW_NS_RELATION]) {
		$text = wfMsgForContent('sf_property_isrelation');
	} else {
		global $smwgContLang;
		$specprops = $smwgContLang->getSpecialPropertiesArray();
		$type_tag = "[[" . $specprops[SMW_SP_HAS_TYPE] .
			"::$property_type|$property_type]]";
		$text = wfMsgForContent('sf_property_isproperty', $type_tag);
		if ($allowed_values_str != '') {
			$text .= "\n\n" . wfMsgForContent('sf_property_allowedvals');
			// replace the comma substitution character that has no chance of
			// being included in the values list - namely, the ASCII beep
			global $sfgListSeparator;
			$allowed_values_str = str_replace("\\$sfgListSeparator", "\a", $allowed_values_str);
			$allowed_values_array = explode($sfgListSeparator, $allowed_values_str);
			foreach ($allowed_values_array as $i => $value) {
				// replace beep with comma, trim
				$value = str_replace("\a", $sfgListSeparator, trim($value));
				$text .= "\n* [[" . $specprops[SMW_SP_POSSIBLE_VALUE] . "::$value]]";
			}
		}
	}
	return $text;
}

function doSpecialCreateProperty() {
	global $wgOut, $wgRequest, $sfgScriptPath;
	global $smwgContLang;

	# cycle through the query values, setting the appropriate local variables
	$property_name = $wgRequest->getVal('property_name');
	$property_type = $wgRequest->getVal('property_type');
	$allowed_values = $wgRequest->getVal('values');

	$save_button_text = wfMsg('savearticle');
	$preview_button_text = wfMsg('preview');

	$property_name_error_str = '';
	$save_page = $wgRequest->getCheck('wpSave');
	$preview_page = $wgRequest->getCheck('wpPreview');
	if ($save_page || $preview_page) {
		# validate property name
		if ($property_name == '') {
			$property_name_error_str = wfMsg('sf_blank_error');
		} else {
			# redirect to wiki interface
			$namespace = SMW_NS_PROPERTY;
			$title = Title::newFromText($property_name, $namespace);
			$full_text = createPropertyText($property_type, $allowed_values);
			// HTML-encode
			$full_text = str_replace('"', '&quot;', $full_text);
			$text = sffPrintRedirectForm($title, $full_text, "", $save_page, $preview_page, false, false, false, null, null);
			$wgOut->addHTML($text);
			return;
		}
	}

	$all_properties = sffGetAllProperties();
	$datatype_labels = $smwgContLang->getDatatypeLabels();

	$javascript_text =<<<END
function toggleAllowedValues() {
	var values_div = document.getElementById("allowed_values");
}

END;

	// set 'title' as hidden field, in case there's no URL niceness
	global $wgContLang;
	$mw_namespace_labels = $wgContLang->getNamespaces();
	$special_namespace = $mw_namespace_labels[NS_SPECIAL];
	$name_label = wfMsg('sf_createproperty_propname');
	$type_label = wfMsg('sf_createproperty_proptype');
	$text =<<<END
	<form action="" method="post">
	<input type="hidden" name="title" value="$special_namespace:CreateProperty">
	<p>$name_label <input size="25" name="property_name" value="">
	<span style="color: red;">$property_name_error_str</span>
	$type_label
	<select id="property_dropdown" name="property_type" onChange="toggleAllowedValues();">
END;
	foreach ($datatype_labels as $label) {
		$text .= "	<option>$label</option>\n";
	}

	$values_input = wfMsg('sf_createproperty_allowedvalsinput');
	$text .=<<<END
	</select>
	<div id="allowed_values" style="margin-bottom: 15px;">
	<p>$values_input</p>
	<p><input size="35" name="values" value=""></p>
	</div>
	<div class="editButtons">
	<input id="wpSave" type="submit" name="wpSave" value="$save_button_text">
	<input id="wpPreview" type="submit" name="wpPreview" value="$preview_button_text">
	</div>
	</form>

END;
	$wgOut->addLink( array(
		'rel' => 'stylesheet',
		'type' => 'text/css',
		'media' => "screen, projection",
		'href' => $sfgScriptPath . "/skins/SF_main.css"
	));
	$wgOut->addScript('<script type="text/javascript">' . $javascript_text . '</script>');
	$wgOut->addHTML($text);
}
