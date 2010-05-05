<?php
////
// Author: Sean Colombo
// Date: 20081101
//
// This extension will allow logged-in users to chose their type of ads that will be displayed.
//
// Installation:
// - Add "Ads" as the body of "http://lyricwiki.org/MediaWiki:Prefs-ads" to be the title of the new preferences tab.
// - Put the following into LocalSettings.php: "include_once 'extensions/PreferencesExtension.php';include_once 'extensions/LyricWiki/adPreferences.php';" (this extension requires the PreferencesExtension).
//
// NOTE: THIS EXTENSION IS NOT USED ANYMORE, BUT IF IT WERE TO BE USED AGAIN, THE wfAddPreferences CALL SHOULD BE INSIDE OF AN INIT FUNCTION
// WHICH IS ADDED TO $wgExtensionFunctions[] SO THAT IT DOESN'T RUN ON EVERY SINGLE REQUEST.
////


$wgExtensionFunctions[] = 'wfInitAdPreferences';

function wfInitAdPreferences(){
	GLOBAL $DEFAULT_AD_TYPE;
	GLOBAL $ALLOWED_AD_TYPES;
	GLOBAL $AD_PREF_ID;
	$DEFAULT_AD_TYPE = ""; // the form will store nothing by default which will mean that the user should use whatever the current default is (ie: they have no preference).
	$ALLOWED_AD_TYPES = array(
		"banners_no-rt" => "Banners, No Ringtone Links",
		"rt_no-banners" => "Ringtone Links, No Banners",
		"banners_and_rt" => "Banners and Ringtones"
	);
	$AD_PREF_ID = "ad_type";

	// Builds the HTML code to create the select-box (the "@VALUE@" will be replaced by PreferencesExtension to be the prior value).
	$html = "<select name='$AD_PREF_ID' id='$AD_PREF_ID' title='@VALUE@'>
				<option value=''>(default)</option>\n";
	foreach($ALLOWED_AD_TYPES as $val=>$text){
		$html .= "<option value='$val'>$text</option>\n";
	}
	$html .= "</select>\n";

	// Adds in the JavaScript which will select the appropriate default value
	$html .= "<script type='text/javascript'>
		var selBox = document.getElementById('$AD_PREF_ID');
		document.getElementById('$AD_PREF_ID').value = selBox.title;";
	$html .= "</script>";

	// Adds the user-preference (making use of the "PreferencesExtension" extension).
	wfAddPreferences(array(
		array(
			"name" => $AD_PREF_ID,
			"section" => "prefs-ads",
			"type" => PREF_USER_T,
			//"size" => "", // Not relevant to this type.
			"html" => $html,
			//"min" => "",
			//"max" => "",
			"validate" => "wfVerifyAdPrefs",
			//"save" => "",
			//"load" => "",
			"default" => ""
		)
	));
}

////
// This function will be called by ExtensionPreferences to verify that the input is valid.
// The only parameter will be the value that the user submitted, and the return value should
// be the value to store.
////	
function wfVerifyAdPrefs($pref){
	GLOBAL $ALLOWED_AD_TYPES;
	if(!in_array($pref, array_keys($ALLOWED_AD_TYPES))){
		$pref = ""; // default back to "no preference".
	}
	return $pref;
} // end wfVerifyAdPrefs()

////
// Returns true iff the users ad preferences include displaying ringtones.
// If the ad-type is unkown, will return true (so that people can't game it AND they will notice a breakage and report it).
////
function wfAdPrefs_doRingtones(){
	GLOBAL $wgUser;
	GLOBAL $AD_PREF_ID;
	$adType = strtolower($wgUser->getOption($AD_PREF_ID));
	return ($adType=="" || (strpos($adType, "no-rt") === false));
} // end wfAdPrefs_doRingtones()

////
// Returns true iff the user's ad preferences include displaying banners.
// If the ad-type is unkown, will return true (so that people can't game it AND they will notice a breakage and report it).
////
function wfAdPrefs_doBanners(){
	GLOBAL $wgUser;
	GLOBAL $AD_PREF_ID;
	$adType = strtolower($wgUser->getOption($AD_PREF_ID));
	return ($adType=="" || (strpos($adType, "no-banner") === false));
} // end wfAdPrefs_doBanners()

?>
