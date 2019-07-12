<?php

if ( !defined( 'MEDIAWIKI' ) ) {
	echo "This file is part of MediaWiki, it is not a valid entry point.\n";
	exit( 1 );
}

$dir = __DIR__;

/**
 * info
 */
$wgExtensionCredits['other'][] = array(
	'name' => 'Hydralytics',
	'author' => array(
		'Brent Copeland',
		'Alexia E. Smith',
		'Hydra Wiki Platform Team',
		'Fandom Data Engineering Team'
	),
	'descriptionmsg' => 'hydralytics_description',
	'version' => '1.0',
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/WikiAnalytics',
);

/**
 * classes
 */
$wgAutoloadClasses['Hydralytics\\SpecialAnalytics'] = "{$dir}/specials/SpecialAnalytics.php";
$wgAutoloadClasses['Hydralytics\\Information'] = "{$dir}/classes/Information.php";
$wgAutoloadClasses['Hydralytics\\Redshift'] = "{$dir}/classes/Redshift.class.php";
$wgAutoloadClasses['Hydralytics\\TemplateAnalytics'] = "{$dir}/templates/TemplateAnalytics.php";

/**
 * message files
 */
$wgExtensionMessagesFiles['Hydralytics'] = "{$dir}/Hydralytics.i18n.php";

$wgSpecialPages['Analytics'] = 'Hydralytics\\SpecialAnalytics';

$wgResourceModules['ext.hydralytics.styles'] = array(
	'styles' => array(
	    'extensions/wikia/Hydralytics/css/hydralytics.scss'
	),
);


$wgResourceModules['ext.hydralytics.scripts'] = array(
	'scripts' => array(
	    'extensions/wikia/Hydralytics/js/Chart.bundle.js',
	    'extensions/wikia/Hydralytics/js/moment.js',
	    'extensions/wikia/Hydralytics/js/lodash.min.js',
	    'extensions/wikia/Hydralytics/js/hydralytics.js',
	),
	'dependencies' => array(
	    "mediawiki.language"
	),
	'messages' => array(
		"based_on_last_30",
		"edits",
		"engaged_admins",
		"logged_in",
		"logged_out",
		"new_visitors",
		"nonengaged_admins",
		"page_views",
		"returning_visitors",
		"total_page_views",
		"total_visitors",
	),
);
