<?php
/**
 * @author Sean Colombo
 * @date 20100911
 *
 * Just a page to test some Sublime code.
 *
 * This isn't meant to be used directly in production ... it will be symlinked to on a devbox.
 * Perhaps, later it could be turned into a star for testing-code.
 *
 * To get this to work, add a symlink like this:
 * ln -s /usr/wikia/source/wiki/extensions/wikia/Sublime/testbed.php /usr/wikia/docroot/wiki.factory/testbed.php
 */

/*
DO WE REALLY NEED THE MEDIAWIKI STACK?  WE PROBABLY SHOULDN'T SINCE THIS PAGE IS SUPPOSED TO BE ANALOGOUS TO THE BROWSER ON AN OFF-SITE PAGE.
$IP = getenv( 'MW_INSTALL_PATH' );
if ( $IP === false ) { 
	$IP = dirname( __FILE__ ) .'/../../..';
}
///// CONFIGURATION /////

// Load the MediaWiki stack.
require( dirname(__FILE__) . '/../../../includes/WebStart.php' );
*/

?><!doctype html>
<html lang="en" dir="ltr">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>Sublime - Testbed</title>
	<style type='text/css'>
		#sendMeToWikia {
			display:block;
			font-family: "Courier New", monospaced;
			background-color:#abf;
		}
	</style>
</head>
<body>
	<h1>Testbed for Sublime</h1>
	<article id='sendMeToWikia'>
		This is the content which should be sent to wikia.
		
		Here is some more content a few lines down.
		
		Sublime, isn't it?
	</article>
	<br/>
	<button id='submitContentToWikia' onclick='submitSublime()'>Send it!</button>
	

	<!-- Javascript at the bottom - don't anger Artur! -->
	<script type="text/javascript" src="/skins/common/jquery/jquery-1.4.2.js?1284232976"></script>
	<script type="text/javascript" src="/skins/common/jquery/jquery.json-1.3.js?1284232976"></script>
	<script type="text/javascript" src="/skins/common/jquery/jquery.wikia.js?1284232976"></script>
	<script type='text/javascript' src='/extensions/wikia/JavascriptAPI/Mediawiki.js'/>
	<script type='text/javascript'>
		var wgScriptPath = "http://sean.wikia-dev.com"; // this should be the endpoint.
		function submitSublime(){
			var sublimeContent = $('#sendMeToWikia').html();
			alert(sublimeContent);
		}
	</script>
</body>
</html>
