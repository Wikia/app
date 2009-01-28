<?php
/* This extension prints out a link tag with a canonical version of the page.
 */

$wgHooks['SkinTemplateOutputPageBeforeExec'][] = "canonicalHref";

$wgExtensionCredits['specialpage'][] = array(
        'name' => 'Canonical Href',
        'author' => 'Nick Sullivan nick at wikia-inc.com',
        'description' => 'This extension prints a link href tag with a Canonical representation of the url, which is used by Google to funnel PageRank'
);


function canonicalHref(&$skin, &$template){
        global $wgTitle;
        $link = Xml::element("link", array(
                        'rel' => 'canonical',
                        'href' => $wgTitle->getFullURL()
                )
        );
        $template->set('headlinks', $template->data['headlinks'] . "\t\t<!-- From canonicalHref -->\n\t\t" . $link . "\n");
        return true;
}

