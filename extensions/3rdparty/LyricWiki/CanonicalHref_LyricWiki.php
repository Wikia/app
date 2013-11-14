<?php
/**
 * @author Sean Colombo
 *
 * This extension hooks into Wikia's CanonicalHref extension to extend it for LyricWiki specific functionality. Namely,
 * that Gracenote/LyricFind pages should have the same 'canonical' tag as their community page (if there is a corresponding community page).
 *
 * This prevents search engines from penalizing us for duplicate content, and also makes sure that search results will tend to
 * show the community (editable) page rather than the Gracenote/LyricFind (locked) page.
 */
 
if ( !defined( 'MEDIAWIKI' ) ) die( "This is an extension to the MediaWiki package and cannot be run standalone." );

$wgExtensionCredits['other'][] = array(
	'path' => __FILE__,
	'name' => 'CanonicalHref tweaks for LyricWiki',
	'version' => '1.0',
	'author' => '[http://seancolombo.com Sean Colombo]',
	//'url' => 'http://lyrics.wikia.com/User:Sean_Colombo',
	'descriptionmsg' => 'canonicalhref-lw-desc',
);

$dir = dirname( __FILE__ );
$wgExtensionMessagesFiles['CanonicalHref_LyricWiki'] = $dir . '/CanonicalHref_LyricWiki.i18n.php';

$wgHooks['WikiaCanonicalHref'][] = 'lw_CanonicalHref';

/**
 * This is called by ImageServing if no representative image is found for a page.
 * If this is a song page, will first check the album page, then the artist page for a good image.
 * If this is an album page, will check the artist page for a good image.
 * If this is an artist page, there is no good fallback, so 'out' will be returned unmodified.
 */
function lw_CanonicalHref( &$canonicalUrl ){
	wfProfileIn( __METHOD__ );
	global $wgTitle;

	// Only process if we're in NS_GRACENOTE or NS_LYRICFIND
	if((defined('NS_GRACENOTE') && ($wgTitle->getNamespace() == NS_GRACENOTE))
		|| (defined('NS_LYRICFIND') && $wgTitle->getNamespace() == NS_LYRICFIND)){
		// Check if a community version of the page exists.
		$nonPrefixedTitleText = $wgTitle->getText();
		$mainNsTitle = Title::newFromText( $nonPrefixedTitleText, NS_MAIN );
		if($mainNsTitle->exists()){
			// There is an equivalent in the main namespace, so modify the canonicalUrl to be the main namespace page's fullUrl.
			$canonicalUrl = $mainNsTitle->getFullURL();
		}
	}

	wfProfileOut( __METHOD__ );
	return true; // because this is a hook
} // end lw_CanonicalHref()
