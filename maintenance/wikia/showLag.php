<?php

ini_set( "include_path", dirname(__FILE__)."/../" );
require_once( 'commandLine.inc' );

print_r( $wgMemc->get_sock( "db:lag_times:db4" ) );
print_r( $wgMemc->get( "db:lag_times:db4" ) );
