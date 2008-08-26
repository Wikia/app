<?php
/**
 * @package MediaWiki
 * @addtopackage maintenance
 * @author eloy@wikia
 *
 * dump wikifactory variables as php values
 *
 */

ini_set( "include_path", dirname(__FILE__)."/.." );
require_once( "commandLine.inc" );


$dbr = wfGetDB( DB_SLAVE );
echo "<?php\n\n";

$oRes = $dbr->select(
    array(
        wfSharedTable( "city_variables" ),
        wfSharedTable( "city_variables_pool" )
    ),
    array( "*" ),
    array( "cv_city_id" => $wgCityId, "cv_variable_id = cv_id" ),
    __FILE__
);

$variables = array();
while( $oRow = $dbr->fetchObject( $oRes ) ) {
	$variables[] = $oRow; #--- for future usage
	$oVar = WikiFactory::getVarByID( $oRow->cv_variable_id, $oRow->cv_city_id );
	print_r( $oVar );
}
