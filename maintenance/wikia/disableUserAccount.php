<?php

/**
 * @author Kenneth Kouot <kenneth@wikia-inc.com
 * @description Job that accepts a user id as an argument and disables that user account
 * @usage cat spamAccountIds.txt | while read line; do SERVER_ID=177 php maintenance/wikia/disableUserAccount.php --conf /usr/wikia/docroot/wiki.factory/LocalSettings.php "$line"; done
 */

ini_set( 'include_path', dirname(__FILE__) . '/../' );
require( 'commandLine.inc' );

// username from command line argument
if ( !$argv[2] ) {
 die('Error: Please specify a user id');
}

$userId = $argv[2];
$stdOut =  fopen('php://stdout', 'w');

fwrite( $stdOut, "\n" );
fwrite( $stdOut, "Attempting to disable user account: " . $userId. "\n" );

$user = User::newFromId($userId);

$statusMessage = NULL;

$result = EditAccount::closeAccount( $user, 'Spamming', $statusMessage );
fwrite( $stdOut, "Status: " . ( $result ? 'SUCCESS' : 'FAIL' ) . "\nMessage: " . $statusMessage . "\n" );
fwrite( $stdOut, "__________________________________________________________\n" );
fclose( $stdOut );
