<?php

if ( getenv( 'MW_INSTALL_PATH' ) ) {
    $IP = getenv( 'MW_INSTALL_PATH' );
} else {
    $IP = dirname(__FILE__).'/../../..';
}
require "$IP/maintenance/commandLine.inc";
require dirname(__FILE__) . '/reviewAllPages.inc';

if( isset($options['help']) || !isset($args[0]) || !$args[0] ) {
	echo <<<TEXT
Usage:
    php reviewAllPages.php --help
    php reviewAllPages.php <user ID>

    --help               : This help message
    --<userid>           : The ID of the existing user to use as the "reviewer" (you can find your ID at Special:Preferences)

TEXT;
	exit(0);
}

error_reporting( E_ALL );

$db = wfGetDB( DB_MASTER );
$user = User::newFromId( intval($args[0]) );

autoreview_current( $user, $db );
