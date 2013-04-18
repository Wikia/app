<?php
/**
 * User: artur
 * Date: 18.04.13
 * Time: 10:26
 */

$optionsWithArgs = array( 'u' );

require_once(__DIR__ . '/../../commandLine.inc');
require_once($IP . '/lib/GoogleWebmasterTools/setup.php');

$userRepository = new GWTUserRepository();

if( !isset($options['u']) ) {
	echo "Specify user (-u).";
	die(1);
}

$user = $userRepository->getByEmail( $options['u'] );
if( $user == null ) {
	echo "No such user. Try add_user.php.\n";
	die(1);
}
$util = new WebmasterToolsUtil();
$sites = $util->getSites( $user );
foreach( $sites as $i => $s ) {
	echo $s->getUrl() . " " . $s->getVerified() . "\n";
}
