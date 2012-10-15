<?php

/**
 * WebStore startup file
 */


$IP = getenv( 'MW_INSTALL_PATH' );
if ( $IP === false ) {
	$IP = dirname( __FILE__ ) . '/../..';
}
require( "$IP/includes/WebStart.php" );

if ( !defined( 'MW_WEBSTORE_ENABLED' ) ) {
	echo <<<EOT
<html><body>
<p>The WebStore extension is disabled. Enable WebStore by putting:</p>

<pre>require( "\$IP/extensions/WebStore.php" );</pre>

<p>in your LocalSettings.php</p>
</body></html>
EOT;
	exit( 1 );
}


