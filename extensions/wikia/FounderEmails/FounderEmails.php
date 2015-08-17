<?php
/**
 * Founder Emails Extensions - helps informing founders about changes on their wiki
 *
 * @author Adrian 'ADi' Wieczorek <adi(at)wikia-inc.com>
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	die();
}

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
	'edit'       => [
		'className'  => 'FounderEmailsEditEvent',
		'hookName'   => 'RecentChange_save',
		'skipUsers'  => [ 929702 /* CreateWiki script */, 22439 /* Wikia */ ]
	],
	'register'   => [
		'className'  => 'FounderEmailsRegisterEvent',
		'hookName'   => 'AddNewAccount'
	],
	'daysPassed' => [
		'className'  => 'FounderEmailsDaysPassedEvent',
		'hookName'   => 'CreateWikiLocalJob-complete',
		'days'       => [ 0, 3, 10 ]
	],
	'completeDigest' => [
		'className'  => 'FounderEmailsCompleteDigestEvent',
		'hookName'   => null
	],
	'viewsDigest' => [
		'className'  => 'FounderEmailsViewsDigestEvent',
		'hookName'   => null
	]
];

/**
 * setup functions
 */
$wgExtensionFunctions[] = 'wfFounderEmailsInit';

function wfFounderEmailsInit() {
	global $wgHooks, $wgAutoloadClasses, $wgFounderEmailsEvents, $wgDefaultUserOptions, $wgCityId;

	$dir = dirname( __FILE__ ) . '/';

	/**
	 * classes
	 */
	$wgAutoloadClasses['FounderEmails'] = $dir . 'FounderEmails.class.php';
	$wgAutoloadClasses['FounderEmailsEvent'] = $dir . 'FounderEmailsEvent.class.php';

	// add event classes & hooks
	foreach ( $wgFounderEmailsEvents as $event ) {
		$wgAutoloadClasses[$event['className']] = $dir . 'events/' . $event['className'] . '.class.php';
		if ( !empty( $event['hookName'] ) ) {
			$wgHooks[$event['hookName']][] = $event['className'] . '::register';
		}
	}

	$wgHooks['GetPreferences'][] = 'FounderEmails::onGetPreferences';
	$wgHooks['UserRights'][] = 'FounderEmails::onUserRightsChange';

	// Set default for the toggle (applied to all new user accounts).  This is safe even if this user isn't a founder yet.
	// $wgDefaultUserOptions["founderemailsenabled"] = 1;  // Old preference not used any more
	$wgDefaultUserOptions["founderemails-joins-$wgCityId"] = 0;
	$wgDefaultUserOptions["founderemails-edits-$wgCityId"] = 0;
	$wgDefaultUserOptions["founderemails-views-digest-$wgCityId"] = 0;
	$wgDefaultUserOptions["founderemails-complete-digest-$wgCityId"] = 0;
}

$dir = dirname( __FILE__ ) . '/';
$wgAutoloadClasses['FounderEmailsController'] = $dir . 'FounderEmailsController.class.php';
$wgAutoloadClasses['SpecialFounderEmails'] = $dir . 'SpecialFounderEmails.class.php';

$wgSpecialPages['FounderEmails'] = 'SpecialFounderEmails';
