<?php

# Alert the user that this is not a valid entry point to MediaWiki if they try to access the special pages file directly.
if ( !defined( 'MEDIAWIKI' ) ) {
	echo <<<EOT
To install my extension, put the following line in LocalSettings.php:
require_once( "\$IP/extensions/ContributionTracking/ContributionTracking.php" );
EOT;
	exit( 1 );
}

$wgExtensionCredits['specialpage'][] = array(
	'path'           => __FILE__,
	'name'           => 'ContributionTracking',
	'url'            => 'https://www.mediawiki.org/wiki/Extension:ContributionTracking',
	'author'         => 'David Strauss',
	'descriptionmsg' => 'contributiontracking-desc',
);

$dir = dirname( __FILE__ ) . '/';

$wgExtensionMessagesFiles['ContributionTracking'] = $dir . 'ContributionTracking.i18n.php';
$wgExtensionMessagesFiles['ContributionTrackingAlias'] = $dir . 'ContributionTracking.alias.php';
$wgAutoloadClasses['ContributionTracking'] = $dir . 'ContributionTracking_body.php';
$wgSpecialPages['ContributionTracking'] = 'ContributionTracking';

$wgAutoloadClasses['ContributionTrackingTester'] = $dir . 'ContributionTracking_Tester.php';
$wgSpecialPages['ContributionTrackingTester'] = 'ContributionTrackingTester';

//give sysops access to the tracking tester form.
$wgGroupPermissions['sysop']['ViewContributionTrackingTester'] = true;
$wgAvailableRights[] = 'ViewContributionTrackingTester';

$wgAutoloadClasses['ApiContributionTracking'] = $dir . 'ApiContributionTracking.php';
$wgAutoloadClasses['ContributionTrackingProcessor'] = $dir . 'ContributionTracking.processor.php';
 
//this only works if contribution tracking is inside a mediawiki DB, which typically it isn't.
$wgHooks['LoadExtensionSchemaUpdates'][] = 'efContributionTrackingLoadUpdates';

// Resource modules
$ctResourceTemplate = array(
	'localBasePath' => $dir . 'modules',
	'remoteExtPath' => 'ContributionTracking/modules',
);
$wgResourceModules['jquery.contributionTracking'] = array(
	'scripts' => 'jquery.contributionTracking.js',
	'dependencies' => 'jquery.json',
) + $ctResourceTemplate;


/**
 * The default 'return to' URL for a thank you page after posting to the contribution
 *
 * NO trailing slash, please
 */
$wgContributionTrackingReturnToURLDefault = 'http://wikimediafoundation.org/wiki/Thank_You';

$wgContributionTrackingDBserver = $wgDBserver;
$wgContributionTrackingDBname = $wgDBname;
$wgContributionTrackingDBuser = $wgDBuser;
$wgContributionTrackingDBpassword = $wgDBpassword;

/**
 * IPN listener address for regular PayPal trxns
 */
$wgContributionTrackingPayPalIPN = 'https://civicrm.wikimedia.org/fundcore_gateway/paypal';

/**
 * IPN listener address for recurring payment PayPal trxns
 */
$wgContributionTrackingPayPalRecurringIPN = 'https://civicrm.wikimedia.org/fundcore_gateway/paypal';

/**
 * 'Business' string for PayPal
 */
$wgContributionTrackingPayPalBusiness = 'donations@wikimedia.org';

/**
 * Recurring PayPal subscription Length. Default of 0 is unlimited until canceled
 */

$wgContributionTrackingRPPLength = '0';

# Unit tests
$wgHooks['UnitTestsList'][] = 'efContributionTrackingUnitTests';

function efContributionTrackingUnitTests( &$files ) {
	$files[] = dirname( __FILE__ ) . '/tests/ContributionTrackingTest.php';
	$files[] = dirname( __FILE__ ) . '/tests/ContributionTrackingProcessorTest.php';
	$files[] = dirname( __FILE__ ) . '/tests/ContributionTrackingAPITest.php';
	return true;
}

// api modules
$wgAPIModules['contributiontracking'] = 'ApiContributionTracking';

/**
 * @param $updater DatabaseUpdater
 * @return bool
 */
function efContributionTrackingLoadUpdates( $updater = null ){

	$dir = dirname( __FILE__ ) . '/';
	if ( $updater === null ) {
		global $wgExtNewTables, $wgExtNewFields;

		$wgExtNewTables[] = array( 'contribution_tracking', $dir . 'ContributionTracking.sql' );
		$wgExtNewTables[] = array( 'contribution_tracking_owa_ref', $dir . 'ContributionTracking_OWA_ref.sql' );

		$wgExtNewFields[] = array(
			'contribution_tracking',
			'owa_session',
			$dir . 'patch-owa.sql',
		);
	} else {
		global $wgContributionTrackingDBname;

		if( $updater->getDB()->getDBname() === $wgContributionTrackingDBname ) {
			$updater->addExtensionTable( 'contribution_tracking', $dir . 'ContributionTracking.sql' );
			$updater->addExtensionTable( 'contribution_tracking_owa_ref', $dir . 'ContributionTracking_OWA_ref.sql' );
			$updater->addExtensionUpdate( array( 'addField', 'contribution_tracking', 'owa_session',
				$dir . 'patch-owa.sql', true ) );
		} else { //We are configured not to use the main mediawiki db.
			//Unless the updater is modified not to run
			//'LoadExtensionSchemaUpdates' hooks in its constructor (or do so
			//conditionally), we're going to have to do these manually.
			$ctDB = ContributionTrackingProcessor::contributionTrackingConnection();
			if (!$ctDB->tableExists('contribution_tracking')){
				$ctDB->sourceFile($dir . 'ContributionTracking.sql');
			}
			if (!$ctDB->tableExists('contribution_tracking_owa_ref')){
				$ctDB->sourceFile($dir . 'ContributionTracking_OWA_ref.sql');
			}
			if (!$ctDB->fieldExists('contribution_tracking', 'owa_session')){
				$ctDB->sourceFile($dir . 'patch-owa.sql');
			}
		}
	}
 	return true;

}
