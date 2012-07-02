<?php

require( dirname( __FILE__ ) . '/commandLine.inc' );
$msg = 'test ' . str_repeat( 'TTTT ', 10000 );
#wfErrorLog( $msg, 'udp://10.0.6.30:8420/test' );

$sock = socket_create( AF_INET, SOCK_DGRAM, SOL_UDP );
socket_sendto( $sock, $msg, strlen( $msg ), 0, '10.0.6.30', 8420 );


