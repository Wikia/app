<?php
if ( isset( $GET_ ) ) {
	echo( "This file cannot be run from the web.\n" );
	die( 1 );
}

$dir = dirname( __FILE__ );

$rec = array( "name" => "foo", "id" => 3, "info" => 'test 1' );

$data = array( 'response' => array(
			'content' => array(
				'foo' => $rec
			)
		) );

file_put_contents( "$dir/test-data-name-foo.pser", serialize( $data ) );
file_put_contents( "$dir/test-data-name-foo.json", json_encode( $data ) );
file_put_contents( "$dir/test-data-name-foo.wddx", wddx_serialize_value( $data ) );