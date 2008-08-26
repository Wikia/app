<?php

/**
 * WebStore startup file
 */


$IP = dirname( realpath( __FILE__ ) ) . '/../..';
chdir( $IP );
require( './includes/WebStart.php' );

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


