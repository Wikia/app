<?php

ini_set( "include_path", dirname(__FILE__)."/../" );
require( 'commandLine.inc' );

$u = User::newFromId(1166936);
$u->load();
echo print_r( $u, true );

exit;
