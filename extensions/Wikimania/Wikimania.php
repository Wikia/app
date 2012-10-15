<?php
/**
 * Extension for managing the Wikimania conferences
 */

if( !defined( 'MEDIAWIKI' ) ) {
	die( "Don't do that." );
}

// Extension credits
$wgExtensionCredits['specialpages'][] = array(
	'path'           => __FILE__,
	'name'           => 'Wikimania',
	'author'         => array( 'Chad Horohoe' ),
	'descriptionmsg' => 'wikimania-desc',
	'url'            => 'https://www.mediawiki.org/wiki/Extension:Wikimania',
	'version'        => 0.1,
);

$d = dirname( __FILE__ );

/**
 * Classes
 */
$wgAutoloadClasses['Payment'] = "$d/backend/Payment.php";
$wgAutoloadClasses['PaymentGoogleCheckout'] = "$d/backend/PaymentGoogleCheckout.php";
$wgAutoloadClasses['PaymentPaypal'] = "$d/backend/PaymentPaypal.php";
$wgAutoloadClasses['Wikimania'] = "$d/backend/Wikimania.php";
$wgAutoloadClasses['WikimaniaRegistration'] = "$d/backend/WikimaniaRegistration.php";
$wgAutoloadClasses['WikimaniaSchema'] = "$d/backend/WikimaniaSchema.php";
$wgAutoloadClasses['SpecialAdministerWikimania'] = "$d/specials/SpecialAdministerWikimania.php";
$wgAutoloadClasses['SpecialCheckWikimaniaStatus'] = "$d/specials/SpecialCheckWikimaniaStatus.php";
$wgAutoloadClasses['SpecialRegisterForWikimania'] = "$d/specials/SpecialRegisterForWikimania.php";

/**
 * i18n
 */
$wgExtensionMessagesFiles['wikimania'] = "$d/lang/Wikimania.i18n.php";
$wgExtensionMessagesFiles['wikimaniaAlias'] = "$d/lang/Wikimania.alias.php";

/**
 * Special pages
 */
$wgSpecialPages['AdministerWikimania'] = 'SpecialAdministerWikimania';
$wgSpecialPages['CheckWikimaniaStatus'] = 'SpecialCheckWikimaniaStatus';
$wgSpecialPages['RegisterForWikimania'] = 'SpecialRegisterForWikimania';
$wgSpecialPageGroups['AdministerWikimania'] = 'wikimania';
$wgSpecialPageGroups['CheckWikimaniaStatus'] = 'wikimania';
$wgSpecialPageGroups['RegisterForWikimania'] = 'wikimania';

/**
 * Hooks
 */
$wgHooks['LoadExtensionSchemaUpdates'][] = 'WikimaniaSchema::hook';

/**
 * Rights
 */
$wgAdditionalRights[] = 'wikimania-register';
$wgAdditionalRights[] = 'wikimania-checkstatus';
$wgAdditionalRights[] = 'wikimania-admin';
$wgGroupPermissions['user']['wikimania-register'] = true;
$wgGroupPermissions['user']['wikimania-checkstatus'] = true;
$wgGroupPermissions['sysop']['wikimania-admin'] = true;

/**
 * RL
 */
$wgResourceModules['ext.wikimania'] = array(
	'localBasePath' => dirname( __FILE__ ) . '/resources',
	'remoteExtPath' => 'Wikimania/resources',
	'styles'  => 'ext.wikimania.css',
);

/**
 * Configuration array for Wikimania. It is a complex array, with many sub-options.
 * Dates, unless otherwise specified, should be in MediaWiki timestamp format,
 * that is: YYYYMMDDHHMMSS
 *
 *  year                => The year of the conference, 2011, 2012, etc.
 *  openDate            => Date to begin accepting registrations
 *  closeDate           => Date to end accepting registrations
 *  baseCurrency        => All prices are in this currency
 *  country             => Country hosting this year's Wikimania
 *  paymentClass        => Which payment handler to use for checkout. Right now
 *                         takes one of PaymentGoogleCheckout|PaymentPaypal
 *  (pre|main|post)Days => Arrays configuring the days available for registration
 *                         for the conference, including pre-events (eg: Developer
 *                         Days) and post-event days (unconference or tours). They
 *                         should each be given a unique key, a date, price and url
 *                         to describe the event.
 */
$wgWikimaniaConf = array(
	'year' => 2012,
	'openDate'  => '',
	'closeDate' => '',
	'baseCurrency' => 'USD',
	'country' => 'us',
	'paymentClass' => 'PaymentGoogleCheckout',
	'preDays' => array(
		'devday1' => array(
			'date' => '',
			'price' => '',
			'url' => '',
		),
		'devday2' => array(
			'date' => '',
			'price' => '',
		),
	),
	'mainDays' => array(

	),
	'postDays' => array(
		'unconf1' => array(

		),
	),
);
