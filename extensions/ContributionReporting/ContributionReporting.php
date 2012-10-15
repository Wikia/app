<?php

# Alert the user that this is not a valid entry point to MediaWiki if they try to access the special pages file directly.
if ( !defined( 'MEDIAWIKI' ) ) {
	echo <<<EOT
To install my extension, put the following line in LocalSettings.php:
require_once( "\$IP/extensions/ContributionReporting/ContributionReporting.php" );
EOT;
	exit( 1 );
}

$wgContributionReportingBaseURL = "http://meta.wikimedia.org/w/index.php?title=Special:NoticeTemplate/view&template=";

// Override these with appropriate DB settings for the CiviCRM master database...
$wgContributionReportingDBserver = $wgDBserver;
$wgContributionReportingDBuser = $wgDBuser;
$wgContributionReportingDBpassword = $wgDBpassword;
$wgContributionReportingDBname = $wgDBname;

// Override these with appropriate DB settings for the CiviCRM slave database...
$wgContributionReportingReadDBserver = $wgDBserver;
$wgContributionReportingReadDBuser = $wgDBuser;
$wgContributionReportingReadDBpassword = $wgDBpassword;
$wgContributionReportingReadDBname = $wgDBname;

// And now the tracking database
$wgContributionTrackingDBserver = $wgDBserver;
$wgContributionTrackingDBuser = $wgDBuser;
$wgContributionTrackingDBpassword = $wgDBpassword;
$wgContributionTrackingDBname = $wgDBname;

$wgExtensionCredits['specialpage'][] = array(
	'path' => __FILE__,
	'name' => 'Contribution Reporting',
	'url' => 'https://www.mediawiki.org/wiki/Extension:ContributionReporting',
	'author' => array( 'David Strauss', 'Brion Vibber', 'Siebrand Mazeland', 'Trevor Parscal', 'Tomasz Finc' ),
	'descriptionmsg' => 'contributionreporting-desc',
);

$dir = dirname( __FILE__ ) . '/';

$wgExtensionMessagesFiles['ContributionReporting'] = $dir . 'ContributionReporting.i18n.php';
$wgExtensionMessagesFiles['ContributionReportingAlias'] = $dir . 'ContributionReporting.alias.php';
$wgExtensionMessagesFiles['ContributionReportingMagic'] = $dir . 'ContributionReporting.magic.php';

$wgAutoloadClasses['ContributionHistory'] = $dir . 'ContributionHistory_body.php';
$wgAutoloadClasses['ContributionTotal'] = $dir . 'ContributionTotal_body.php';
$wgAutoloadClasses['SpecialContributionStatistics'] = $dir . 'ContributionStatistics_body.php';
$wgAutoloadClasses['SpecialFundraiserStatistics'] = $dir . 'FundraiserStatistics_body.php';
$wgAutoloadClasses['SpecialContributionTrackingStatistics'] = $dir . 'ContributionTrackingStatistics_body.php';
$wgAutoloadClasses['SpecialDailyTotal'] = $dir . 'DailyTotal_body.php';
/*
$wgAutoloadClasses['DisabledNotice'] = $dir . 'DisabledNotice_body.php';
*/

$wgSpecialPages['ContributionHistory'] = 'ContributionHistory';
$wgSpecialPages['ContributionTotal'] = 'ContributionTotal';
$wgSpecialPages['ContributionStatistics'] = 'SpecialContributionStatistics';
$wgSpecialPages['FundraiserStatistics'] = 'SpecialFundraiserStatistics';
$wgSpecialPages['ContributionTrackingStatistics'] = 'SpecialContributionTrackingStatistics';
$wgSpecialPages['DailyTotal'] = 'SpecialDailyTotal';

$wgSpecialPageGroups['ContributionHistory'] = 'contribution';
$wgSpecialPageGroups['ContributionTotal'] = 'contribution';
$wgSpecialPageGroups['ContributionStatistics'] = 'contribution';
$wgSpecialPageGroups['FundraiserStatistics'] = 'contribution';
$wgSpecialPageGroups['ContributionTrackingStatistics'] = 'contribution';

// Shortcut to this extension directory
$dir = dirname( __FILE__ ) . '/';

// CutOff for fiscal year
$egContributionStatisticsFiscalYearCutOff = 'July 1';

// Days back to show
$egContributionStatisticsViewDays = 7;

// Fundraiser dates
// Please list these in chronological order
$egFundraiserStatisticsFundraisers = array(
	array(
		'id' => '2007',
		'title' => '2007 Fundraiser',
		'start' => 'Oct 22 2007',
		'end' => 'Jan 3 2008'
	),
	array(
		'id' => '2008',
		'title' => '2008 Fundraiser',
		'start' => 'Nov 4 2008',
		'end' => 'Jan 9 2009'
	),
	array(
		'id' => '2009',
		'title' => '2009 Fundraiser',
		'start' => 'Nov 10 2009',
		'end' => 'Jan 15 2010'
	),
	array(
		'id' => '2010',
		'title' => '2010 Fundraiser',
		'start' => 'Nov 11 2010',
		'end' => 'Jan 15 2011',
	),
	array(
		'id' => '2011',
		'title' => '2011 Fundraiser',
		'start' => 'Nov 16 2011',
		'end' => 'Jan 15 2012',
	),
);

// The first year of statistics to make visible by default.
// We normally don't show all of them by default, since it makes the chart extremely wide.
$egFundraiserStatisticsFirstYearDefault = 2009;

// Thesholds for fundraiser statistics
$egFundraiserStatisticsMinimum = 1;
$egFundraiserStatisticsMaximum = 10000;

// Cache timeout for fundraiser statistics (short timeout), in seconds
$egFundraiserStatisticsCacheTimeout = 900; // 15 minutes
// Cache timeout for fundraiser statistics (long timeout), in seconds
$wgFundraiserStatisticsLongCacheTimeout = 60 * 60 * 24 * 7; // one week


$wgContributionTrackingStatisticsViewWeeks = 3;

$commonModuleInfo = array(
	'localBasePath' => dirname( __FILE__ ) . '/modules',
	'remoteExtPath' => 'ContributionReporting/modules',
);

$wgResourceModules['ext.fundraiserstatistics.table'] = array(
	'styles' => 'ext.fundraiserstatistics.table.css',
) + $commonModuleInfo;

$wgResourceModules['ext.fundraiserstatistics'] = array(
	'scripts' => 'ext.fundraiserstatistics.js',
	'styles' => 'ext.fundraiserstatistics.css',
) + $commonModuleInfo;

$wgResourceModules['ext.disablednotice'] = array(
	'styles' => 'ext.disablednotice.css',
) + $commonModuleInfo;

$wgHooks['ParserFirstCallInit'][] = 'efContributionReportingSetup';

/**
 * @param $parser Parser
 * @return bool
 */
function efContributionReportingSetup( $parser ) {
	$parser->setFunctionHook( 'contributiontotal', 'efContributionReportingTotal_Render' );
	return true;
}

/**
 * Automatically use a local or special database connection for reporting
 * This connection will typically be to the CiviCRM master database
 * @return DatabaseMysql
 */
function efContributionReportingConnection() {
	global $wgContributionReportingDBserver, $wgContributionReportingDBname;
	global $wgContributionReportingDBuser, $wgContributionReportingDBpassword;

	static $db;

	if ( !$db ) {
		$db = new DatabaseMysql(
			$wgContributionReportingDBserver,
			$wgContributionReportingDBuser,
			$wgContributionReportingDBpassword,
			$wgContributionReportingDBname );
		$db->query( "SET names utf8" );
	}

	return $db;
}

/**
 * Automatically use a local or special database connection for reporting
 * This connection will typically be to a CiviCRM slave database
 * @return DatabaseMysql
 */
function efContributionReportingReadConnection() {
	global $wgContributionReportingReadDBserver, $wgContributionReportingReadDBname;
	global $wgContributionReportingReadDBuser, $wgContributionReportingReadDBpassword;

	static $db;

	if ( !$db ) {
		$db = new DatabaseMysql(
			$wgContributionReportingReadDBserver,
			$wgContributionReportingReadDBuser,
			$wgContributionReportingReadDBpassword,
			$wgContributionReportingReadDBname );
		$db->query( "SET names utf8" );
	}

	return $db;
}

/**
 * Automatically use a local or special database connection for tracking
 * @return DatabaseMysql
 */
function efContributionTrackingConnection() {
	global $wgContributionTrackingDBserver, $wgContributionTrackingDBname;
	global $wgContributionTrackingDBuser, $wgContributionTrackingDBpassword;

	static $db;

	if ( !$db ) {
		$db = new DatabaseMysql(
			$wgContributionTrackingDBserver,
			$wgContributionTrackingDBuser,
			$wgContributionTrackingDBpassword,
			$wgContributionTrackingDBname );
		$db->query( "SET names utf8" );
	}

	return $db;
}

/**
 * Get the total amount of money raised for a specific fundraiser
 * @param string $fundraiser The ID of the fundraiser to return the current total for
 * @param int $fudgeFactor How much to adjust the total by
 * @return integer
 */
function efContributionReportingTotal( $fundraiser, $fudgeFactor = 0 ) {
	global $wgMemc, $egFundraiserStatisticsFundraisers, $egFundraiserStatisticsCacheTimeout;

	// If a total is cached, use that
	$key = wfMemcKey( 'contributionreportingtotal', $fundraiser, $fudgeFactor );
	$cache = $wgMemc->get( $key );
	if ( $cache != false && $cache != -1 ) {
		return $cache;
	}
	
	$dbr = wfGetDB( DB_SLAVE );
	
	// Find the index number for the requested fundraiser
	$myFundraiserIndex = false;
	foreach ( $egFundraiserStatisticsFundraisers as $fundraiserIndex => $fundraiserArray ) {
		if ( $fundraiserArray['id'] == $fundraiser ) {
			$myFundraiserIndex = $fundraiserIndex;
			break;
		}
	}
	if ( !$myFundraiserIndex ) {
		// If none was found, use the most recent fundraiser
		$myFundraiserIndex = count( $egFundraiserStatisticsFundraisers ) - 1;
	}
	
	$myFundraiser = $egFundraiserStatisticsFundraisers[$myFundraiserIndex];

	// First, try to get the total from the summary table
	$result = $dbr->select(
		'public_reporting_fundraisers',
		'round( prf_total ) AS total',
		array( 'prf_id' => $myFundraiser['id'] ),
		__METHOD__
	);
	$row = $dbr->fetchRow( $result );
	
	if ( $row['total'] > 0 ) {
		$total = $row['total'];
	} else {
		$total = 0;
	}
	
	// Make sure the fudge factor is a number
	if ( is_nan( $fudgeFactor ) ) {
		$fudgeFactor = 0;
	}

	// Add the fudge factor to the total
	$total += $fudgeFactor;

	$wgMemc->set( $key, $total, $egFundraiserStatisticsCacheTimeout );
	return $total;
}

/**
 * @return integer
 */
function efContributionReportingTotal_Render() {
	$args = func_get_args();
	array_shift( $args );

	$fudgeFactor = false;
	$start = false;

	foreach( $args as $arg ) {
		if ( strpos( $arg,'=' ) === false ) {
			continue;
		}

		list( $key, $value ) = explode( '=', trim( $arg ), 2 );

		if ( $key == 'fudgefactor' ) {
			$fudgeFactor = $value;
		} elseif ( $key == 'fundraiser' ) {
			$fundraiser = $value;
		}
	}

	return efContributionReportingTotal( $fundraiser, $fudgeFactor );
}
