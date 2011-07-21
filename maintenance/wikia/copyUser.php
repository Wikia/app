<?php

ini_set( "include_path", dirname(__FILE__)."/.." );
require_once( 'commandLine.inc' );

$userid = isset( $options['u'] ) ? $options['u'] : 0;

if ( $userid == 0 ) {
	die ( 'invalid user ID' );
}

$mExtUser = ExternalUser::newFromId( $userid );
if ( is_object( $mExtUser ) && ( 0 != $mExtUser->getId() ) ) {
	$mExtUser->linkToLocal( $mExtUser->getId() );
}

?>
