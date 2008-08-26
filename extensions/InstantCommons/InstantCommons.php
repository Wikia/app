<?php

if ( !defined( 'MEDIAWIKI' ) ) {
	echo <<<EOT
<html><body>
<p>This is the InstantCommons extension for MediaWiki. To enable it, put the following 
at the end of your LocalSettings.php:</p>
<pre>
require_once( "\$IP/extensions/InstantCommons/InstantCommons.php" );
</pre>
</body></html>
EOT;
	exit;
}

$wgAutoloadClasses['ApiInstantCommons'] = dirname( __FILE__ ) . '/InstantCommons_body.php';
$wgAPIModules['instantcommons'] = 'ApiInstantCommons';

?>
