<?php
// Process system for managing trademark usage requests.

$wgExtensionCredits['specialpage'][] = array(
	'path'           => __FILE__,
	'name'           => 'Trade Track',
	'author'         => array( 'Brandon Harris' ),
	'url'            => 'https://www.mediawiki.org/wiki/Extension:TradeTrack',
	'descriptionmsg' => 'tradetrack-desc',
);

$wgSpecialPages['TradeTrack'] = 'SpecialTradeTrack';

$wgTradeTrackEmailSubject = "A new Trademark Request has Arrived";
$wgTradeTrackFromEmail = "tradetrack@wikimedia.org";

$dir = dirname(__FILE__);
$wgAutoloadClasses['SpecialTradeTrack'] = $dir . "/SpecialTradeTrack.php";
$wgAutoloadClasses['TradeTrackScreen'] = $dir . "/templates/TradeTrackScreen.php";
$wgAutoloadClasses['TradeTrackScreenDetailsForm'] = $dir . "/templates/TradeTrackScreenDetailsForm.php";
$wgAutoloadClasses['TradeTrackScreenNonComAgreement'] = $dir . "/templates/TradeTrackScreenNonComAgreement.php";
$wgAutoloadClasses['TradeTrackScreenRouting'] = $dir . "/templates/TradeTrackScreenRouting.php";
$wgAutoloadClasses['TradeTrackScreenThanks'] = $dir . "/templates/TradeTrackScreenThanks.php";
$wgAutoloadClasses['TradeTrackEmail'] = $dir . "/templates/TradeTrackEmail.php";

$wgSpecialPages['TradeTrack'] = 'SpecialTradeTrack';
$wgSpecialPageGroups['TradeTrack'] = 'other';

$wgExtensionMessagesFiles['TradeTrack'] = $dir . "/TradeTrack.i18n.php";
$wgExtensionMessagesFiles['TradeTrackAlias'] = $dir . "/TradeTrack.alias.php";

$wgTradeTrackEmailCommercial = "bharris@wikimedia.org";  // Who gets commercial requests (Kul)
$wgTradeTrackEmailNonCommercial = "bharris@wikimedia.org"; // Who gets non-commercial requests (Mike)
$wgTradeTrackEmailMedia = "bharris@wikimedia.org"; // Who gets media requests (Jay)

