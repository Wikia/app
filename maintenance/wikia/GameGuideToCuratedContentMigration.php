<?php
/**
 * Migration Script from GameGuideContent to CuratedContent
 * https://wikia-inc.atlassian.net/browse/DAT-2264
 *
 * Get familiar with "How_to_run_maintenance_script" article on internal to figure out how to run it.
 *
 */

ini_set( "include_path", dirname( __FILE__ ) . "/.." );
require_once( 'commandLine.inc' );
require_once( "../extensions/wikia/CuratedContent/maintenance/GameGuideToCuratedContentHelper.php" );
$app = F::app();
$cityId = $app->wg->CityId;
if ( empty( $cityId ) ) {
	die( "Error: Invalid wiki id." );
}

$convertGameGuideToCuratedContent = GameGuideToCuratedContentHelper::ConvertGameGuideToCuratedContent( $app->wg->WikiaGameGuidesContent );

$statusContent = ( new CommunityDataService( $cityId ) )->setCuratedContent( $convertGameGuideToCuratedContent );
if ( $statusContent == 0 ) {
	die( "Error: Cannot Set WikiaCuratedContent Variable" );
}

echo "set content on wikiId: " . $cityId . "\n";
