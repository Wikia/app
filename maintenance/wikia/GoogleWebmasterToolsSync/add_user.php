<?php
/**
 * User: artur
 * Date: 17.04.13
 * Time: 18:08
 */

// example: SERVER_ID=5915 php maintenance/wikia/GoogleWebmasterToolsSync/add_user.php --conf /usr/wikia/docroot/wiki.factory/LocalSettings.php -u u2 -p pass

$optionsWithArgs = array( 'u', 'p' );

require_once(__DIR__ . '/../../commandLine.inc');
require_once($IP . '/lib/GoogleWebmasterTools/init.php');

if( !isset($options['u']) || !isset($options['p']) ) {
	echo "Specify user (-u) and password (-p)";
}

$userRepository = new GWTUserRepository();

$r = $userRepository->create( $options['u'], $options['p'] );
if ( $r == null ) {
	echo "error while inserting user";
	die( 1 );
}
echo $r->getId() . " " . $r->getEmail() . "\n";
