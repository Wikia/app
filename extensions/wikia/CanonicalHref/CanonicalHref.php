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
        'descriptionmsg' => 'canonicalhref-desc',
		'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/CanonicalHref'
);

//i18n

$wgHooks['BeforePageDisplay'][] = 'wfCanonicalHref';
/**
 * @param OutputPage $out
 * @param Skin $skin
 * @return bool
 * @internal param $sk
 */
function wfCanonicalHref( OutputPage $out, Skin $skin ): bool {
	// No canonical on pages with pagination -- they should have the link rel="next/prev" instead
	if ( $out->getRequest()->getVal( 'page' ) ) {
		return true;
	}

	$canonicalUrl = $out->getTitle()->getFullURL();

	// Allow hooks to change the canonicalUrl that will be used in the page.
	Hooks::run( 'WikiaCanonicalHref', [ &$canonicalUrl ] );

	$out->addLink( [
		'rel' => 'canonical',
		'href' => $canonicalUrl,
	] );

	return true;
}
