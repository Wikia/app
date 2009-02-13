<?php
/* This extension prints out a link tag with a canonical url to the article,
 * which handles Mediawiki's "soft" redirects much more elegantly.
 *
 * http://www.techyouruniverse.com/wikia/google-canonical-href-with-mediawiki
 * http://googlewebmastercentral.blogspot.com/2009/02/specify-your-canonical.html
 * http://ysearchblog.com/2009/02/12/fighting-duplication-adding-more-arrows-to-your-quiver/
 * http://blogs.msdn.com/webmaster/archive/2009/02/12/partnering-to-help-solve-duplicate-content-issues.aspx
 *
 * Note this extension should be mutually exclusive with extensions that do "Hard" redirects,
 * https://wikia-code.com/wikia/trunk/extensions/wikia/HardRedirectsWithJSText/
 */

$wgHooks['SkinTemplateOutputPageBeforeExec'][] = "canonicalHref";

$wgExtensionCredits['specialpage'][] = array(
        'name' => 'Canonical Href',
        'author' => 'Nick Sullivan nick at wikia-inc.com',
        'description' => 'This extension prints a link type="canonical" tag with a canonical representation of the url, which is used by Google, MSN, and Yahoo! to funnel PageRank'
);


function canonicalHref(&$skin, &$template){
        global $wgTitle;
	if (!is_object($wgTitle) || !method_exists($wgTitle, "getFullURL")){
		// Avoid a fatal error if for any reason $wgTitle isn't an object
		return true;
	}
        $link = Xml::element("link", array(
                        'rel' => 'canonical',
                        'href' => $wgTitle->getFullURL()
                )
        );
        $template->set('headlinks', $template->data['headlinks'] . "\n" . $link . "\n");
        return true;
}

