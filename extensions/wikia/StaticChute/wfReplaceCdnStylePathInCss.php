<?php

/**
 * Replace the local image URLs with the CDN's URL anywhere we've indicated to do this.
 * If a line has a "/* $wgCdnStylePath * /" comment after it (without the space before the last slash... that's just here
 * so that it doesn't break this multiline comment that you are reading), modify the URL to start with the actual wgCdnStylePath.
 * This can't be in the line itself (as in the .sql setup files) because that's not valid in CSS to have a comment inside a line.
 *
 * Macbre: don't modify paths NOT starting with "/" - they already have domains. Compare:
 *  - /skins/oasis/images/themes/beach.png
 *  - http://images.wikia.com/muppet/images/e/e7/Oasis-background
 *
 * This allows us to have images relative to the docroot in the CSS which will work on devboxes, but also do replacements in production
 * so that the resource will come from the CDN.
 *
 * @author Sean Colombo
 */
function wfReplaceCdnStylePathInCss($css, $cdnStylePath=''){
	// This function won't always be called from somewhere that wgCdnStylePath exists, so we allow
	// the cdnStylePath to be set explicitly, but default to just using the global.
	if($cdnStylePath == ""){
		global $wgCdnStylePath;
		$cdnStylePath = $wgCdnStylePath;
	}

	if(strpos($css, "wgCdnStylePath") !== false){ // faster to skip the regex in most cases
		$css = preg_replace("/([\(][\"']?)(\/[^\n]*?)\s*\/\*\s*[\\\$]?wgCdnStylePath\s*\*\//is", '\\1'.$cdnStylePath.'\\2', $css);
	}
	return $css;
} // end wfReplaceCdnStylePathInCss()
