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
	'url' => 'http://www.wikia.com' ,
	'description' => 'Helps informing founders about changes on their wiki',
	'descriptionmsg' => 'founderemails-desc'
);

/**
 * messages file
 */
$wgExtensionMessagesFiles['FounderEmails'] = dirname( __FILE__ ) . '/FounderEmails.i18n.php';

/**
 * extension config
 */
$wgFounderEmailsExtensionConfig = array(
	'events' => array(
		'edit'       => array(
			'className'  => 'FounderEmailsEditEvent',
			'threshold'  => 1,
			'hookName'   => 'RecentChange_save',
			'skipUsers'  => array( 929702 /* CreateWiki script */, 22439 /* Wikia */ )
		),
		'register'   => array(
			'className'  => 'FounderEmailsRegisterEvent',
			'threshold'  => 1,
			'hookName'   => 'AddNewAccount'
		),
		'daysPassed' => array(
			'className'  => 'FounderEmailsDaysPassedEvent',
			'hookName'   => 'CreateWikiLocalJob-complete',
			'days'       => array( 0, 3, 10 )
		),
		'completeDigest' => array(
			'className'  => 'FounderEmailsCompleteDigestEvent',
			'hookName'   => null
		),
		'viewsDigest' => array(
			'className'  => 'FounderEmailsViewsDigestEvent',
			'hookName'   => null
		)
	)
);

/**
 * setup functions
 */
$wgExtensionFunctions[] = 'wfFounderEmailsInit';

function wfFounderEmailsInit() {
	global $wgHooks, $wgAutoloadClasses, $wgFounderEmailsExtensionConfig, $wgDefaultUserOptions, $wgCityId;

	$dir = dirname( __FILE__ ) . '/';

	/**
	 * classes
	 */
	$wgAutoloadClasses['FounderEmails'] = $dir . 'FounderEmails.class.php';
	$wgAutoloadClasses['FounderEmailsEvent'] = $dir . 'FounderEmailsEvent.class.php';

	// add event classes & hooks
	foreach ( $wgFounderEmailsExtensionConfig['events'] as $event ) {
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

$dir = dirname(__FILE__).'/';
$wgAutoloadClasses['FounderEmailsController'] = $dir . 'FounderEmailsController.class.php';
$wgAutoloadClasses['SpecialFounderEmails'] = $dir . 'SpecialFounderEmails.class.php';

$wgSpecialPages['FounderEmails'] = 'SpecialFounderEmails';
