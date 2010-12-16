<?php
if ( !defined( 'MEDIAWIKI' ) ) {
	die( "Not a valid entry point\n" );
}

$wgExtensionCredits['specialpage'][] = array(
	'path' => __FILE__,
	'name' => 'MakeDBError',
	'description' => 'makes a database error with an invalid query'
);

$dir = dirname(__FILE__) . '/';
$wgAutoloadClasses['SpecialMakeDBError'] = $dir . 'MakeDBError_body.php';
$wgSpecialPages['MakeDBError'] = 'SpecialMakeDBError';
