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
	'author' => array( 'Nick Sullivan nick at wikia-inc.com', 'Maciej Brencz', '[http://seancolombo.com Sean Colombo]' ),
	'descriptionmsg' => 'canonicalhref-desc',
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/CanonicalHref'
);

$wgAutoloadClasses[ 'CanonicalHrefHooks' ] = __DIR__ . '/CanonicalHrefHooks.php';

//i18n
$wgExtensionMessagesFiles['CanonicalHref'] = __DIR__ . '/CanonicalHref.i18n.php';

$wgHooks['BeforePageDisplay'][] = 'CanonicalHrefHooks::onBeforePageDisplay';
$wgHooks['OutputPageAfterGetHeadLinksArray'][] = 'CanonicalHrefHooks::onOutputPageAfterGetHeadLinksArray';
