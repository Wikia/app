<?php
/**
 * User: artur
 * Date: 17.04.13
 * Time: 19:03
 */

// example: SERVER_ID=5915 php maintenance/wikia/GoogleWebmasterToolsSync/remove_user.php --conf /usr/wikia/docroot/wiki.factory/LocalSettings.php -u example@gmail.com

$optionsWithArgs = array( 'u' );

require_once(__DIR__ . '/../../commandLine.inc');
require_once($IP . '/lib/GoogleWebmasterTools/init.php');

if( !isset($options['u']) ) {
	echo "Specify email (-u)";
}

$userRepository = new GWTUserRepository();

$userRepository->deleteByEmail( $options['u'] );
