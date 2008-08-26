<?php

if ( !defined( 'MEDIAWIKI' ) ) {
	die( "Not a valid entry point\n" );
}

$wgExtensionCredits['specialpage'][] = array(
	'name' => 'MakeDBError',
	'description' => 'makes a database error with an invalid query'
);

if ( !function_exists( 'extAddSpecialPage' ) ) {
	require( dirname(__FILE__) . '/../ExtensionFunctions.php' );
}
extAddSpecialPage( dirname(__FILE__) . '/MakeDBError_body.php', 'MakeDBError', 'MakeDBErrorPage' );


