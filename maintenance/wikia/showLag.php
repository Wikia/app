<?php

ini_set( "include_path", dirname(__FILE__)."/../" );
require_once( 'commandLine.inc' );

$wgMemc->set_debug( true );
print_r( $wgMemc->get( "db:lag_times:db4" ) );
