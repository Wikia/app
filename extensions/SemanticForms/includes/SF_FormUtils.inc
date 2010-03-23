<?php
/**
 * Javascript- and HTML-creation utilities for the display of a form
 *
 * @author Yaron Koren
 * @author Jeffrey Stuckman
 * @author Harold Solbrig
 * @author Eugene Mednikov
 */

class SFFormUtils {

	static function chooserJavascript() {
		$javascript_text = <<<END
<script type="text/javascript">/* <![CDATA[ */

function updatechooserbutton(f,n)
{
	document.getElementById(n).disabled = (f.options[f.selectedIndex].value=="invalid");
}

function addInstanceFromChooser(chooserid)
{
	var chooser = document.getElementById(chooserid);
	var optionstring = chooser.options[chooser.selectedIndex].value;
	var pos = optionstring.indexOf(",");
	var tabindex = optionstring.substr(0,pos);
	var chooservalue = optionstring.substr(pos+1);
	addInstance('starter_' + chooservalue, 'main_' + chooservalue, parseInt(tabindex));
}

//The fieldset containing the given element was just updated. If the fieldset is associated with a chooser,
//ensure that the fieldset is hidden if and only if there are no template instances inside.
function hideOrShowFieldset(element)
{
	//Find fieldset
	while (element.tagName.toLowerCase() != "fieldset")
		element = element.parentNode;
	//Bail out if fieldset is not part of chooser
	if (!element.getAttribute("haschooser"))
		return;
	//Now look for "input" or "select" tags that don't look like they're part of the starter template
	var inputs = element.getElementsByTagName("input");
	var x;
	var show = false;
	for (x=0;x<inputs.length;x++)
	{
		if (inputs[x].type=="text" && inputs[x].name.indexOf("[num]") == -1)
			show = true;
	}
	var selects = element.getElementsByTagName("select");
	for (x=0;x<selects.length;x++)
	{
		if (selects[x].name.indexOf("[num]") == -1)
			show = true;
	}
	//Now show or hide fieldset
	element.style.display = (show?"block":"none");
}
/* ]]> */ </script>

END;
		return $javascript_text;
	}

	/**
	 * All the Javascript calls to validate both the type of each
	 * form field and their presence, for mandatory fields
	 */
	static function validationJavascript() {
		global $sfgJSValidationCalls;

		$form_errors_header = Xml::escapeJsString(wfMsg('sf_formerrors_header'));
		$blank_error_str = Xml::escapeJsString(wfMsg('sf_blank_error'));
		$bad_url_error_str = Xml::escapeJsString(wfMsg('sf_bad_url_error'));
		$bad_email_error_str = Xml::escapeJsString(wfMsg('sf_bad_email_error'));
		$bad_number_error_str = Xml::escapeJsString(wfMsg('sf_bad_number_error'));
		$bad_integer_error_str = Xml::escapeJsString(wfMsg('sf_bad_integer_error'));
		$bad_date_error_str = Xml::escapeJsString(wfMsg('sf_bad_date_error'));

		$javascript_text =<<<END

function validate_mandatory_field(field_id, info_id) {
	field = document.getElementById(field_id);
	if (field.value.replace(/\s+/, '') == '') {
		infobox = document.getElementById(info_id);
		infobox.innerHTML = "$blank_error_str";
		return false;
	} else {
		return true;
	}
}

// special handling for radiobuttons, because what's being checked
// is the first radiobutton, which has value of "None"
function validate_mandatory_radiobutton(none_button_id, info_id) {
	none_button = document.getElementById(none_button_id);
	if (none_button && none_button.checked) {
		infobox = document.getElementById(info_id);
		infobox.innerHTML = "$blank_error_str";
		return false;
	} else {
		return true;
	}
}

function validate_mandatory_checkboxes(field_id, info_id) {
	elems = document.getElementsByTagName("*");
	var all_fields_unchecked = true;
	for (var i = 0; i < elems.length; i++) {
		if (elems[i].id == field_id) {
			if (elems[i].checked) {
				all_fields_unchecked = false;
			}
		}
	}
	if (all_fields_unchecked) {
		infobox = document.getElementById(info_id);
		infobox.innerHTML = "$blank_error_str";
		return false;
	} else {
		return true;
	}
}

// validate a mandatory field that exists across multiple instances of
// a template - we have to find each one, matching on the pattern of its
// ID, and validate it
function validate_multiple_mandatory_fields(field_num) {
	var num_errors = 0;
	elems = document.getElementsByTagName("*");
	var field_pattern = new RegExp('input_(.*)_' + field_num);
	for (var i = 0; i < elems.length; i++) {
		id = elems[i].id;
		if (matches = field_pattern.exec(id)) {
			instance_num = matches[1];
			var input_name = "input_" + instance_num + "_" + field_num;
			var info_name = "info_" + instance_num + "_" + field_num;
			if (! validate_mandatory_field(input_name, info_name)) {
				num_errors += 1;
			}
		}
	}
	return (num_errors == 0);
}

function validate_field_type(field_id, type, info_id) {
	field = document.getElementById(field_id);
	if (type != 'date' && field.value == '') {
		return true;
	} else {
		if (type == 'URL') {
			// code borrowed from http://snippets.dzone.com/posts/show/452
			var url_regexp = /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/;
			if (url_regexp.test(field.value)) {
				return true;
			} else {
				infobox = document.getElementById(info_id);
				infobox.innerHTML = "$bad_url_error_str";
				return false;
			}
		} else if (type == 'email') {
			// code borrowed from http://javascript.internet.com/forms/email-validation---basic.html
			var email_regexp = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,6})+$/;
			if (email_regexp.test(field.value)) {
				return true;
			} else {
				infobox = document.getElementById(info_id);
				infobox.innerHTML = "$bad_email_error_str";
				return false;
			}
		} else if (type == 'number') {
			if (field.value.match(/^\-?[\d\.,]+$/)) {
				return true;
			} else {
				infobox = document.getElementById(info_id);
				infobox.innerHTML = "$bad_number_error_str";
				return false;
			}
		} else if (type == 'date') {
			// validate only if day and year fields are both filled in
			day_field = document.getElementById(field_id + "_day");
			year_field = document.getElementById(field_id + "_year");
			if (day_field.value == '' || year_field.value == '') {
				return true;
			} else if (day_field.value.match(/^\d+$/) &&
				day_field.value <= 31) {
				// no year validation, since it can also include
				// 'BC' and possibly other non-number strings
				return true;
			} else {
				infobox = document.getElementById(info_id);
				infobox.innerHTML = "$bad_date_error_str";
				return false;
			}
		} else {
			return true;
		}
	}
}

// same as validate_multiple_mandatory_fields(), but for type validation
function validate_type_of_multiple_fields(field_num, type) {
	var num_errors = 0;
	elems = document.getElementsByTagName("*");
	var field_pattern = new RegExp('input_(.*)_' + field_num);
	for (var i = 0; i < elems.length; i++) {
		id = elems[i].id;
		if (matches = field_pattern.exec(id)) {
			instance_num = matches[1];
			var input_name = "input_" + instance_num + "_" + field_num;
			var info_name = "info_" + instance_num + "_" + field_num;
			if (! validate_field_type(input_name, type, info_name)) {
				num_errors += 1;
			}
		}
	}
	return (num_errors == 0);
}


function validate_all() {
	var num_errors = 0;

END;
		foreach ($sfgJSValidationCalls as $function_call) {
			$javascript_text .= "	if (! $function_call) num_errors += 1;\n";
		}
		$javascript_text .=<<<END
	if (num_errors > 0) {
		// add error header, if it's not there already
		if (! document.getElementById("form_error_header")) {
			var errorMsg = document.createElement('div');
			errorMsg.innerHTML = "<div id=\"form_error_header\" class=\"warningMessage\" style=\"font-size: medium\">$form_errors_header</div>";
			document.getElementById("contentSub").appendChild(errorMsg);
		}
		scroll(0, 0);
	}
	return (num_errors == 0);
}

END;
		return $javascript_text;
	}

	static function instancesJavascript($using_choosers) {
		$remove_text = wfMsg('sf_formedit_remove');
		$javascript_text =<<<END

var num_elements = 0;

function addInstance(starter_div_id, main_div_id, tab_index)
{
	var starter_div = document.getElementById(starter_div_id);
	var main_div = document.getElementById(main_div_id);
	num_elements++;
	
	//Create the new instance
	var new_div = starter_div.cloneNode(true);
	var div_id = 'div_gen_' + num_elements;
	new_div.className = 'multipleTemplate';
	new_div.id = div_id;
	new_div.style.display = 'block';
	
	// make internal ID unique for the relevant divs and spans, and replace
	// the [num] index in the element names with an actual unique index
	var children = new_div.getElementsByTagName('*');
	// this array is needed to counteract an IE bug
	var orig_children = starter_div.getElementsByTagName('*');
	var x;
	for (x = 0; x < children.length; x++) {
		if (children[x].name)
			children[x].name = children[x].name.replace(/\[num\]/g, '[' + num_elements + ']');
		if (children[x].id)
			children[x].id = children[x].id
				.replace(/input_/g, 'input_' + num_elements + '_')
				.replace(/info_/g, 'info_' + num_elements + '_')
				.replace(/div_/g, 'div_' + num_elements + '_');
		if (children[x].href)
			children[x].href = children[x].href
				.replace(/input_/g, 'input_' + num_elements + '_');
		// for dropdowns, copy over selectedIndex from original div,
		// to get around a bug in IE
		if (children[x].type == 'select-one') {
			children[x].selectedIndex = orig_children[x].selectedIndex;
		}
	}
	if (children[x]) {
		//We clone the last object
		if (children[x].href) {
			children[x].href = children[x].href
				.replace(/input_/g, 'input_' + num_elements + '_')
				.replace(/info_/g, 'info_' + num_elements + '_')
				.replace(/div_/g, 'div_' + num_elements + '_');
		}
	}
	// Since we clone the first object and we have uploadable field
	// we must replace the input_ in order to let the printer return
	// the value into the right field
	//Create remove button
	var remove_button = document.createElement('input');
	remove_button.type = 'button';
	remove_button.value = "$remove_text";
	remove_button.tabIndex = tab_index;
	remove_button.onclick = removeInstanceEventHandler(div_id);
	new_div.appendChild(remove_button);
	
	//Add the new instance
	main_div.appendChild(new_div);
	attachAutocompleteToAllFields(new_div);
	
	//In order to add the new instances in multiple floatBox (multiple templates)
	fb.tagAnchors(self.document);
	if ($using_choosers) {
		hideOrShowFieldset(new_div);
	}
}

function removeInstanceEventHandler(this_div_id)
{
	return function() {
		removeInstance(this_div_id);
	};
}

function removeInstance(div_id) {
	var olddiv = document.getElementById(div_id);
	var parent = olddiv.parentNode;
	parent.removeChild(olddiv);
	if ($using_choosers)
		hideOrShowFieldset(parent);
}

END;
		return $javascript_text;
	}

	static function autocompletionJavascript() {
		global $wgScriptPath;

		$javascript_text =<<<END
var autocompletemappings = new Array();
var autocompletestrings = new Array();
var autocompletedatatypes = new Array();

//Activate autocomplete functionality for every field on the document
function attachAutocompleteToAllDocumentFields()
{
	var forms = document.getElementsByTagName("form");
	var x;
	for (x = 0; x < forms.length; x++) {
		if (forms[x].name == "createbox") {
			attachAutocompleteToAllFields(forms[x]);
		}	
	}
}

//Activate autocomplete functionality for every field under the specified element
function attachAutocompleteToAllFields(base)
{
	var inputs = base.getElementsByTagName("input");
	var y;
	for (y = 0; y < inputs.length; y++) {
		attachAutocompleteToField(inputs[y].id);
	}
	// don't forget the textareas
	inputs = base.getElementsByTagName("textarea");
	for (y = 0; y < inputs.length; y++) {
		attachAutocompleteToField(inputs[y].id);
	}
}

//Activate autocomplete functionality for the specified field
function attachAutocompleteToField(input_id)
{
	//Check input id for the proper format, to ensure this is for SF
	if (input_id.substr(0,6) == 'input_')
	{
		//Extract the field ID number from the input field
		var field_num = parseInt(input_id.substring(input_id.lastIndexOf('_') + 1, input_id.length),10);
		//Add the autocomplete string, if a mapping exists.
		var field_string = autocompletemappings[field_num];
		if (field_string) {
			var div_id = input_id.replace(/input_/g, 'div_');
			var field_values = new Array();
			field_values = field_string.split(',');
			var delimiter = null;
			var data_source = field_values[0];
			if (field_values[1] == 'list') {
				delimiter = ",";
				if (field_values[2] != null) {
					delimiter = field_values[2];
				}
			}
			if (autocompletestrings[field_string] != null) {
				sf_autocomplete(input_id, div_id, autocompletestrings[field_string], null, null, delimiter, data_source);
			} else {
				sf_autocomplete(input_id, div_id, null, "{$wgScriptPath}/api.php", autocompletedatatypes[field_string], delimiter, data_source);
			}
		}
	}
}

YAHOO.util.Event.addListener(window, 'load', attachAutocompleteToAllDocumentFields);

END;
		return $javascript_text;
	}

	static function hiddenFieldHTML($input_name, $cur_value) {
		$input = self::buttonHTML(array(
			'type' => 'hidden',
			'name' => $input_name,
			'value' => $cur_value,
		));
		return <<<END
	$input

END;
	}

	/**
	 * Add a hidden input for each field in the template call that's
	 * not handled by the form itself
	 */
	static function unhandledFieldsHTML($template_contents) {
		$text = "";
		foreach ($template_contents as $key => $value) {
			if ($key != '' && !is_numeric($key))
				$text .= self::hiddenFieldHTML("_unhandled_$key", $value);
		}
		return $text;
	}

	/**
	 * Add unhandled fields back into the template call that the form
	 * generates, so that editing with a form will have no effect on them
	 */
	static function addUnhandledFields() {
		global $wgRequest;
		$additional_template_text = "";
		foreach ($wgRequest->getValues() as $key => $value) {
			if (substr($key, 0, 11) == '_unhandled_') {
				$field_name = substr($key, 11);
				$additional_template_text .= "|$field_name=$value\n";
			}
		}
		return $additional_template_text;
	}

	static function summaryInputHTML($is_disabled, $label = null, $attr = array()) {
		global $sfgTabIndex;

		$sfgTabIndex++;
		if ($label == null)
			$label = wfMsg('summary');
		$disabled_text = ($is_disabled) ? " disabled" : "";
		$attr = Xml::expandAttributes($attr);
		$text =<<<END
	<span id='wpSummaryLabel'><label for='wpSummary'>$label</label></span>
	<input tabindex="$sfgTabIndex" type='text' value="" name='wpSummary' id='wpSummary' maxlength='200' size='60'$disabled_text$attr/>

END;
		return $text;
	}

	static function minorEditInputHTML($is_disabled, $label = null, $attr = array()) {
		global $sfgTabIndex;

		$sfgTabIndex++;
		$disabled_text = ($is_disabled) ? " disabled" : "";
		if ($label == null)
			$label = wfMsgExt('minoredit', array('parseinline'));
		$accesskey = wfMsg('accesskey-minoredit');
		$tooltip = wfMsg('tooltip-minoredit');
		$attr = Xml::expandAttributes($attr);
		$text =<<<END
	<input tabindex="$sfgTabIndex" type="checkbox" value="1" name="wpMinoredit" accesskey="$accesskey" id="wpMinoredit"$disabled_text$attr/>
	<label for="wpMinoredit" title="$tooltip">$label</label>

END;
		return $text;
	}

	static function watchInputHTML($is_disabled, $label = null, $attr = array()) {
		global $sfgTabIndex, $wgUser, $wgTitle;

		$sfgTabIndex++;
		$checked_text = "";
		$disabled_text = ($is_disabled) ? " disabled" : "";
		// figure out if the checkbox should be checked - 
		// this code borrowed from /includes/EditPage.php
		if ($wgUser->getOption('watchdefault')) {
			# Watch all edits
			$checked_text = " checked";
		} elseif ($wgUser->getOption('watchcreations') && !$wgTitle->exists() ) {
			# Watch creations
			$checked_text = " checked";
		} elseif ($wgTitle->userIsWatching()) {
			# Already watched
			$checked_text = " checked";
		}
		if ($label == null)
			$label = wfMsgExt('watchthis', array('parseinline'));
		$accesskey = htmlspecialchars(wfMsg('accesskey-watch'));
		$tooltip = htmlspecialchars(wfMsg('tooltip-watch'));
		$attr = Xml::expandAttributes($attr);
		$text =<<<END
	<input tabindex="$sfgTabIndex" type="checkbox" name="wpWatchthis" accesskey="$accesskey" id='wpWatchthis'$checked_text$disabled_text$attr/>
	<label for="wpWatchthis" title="$tooltip">$label</label>

END;
		return $text;
	}

	/**
	 * Helper function to display a simple button
	 */
	static function buttonHTML($values) {
		$button_html = Xml::element('input', $values, '');
		return "		$button_html\n";
	}

	static function saveButtonHTML($is_disabled, $label = null, $attr = array()) {
		global $sfgTabIndex;

		$sfgTabIndex++;
		$disabled_text = ($is_disabled) ? "disabled" : "";
		if ($label == null)
			$label = wfMsg('savearticle');
		$temp = $attr + array(
			'id'        => 'wpSave',
			'name'      => 'wpSave',
			'type'      => 'submit',
			'tabindex'  => $sfgTabIndex,
			'value'     => $label,
			'accesskey' => wfMsg('accesskey-save'),
			'title'     => wfMsg('tooltip-save'),
			$disabled_text => '',
		);
		return self::buttonHTML($temp);
	}

	static function showPreviewButtonHTML($is_disabled, $label = null, $attr = array()) {
		global $sfgTabIndex;

		$sfgTabIndex++;
		$disabled_text = ($is_disabled) ? "disabled" : "";
		if ($label == null)
			$label = wfMsg('showpreview');
		$temp = $attr + array(
			'id'        => 'wpPreview',
			'name'      => 'wpPreview',
			'type'      => 'submit',
			'tabindex'  => $sfgTabIndex,
			'value'     => $label,
			'accesskey' => wfMsg('accesskey-preview'),
			'title'     => wfMsg('tooltip-preview'),
			$disabled_text => '',
		);
		return self::buttonHTML($temp);
	}

	static function showChangesButtonHTML($is_disabled, $label = null, $attr = array()) {
		global $sfgTabIndex;

		$sfgTabIndex++;
		$disabled_text = ($is_disabled) ? "disabled" : "";
		if ($label == null)
			$label = wfMsg('showdiff');
		$temp = $attr + array(
			'id'        => 'wpDiff',
			'name'      => 'wpDiff',
			'type'      => 'submit',
			'tabindex'  => $sfgTabIndex,
			'value'     => $label,
			'accesskey' => wfMsg('accesskey-diff'),
			'title'     => wfMsg('tooltip-diff'),
			$disabled_text => '',
		);
		return self::buttonHTML($temp);
	}

	static function cancelLinkHTML($is_disabled, $label = null, $attr = array()) {
		global $wgUser, $wgTitle;

		$sk = $wgUser->getSkin();
		if ($label == null)
			$label = wfMsgExt('cancel', array('parseinline'));
		if ($wgTitle == null)
			$cancel = '';
		// if we're on the special 'FormEdit' page, just send the user
		// back to the previous page they were on
		elseif ($wgTitle->getText() == 'FormEdit'
			 && $wgTitle->getNamespace() == NS_SPECIAL) {
			$cancel = '<a href="javascript:history.go(-1);">' . $label . '</a>';
		} else
			$cancel = $sk->makeKnownLink( $wgTitle->getPrefixedText(), $label);
		$text = "		<span class='editHelp'>$cancel</span>\n";
		return $text;
	}
	
	static function runQueryButtonHTML($is_disabled = false, $label = null, $attr = array()) {
		// is_disabled is currently ignored
		global $sfgTabIndex;

		$sfgTabIndex++;
		$disabled_text = ($is_disabled) ? "disabled" : "";
		if ($label == null)
			$label = wfMsg('runquery');
		return self::buttonHTML($attr + array(
			'id'        => 'wpRunQuery',
			'name'      => 'wpRunQuery',
			'type'      => 'submit',
			'tabindex'  => $sfgTabIndex,
			'value'     => $label,
			'title'     => $label,
		));
	}

	// Much of this function is based on MediaWiki's EditPage::showEditForm()
	static function formBottom($is_disabled) {
		global $wgUser;

		$summary_text = SFFormUtils::summaryInputHTML($is_disabled);
		$text =<<<END
	<br /><br />
	<div class='editOptions'>
$summary_text	<br />

END;
		if ( $wgUser->isAllowed('minoredit') ) {
			$text .= SFFormUtils::minorEditInputHTML($is_disabled);
		}

		if ( $wgUser->isLoggedIn() ) {
			$text .= SFFormUtils::watchInputHTML($is_disabled);
		}

		$text .=<<<END
	<br />
	<div class='editButtons'>

END;
		$text .= SFFormUtils::saveButtonHTML($is_disabled);
		$text .= SFFormUtils::showPreviewButtonHTML($is_disabled);
		$text .= SFFormUtils::showChangesButtonHTML($is_disabled);
		$text .= SFFormUtils::cancelLinkHTML($is_disabled);
		$text .=<<<END
	</div><!-- editButtons -->
	</div><!-- editOptions -->

END;
		return $text;
	}

	// based on MediaWiki's EditPage::getPreloadedText()
	static function getPreloadedText($preload) {
		if ( $preload === '' ) {
			return '';
		} else {
			$preloadTitle = Title::newFromText( $preload );
			if ( isset( $preloadTitle ) && $preloadTitle->userCanRead() ) {
				$rev = Revision::newFromTitle($preloadTitle);
				if ( is_object( $rev ) ) {
					$text = $rev->getText();
					// Remove <noinclude> sections and <includeonly> tags from text
					$text = StringUtils::delimiterReplace('<noinclude>', '</noinclude>', '', $text);
					$text = strtr($text, array('<includeonly>' => '', '</includeonly>' => ''));
					return $text;
				}
			}
			return '';
		}
	} 

	/**
	 * Used by 'RunQuery' page
	 */
	static function queryFormBottom() {
		return self::runQueryButtonHTML( false );
	}

	static function getMonthNames() {
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

	static function getShowFCKEditor() {
		global $wgUser, $wgDefaultUserOptions;

		$showFCKEditor = 0;
		if ( !$wgUser->getOption( 'riched_start_disabled', $wgDefaultUserOptions['riched_start_disabled'] ) ) {
			$showFCKEditor += RTE_VISIBLE;
		}
		if ( $wgUser->getOption( 'riched_use_popup', $wgDefaultUserOptions['riched_use_popup'] ) ) {
			$showFCKEditor += RTE_POPUP;
		}
		if ( $wgUser->getOption( 'riched_use_toggle', $wgDefaultUserOptions['riched_use_toggle'] ) ) {
			$showFCKEditor += RTE_TOGGLE_LINK;
		}

		if( (!empty($_SESSION['showMyFCKeditor'])) && ($wgUser->getOption( 'riched_toggle_remember_state' )))
		{
			//clear RTE_VISIBLE flag
			$showFCKEditor &= ~RTE_VISIBLE ;
			//get flag from session
			$showFCKEditor |= $_SESSION['showMyFCKeditor'] ;			
		}
		return $showFCKEditor;
	}

	static function prepareTextForFCK($text) {
		global $wgTitle;

		$options = new FCKeditorParserOptions();
		$options->setTidy(true);
		$parser = new FCKeditorParser();
		$parser->setOutputType(OT_HTML);
		$text = $parser->parse($text, $wgTitle, $options)->getText();
		return $text;
	}

	static function mainFCKJavascript($showFCKEditor) {
		global $wgUser, $wgScriptPath, $wgFCKEditorExtDir, $wgFCKEditorDir, $wgFCKEditorToolbarSet, $wgFCKEditorHeight;

		$newWinMsg = wfMsg('rich_editor_new_window');
		$javascript_text = '
var showFCKEditor = '. $showFCKEditor .';
var popup = false;		//pointer to popup document
var firstLoad = true;
var editorMsgOn = "'. wfMsg( 'textrichditor' ) .'";
var editorMsgOff = "'. wfMsg( 'tog-riched_disable' ) .'";
var editorLink = "'. (($showFCKEditor & RTE_VISIBLE)? wfMsg( 'tog-riched_disable' ): wfMsg( 'textrichditor' )) .'";		
var saveSetting = '. ($wgUser->getOption( 'riched_toggle_remember_state' ) ?  1 : 0) .';
var RTE_VISIBLE = '.RTE_VISIBLE.';
var RTE_TOGGLE_LINK = '.RTE_TOGGLE_LINK.';
var RTE_POPUP = '.RTE_POPUP.';
';		
		
		$javascript_text .= <<<END
var oFCKeditor = new FCKeditor( "free_text" );

//Set config
oFCKeditor.BasePath = '$wgScriptPath/$wgFCKEditorDir/';
oFCKeditor.Config["CustomConfigurationsPath"] = "$wgScriptPath/$wgFCKEditorExtDir/fckeditor_config.js" ;
oFCKeditor.Config["EditorAreaCSS"] = "$wgScriptPath/$wgFCKEditorExtDir/css/fckeditor.css" ;
oFCKeditor.ToolbarSet = "$wgFCKEditorToolbarSet" ; 
oFCKeditor.ready = true;

//IE hack to call func from popup
function FCK_sajax(func_name, args, target) {
	sajax_request_type = 'POST' ;
	sajax_do_call(func_name, args, function (x) {
		// I know this is function, not object
		target(x);
		}
	);
}

function onLoadFCKeditor()
{
	if (!(showFCKEditor & RTE_VISIBLE)) 
		showFCKEditor += RTE_VISIBLE;
	firstLoad = false;
	realTextarea = document.getElementById('free_text');
	if ( realTextarea )
	{
		// Create the editor instance and replace the textarea.
		oFCKeditor.Height = 300;
		oFCKeditor.ReplaceTextarea() ;
		
		FCKeditorInsertTags = function (tagOpen, tagClose, sampleText, oDoc)
		{
			var txtarea;

			if ( !(typeof(oDoc.FCK) == "undefined") && !(typeof(oDoc.FCK.EditingArea) == "undefined") )
			{
				txtarea = oDoc.FCK.EditingArea.Textarea ;
			}
			else if (oDoc.editform)
			{
				// if we have FCK enabled, behave differently...
				if ( showFCKEditor & RTE_VISIBLE )
				{
					SRCiframe = oDoc.getElementById ('free_text___Frame') ;
					if ( SRCiframe )
					{
						if (window.frames[SRCiframe])
							SRCdoc = window.frames[SRCiframe].oDoc ;
						else
							SRCdoc = SRCiframe.contentDocument ;
							
						var SRCarea = SRCdoc.getElementById ('xEditingArea').firstChild ;
						
						if (SRCarea)
							txtarea = SRCarea ;
						else
							return false ;
							
					} 
					else 
					{
						return false ;
					}
				}
				else
				{
					txtarea = oDoc.editform.free_text ;
				}
			}
			else
			{
				// some alternate form? take the first one we can find
				var areas = oDoc.getElementsByTagName( 'textarea' ) ;
				txtarea = areas[0] ;
			}

			var selText, isSample = false ;

			if ( oDoc.selection  && oDoc.selection.createRange ) 
			{ // IE/Opera

				//save window scroll position
				if ( oDoc.documentElement && oDoc.documentElement.scrollTop )
					var winScroll = oDoc.documentElement.scrollTop ;
				else if ( oDoc.body )
					var winScroll = oDoc.body.scrollTop ;

				//get current selection
				txtarea.focus() ;
				var range = oDoc.selection.createRange() ;
				selText = range.text ;
				//insert tags
				checkSelected();
				range.text = tagOpen + selText + tagClose ;
				//mark sample text as selected
				if ( isSample && range.moveStart )
				{
					if (window.opera)
						tagClose = tagClose.replace(/\\n/g,'') ; //check it out one more time
					range.moveStart('character', - tagClose.length - selText.length) ;
					range.moveEnd('character', - tagClose.length) ;
				}
				range.select();
				//restore window scroll position
				if ( oDoc.documentElement && oDoc.documentElement.scrollTop )
					oDoc.documentElement.scrollTop = winScroll ;
				else if ( oDoc.body )
					oDoc.body.scrollTop = winScroll ;

			} 
			else if ( txtarea.selectionStart || txtarea.selectionStart == '0' ) 
			{ // Mozilla

				//save textarea scroll position
				var textScroll = txtarea.scrollTop ;
				//get current selection
				txtarea.focus() ;
				var startPos = txtarea.selectionStart ;
				var endPos = txtarea.selectionEnd ;
				selText = txtarea.value.substring( startPos, endPos ) ;
				
				//insert tags
				if (!selText) 
				{
					selText = sampleText ;
					isSample = true ;
				} 
				else if (selText.charAt(selText.length - 1) == ' ')
				{ //exclude ending space char
					selText = selText.substring(0, selText.length - 1) ;
					tagClose += ' ' ;
				}
				txtarea.value = txtarea.value.substring(0, startPos) + tagOpen + selText + tagClose + 
								txtarea.value.substring(endPos, txtarea.value.length) ;
				//set new selection
				if (isSample) 
				{
					txtarea.selectionStart = startPos + tagOpen.length ;
					txtarea.selectionEnd = startPos + tagOpen.length + selText.length ;
				} 
				else 
				{
					txtarea.selectionStart = startPos + tagOpen.length + selText.length + tagClose.length ;
					txtarea.selectionEnd = txtarea.selectionStart;
				}
				//restore textarea scroll position
				txtarea.scrollTop = textScroll;
			}
		}
	}
}
function checkSelected()
{
	if (!selText) {
		selText = sampleText;
		isSample = true;
	} else if (selText.charAt(selText.length - 1) == ' ') { //exclude ending space char
		selText = selText.substring(0, selText.length - 1);
		tagClose += ' '
	} 
}
function initEditor()
{	
	var toolbar = document.getElementById('free_text');
	//show popup or toogle link
	if (showFCKEditor & (RTE_POPUP|RTE_TOGGLE_LINK)){
		var fckTools = document.createElement('div');
		fckTools.setAttribute('id', 'fckTools');
		
		var SRCtextarea = document.getElementById( "free_text" ) ;
		if (showFCKEditor & RTE_VISIBLE) SRCtextarea.style.display = "none";
	}

	if (showFCKEditor & RTE_TOGGLE_LINK)
	{
		fckTools.innerHTML='[<a class="fckToogle" id="toggle_free_text" href="javascript:void(0)" onclick="ToggleFCKEditor(\'toggle\',\'free_text\')">'+ editorLink +'</a>] ';
	}
	if (showFCKEditor & RTE_POPUP)
	{
		var style = (showFCKEditor & RTE_VISIBLE) ? 'style="display:none"' : "";
		fckTools.innerHTML+='<span ' + style + ' id="popup_free_text">[<a class="fckPopup" href="javascript:void(0)" onclick="ToggleFCKEditor(\'popup\',\'free_text\')">{$newWinMsg}</a>]</span>';
	}

	if (showFCKEditor & (RTE_POPUP|RTE_TOGGLE_LINK)){
		//add new toolbar before wiki toolbar
		toolbar.parentNode.insertBefore( fckTools, toolbar );
	}

	if (showFCKEditor & RTE_VISIBLE)
	{
		if ( toolbar )		//insert wiki buttons
		{
			mwSetupToolbar = function() { return false ; } ;

			for (var i = 0; i < mwEditButtons.length; i++) {
				mwInsertEditButton(toolbar, mwEditButtons[i]);
			}
			for (var i = 0; i < mwCustomEditButtons.length; i++) {
				mwInsertEditButton(toolbar, mwCustomEditButtons[i]);
			}
		}
		onLoadFCKeditor();
	}
	return true;
}
addOnloadHook( initEditor );

END;
		return $javascript_text;
	}

	static function FCKToggleJavascript() {
		//add toggle link and handler
		$javascript_text = <<<END

function ToggleFCKEditor(mode, objId)
{
	var SRCtextarea = document.getElementById( objId ) ;
	if(mode == 'popup'){
		if (( showFCKEditor & RTE_VISIBLE) && ( FCKeditorAPI ))	//if FCKeditor is up-to-date
		{
			var oEditorIns = FCKeditorAPI.GetInstance( objId );
			var text = oEditorIns.GetData( oEditorIns.Config.FormatSource );
			SRCtextarea.value = text;			//copy text to textarea
		}
		FCKeditor_OpenPopup('oFCKeditor',objId);
		return true;
	}
	
	var oToggleLink = document.getElementById('toggle_'+ objId );
	var oPopupLink = document.getElementById('popup_'+ objId );

	if ( firstLoad )
	{
		// firstLoad = true => FCKeditor start invisible
		// "innerHTML" fails for IE - use "innerText" instead
		if (oToggleLink) {
			if (oToggleLink.innerText)
				oToggleLink.innerText = "Loading...";
			else
				oToggleLink.innerHTML = "Loading...";
		}
		sajax_request_type = 'POST' ;
		oFCKeditor.ready = false;
		sajax_do_call('wfSajaxWikiToHTML', [SRCtextarea.value], function ( result ){
			if ( firstLoad )	//still
			{
				SRCtextarea.value = result.responseText; //insert parsed text
				onLoadFCKeditor();
				// "innerHTML" fails for IE - use "innerText" instead
				if (oToggleLink) {
					if (oToggleLink.innerText)
						oToggleLink.innerText = editorMsgOff;
					else
						oToggleLink.innerHTML = editorMsgOff;
				}
				oFCKeditor.ready = true;
			}
		});
		return true;
	}
	
	if (!oFCKeditor.ready) return false;		//sajax_do_call in action
	if (!FCKeditorAPI) return false;			//not loaded yet
	var oEditorIns = FCKeditorAPI.GetInstance( objId );
	var oEditorIframe  = document.getElementById( objId+'___Frame' );
	var FCKtoolbar = document.getElementById('toolbar');
	var bIsWysiwyg = ( oEditorIns.EditMode == FCK_EDITMODE_WYSIWYG );

	//FCKeditor visible -> hidden
	if ( showFCKEditor & RTE_VISIBLE)
	{
		var text = oEditorIns.GetData( oEditorIns.Config.FormatSource );
		SRCtextarea.value = text;
		if ( bIsWysiwyg ) oEditorIns.SwitchEditMode();		//switch to plain
		var text = oEditorIns.GetData( oEditorIns.Config.FormatSource );
		//copy from FCKeditor to textarea
		SRCtextarea.value = text;
		if (saveSetting)
		{
			sajax_request_type = 'GET' ;
			sajax_do_call( 'wfSajaxToggleFCKeditor', ['hide'], function(){} ) ;		//remember closing in session
		}
		if (oToggleLink) {
			if (oToggleLink.innerText)
				oToggleLink.innerText = editorMsgOn;
			else
				oToggleLink.innerHTML = editorMsgOn;
		}
		if (oPopupLink) oPopupLink.style.display = '';
		showFCKEditor -= RTE_VISIBLE;
		oEditorIframe.style.display = 'none';
		//FCKtoolbar.style.display = '';
		SRCtextarea.style.display = '';
	}
	//FCKeditor hidden -> visible
	else
	{
		if ( bIsWysiwyg ) oEditorIns.SwitchEditMode();		//switch to plain
		SRCtextarea.style.display = 'none';
		//copy from textarea to FCKeditor
		oEditorIns.EditingArea.Textarea.value = SRCtextarea.value
		//FCKtoolbar.style.display = 'none';
		oEditorIframe.style.display = '';
		if ( !bIsWysiwyg ) oEditorIns.SwitchEditMode();		//switch to WYSIWYG
		showFCKEditor += RTE_VISIBLE;
		if (oToggleLink) {
			if (oToggleLink.innerText)
				oToggleLink.innerText = editorMsgOff;
			else
				oToggleLink.innerHTML = editorMsgOff;
		}
		if (oPopupLink) oPopupLink.style.display = 'none';
	}
	return true;
}

END;
		return $javascript_text;
	}

	static function FCKPopupJavascript() {
		global $wgFCKEditorExtDir;
		$javascript_text = <<<END

function FCKeditor_OpenPopup(jsID, textareaID)
{
	popupUrl = '${wgFCKEditorExtDir}/FCKeditor.popup.html';
	popupUrl = popupUrl + '?var='+ jsID + '&el=' + textareaID;
	window.open(popupUrl, null, 'toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=no,resizable=1,dependent=yes');
	return 0;
}

END;
		return $javascript_text;
	}
}
