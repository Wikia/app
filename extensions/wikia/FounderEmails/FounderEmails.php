<?php
/**
 * Founder Emails Extensions - helps informing founders about changes on their wiki
 *
 * @author Adrian 'ADi' Wieczorek <adi(at)wikia-inc.com>
 */

if (!defined('MEDIAWIKI')) {
	die();
}

global $wgCityId, $wgAutoloadClasses, $wgExtensionCredits;

$wgExtensionCredits['specialpage'][] = array(
	'name' => 'Founder Emails',
	'author' => 'Adrian \'ADi\' Wieczorek',
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/FounderEmails',
	'descriptionmsg' => 'founderemails-desc'
);

/**
 * messages file
 */
$wgExtensionMessagesFiles['FounderEmails'] = dirname( __FILE__ ) . '/FounderEmails.i18n.php';

/**
 * extension config
 */
$wgFounderEmailsEvents = [
	'edit' => [
		'className' => 'FounderEmailsEditEvent',
		'skipUsers' => [929702 /* CreateWiki script */, 22439 /* Wikia */]
	],
	'register' => [
		'className' => 'FounderEmailsRegisterEvent',
	],
	'daysPassed' => [
		'className' => 'FounderEmailsDaysPassedEvent',
		'days' => [0, 3, 10]
	],
	'completeDigest' => [
		'className' => 'FounderEmailsCompleteDigestEvent',
	],
	'viewsDigest' => [
		'className' => 'FounderEmailsViewsDigestEvent',
	]
];

/**
 * setup functions
 */
$wgExtensionFunctions[] = 'wfFounderEmailsInit';

function wfFounderEmailsInit()
{
	global $wgHooks, $wgAutoloadClasses;

	$dir = dirname(__FILE__) . '/';

	/**
	 * classes
	 */
	$wgAutoloadClasses['FounderEmails'] = $dir . 'FounderEmails.class.php';
	$wgAutoloadClasses['FounderEmailsEvent'] = $dir . 'FounderEmailsEvent.class.php';
	$wgAutoloadClasses['FounderEmailsEditEvent'] = $dir . 'events/FounderEmailsEditEvent.class.php';
	$wgAutoloadClasses['FounderEmailsRegisterEvent'] = $dir . 'events/FounderEmailsRegisterEvent.class.php';
	$wgAutoloadClasses['FounderEmailsDaysPassedEvent'] = $dir . 'events/FounderEmailsDaysPassedEvent.class.php';
	$wgAutoloadClasses['FounderEmailsCompleteDigestEvent'] = $dir . 'events/FounderEmailsCompleteDigestEvent.class.php';
	$wgAutoloadClasses['FounderEmailsViewsDigestEvent'] = $dir . 'events/FounderEmailsViewsDigestEvent.class.php';

	$wgHooks['RecentChange_save'][] = 'FounderEmailsEditEvent::recentChanges';
	$wgHooks['CreateWikiLocalJob-complete'][] = 'FounderEmailsDaysPassedEvent::createWikiCompleted';

	$wgHooks['GetPreferences'][] = 'FounderEmails::onGetPreferences';
	$wgHooks['UserRights'][] = 'FounderEmails::onUserRightsChange';
}

$dir = dirname(__FILE__) . '/';
$wgAutoloadClasses['FounderEmailsController'] = $dir . 'FounderEmailsController.class.php';
$wgAutoloadClasses['SpecialFounderEmails'] = $dir . 'SpecialFounderEmails.class.php';

// Set default for the toggle (applied to all new user accounts).  This is safe even if this user isn't a founder yet.
$wgDefaultUserOptions["founderemails-joins-$wgCityId"] = 0;
$wgDefaultUserOptions["founderemails-edits-$wgCityId"] = 0;
$wgDefaultUserOptions["founderemails-views-digest-$wgCityId"] = 0;
$wgDefaultUserOptions["founderemails-complete-digest-$wgCityId"] = 0;

$wgSpecialPages['FounderEmails'] = 'SpecialFounderEmails';
