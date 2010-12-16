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

// Override these with appropriate DB settings for the CiviCRM database...
$wgContributionReportingDBserver = $wgDBserver;
$wgContributionReportingDBuser = $wgDBuser;
$wgContributionReportingDBpassword = $wgDBpassword;
$wgContributionReportingDBname = $wgDBname;

// And now the tracking database
$wgContributionTrackingDBserver = $wgDBserver;
$wgContributionTrackingDBuser = $wgDBuser;
$wgContributionTrackingDBpassword = $wgDBpassword;
$wgContributionTrackingDBname = $wgDBname;

$wgExtensionCredits['specialpage'][] = array(
	'path' => __FILE__,
	'name' => 'Contribution Reporting',
	'url' => 'http://www.mediawiki.org/wiki/Extension:ContributionReporting',
	'author' => array( 'David Strauss', 'Brion Vibber', 'Siebrand Mazeland', 'Trevor Parscal', 'Tomasz Finc' ),
	'descriptionmsg' => 'contributionreporting-desc',
);

$dir = dirname( __FILE__ ) . '/';

$wgExtensionMessagesFiles['ContributionReporting'] = $dir . 'ContributionReporting.i18n.php';
$wgExtensionAliasesFiles['ContributionReporting'] = $dir . 'ContributionReporting.alias.php';

$wgAutoloadClasses['ContributionHistory'] = $dir . 'ContributionHistory_body.php';
$wgAutoloadClasses['ContributionTotal'] = $dir . 'ContributionTotal_body.php';
$wgAutoloadClasses['SpecialContributionStatistics'] = $dir . 'ContributionStatistics_body.php';
$wgAutoloadClasses['SpecialFundraiserStatistics'] = $dir . 'FundraiserStatistics_body.php';
$wgAutoloadClasses['SpecialContributionTrackingStatistics'] = $dir . 'ContributionTrackingStatistics_body.php';

$wgSpecialPages['ContributionHistory'] = 'ContributionHistory';
$wgSpecialPages['ContributionTotal'] = 'ContributionTotal';
$wgSpecialPages['ContributionStatistics'] = 'SpecialContributionStatistics';
$wgSpecialPages['FundraiserStatistics'] = 'SpecialFundraiserStatistics';
$wgSpecialPages['ContributionTrackingStatistics'] = 'SpecialContributionTrackingStatistics';
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
);

// Thesholds for fundraiser statistics
$egFundraiserStatisticsMinimum = 1;
$egFundraiserStatisticsMaximum = 10000;



$wgContributionTrackingStatisticsViewWeeks = 3;

$wgHooks['ParserFirstCallInit'][] = 'efContributionReportingSetup';
$wgHooks['LanguageGetMagic'][] = 'efContributionReportingTotal_Magic';

function efContributionReportingSetup( $parser ) {
	$parser->setFunctionHook( 'contributiontotal', 'efContributionReportingTotal_Render' );
	return true;
}

function efContributionReportingTotal_Magic( &$magicWords, $langCode ) {
	$magicWords['contributiontotal'] = array( 0, 'contributiontotal' );
	return true;
}

// Automatically use a local or special database connection
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

function efContributionReportingTotal( $start, $fudgeFactor ) {
	$db = efContributionReportingConnection();

	$sql = 'SELECT ROUND( SUM(converted_amount) ) AS ttl FROM public_reporting';

	if ( $start ) {
		$sql .= ' WHERE received >= ' . $db->addQuotes( wfTimestamp( TS_UNIX, $start ) );
	}

	$res = $db->query( $sql );

	$row = $res->fetchRow();

	# Output
	$output = $row['ttl'] ? $row['ttl'] : '0';
	
	$output += $fudgeFactor;
	
	return $output;
}

function efContributionReportingTotal_Render() {
	$args = func_get_args();
	$parser = array_shift( $args );
	
	$fudgeFactor = false;
	$start = false;
	
	foreach( $args as $arg ) {
		if ( strpos($arg,'=') === false )
			continue;
		
		list($key,$value) = explode( '=', trim($arg), 2 );
		
		if ($key == 'fudgefactor') {
			$fudgeFactor = $value;
		} elseif ($key == 'start') {
			$start = $value;
		}
	}
	
	return efContributionReportingTotal( $start, $fudgeFactor );
}
