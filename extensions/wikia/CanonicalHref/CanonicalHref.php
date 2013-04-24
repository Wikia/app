<?php
/* This extension prints out a link tag with a canonical url to the article,
 * which handles Mediawiki's "soft" redirects much more elegantly.
 *
 * http://www.techyouruniverse.com/wikia/google-canonical-href-with-mediawiki
 * http://googlewebmastercentral.blogspot.com/2009/02/specify-your-canonical.html
 * http://ysearchblog.com/2009/02/12/fighting-duplication-adding-more-arrows-to-your-quiver/
 * http://blogs.msdn.com/webmaster/archive/2009/02/12/partnering-to-help-solve-duplicate-content-issues.aspx
 */

$wgExtensionCredits['specialpage'][] = array(
        'name' => 'Canonical Href',
		'version' => '1.1',
        'author' => array('Nick Sullivan nick at wikia-inc.com', 'Maciej Brencz', '[http://seancolombo.com Sean Colombo]'),
        'description' => 'This extension prints a link type="canonical" tag with a canonical representation of the url, which is used by Google, MSN, and Yahoo! to funnel PageRank.'
);

$wgHooks['BeforePageDisplay'][] = 'wfCanonicalHref';
/**
 * @param OutputPage $out
 * @param $sk
 * @return bool
 */
function wfCanonicalHref(&$out, &$sk) {
	global $wgTitle;

	if ( !($wgTitle instanceof Title) ) {
		return true;
	}

	$canonicalUrl = $wgTitle->getFullURL();

	// Allow hooks to change the canonicalUrl that will be used in the page.
	wfRunHooks( 'WikiaCanonicalHref', array( &$canonicalUrl ) );

	$out->addLink(array(
		'rel' => 'canonical',
		'href' => $canonicalUrl,
	));

	return true;
}
