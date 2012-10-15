<?php

$IP = getenv( 'MW_INSTALL_PATH' );
if ( strval( $IP ) === '' ) {
	$IP = dirname( __FILE__ ).'/../..';
}
if ( !file_exists( "$IP/includes/WebStart.php" ) ) {
	$IP .= '/phase3';
}
chdir( $IP );

require( "$IP/includes/WebStart.php" );

if ( !class_exists( 'SecurePoll_RemoteMWAuth' ) ) {
	header( 'HTTP/1.1 500 Internal Server Error' );
	echo "SecurePoll is disabled.\n";
	exit( 1 );
}

header( 'Content-Type: application/vnd.php.serialized; charset=utf-8' );

$token = $wgRequest->getVal( 'token' );
$id = $wgRequest->getInt( 'id' );
if ( is_null( $token ) || !$id ) {
	echo serialize( Status::newFatal( 'securepoll-api-invalid-params' ) );
	exit;
}

$user = User::newFromId( $id );
if ( !$user ) {
	echo serialize( Status::newFatal( 'securepoll-api-no-user' ) );
	exit;
}
$token2 = SecurePoll_RemoteMWAuth::encodeToken( $user->getToken() );
if ( $token2 !== $token ) {
	echo serialize( Status::newFatal( 'securepoll-api-token-mismatch' ) );
	exit;
}
$context = new SecurePoll_Context;
$auth = $context->newAuth( 'local' );
$status = Status::newGood( $auth->getUserParams( $user ) );
echo serialize( $status );

