<?php
////
// Author: Sean Colombo
// Date: 20080329
//
//  Lets articles follow implied-redirects the same way that the API does.
// For example, if "Prodigy" redirects to "The Prodigy" and a user goes to the page
// for "Prodigy:Firestarter", this will allow the wiki to understand that there is an implied
// redirect, and the "The Prodigy:Firestarter" page should be displayed.
////

if(isset($wgScriptPath)){
	$wgExtensionCredits["other"][]=array(
		'name' => 'Implied Redirects extension',
		'version' => '0.1',
		'url' => 'http://lyrics.wikia.com/User:Sean_Colombo',
		'author' => '[http://www.seancolombo.com Sean Colombo]',
		'description' => 'Allows the wiki to find songs for implied redirects.  For example, if "Prodigy" redirects to "The Prodigy" and a user goes to the page for "Prodigy:Firestarter", this will allow the wiki to understand that there is an implied redirect, and the "The Prodigy:Firestarter" page should be displayed.'
	);

	$wgExtensionFunctions[] = "wfImpliedRedirects"; // calls wfImpliedRedirects() to install function (basically to register the hooks)
}

////
// Installs the extension.
////
function wfImpliedRedirects(){
	GLOBAL $wgHooks;
	$wgHooks['ArticleFromTitle'][] = 'wfImpliedRedirects_articleFromTitle';
}

////
// Given a title, gives us a chance to create an article for it before MediaWiki takes its normal approach.
////
function wfImpliedRedirects_articleFromTitle(&$title, &$article){
	// We only want to mess with titles for pages that don't already exist.
	if(!$title->exists() && ($title->getNamespace() == NS_MAIN || $title->getNamespace() == NS_GRACENOTE)){
		$origTitle = $title->getDBkey(); // this format has the characters as we need them already

		// If there is more than one colon, the vast majority of the time it seems to be in the name of the song rather than the artist so we
		// use strpos instead of strrpos (this query was used to create this assumption: "SELECT page_title FROM wiki_page WHERE page_title LIKE '%:%:%'").
		$index = mb_strpos($origTitle, ":");
		if($index !== false){
			$artist = mb_substr($origTitle, 0, $index);
			$song = mb_substr($origTitle, ($index+1));

			// Borrow functions from the SOAP
			define('LYRICWIKI_SOAP_FUNCS_ONLY', true); // so we can borrow functions from server.php w/o initializing a SOAP request.
			$debug = false;
			GLOBAL $IP;
			include_once $IP.'/extensions/3rdparty/LyricWiki/server.php';

			// If the artist has a redirect on their own page, that generally means that all songs belong to that finalized name...
			// so try to grab the song using that version of the artist's name.
			$artistTitle = lw_getTitle($artist); // leaves the original version in tact
			$finalName = $artistTitle;
			$page = lw_getPage($artistTitle, array(), $finalName, $debug);
			print (!$debug?"":"found:\n$page");
			if($finalName != $artistTitle){
				print (!$debug?"":"Artist redirect found to \"$finalName\". Applying to song \"$song\".\n");
				$titleStr = utf8_decode(lw_getTitle($finalName, $song)); // decode is used to prevent double-encode calls that would otherwise happen.  I'm skeptical as to whether this would always work (assuming the special char was in the original title instead of the redirected artist as tested).
				print (!$debug?"":"Title \"$titleStr\"\n");
			}

			// If the song was still not found... chop off any trailing parentheses and try again. - SWC 20070101
			if(!lw_pageExists($titleStr)){
				print (!$debug?"":"$titleStr not found.\n");
				$finalSong = preg_replace("/\s*\(.*$/", "", $song);
				if($song != $finalSong){
					$titleStr = lw_getTitle($finalName, $finalSong);
					print (!$debug?"":"Looking without parentheses for \"$titleStr\"\n");
				}
			} else {
				print (!$debug?"":"$titleStr found.\n");
			}

			// We successfully found a page using implied redirects... change this request around.
			if($titleStr != $origTitle){
			    if (!class_exists('LW_ImpliedRedirect')) {
			        class LW_ImpliedRedirect extends Article {
			            var $mTarget;
			        
			            function __construct( $source, $target ) {
			                Article::__construct($source);
			                $this->mTarget = $target;
			                $this->mIsRedirect = true;
			            }
			        
			            function followRedirect() {
			                return $this->mTarget;
			            }

			            function loadPageData( $data = 'fromdb' ) {
			                Article::loadPageData( $data );
			                $this->mIsRedirect = true;
			            }

						// since we're certain the target exists, we might as well say so
						// this fools Our404Handler into following the redirect
						function exists() {
							return true;
						}
			        }
			    }
				$target = Title::newFromDBkey($titleStr);
				if($target && $target->exists()){
					$article = new LW_ImpliedRedirect( $title, $target ); //trigger redirect to implied page.
				}
			}
		}
	}
	return true;
} // end wfImpliedRedirects_articleFromTitle()
