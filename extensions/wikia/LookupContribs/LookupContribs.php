<?php

$wgExtensionCredits['specialpage'][] = [
	"name" => "LookupContribs",
	"descriptionmsg" => "lookupcontribs-desc",
	"author" => array( "Bartek Lapinski", "Piotr Molski" ),
	"url" => "https://github.com/Wikia/app/tree/dev/extensions/wikia/LookupContribs",
];

$dir = dirname( __FILE__ ) . '/';

/**
 * classes
 */
$wgAutoloadClasses['LookupContribsCore'] =  $dir . 'SpecialLookupContribs_helper.php';
$wgAutoloadClasses['LookupContribsAjax'] =  $dir . 'SpecialLookupContribs_ajax.php';
$wgAutoloadClasses['LookupContribsPage'] =  $dir . 'SpecialLookupContribs_body.php';
$wgAutoloadClasses['LookupContribsHooks'] =  $dir . 'SpecialLookupContribs_hooks.php';

/**
 * special pages
 */
$wgSpecialPages['LookupContribs'] = 'LookupContribsPage';
$wgSpecialPageGroups['LookupContribs'] = 'users';

/**
 * i18n
 */
$wgExtensionMessagesFiles["SpecialLookupContribs"] = $dir . 'SpecialLookupContribs.i18n.php';

/**
 * hooks
 */
$wgHooks['ArticleSaveComplete'][] = 'LookupContribsHooks::ArticleSaveComplete';
$wgHooks['ContributionsToolLinks'][] = 'LookupContribsHooks::ContributionsToolLinks';

$wgAjaxExportList[] = "LookupContribsAjax::axData";

