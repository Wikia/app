<?php
/**
 * This file is to help us get around cross-site scripting restrictions.
 * The sublime extension will include this page in an iframe, and then post messages to it.
 * This page will then do the ajax requests as needed (to its own domain).
 *
 * This code is based on Christian Williams' code for StickerBomb.
 *
 * @author Sean Colombo
 */

$wikiHost = ""; // the API target is the same server
 
?><!doctype html>
<html lang="en">
<head>
	<script type="text/javascript" src="<?= $wikiHost ?>/skins/common/jquery/jquery-1.4.2.js?1284232976"></script>
	<?php // TODO: REVIEW WHICH OF THESE JQUERY FILES ARE NEEDED ?>
	<script type="text/javascript" src="<?= $wikiHost ?>/skins/common/jquery/jquery.json-1.3.js?1284232976"></script>
	<!-- <script type="text/javascript" src="<?= $wikiHost ?>/skins/common/jquery/jquery.wikia.js?1284232976"></script> -->
	<script type='text/javascript' src='<?= $wikiHost ?>/extensions/wikia/JavascriptAPI/Mediawiki.js'></script>
	<script>
		var wgScriptPath = "<?= $wikiHost ?>"; // this should be the endpoint 

		//register event
		window.addEventListener("message", receiveMessage, false);		
		
		//run when messages are received
		function receiveMessage(e) {
			// Get the JSON object that was sent in by the parent-page.
			var json = JSON.parse(e.data);
			
			var action = (json.action?json.action:'edit');
			if(action == 'edit'){
				var articleTitle = json.title;
				var articleContent = json.content;
				
				sendEditToWikia(articleTitle, articleContent);
			} else {
				console.log("Sublime action: \"" + action + "\" not implemented yet.");
			}
		}
		
		// Use RTE's ajax method for html to wikitext conversion (this is based on RTE.ajax() from RTE.js).
		function html2wiki(params, callback) {
			if (typeof params != 'object') {
				params = {};
			}
			params.method = 'html2wiki';
			jQuery.post(window.wgScript + '?action=ajax&rs=RTEAjax', params, function(data) {
				if (typeof callback == 'function') {
					callback(data);
				}
			}, 'json');
		}
		
		function sendEditToWikia(articleTitle, articleContent, summary){
			summary = (summary?summary:'Edited using Sublime plugin by Wikia');
			var normalizedTitle = Mediawiki.getNormalizedTitle(articleTitle);
			
		//VERSION WITHOUT ANY REVERSE-PARSING OF HTML.  CAN ONLY HANDLE PLAINTEXT/WIKITEXT.
			Mediawiki.editArticle({
				"title": normalizedTitle,
				//"createonly": true,
				"summary": summary,
				"text": articleContent
			}, function(){Mediawiki.updateStatus("Article saved.");}, apiFailed);
		/*
			Mediawiki.updateStatus("Converting HTML to wikitext...");
			html2wiki({html: articleContent, title: articleTitle}, function(data) {
				Mediawiki.updateStatus("Submitting article...");
				wikiText = data.wikitext;
				Mediawiki.editArticle({
					"title": normalizedTitle,
					//"createonly": true,
					"summary": summary,
					"text": wikiText
				}, function(){Mediawiki.updateStatus("Article saved.");}, apiFailed);
			});
		*/
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

		


		
		/*
		TODO: REMOVE - This was from stickerbomb
		function report() {
			//console.log(stickers);
			//TODO: XHR stickers object to server for storage.

			var req = new XMLHttpRequest();
			req.open('POST', 'http://www.framezero.com/stickerbomb/stickerserver.php', true);
			req.onreadystatechange = function (e) {
				if (req.readyState == 4) {
					if (req.status == 200) {
						console.log(req.responseText);
					} else {
						console.log("Error loading page");
					}  
				} 
			}
			req.send(JSON.stringify(stickers));
		}
		*/
	</script>
</head>
<body>
</body>
</html>