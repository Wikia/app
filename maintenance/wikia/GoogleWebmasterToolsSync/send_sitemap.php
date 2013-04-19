<?php
/**
 * User: artur
 * Date: 18.04.13
 * Time: 20:34
 */

$optionsWithArgs = array( 'i' );

require_once(__DIR__ . '/../../commandLine.inc');
require_once($IP . '/lib/GoogleWebmasterTools/setup.php');

if( !isset($options['i']) ) {
	echo "Specify wikiid (-i)";
}

$service = new GWTService();

$wiki = $service->getWikiRepository()->oneByWikiId( $options['i'] );
if( !$wiki ) {
	echo "No wiki for " . $options['i'] . "\n";
	die();
}
if( !$wiki->getUserId() ) {
	echo "User id empty for " . $wiki->getWikiId() . "\n";
	die();
}
$user = $service->getUserRepository()->getById( $wiki->getUserId() );
$info = $service->sendSitemap( $wiki, $user );
var_dump($info);
