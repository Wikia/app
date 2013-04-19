<?php
/**
 * User: artur
 * Date: 18.04.13
 * Time: 19:39
 */

$optionsWithArgs = array( 'i' );

require_once(__DIR__ . '/../../commandLine.inc');
require_once($IP . '/lib/GoogleWebmasterTools/setup.php');

if( !isset($options['i']) ) {
	echo "Specify wikiid (-i)";
}

$wikiRepository = new GWTWikiRepository();

$user = $wikiRepository->create( $options['i'] );
var_dump($user);
