<?php
/**
 * User: artur
 * Date: 18.04.13
 * Time: 14:28
 */

$optionsWithArgs = array( 'u', 'w' );

require_once(__DIR__ . '/../../commandLine.inc');
require_once($IP . '/lib/GoogleWebmasterTools/setup.php');

if( !isset($options['u']) || !isset($options['w']) ) {
	echo "Specify user (-u) and wikiId (-p)";
	die(1);
}

$userRepository = new GWTUserRepository();
$wikiRepository = new GWTWikiRepository();
$service = new GWTService($userRepository, $wikiRepository);

$u = $userRepository->getByEmail( $options['u'] );
$w = $wikiRepository->oneByWikiId( $options['w']);

if ( $u == null && $w == null ) {
	echo "no user or no wiki.";
	die( 1 );
}
$result = $service->uploadWikiAsUser( $w, $u );
echo "upload: " . $result . "\n";
