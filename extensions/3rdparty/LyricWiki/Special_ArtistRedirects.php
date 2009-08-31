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

require_once 'lw_cache.php'; // Caches the results of this processor-intensive query.
if(!defined('MEDIAWIKI')) die();

// Allows anyone to view the page.
//$wgAvailableRights[] = 'artistredirects';
//$wgGroupPermissions['*']['artistredirects'] = true;
//$wgGroupPermissions['user']['artistredirects'] = true;
//$wgGroupPermissions['sysop']['artistredirects'] = true;

$wgExtensionCredits["specialpage"][] = array(
  'name' => 'Artist Redirects',
  'version' => '0.0.1',
  'url' => 'http://lyricwiki.org/User:Sean_Colombo',
  'author' => '[http://lyricwiki.org/User:Sean_Colombo Sean Colombo]',
  'description' => "This page will list the artist redirects on the site so that spiders can find and index these misspellings, allowing users to more easily find our pages even if they don't know the correct spelling or use the same form (abbreviated, vs. longhand) that we do."
);
$dir = dirname(__FILE__) . '/';
$wgAutoloadClasses['ArtistRedirects'] = $dir . 'Special_ArtistRedirects.body.php'; # Tell MediaWiki to load the extension body.
$wgExtensionMessagesFiles['ArtistRedirects'] = $dir . 'Special_ArtistRedirects.i18n.php';
$wgSpecialPages['ArtistRedirects'] = 'ArtistRedirects'; # Let MediaWiki know about your new special page.

// Initial setup.
//function wfSetupArtistRedirects(){
//	global $IP, $wgMessageCache;
//	require_once($IP . '/includes/SpecialPage.php');
//	//SpecialPage::addPage(new SpecialPage('Artistredirects', 'artistredirects', true, 'wfArtistRedirects', false));
//	SpecialPage::addPage(new SpecialPage('Artistredirects', 'artistredirects', true, 'wfArtistRedirects', false));
//	$wgMessageCache->addMessage('artistredirects', 'Artist Redirects');
//}

?>
