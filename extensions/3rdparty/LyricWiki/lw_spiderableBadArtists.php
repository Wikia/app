<?php
////
// Author: Sean Colombo
// Date: 20080330
//
// This extension makes it so that "bad" (mispelled or differently abbreviated, or aliased) artists
// can have the song pages for these versions of thier name also spidered.  For instance, if
// "Of A Revolution" redirects to "O.A.R." but a user searches for "Of A Revolution Crazy Game
// Of Poker" on a search engine, they won't get LyricWiki results because there is no page by that
// name.  However, now that we have implied redirects, that page can exist... so this extension makes
// it so there will be a link to that name so that spiders can index that version of the page as well.
//
// This works in co-operation with Special_ArtistRedirects which will send the spiders to the various
// spelled pages to begin with (this extension is just putting a link ON those pages).
////

if(isset($wgScriptPath)){
	$wgExtensionCredits["other"][]=array(
		'name' => 'Spiderable Artist Typos',
		'version' => '0.1',
		'url' => 'http://lyrics.wikia.com/User:Sean_Colombo',
		'author' => '[http://www.seancolombo.com Sean Colombo]',
		'description' => 'Allows the wiki to find links to the implied-redirect pages.  For example, if "Of A Revolution" redirects to "O.A.R." and a user searches a search engine for "Of A Revolution Crazy Game Of Poker", this will allow the spiders to understand that there is an implied redirect, and to index the "Of A Revolution:Crazy Game Of Poker" implied-redirect page.'
	);

	$wgExtensionFunctions[] = "wfSpiderableBadArtists"; // calls wfImpliedRedirects() to install function (basically to register the hooks)
}

////
// Installs the extension.
////
function wfSpiderableBadArtists(){
	GLOBAL $wgHooks;
	$wgHooks['OutputPageBeforeHTML'][] = 'wfSpiderableBadArtists_outputPage';
}

////
// Given a title, gives us a chance to create an article for it before MediaWiki takes its normal approach.
////
function wfSpiderableBadArtists_outputPage(&$out, &$text){
	GLOBAL $wgTitle;

	// For "virtual pages" that the spiders can index.
	if(isset($_GET['virtPage'])){
		$subTitle = $out->getSubtitle();
		$matches = array();
		if(0 < preg_match("/Redirected from <a href=\"[^\"]+&amp;redirect=no\" title=\"([^\"]+)\"/i", $subTitle, $matches)){
			$redirFrom = $matches[1];
			if(false === strpos($redirFrom, ":")){
				$redirFrom = str_replace(" ", "_", $redirFrom);
				$redirFrom = urlencode($redirFrom);
				$from = $wgTitle->mUrlform;
				if(strtolower($from) != strtolower($redirFrom)){
					// Replaces just the links (taking into account wgArticlePath.
					global $wgArticlePath;
					$fromLink = str_replace("$1", $from, $wgArticlePath);
					$toLink = str_replace("$1", $redirFrom, $wgArticlePath);
					$text = str_replace("\"/$fromLink", "\"/$toLink", $text);
					$text = str_replace("\"$fromLink", "\"$toLink", $text);
				}
			}
		}
	}

	return true;
} // end wfSpiderableBadArtists_outputPage()

