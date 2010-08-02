<?php

/**
 * @package MediaWiki
 * @subpackage SpecialPage
 * @author Piotr Molski (moli@wikia.com)
 * @version: $Id$
 */

if ( !defined( 'MEDIAWIKI' ) ) {
    echo "This is MediaWiki extension and cannot be used standalone.\n";
    exit( 1 ) ;
}

define ("WIKISTATS_TREND_MONTH", 5);
define ("WIKISTATS_TREND_CITY_NBR", 20);
define ("WIKISTATS_WIKIANS_RANK_NBR", 10);
define ("WIKISTATS_COLUMN_CITY_NBR", 59);
define ("WIKISTATS_MIN_STATS_DATE", '2001-01');
define ("WIKISTATS_COLUMN_PREFIX", "diff_");
define ("WIKISTATS_MIN_COUNT_STATS_YEAR", '2000');
define ("WIKISTATS_MIN_COUNT_STATS_YEAR_MONTH", '200012');
define ("WIKISTATS_MIN_STATS_YEAR", '2008');
define ("WIKISTATS_MIN_STATS_MONTH", '01');
define ("WIKISTATS_RANGE_STATS_MIN", 'A');
define ("WIKISTATS_RANGE_STATS_MAX", 'K');
define ("WIKISTATS_STATS_EMPTY_LINE_TAG", "_empty_%s");
define ("WIKISTATS_DEFAULT_WIKIA_XLS_FILENAME", "wikia_xls_%d");
define ("WIKISTATS_MAX_CHART_HEIGHT", '180');
define ("WIKISTATS_CHART_BAR_WIDTH", '14');
define ("WIKISTATS_CHART_BAR_WIDTH_UNIT", 'px');
define ("WIKISTATS_CENTRAL_ID", 'wikicities');
define ("WIKISTATS_ABSENT_TIME", 60 * 60 * 24 * 30);
define ("WIKISTATS_ANON_ARRAY_LGTH", 30);


$wgExtensionCredits['specialpage'][] = array(
    'name' => 'WikiStats',
    'url' => 'http://help.wikia.com/wiki/Help:WikiaStats',
    "description" => "Gathers a wide array of statistics for this wiki and adds an GUI to browse them. Inspired by and partially based on the original [http://meta.wikimedia.org/wiki/Wikistats WikiStats] written by Erik Zachte",
    "author" => "Piotr Molski (moli) <moli@wikia-inc.com>"
);

$wgStatsExcludedNonSpecialGroup = array();
$wgStatsSpecialGroupUser = false;

#--- messages file
$wgExtensionMessagesFiles["WikiStats"] = dirname(__FILE__) . '/SpecialWikiStats.i18n.php';

#--- helper file
require_once( dirname(__FILE__) . '/SpecialWikiStats_helper.php' );

#--- ajax's method file
require_once( dirname(__FILE__) . '/SpecialWikiStats_ajax.php' );

#--- xls method file
require_once( dirname(__FILE__) . '/SpecialWikiStats_xls.php' );

#--- register special page (MW 1.10 way)
if ( !function_exists( 'extAddSpecialPage' ) ) {
    require( "$IP/extensions/ExtensionFunctions.php" );
}

$wgStatsIgnoreWikis = array( 5, 11, 6745 );

extAddSpecialPage( dirname(__FILE__) . '/SpecialWikiStats_body.php', 'WikiStats', 'WikiStatsPage' );

?>
