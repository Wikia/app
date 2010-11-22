<?php

/**
 * @package MediaWiki
 * @addtopackage maintenance
 */

ini_set( "include_path", dirname(__FILE__)."/../../../../maintenance/" );
require_once( "commandLine.inc" );

$dbw = wfGetDB( DB_SLAVE, array(), $wgAdSS_DBname );
$res = $dbw->select(
		array( 'ads' ),
		array( 'ad_wiki_id', 'count(*) as ad_cnt', 'sum(ad_weight) as weight_sum', 'count( distinct( ad_user_id ) ) as user_cnt' ),
		array(
			'ad_closed' => null,
			'ad_expires IS NOT NULL',
			),
		__METHOD__,
		array(
			'GROUP BY' => 'ad_wiki_id',
			'ORDER BY' => 'ad_cnt desc, weight_sum desc, user_cnt desc',
		     )
	       );

$total_ad_cnt = $total_weight_sum = 0;
$others_ad_cnt = $others_weight_sum = 0;
printf( "%30s | %10s | %10s | %10s\n", "Wiki", "# of ads", "# of shares", "# of users" );
$i=0;
foreach( $res as $row ) {
	$wiki = WikiFactory::getWikiByID( $row->ad_wiki_id );
	if( $i<5 ) {
		printf( "%30s | %10s | %10s | %10s\n", $wiki->city_title . " (id=".$wiki->city_id.")", $row->ad_cnt, $row->weight_sum, $row->user_cnt );
	} else {
		$others_ad_cnt += $row->ad_cnt;
		$others_weight_sum += $row->weight_sum;
	}
	$i++;
	$total_ad_cnt += $row->ad_cnt;
	$total_weight_sum += $row->weight_sum;
}
$dbw->freeResult( $res );
printf( "%30s | %10s | %10s | %10s\n", "others", $others_ad_cnt, $others_weight_sum, "" );
printf( "%30s | %10s | %10s | %10s\n", "", "", "", "" );
printf( "%30s | %10s | %10s | %10s\n", "TOTAL", $total_ad_cnt, $total_weight_sum, "" );
