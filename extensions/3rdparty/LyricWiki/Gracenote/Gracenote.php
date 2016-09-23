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
define('GRACENOTE_VIEW_NOT_LYRICS', 'NotLyrics');
define('GRACENOTE_VIEW_UNKNOWN', 'Unknown'); // indicates an error
define('GRACENOTE_ALREADY_PROCESSED', '#PROCESSED#'); // this would not be a valid page name, so this is guaranteed not to be a valid entry into the gracenote-id div.

////
// Returns HTML which outputs the required branding for Gracenote.
// This includes an icon that is 30 pixels tall or more and a specific
// sentence (no links are required on this attribution).
////
function gracenote_getBrandingHtml(){
	global $wgWikiaBaseDomain, $wgWikiaNocookieDomain;
	return "<div id='gracenote-branding'>".
			"<img src='http://images1.{$wgWikiaNocookieDomain}/lyricwiki/images/6/66/Logo-gracenote.gif' border='0'/><br/>".
			"Lyrics Provided by Gracenote (<a href='http://lyrics.{$wgWikiaBaseDomain}/Gracenote:EULA' rel='nofollow'>Lyrics Terms of Use</a>)</div>\n";
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

	# Prevent over-encoding of special HTML-encoded characters.
	# TODO: Is it safe to just make sure all /&([0-9a-zA-Z]{2,4});/ are put back to normal text?
	$lyrics = str_replace( "&#38;&#110;&#98;&#115;&#112;&#59;", "&nbsp;", $lyrics );
	$lyrics = str_replace( "&#38;&#35;&#49;&#54;&#48;&#59;", "&#160;", $lyrics); // fb#42619
	$lyrics = str_replace( "&#38;&#97;&#109;&#112;&#59;", "&amp;", $lyrics); // rt#35365
	$lyrics = str_replace( "&#38;&#103;&#116;&#59;", "&gt;", $lyrics ); // fb#16034
	$lyrics = str_replace( "&#38;&#108;&#116;&#59;", "&lt;", $lyrics );

	return substr($lyrics, 0, strlen($lyrics) - strlen($LINE_BREAK));
} // end gracenote_obfuscateText()

/**
 * DEPRECATED.
 *
 * This code used to return some HTML containing Javascript for tracking lyrics page-views
 * in Google Analytics.  However, now we use the data warehouse for Gracenote Reporting instead
 * of Google Analytics.
 */
function gracenote_getAnalyticsHtml($google_action){
	return "";
} // end gracenote_getAnalyticsHtml()

////
// Returns a message explaining why print functionality has been disabled.
////
function gracenote_getPrintDisabledNotice(){
	return "<div class='print-disabled-notice'><br/><br/>Unfortunately, the licenses with music publishers require that we disable printing of lyrics.  We're sorry for the inconvenience.<br/><br/></div>";
}

////
// Returns the HTML for a noscript  tag which will hide the lyrics if javascript is disabled and give a message to the end-user explaining what happened.
////
function gracenote_getNoscriptTag(){
	return "<noscript><div class='gracenote-header'>You must enable javascript to view this page.  This is a requirement of our licensing agreement with music Gracenote.</div>".
	"<style type='text/css'>".
		".lyricbox{display:none !important;}".
	"</style>".
	"</noscript>\n";
} // end gracenote_getNoscriptTag()

////
// Adds Google Analytics tracking to the bottom of every page.
//
// The javascript that this section adds will only record an impression
// if there was not a previous impression earlier on the page (from a 'lyrics'
// tag or 'gracenotelyrics' tag).
////
function gracenote_outputGoogleAnalytics($skin, &$text){
	$text .= gracenote_getAnalyticsHtml(GRACENOTE_VIEW_NOT_LYRICS);
	return true;
} // end gracenote_outputGoogleAnalytics()
