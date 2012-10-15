<?php

if ( ! defined( 'MEDIAWIKI' ) ) {
	die;
}

$wgExtensionCredits['other'][] = array(
	'path' => __FILE__,
	'name' => 'CommunityApplications',
	'author' => 'Andrew Garrett',
	'url' => 'https://www.mediawiki.org/wiki/Extension:CommunityApplications',
);

// Reader for CommunityHiring data
$wgSpecialPages['CommunityApplications'] = 'SpecialCommunityApplications';
$wgAutoloadClasses['SpecialCommunityApplications'] = dirname(__FILE__) . "/SpecialCommunityApplications.php";

$wgExtensionMessagesFiles['CommunityApplications'] = dirname( __FILE__ ) . "/CommunityApplications.i18n.php";

$wgCommunityHiringDatabase = false;
