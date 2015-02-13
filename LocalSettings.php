<?php

# Determine $IP using the same process as mediawika core
# We duplicate this code because some entry points do not go through webstart or maintenance
$IP = getenv( 'MW_INSTALL_PATH' );
if ( $IP === false ) {
	$IP = realpath( __DIR__ );
}

require __DIR__.'/../config/LocalSettings.php';
