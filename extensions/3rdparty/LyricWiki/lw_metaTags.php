<?php
////
// Author: Sean Colombo
// Date: 20090429
//
// This extension will modify the meta tags to make sure LyricWiki pages are giving the correct info to spiders.
//
// The code was heavily inspired by the MetaKeywordsTag extension from Jimbojw.com - http://jimbojw.com/wiki/index.php?title=MetaKeywordsTag
////

if (defined('MEDIAWIKI')) {
	// Credits
	$wgExtensionCredits['other'][] = array(
	    'name'=>'LyricWiki MetaTags',
		'url' => 'http://lyrics.wikia.com/User:Sean_Colombo',
		'author' => '[http://www.seancolombo.com Sean Colombo]',
	    'description'=>'Extension for custom meta-tags that make sense for [http://lyrics.wikia.com LyricWiki]',
	    'version'=>'0.1'
	);

	// Attach post-parser hook to extract metadata and alter headers
	$wgHooks['OutputPageBeforeHTML'][] = 'insertMetaKeywords';

	/**
	 * Adds the appropriate data into the meta-tags where appropriate.
	 *
	 * @param OutputPage $out Handle to an OutputPage object - presumably $wgOut (passed by reference).
	 * @param String $text Output text.
	 * @return Boolean Always true to allow other extensions to continue processing.
	 */
	function insertMetaKeywords($out, $text){
		$title = (isset($_GET['title'])?$_GET['title']:"");

		// Ignore articles outside of the main namespace.  Namespace isn't in the parser afaik, so guess by title if it's in the main namespace.
		if(($title != "") && (0 == preg_match("/(LyricWiki|Help|MediaWiki|User|File|Template|Category|Special)(_talk)?:/", $title))){
			$matches = array();

			// Store the original keywords so that they can be added back at the end.
			$originalKeywords = $out->mKeywords;
			$out->mKeywords = array();

			// Add some meta keywords based on the type of page.
			if(0 < preg_match("/^(.*?):(.*?)\s*\([0-9]{4}\)$/", $title, $matches)){
				// Album
				$artist = $matches[1];
				$album = $matches[2];
				$out->addKeyword("$album lyrics");
				$out->addKeyword("$artist $album lyrics");
				$out->addKeyword("$album by $artist lyrics");
			} else if($title != "Main_Page"){
				if(strpos($title, ":") !== false){
					// Song
					$artist = substr($title, 0, strpos($title, ":"));
					$song = substr($title, strpos($title, ":") + 1);
					$out->addKeyword("$song lyrics");
					$out->addKeyword("$artist $song lyrics");
					$out->addKeyword("$song by $artist lyrics");
				} else {
					// Artist
					$artist = $title;
					$out->addKeyword("$artist lyrics");
					$out->addKeyword("lyrics by $artist");
				}
			}
			$out->addKeyword("lyrics");
			$out->addKeyword("LyricWiki");

			// Add back the original keywords.
			foreach($originalKeywords as $kw){
				$out->addKeyword($kw);
			}
		}

		return true;
	} // end insertMetaKeywords()

} // end check to see if this was a direct-access or not.
