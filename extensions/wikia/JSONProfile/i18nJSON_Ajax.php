<?php
$wgAjaxExportList [] = 'wfGetJsTranslation';
function wfGetJsTranslation($lang, $do_on_fly=false) {
	// get the list of messages from the master list
	$lang_array = getTransList("all");

	// these dont have translated values, so set all of the values to be equal to the keys
	foreach ($lang_array as $id=>$val) {
		$lang_array[$id] = $id;
	}
	
	// now get the list for the current language
	$lang_array_lang = getTransList($lang);
	
	// replace all of the untranslated ones from before with the translated version here
	// and add any that may have not been in the master for some reason
	foreach ($lang_array_lang as $id=>$val) {
		$lang_array[$id] = $val;
	}
	// create the output string that will return the javascript object for the language translation
	$output = "";
	foreach ($lang_array as $id=>$val) {
		$output .= "\"".$id."\"" . ":" . "\"".$val."\",\n";
	}
	
	//if there is anything there will be a comma and a newline at the end of this string
	// having a comma after the last property of a js object makes IE and opera barf, so cut out the last two characters
	if (strlen($output)) $output = substr($output, 0, strlen($output)-2);
	
	// output the object, and if this is a subsequent call after changes are saved, add the js function calls to translate the text and set the language
	return "i18n." . $lang . "={" . $output . "};" . ($do_on_fly ? "\nxlateOnFly('{$lang}');\ni18n.setlanguage('{$lang}');" : "");
	
}

function getTransList($lang) {
	// all the translations will be stored in a mw message... read in the one that we want for this language
	$lang_trans = trim(wfMsg("Jstrans_" . $lang));
	
	// if there is a comma at the end of the string, it will cause a blank element when looping through, so remove it if there is 
	if (substr($lang_trans, -1)==",") $lang_trans = substr($lang_trans, 0, strlen($lang_trans)-1);

	// if the requested mw message doesnt exist, it will return the name we passed with <> around it... in that case, return an empty array
	if ($lang_trans == "&lt;Jstrans_".$lang."&gt;") return array();
	// otherwise, pass it to the function that splits up the string and parses the pieces into the key/value array 
	else return breakdown_lang($lang_trans);
}

function breakdown_lang($lang_trans, $explode_separator=",\n") {
	// explode separator gets passed in here because this function gets used when splitting up the text read in
	// from the mediawiki message as well as what is passed in when the changes are saved from the html...
	// they come in in different formats with different separators, so need to be able to use either
	$messages = explode($explode_separator, $lang_trans);
	$full_message_array = array();
	foreach( $messages as $message ){
		
		if (trim($message) == "") continue;
		$message_array = explode(":", $message);
		
		// if there are not 2 parts, its an invalid line... skip it
		if (count($message_array) != 2) {
			continue;
		}
		
		$id = trim($message_array[0]);
		$val = trim($message_array[1]);
		
		// reading in a set of keys and values, which based on who edited the files may have " or ' around them
		// check if the first character and the last character of the id are "s or 's (a valid value either way)
		if ((substr($id,0,1) == "\"" && substr($id, -1) == "\"") ||  (substr($id,0,1) == "'" && substr($id, -1) == "'")) {
			// if so. get the text inbetween the first and last characters
			$id = substr($id, 1, strlen($id)-2);
		}
		// do the same for the value
		if ((substr($val,0,1) == "\"" && substr($val, -1) == "\"") ||  (substr($val,0,1) == "'" && substr($val, -1) == "'")) {
			$val = substr($val, 1, strlen($val)-2);
		}
		// and if its not empty, add it to the array
		if (trim($id) != "") $full_message_array[$id]=$val;
		
	}
	return $full_message_array;
}

$wgAjaxExportList[] = 'saveTransListMulti';
function saveTransListMulti() {
	
	// if the form submission from the html is missing necessary parts, dont bother, just quit
	if(!isset($_POST['lang']) || !isset($_POST['trans_changes']) || !isset($_POST['source'])) {
		return "no";
	}
	
	$lang = $_POST['lang'];
	$lang_changes = $_POST['trans_changes'];
	$wpSourceForm = $_POST['source'];
	
	// the $lang_changes val just contains a list of the changed params, so read back in the mw message and create the array again
	// so that we can apply the changes to the array, and re-save the message
	$lang_array = getTransList($lang);
	
	// split up the string that was passed in with the changes, and parse it out into an array
	$changes_array = breakdown_lang($lang_changes, ",||");
	
	// loop through the array of changes and apply the new translation to the array that we will use to save out the file
	foreach ($changes_array as $change_id=>$change_text) {
		$lang_array[$change_id] = $change_text;
	}
	
	// loop through the array that has everything, and create the string that we will save to the mw message
	$output = "";
	foreach ($lang_array as $id=>$val) {
		$output .= "\"".$id."\"" . ":" . "\"".$val."\",\n";
	}
	
	// save the string that we just created to the mw message page for that language
	$title = "Jstrans_" . $lang;
	$page_title = Title::makeTitleSafe( NS_MEDIAWIKI, $title );
	$article = new Article($page_title);
	$article->doEdit( $output, "Search translation JSON");
	
	// this is the master list that untranslated languages use to provide a base for what things there are that need to get translated
	// read in the mw message and check the size of the array
	$lang_array_all = getTransList("all");
	$all_size = sizeof($lang_array_all);
	
	// loop through the array for the messages for that language, and add any ones that may not have been there 
	foreach ($lang_array as $id=>$val) {
		$lang_array_all[$id] = "\"*\"";
	}
	
	// most of the time nothing new will be getting added in here, so no need to save this one if nothing changed for it
	// so check the size of the update array against what we had before
	if(sizeof($lang_array_all) > $all_size) {
		$output_all = "";
		// do what we did before to save the master list 
		foreach ($lang_array_all as $id=>$val) {
			$output_all .= "\"".$id."\"" . ":" . "\"".$val."\",\n";
		}
		
		$title = "Jstrans_all";
		$page_title = Title::makeTitleSafe( NS_MEDIAWIKI, $title );
		$article = new Article($page_title);
		$article->doEdit( $output_all, "Search translation JSON");
	}
	// return the output into the iframe the submitted the form here to reload the page back to the transframe document on the search server
	return "<script type=\"text/javascript\">location.href='{$wpSourceForm}?saved=1';</script>";
	
}
?>
