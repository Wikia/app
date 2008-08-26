<?php

if ( !defined( 'MEDIAWIKI' ) ):
?>
<html>
<head><title>PovWatch Version 1.0</title></head>
<body>
<h1>PovWatch Version 1.0</h1>
<p>
This is a MediaWiki extension for pushing articles on to the watchlists of other users.
To install it, add the following to the bottom of your <tt>LocalSettings.php</tt>,
before the "?&gt;":</p>
<pre>
require_once( "$IP/extensions/PovWatch/PovWatch.php" );
</pre>
</body>
</html>
<?php
	exit(1);
endif;

$wgExtensionCredits['specialpage'][] = array(
	'name'           => 'PovWatch',
	'version'        => '1.1.1',
	'url'            => 'http://www.mediawiki.org/wiki/Extension:PovWatch',
	'author'         => 'Tim Starling',
	'description'    => 'Extension for pushing pages on to the watchlists of other users',
	'descriptionmsg' => 'povwatch_desc',
);

$wgAvailableRights[] = 'povwatch_user';
$wgAvailableRights[] = 'povwatch_admin';
#$wgAvailableRights[] = 'povwatch_subscriber_list';

$wgGroupPermissions['sysop']['povwatch_user'] = true;
#$wgGroupPermissions['sysop']['povwatch_subscriber_list'] = true;
$wgGroupPermissions['povwatch'] = array(
	'povwatch_user' => true,
	'povwatch_admin' => true,
#	'povwatch_subscriber_list' => true,
);

if ( !function_exists( 'extAddSpecialPage' ) ) {
	require( dirname(__FILE__) . '/../ExtensionFunctions.php' );
}
extAddSpecialPage( dirname(__FILE__) . '/PovWatch_body.php', 'PovWatch', 'PovWatchPage' );
$dir = dirname(__FILE__) . '/';
$wgExtensionMessagesFiles['povwatch'] = $dir . 'PovWatch.i18n.php';
