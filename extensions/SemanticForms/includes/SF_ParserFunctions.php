<?php
/**
 * Parser functions for Semantic Forms.
 *
 * Four parser functions are defined: 'forminput', 'formlink', 'arraymap'
 * and 'arraymaptemplate'.
 *
 * 'forminput' is called as:
 *
 * {{#forminput:form_name|size|value|button_text|query_string}}
 *
 * This function returns HTML representing a form to let the user enter the
 * name of a page to be added or edited using a Semantic Forms form. All
 * arguments are optional. form_name is the name of the SF form to be used;
 * if it is left empty, a dropdown will appear, letting the user chose among
 * all existing forms. size represents the size of the text input (default
 * is 25), and value is the starting value of the input (default is blank).
 * button_text is the text that will appear on the "submit" button, and
 * query_string is the set of values that you want passed in through the
 * query string to the form.
 *
 * Example: to create an input to add or edit a page with a form called
 * 'User' within a namespace also called 'User', and to have the form
 * preload with the page called 'UserStub', you could call the following:
 *
 * {{#forminput:User|||Add or edit user|namespace=User&preload=UserStub}}
 *
 *
 * 'formlink' is called as:
 *
 * {{#formlink:form_name|link_text|link_type|query_string}}
 *
 * This function returns HTML representing a link to a form; given that
 * no page name is entered by the the user, the form must be one that
 * creates an automatic page name, or else it will display an error
 * message when the user clicks on the link.
 *
 * The first two arguments are mandatory: form_name is the name of the SF
 * form, and link_text is the text of the link. link_type is the type of
 * the link: if set to 'button', the link will be a button; if set to
 * blank or anything else, it will be a standard hyperlink. query_string
 * is the text to be added to the generated URL's query string.
 *
 * Example: to create a link to add data with a form called
 * 'User' within a namespace also called 'User', and to have the form
 * preload with the page called 'UserStub', you could call the following:
 *
 * {{#formlink:User|Add a user||namespace=User&preload=UserStub}}
 *
 *
 * 'arraymap' is called as:
 *
 * {{#arraymap:value|delimiter|var|new_value|new_delimiter}}
 *
 * This function applies the same transformation to every section of a
 * delimited string; each such section, as dictated by the 'delimiter'
 * value, is given the same transformation that the 'var' string is
 * given in 'new_value'. Finally, the transformed strings are joined
 * together using the 'new_delimiter' string. Both 'delimiter' and
 * 'new_delimiter' default to commas.
 *
 * Example: to take a semicolon-delimited list, and place the attribute
 * 'Has color' around each element in the list, you could call the
 * following:
 *
 * {{#arraymap:blue;red;yellow|;|x|[[Has color::x]]|;}}
 *
 *
 * 'arraymaptemplate' is called as:
 *
 * {{#arraymaptemplate:value|template|delimiter|new_delimiter}}
 *
 * This function makes the same template call for every section of a
 * delimited string; each such section, as dictated by the 'delimiter'
 * value, is passed as a first parameter to the template specified.
 * Finally, the transformed strings are joined together using the
 * 'new_delimiter' string. Both 'delimiter' and 'new_delimiter'
 * default to commas.
 *
 * Example: to take a semicolon-delimited list, and call a template
 * named 'Beautify' on each element in the list, you could call the
 * following:
 *
 * {{#arraymaptemplate:blue;red;yellow|Beautify|;|;}}
 *
 * @author Yaron Koren
 * @author Sergey Chernyshev
 */


function sfgParserFunctions () {
	global $wgParser;
	$wgParser->setFunctionHook('forminput', 'sfRenderFormInput');
	$wgParser->setFunctionHook('formlink', 'sfRenderFormLink');
	$wgParser->setFunctionHook('arraymap', 'sfRenderArrayMap');
	$wgParser->setFunctionHook('arraymaptemplate', 'sfRenderArrayMapTemplate');
}

function sffLanguageGetMagic( &$magicWords, $langCode = "en" ) {
	switch ( $langCode ) {
	default:
		$magicWords['forminput']	= array ( 0, 'forminput' );
		$magicWords['formlink']		= array ( 0, 'formlink' );
		$magicWords['arraymap']		= array ( 0, 'arraymap' );
		$magicWords['arraymaptemplate']	= array ( 0, 'arraymaptemplate' );
	}
	return true;
}

function sfRenderFormLink (&$parser, $inFormName = '', $inLinkStr = '', $inLinkType='', $inQueryStr = '') {
	$ad = SpecialPage::getPage('AddData');
	$link_url = $ad->getTitle()->getLocalURL() . "/$inFormName";
	$link_url = str_replace(' ', '_', $link_url);
	if ($inQueryStr != '') {
		$link_url .= (strstr($link_url, '?')) ? '&' : '?';
		$link_url .= $inQueryStr;
	}
	if ($inLinkType == 'button') {
		$str = "<form><input type=\"button\" value=\"$inLinkStr\" onclick=\"window.location.href='$link_url'\"></form>";
	} else {
		$str = "<a href=\"$link_url\">$inLinkStr</a>";
	}
	return array($str, 'noparse' => 'true', 'isHTML' => 'true');
}

function sfRenderFormInput (&$parser, $inFormName = '', $inSize = '25', $inValue = '', $inButtonStr = '', $inQueryStr = '') {
	$ap = SpecialPage::getPage('AddPage');
	$ap_url = $ap->getTitle()->getLocalURL();
	$str = <<<END
			<form action="$ap_url" method="get">
			<p><input type="text" name="page_name" size="$inSize" value="$inValue">

END;
	// if the add page URL looks like "index.php?title=Special:AddPage"
	// (i.e., it's in the default URL style), add in the title as a
	// hidden value
	if (($pos = strpos($ap_url, "title=")) > -1) {
		$str .= '			<input type="hidden" name="title" value="' . substr($ap_url, $pos + 6) . '">' . "\n";
	}
	if ($inFormName == '') {
		$str .= sffFormDropdownHTML();
	} else {
		$str .= '			<input type="hidden" name="form" value="' . $inFormName . '">' . "\n";
	}
	// recreate the passed-in query string as a set of hidden variables
	$query_components = explode('&', $inQueryStr);
	foreach ($query_components as $component) {
		$subcomponents = explode('=', $component, 2);
		$key = (isset($subcomponents[0])) ? $subcomponents[0] : '';
		$val = (isset($subcomponents[1])) ? $subcomponents[1] : '';
		$str .= '			<input type="hidden" name="' . $key . '" value="' . $val . '">' . "\n";
	}
	$button_str = ($inButtonStr != '') ? $inButtonStr : wfMsg('addoreditdata');
	$str .= <<<END
			<input type="submit" value="$button_str"></p>
			</form>
END;
	return array($str, 'noparse' => 'true', 'isHTML' => 'true');
}

/**
 * {{#arraymap:value|delimiter|var|new_value|new_delimiter}}
 */
function sfRenderArrayMap ( &$parser, $value = '', $delimiter = ',', $var = 'x', $new_value = '', $new_delimiter = ', ' ) {
	$values_array = explode($delimiter, $value);
	$results = array();
	foreach ($values_array as $cur_value) {
		$cur_value = trim($cur_value);
		// ignore a value if it's null
		if ('' != $cur_value) {
			// remove whitespaces
			$results[] = str_replace($var, $cur_value, $new_value);
		}
	}
	return implode($new_delimiter, $results);
}

/**
 * {{#arraymaptemplate:blue;red;yellow|Beautify|;|;}}
 */
function sfRenderArrayMapTemplate ( &$parser, $value = '', $template = '', $delimiter = ',', $new_delimiter = ', ' ) {
	$values_array = explode($delimiter, $value);
	$results = array();
	$template = trim($template);
	foreach ($values_array as $cur_value) {
		$cur_value = trim($cur_value);
		// ignore a value if it's null
		if ('' != $cur_value) {
			// remove whitespaces
			$results[] = '{{'.$template.'|'.$cur_value.'}}';
		}
	}
	return implode($new_delimiter, $results);
}
