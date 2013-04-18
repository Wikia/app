<?php
/**
 * User: artur
 * Date: 18.04.13
 * Time: 15:23
 */

$optionsWithArgs = array( 'i' );

require_once(__DIR__ . '/../../commandLine.inc');
require_once($IP . '/lib/GoogleWebmasterTools/setup.php');

if( !isset($options['i']) ) {
	echo "Specify wikiid (-i)";
}

$service = new GWTService();
$info = $service->getWikiInfo( $options['i'] );
var_dump($info);
