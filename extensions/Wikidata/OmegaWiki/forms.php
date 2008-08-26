<?php

require_once('languages.php');

function getTextBox($name, $value = "", $onChangeHandler = "", $maximumLength = 255) {
	if ($onChangeHandler != "")
		$onChangeAttribute = ' onchange="'. $onChangeHandler . '"';
	else
		$onChangeAttribute = '';

	return '<input type="text" id="'. $name .'" name="'. $name .'" value="'. htmlspecialchars($value) .'" maxlength="'. $maximumLength .'"' . $onChangeAttribute . ' style="width: 100%; padding: 0px; margin: 0px;"/>';
}
 
function getTextArea($name, $text = "", $rows = 5, $columns = 80) {
	return '<textarea name="'.$name. '" rows="'. $rows . '" cols="'. $columns . '">' . htmlspecialchars($text) . '</textarea>';	
}

function checkBoxCheckAttribute($isChecked) {
	if ($isChecked)
		return ' checked="checked"';
	else
		return '';	
}
 
function getCheckBox($name, $isChecked) {
	return '<input type="checkbox" name="'. $name .'"'. checkBoxCheckAttribute($isChecked) . '/>';
}

function getCheckBoxWithOnClick($name, $isChecked, $onClick) {
	return '<input type="checkbox" name="'. $name .'"'. checkBoxCheckAttribute($isChecked) . ' onclick="'. $onClick .'"/>';
}

function getRemoveCheckBox($name) {
	return getCheckBoxWithOnClick($name, false, "removeClicked(this);");
}
  
# $options is an array of [value => text] pairs
function getSelect($name, $options, $selectedValue="", $onChangeHandler="") {
	if ($onChangeHandler != "")
		$onChangeAttribute = ' onchange="'. $onChangeHandler . '"';
	else
		$onChangeAttribute = '';
	
	$result = '<select id="' . $name . '" name="'. $name . '"' . $onChangeAttribute . '>';	  
 
	asort($options);

	foreach($options as $value => $text) {
		if ($value == $selectedValue)
			$selected = ' selected="selected"';
		else
			$selected = '';
			
		$result .= '<option value="'. $value .'"'. $selected .'>'. htmlspecialchars($text) . '</option>';
	}	

	return $result . '</select>';
}

function getFileField($name, $onChangeHandler = "") {
	if ($onChangeHandler != "")
		$onChangeAttribute = ' onchange="'. $onChangeHandler . '"';
	else
		$onChangeAttribute = '';

	return '<input type="file" id="'. $name .'" name="'. $name . '"' . $onChangeAttribute . ' style="width: 100%; padding: 0px; margin: 0px;"/>';
}
 

/**
 *
 * Returns HTML for an autocompleted form field.
 *
 * @param String unique identifier for this form field
 * @param String type of query to run
 * @param Integer Default value
 * @param String How default value will be shown
 * @param Array Override column titles
 * @param DataSet Override standard dataset
 *
*/
function getSuggest($name, $query, $parameters = array(), $value=0, $label='', $displayLabelColumns = array(0), DataSet $dc=null) {
	global
		$wgScriptPath;

	if(is_null($dc)) {
		$dc=wdGetDataSetContext();
	}
	if ($label == "")
		$label = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
	
	$result = 
		'<span class="suggest">' .
			'<input type="hidden" id="'. $name .'-suggest-query" value="'. $query .'"/>' .
			'<input type="hidden" id="'. $name .'-suggest-offset" value="0"/>' .
			'<input type="hidden" id="'. $name .'-suggest-label-columns" value="'. implode(', ', $displayLabelColumns) .'"/>' .
			'<input type="hidden" id="'. $name .'" name="'. $name .'" value="'. $value .'"/>' .
			'<input type="hidden" id="'.$name.'-suggest-dataset" value="'.$dc.'"/>';

	foreach ($parameters as $parameter => $parameterValue)
		$result .= 
			'<input type="hidden" id="'. $name .'-suggest-parameter-'. $parameter .'" name="'. $parameter .'" value="'. $parameterValue .'"/>';

	$result .=		
			'<a id="'. $name .'-suggest-link" class="suggest-link" onclick="suggestLinkClicked(event, this);" title="Click to change selection">' . $label . '</a>' .
		'</span>'.
        '<div class="suggest-drop-down" style="position: relative"><div id="'. $name .'-suggest-div" style="position: absolute; left: 0px; top: 0px; border: 1px solid #000000; display: none; background-color: white; padding: 4px">' .
        	'<div><table>' .
        		'<tr>' .
        			'<td><input type="text" id="'. $name .'-suggest-text" autocomplete="off" onkeyup="suggestTextChanged(this)" style="width: 300px"></input></td>' .
        			'<td><a id="'. $name .'-suggest-clear" href="javascript:void(0)" onclick="suggestClearClicked(event, this)">Clear</a></td>' .
        			'<td style="white-space: nowrap"><a id="'. $name .'-suggest-previous" href="javascript:void(0)" class="suggest-previous" onclick="suggestPreviousClicked(event, this)"><img src="'.$wgScriptPath.'/extensions/Wikidata/Images/ArrowLeft.png" alt="Previous"/> Previous</a></td>'.
        			'<td style="white-space: nowrap"><a id="'. $name .'-suggest-next" href="javascript:void(0)" class="suggest-next" onclick="suggestNextClicked(event, this)">Next <img src="'.$wgScriptPath.'/extensions/Wikidata/Images/ArrowRight.png" alt="Next"/></a></td>'.
        			'<td><a id="'. $name .'-suggest-close" href="javascript:void(0)" onclick="suggestCloseClicked(event, this)">[X]</a></td>' .
        		'</tr>' .
        	'</table></div>' .
        	'<div><table id="'. $name .'-suggest-table"><tr><td></td></tr></table></div>'.
        '</div></div>';
	
	return $result;
}

function getStaticSuggest($name, $suggestions, $idColumns = 1, $value=0, $label='', $displayLabelColumns = array(0)) {
	if ($label == "")
		$label = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';

	$result = 
		'<span class="suggest">' .
//			'<input type="hidden" id="'. $name .'-suggest-query" value="'. $query .'"/>' .
			'<input type="hidden" id="'. $name .'-suggest-label-columns" value="'. implode(', ', $displayLabelColumns) .'"/>' .
			'<input type="hidden" id="'. $name .'" name="'. $name .'" value="'. $value .'"/>';

	if ($idColumns > 1)
		$result .= '<input type="hidden" id="'. $name .'-suggest-id-columns" value="' . $idColumns. '"/>';

	$result .=
			'<a id="'. $name .'-suggest-link" class="suggest-link" onclick="suggestLinkClicked(event, this);" title="Click to change selection">' . $label . '</a>' .
		'</span>'.
        '<div class="suggest-drop-down" style="position: relative"><div id="'. $name .'-suggest-div" style="position: absolute; left: 0px; top: 0px; border: 1px solid #000000; display: none; background-color: white; padding: 4px">' .
        	'<div><table><tr><td>' .
//        	'<input type="text" id="'. $name .'-suggest-text" autocomplete="off" onkeyup="suggestTextChanged(this)" style="width: 300px"></input>' .
        	'</td><td><a id="'. $name .'-suggest-clear" href="javascript:void(0)" onclick="suggestClearClicked(event, this)">Clear</a></td><td><a id="'. $name .'-suggest-close" href="#'. $name . '-suggest-link" onclick="suggestCloseClicked(event, this)">[X]</a></td></tr></table></div>' .
        	'<div>' . $suggestions .
        	//<table id="'. $name .'-suggest-table"><tr><td></td></tr></table>
        	'</div>'.
        '</div></div>';
	
	return $result;
}

function getLanguageOptions($languageIdsToExclude = array()) {
	global 
		$wgUser;
		
	$userLanguage = $wgUser->getOption('language');
	$idNameIndex = getLangNames($userLanguage);
	
	$result = array();
	
	foreach($idNameIndex as $id => $name) 
		if (!in_array($id, $languageIdsToExclude)) 
			$result[$id] = $name;
	
	return $result;
}
	
function getLanguageSelect($name, $languageIdsToExclude = array()) {
	global 
		$wgUser;
		
	$userLanguage = $wgUser->getOption('language');
	$userLanguageId = getLanguageIdForCode($userLanguage);

	return getSelect($name, getLanguageOptions($languageIdsToExclude), $userLanguageId);
}

function getSubmitButton($name, $value) {
	return '<input type="submit" name="'. $name .'" value="'. $value .'"/>'; 	
}

function getOptionPanel($fields, $action = '', $buttons = array("show" => "Show")) {
	global 
		$wgTitle;

	$result = 
		'<div class="option-panel">' .
			'<form method="GET" action="">' .
				'<table cellpadding="0" cellspacing="0">' .
					'<input type="hidden" name="title" value="' . $wgTitle->getNsText() . ':' . htmlspecialchars($wgTitle->getText()) . '"/>';

	if ($action && $action != '')
		$result .= '<input type="hidden" name="action" value="' . $action . '"/>';

	foreach($fields as $caption => $field) 
		$result .= '<tr><th>' . $caption . ':</th><td class="option-field">' . $field . '</td></tr>';

	$buttonHTML = "";
	
	foreach ($buttons as $name => $caption)
		$buttonHTML .= getSubmitButton($name, $caption);
	
	$result .=
					'<tr><th/><td>' . $buttonHTML . '</td></tr>' .
				'</table>' .
			'</form>' .
		'</div>';
		
	return $result;
}

function getOptionPanelForFileUpload($fields, $action = '', $buttons = array("upload" => "Upload")) {
	global 
		$wgTitle;

	$result = 
		'<div class="option-panel">' .
			'<form method="POST" enctype="multipart/form-data" action="">' .
				'<table cellpadding="0" cellspacing="0">' .
					'<input type="hidden" name="title" value="' . $wgTitle->getNsText() . ':' . htmlspecialchars($wgTitle->getText()) . '"/>';

	if ($action && $action != '')
		$result .= '<input type="hidden" name="action" value="' . $action . '"/>';

	foreach($fields as $caption => $field) 
		$result .= '<tr><th>' . $caption . ':</th><td class="option-field">' . $field . '</td></tr>';

	$buttonHTML = "";
	
	foreach ($buttons as $name => $caption)
		$buttonHTML .= getSubmitButton($name, $caption);
	
	$result .=
					'<tr><th/><td>' . $buttonHTML . '</td></tr>' .
				'</table>' .
			'</form>' .
		'</div>';
		
	return $result;
}

