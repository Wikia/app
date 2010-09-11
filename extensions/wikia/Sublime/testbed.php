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
		#logoutForm{
			display:none;
		}
		#loggedInUsername{
			display:inline;
			font-weight:bold;
		}
		#editform{
			display:inline;
		}
	</style>
</head>
<body>
	<h1>Testbed for Sublime</h1>
	<div id='editform'><textarea id='wpTextbox1'></textarea></div>
	<article id='sendMeToWikia'>
		This is the content which should be sent to wikia.
		
		Here is some more content a few lines down.
		
		Sublime, isn't it?
		
		This tests reverse-parsing.  <strong>This should be strong!</strong>
	</article>
	<br/>
	<button id='makeContentEditable' onclick='makeContentEditable()'>Make editable</button> &nbsp;&nbsp;&nbsp;&nbsp;
	<button id='submitContentToWikia' onclick='submitSublime()'>Send it!</button>

	<br/><br/>
	<div id='loginCredentials'>
		<form id='loginForm'>
			Login credentials:<br/>
			<input type='text' id='loginName' value='Sean Colombo'/> Username<br/>
			<input type='password' id='loginPass'/> Password<br/>
			<button onclick='return sublimeLoginWrapper()'>Log in</button>
		</form>
		<form id='logoutForm'>
			<div>
				Logged in as: <div id='loggedInUsername'>&nbsp;</div>
			</div>
			<button onclick='return sublimeLogout()'>Log out</button>
		</form>
	</div>
	
	<!-- Make the Mediawiki status bar appear lower -->
	<br/><br/>

	<!-- Javascript at the bottom - don't anger Artur! -->
	<script type="text/javascript" src="/skins/common/jquery/jquery-1.4.2.js?1284232976"></script>
	<script type="text/javascript" src="/skins/common/jquery/jquery.json-1.3.js?1284232976"></script>
	<script type="text/javascript" src="/skins/common/jquery/jquery.wikia.js?1284232976"></script>
	<script type='text/javascript'>
		// Setup for Mediawiki.js
		var wgScriptPath = "http://sean.wikia-dev.com"; // this should be the endpoint.

		// Setup for ckeditor.js
		var wgScript = "/index.php";
		// NOTE: ALSO NEED 'editform' element or RTE won't initialize.
	</script>
	<script type='text/javascript' src='/extensions/wikia/JavascriptAPI/Mediawiki.js'></script>
	<script type='text/javascript' src='/extensions/wikia/RTE/ckeditor/ckeditor.js'></script>

	<script type='text/javascript'>

// PROBABLY JUST CODE FOR THIS PAGE //

		function submitSublime(){
			var sublimeTitle = $('title').html();
			var sublimeContent = $('#sendMeToWikia').html();
			sendEditToWikia(sublimeTitle, sublimeContent);
		}
		function makeContentEditable(){
			$('#sendMeToWikia').attr('contenteditable', true);
		}
		function sublimeLoginWrapper(){
			var wikiUsername = $('#loginName').val();
			var wikiPass = $('#loginPass').val();
			sublimeLogin(wikiUsername, wikiPass);
			return false;
		}
		function sublimeLogout(){
			Mediawiki.logout(function(){
				Mediawiki.updateStatus("Logged out.");
				$('#logoutForm').hide();
				$('#loginForm').fadeIn();
			});
			return false;
		}
		
		
		
		
// PROBABLY TO BE PUT INTO EXTENSION (WITH MODIFICATIONS) //

		function sendEditToWikia(articleTitle, articleContent, summary){
			summary = (summary?summary:'Edited using Sublime plugin by Wikia');
			var normalizedTitle = Mediawiki.getNormalizedTitle(articleTitle);
			
			Mediawiki.updateStatus("Converting HTML to wikitext...");
			RTE.ajax('html2wiki', {html: articleContent, title: articleTitle}, function(data) {
				Mediawiki.updateStatus("Submitting article...");
				wikiText = data.wikitext;
				Mediawiki.editArticle({
					"title": normalizedTitle,
					//"createonly": true,
					"summary": summary,
					"text": wikiText
				}, function(){Mediawiki.updateStatus("Article saved.");}, apiFailed);
			});
		}

		// Login the user.		
		function sublimeLogin(wikiUsername, wikiPass){
			try { 
				if (Mediawiki.isLoggedIn()){
					Mediawiki.updateStatus("Already logged in.");
					loginWorked();
				}
				Mediawiki.updateStatus("Logging in...");
				Mediawiki.login(wikiUsername, wikiPass, loginWorked, apiFailed);
			} catch (e) {
				Mediawiki.updateStatus( "Error logging in:" + Mediawiki.print_r(e));	
			}
		}
		function loginWorked (){
			Mediawiki.updateStatus("Login successful");
			$("#loginForm").fadeOut();

			// Show your name and a button to logout.
			$('#loggedInUsername').html(Mediawiki.UserName);
			$("#logoutForm").fadeIn();
		}

		function apiFailed(reqObj, msg, error){
				Mediawiki.waitingDone();
			if (typeof msg == "undefined" && typeof reqObj == "string"){
				msg = reqObj;
			} else if (typeof msg == "object"){
						msg = Mediawiki.print_r(msg);
			}
			Mediawiki.updateStatus("ERROR from API: " + msg, true);
		}

		// On page-load if we're already logged in, then hide the login form.
		if (Mediawiki.isLoggedIn()){
			loginWorked();
		}
	</script>
</body>
</html>
