<?php
////
// Author: Sean Colombo
// Date: 20090913
//
// This file contains methods for dealing with Gracenote integration which
// are intended to be used in more than one extension.
////

// Definitions for which type of page to track with GoogleAnalytics.
define('GRACENOTE_VIEW_GRACENOTE_LYRICS', 'ViewGracenote');
define('GRACENOTE_VIEW_OTHER_LYRICS', 'ViewOther');

define('GOOGLE_ANALYTICS_ID', "UA-288915-1"); // Wikia's GA id.

////
// Returns HTML which outputs the required branding for Gracenote.
// This includes an icon that is 30 pixels tall or more and a specific
// sentence (no links are required on this attribution).
////
function gracenote_getBrandingHtml(){
	return "<div id='gracenote-branding'>".
			"<img src='http://images1.wikia.nocookie.net/lyricwiki/images/6/66/Logo-gracenote.gif' border='0'/><br/>".
			"Lyrics Provided by Gracenote</div>\n";
} // end gracenote_getBrandingHtml()

////
// Given a string, returns an obfuscated version so that the text cannot
// easily be copied when doing "View Source" in a browser.
////
function gracenote_obfuscateText($text){
	require_once 'utf8ToUnicode.php';

	// Copy-protection: encode the contents of each line.  Will not encode anything inside of "<" and ">" characters (because that would break any HTML).
	$LINE_BREAK = "<br />"; // this is the format in which it comes out of the parser.
	$LT_UNICODE = 60;
	$GT_UNICODE = 62;
	$lines = explode($LINE_BREAK, $text);
	$lyrics = "";
	$isInsideTag = false;
	foreach($lines as $oneLine){
		$charsFromLyrics = utf8ToUnicode($oneLine);
		foreach($charsFromLyrics as $unicodeValue){
			if($isInsideTag){
				$unicodeAsArray = array($unicodeValue); // assigned so it can be passed by reference.
				$lyrics .= unicodeToUtf8($unicodeAsArray);
				if($GT_UNICODE == $unicodeValue){
					$isInsideTag = false;
				}
			} else {
				if($LT_UNICODE == $unicodeValue){
					$lyrics .= "<";
					$isInsideTag = true;
				} else {
					$lyrics .= "&#$unicodeValue;";
				}
			}
		}
		$lyrics .= $LINE_BREAK;
	}
	return substr($lyrics, 0, strlen($lyrics) - strlen($LINE_BREAK));
} // end gracenote_obfuscateText()

////
// Returns the HTML which should be inserted into a page to track the song-specific stats for Gracenote tracking.
//
// The only parameter is the 'action' to pass into the _trackEvent function.  Use one of the predefined values from
// the top of the Gracenote.php file such as GRACENOTE_VIEW_GRACENOTE_LYRICS or GRACENOTE_VIEW_OTHER_LYRICS.
//
// For more info on how this works, see:
// http://code.google.com/intl/en-US/apis/analytics/docs/tracking/eventTrackerGuide.html
////
function gracenote_getAnalyticsHtml($google_action){
	$google_category = "Lyrics";

	$googleAnalyticsId = GOOGLE_ANALYTICS_ID;
	$retVal = <<<GOOGLE_JS
	<script src='http://www.google-analytics.com/ga.js' type='text/javascript'></script>
	<script type="text/javascript">
	try{
	var pageTracker = _gat._getTracker("$googleAnalyticsId");
	var gIdDiv = document.getElementById('gracenoteid');
	var jsGoogleLabel = "Unknown";
	if(gIdDiv){
		jsGoogleLabel = gIdDiv.innerHTML;
	} else {
		var titleElement = document.getElementsByTagName('title')[0];
		if(titleElement){
			jsGoogleLabel = titleElement.innerHTML;
			jsGoogleLabel = jsGoogleLabel.substring(0, jsGoogleLabel.indexOf(" - Lyric Wiki")); // Get just the page-name from the title.
			var gnPrefix  = "Gracenote:"; // If the page name starts with "Gracenote:", get rid of that.
			if(jsGoogleLabel.substring(0, gnPrefix.length) == gnPrefix){
				jsGoogleLabel = jsGoogleLabel.substring(gnPrefix.length);
			}
		} 
	}
	pageTracker._trackEvent('$google_category', '$google_action', jsGoogleLabel);
	pageTracker._trackPageview();
	} catch(err) {}</script>
GOOGLE_JS
;

	return $retVal;
} // end gracenote_getAnalyticsHtml()


////
// Called at BeforePageDisplay hook, this will let us stuff some javascript into the <head> element to accomplish the
// copy-protection requirements of the Gracenote integration.
////
function gracenote_installCopyProtection(&$out, &$sk){
	// Add jQuery from Google's servers (free bandwidth & increases likelihood that it will already be in a user's cache).
	$out->addScript("<script type=\"text/javascript\" src=\"http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js\"></script>");
	
	// Disable text-selection in the lyricsbox divs (this only needs to be done once between both the lyrics and gracenotelyrics extensions.
	$DISABLE_TEXT_SELECTION = "
		function preventHighlighting(element){
			if (typeof element.onselectstart!=\"undefined\"){ // IE
				element.onselectstart=function(){return false};
			} else if (typeof element.style.MozUserSelect!=\"undefined\"){ // Moz-based (FireFox, etc.)
				element.style.MozUserSelect=\"none\";
			} else {
				element.onmousedown=function(){return false};
			}
			element.style.cursor = \"default\";
		}
		$('.lyricbox').each(function (i){
			preventHighlighting(this);
		});
	";

	// Disable CTRL+A's select-all capability.
	$DISABLE_SELECT_ALL = "
		$(window).keypress(function(event) {
			if (!(event.which == 97 && event.ctrlKey)) return true;
			event.preventDefault();
			return false;
		});
	";
	
	// Repeatedly clear clipboard (to attempt to stop Print-Screen, this doesn't work in modern browsers).
	$DISABLE_CLIPBOARD = "
		function no_cp(){
			if($.browser.msie && $.browser.version==\"6.0\"){
				window.clipboardData.setData('text', '');
				setTimeout(\"no_cp()\",500);
			}
		}
		function do_err(){return true}
		if($.browser.msie && $.browser.version==\"6.0\"){onerror=do_err;}
		no_cp();
	";

	// Add the various chunks of javascript that need to be run after the page is loaded.
	$out->addScript("<script type=\"text/javascript\">
		$(document).ready(function() {
			$DISABLE_TEXT_SELECTION
			$DISABLE_SELECT_ALL
			$DISABLE_CLIPBOARD
		});
	</script>");

	return true;
}

////
// Returns a message explaining why print functionality has been disabled.
////
function gracenote_getPrintDisabledNotice(){
	return "<div class='print-disabled-notice'><br/><br/>Unfortunately, the licenses with music publishers require that we disable printing of lyrics.  We're sorry for the inconvenience.<br/><br/></div>";
}

?>
