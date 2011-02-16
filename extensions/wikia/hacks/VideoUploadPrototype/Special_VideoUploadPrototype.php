<?php
////
// Author: Sean Colombo
// Date: 20110211
//
// Special page to test uploading videos to a third party provider and playing them.
////

if(!defined('MEDIAWIKI')) die();

// Allows anyone to view the page.
//$wgAvailableRights[] = 'videouploadprototype';
//$wgGroupPermissions['*']['videouploadprototype'] = true;
//$wgGroupPermissions['user']['videouploadprototype'] = true;
//$wgGroupPermissions['sysop']['videouploadprototype'] = true;

$wgExtensionCredits["specialpage"][] = array(
  'name' => 'Video Upload Prototype',
  'version' => '0.0.1',
  'url' => 'http://lyrics.wikia.com/User:Sean_Colombo',
  'author' => '[http://www.seancolombo.com Sean Colombo]',
  'description' => "Special page to test uploading videos to a third party provider and playing them."
);
$dir = dirname(__FILE__) . '/';
include_once $dir . "LongtailVideoClient.php";
$wgAutoloadClasses['VideoUploadPrototype'] = $dir . 'Special_VideoUploadPrototype.body.php'; # Tell MediaWiki to load the extension body.

// TOTAL HACK... should never be shown to end-users... no need for i18n (sorry TOR!)
//$wgExtensionMessagesFiles['VideoUploadPrototype'] = $dir . 'Special_VideoUploadPrototype.i18n.php';

$wgSpecialPages['VideoUploadPrototype'] = 'VideoUploadPrototype'; # Let MediaWiki know about your new special page.


?>
