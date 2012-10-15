<?php
// Community department job applications

$wgExtensionCredits['other'][] = array(
	'path' => __FILE__,
	'name' => 'CommunityHiring',
	'author' => 'Andrew Garrett',
	'url' => 'https://www.mediawiki.org/wiki/Extension:CommunityHiring',
);

$wgSpecialPages['CommunityHiring'] = 'SpecialCommunityHiring';
$wgAutoloadClasses['SpecialCommunityHiring'] = dirname(__FILE__) . "/SpecialCommunityHiring.php";

$wgExtensionMessagesFiles['CommunityHiring'] = dirname( __FILE__ ) . "/CommunityHiring.i18n.php";

$wgCommunityHiringDatabase = false;
