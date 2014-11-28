<?php
/**
 * Enables CuratedContent on wikias where GameGuides was enabled
 * https://wikia-inc.atlassian.net/browse/DAT-2264
 *
 * Get familiar with "How_to_run_maintenance_script" article on internal to figure out how to run it.
 *
 */

ini_set( "include_path", dirname( __FILE__ ) . "/.." );
require_once( 'commandLine.inc' );
$app = F::app();
$cityId = $app->wg->CityId;
if ( empty( $cityId ) ) {
	die( "Error: Invalid wiki id." );
}

$statusEnabled = WikiFactory::setVarByName( 'wgEnableCuratedContentExt', $cityId, $app->wg->GameGuidesContentForAdmins );
if ( $statusEnabled == 0 ) {
	die( "Error: Cannot Set EnableCuratedContentExt Variable" );
}

echo "enabled Curated Content on wikiId: " . $cityId . "\n";
