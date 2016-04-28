<?php
////
// Author: Sean Colombo
// Date: 20080331
//
// This page will list the artist redirects on the site so that spiders
// can find and index these misspellings, allowing users to more easily
// find our pages even if they don't know the correct spelling or use
// the same form (abbreviated, vs. longhand) that we do.
////

if(!defined('MEDIAWIKI')) die();

$wgExtensionCredits["specialpage"][] = array(
  'name' => 'Artist Redirects',
  'version' => '0.0.1',
  'url' => 'http://lyrics.wikia.com/User:Sean_Colombo',
  'author' => '[http://www.seancolombo.com Sean Colombo]',
  'description' => "This page will list the artist redirects on the site so that spiders can find and index these misspellings, allowing users to more easily find our pages even if they don't know the correct spelling or use the same form (abbreviated, vs. longhand) that we do."
);
$dir = dirname(__FILE__) . '/';
$wgAutoloadClasses['ArtistRedirects'] = $dir . 'Special_ArtistRedirects.body.php'; # Tell MediaWiki to load the extension body.
$wgExtensionMessagesFiles['ArtistRedirects'] = $dir . 'Special_ArtistRedirects.i18n.php';
$wgSpecialPages['ArtistRedirects'] = 'ArtistRedirects'; # Let MediaWiki know about your new special page.

