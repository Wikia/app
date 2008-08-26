<?php
if (!defined('MEDIAWIKI')) {
	exit;
}
/**
 * Class provides a special page
 *
 * @addtogroup Extensions
 */

class SpecialYouTubeAuthSub extends SpecialPage {

	function __construct() {
		parent::__construct( 'YouTubeAuthSub' );
	}

	function execute( $par ) {
		global $wgRequest, $wgTitle, $wgOut, $wgMemc, $wgUser;
		global $wgYTAS_User, $wgYTAS_Password, $wgYTAS_DeveloperId;
		global $wgYTAS_DefaultCategory, $wgYTAS_UseClientLogin, $wgYTAS_EnableLogging, $wgYTAS_UseNamespace;

		wfLoadExtensionMessages( 'YouTubeAuthSub' );

		$this->setHeaders();

		# Check permissions
		if( !$wgUser->isAllowed( 'upload' ) ) {
			if( !$wgUser->isLoggedIn() ) {
				$wgOut->showErrorPage( 'uploadnologin', 'uploadnologintext' );
			}
			else {
				$wgOut->permissionRequired( 'upload' );
			}
			return;
		}

		if ($wgRequest->getVal('status') == '200' && $wgRequest->getVal('id') != null) {
			$wgOut->addHTML(wfMsg('youtubeauthsub_success', $wgRequest->getVal('id')));
			$descTitle = null;
			$desc = wfMsg('youtubeauthsub_summary');
			//TODO: can we grab the keywords and description the user has submitted?
			if ($wgYTAS_UseNamespace) {
				$descTitle = Title::makeTitle(NS_YOUTUBE, $wgRequest->getVal('id'));
				$a = new Article($descTitle);
				if ($a->getID() == 0) {
					$title = $keywords = $description = $category = "";
					if ($wgRequest->getVal('metaid') != null) {
						$dbr = wfGetDB(DB_SLAVE);
						$row = $dbr->selectRow('ytas_meta', array('ytas_title', 'ytas_description', 'ytas_keywords', 'ytas_category'),
						array("ytas_id={$wgRequest->getVal('metaid')}"));
						if ($row) {
							$title 			= $row->ytas_title;
							$keywords 		= $row->ytas_keywords;
							$description	= $row->ytas_description;
							$category		= $row->ytas_category;
						}
					}
					$content = "{{YoutubeVideo|{$wgRequest->getVal('id')}|{$title}|{$keywords}|{$description}|{$category}}}";
					$a->insertNewArticle($content,
					wfMsg('youtubeauthsub_summary'),
					false,
					false);
					$wgOut->redirect('');
				}
				$wgOut->addWikiText(wfMsg('youtubeauthsub_viewpage', $descTitle->getFullText()) );
			}
			if ($wgYTAS_EnableLogging) {
				# Add the log entry
				$log = new LogPage( 'upload' );
				$log->addEntry( 'upload', $descTitle, $desc );
			}
		}

		if ($wgYTAS_UseClientLogin) {

			$key = wfMemcKey('youtube', 'authsub', 'token', $wgYTAS_User);
			$token = $wgMemc->get( $key );
			// regenerate the token
			if (!$token) {
				$result = wfSpecialYouTubePost("https://www.google.com/youtube/accounts/ClientLogin?"
				, "Email={$wgYTAS_User}&Passwd={$wgYTAS_Password}&service=youtube&source=wikiHow");
				$YouTubeUser = "";
				$lines = split("\n", $result);
				foreach ($lines as $line) {
					$params = split("=", $line);
					switch ($params[0]) {
						case "Auth":
						$token = $params[1];
						break;
						case "YouTubeUser":
						$YouTubeUser = $params[1];
						break;
					}
				}
				if (!$token) {
					$wgOut->addHTML(wfMsg('youtubeauthsub_tokenerror'));
					return;
				}
				$wgMemc->set($key, $token, 3600);
			}
		}
		else {
			$token = $wgRequest->getVal('token');
			if (!$token) {
				$wgOut->addHTML(wfMsg('youtubeauthsub_authsubinstructions') .
				"
				<script type='text/javascript'>
				var gYTAS_nokeywords = '" . wfMsg('youtubeauthsub_jserror_nokeywords') . "';
				var gYTAS_notitle = '" . wfMsg('youtubeauthsub_jserror_notitle') . "';
				</script>
				<script type='text/javascript' src='/extensions/YouTubeAuthSub/youtubeauthsub.js'>
				</script>
				<form action='https://www.google.com/accounts/AuthSubRequest' method='POST' onsubmit='return checkYTASForm();' name='ytas_form'/>
				<input type='hidden' name='next' value='{$wgTitle->getFullURL()}'/>
				<input type='hidden' name='scope' value='http://gdata.youtube.com/feeds'/>
				<input type='hidden' name='session' value='0'/>
				<input type='hidden' name='secure' value='0'/>
				<input type='submit' value='" . wfMsg('youtubeauthsub_clickhere') . "'/>"
				);
				return;
			}
		}

		if ($wgRequest->wasPosted()) {
			$url = "http://uploads.gdata.youtube.com/feeds/api/users/{$wgYTAS_User}/uploads";

			$data = "<?xml version='1.0'?>
	<entry xmlns='http://www.w3.org/2005/Atom'
	  xmlns:media='http://search.yahoo.com/mrss/'
	  xmlns:yt='http://gdata.youtube.com/schemas/2007'>
	  <media:group>
	    <media:title type='plain'>" .  FeedItem::xmlEncode($wgRequest->getVal('youtube_title')) . "</media:title>
	    <media:description type='plain'>" .  FeedItem::xmlEncode($wgRequest->getVal('youtube_description')) . "</media:description>
	    <media:keywords>" .  FeedItem::xmlEncode($wgRequest->getVal('youtube_keywords')) . "</media:keywords>
		<media:category scheme='http://gdata.youtube.com/schemas/2007/categories.cat'>" .
				FeedItem::xmlEncode($wgRequest->getVal('youtube_category')) . "</media:category>
	  </media:group>
	</entry>
	";
			$headers = array (
					"X-GData-Key: key={$wgYTAS_DeveloperId}",
					"Content-Type: application/atom+xml; charset=UTF-8",
					"Content-Length: " . strlen($data),
					);
			if ($wgYTAS_UseClientLogin)
				$headers[] = "Authorization: GoogleLogin auth=$token";
			else
				$headers[] = "Authorization: AuthSub token=$token";

			$results = wfSpecialYouTubePost($url, $data, $headers);

			preg_match("/<yt:token>.*<\/yt:token>/", $results, $matches);
			$token = strip_tags($matches[0]);
			preg_match("/'edit-media'[^>]*href='[^']*'>/", $results, $matches);
			$url = preg_replace("/.*href='([^']*)'>/", "$1", $matches[0]);

			if ($url == "") {
				$wgOut->addHTML("Unable to extract URL, results where <pre>{$results}</pre>");
				return;
			}
			// CAPTURE THE META INFO AND STORE IT
			$meta_id = '';
			$dbw = wfGetDB(DB_MASTER);
			$fields = array (
					'ytas_user'	=> $wgUser->getID(),
					'ytas_timestamp' => $dbw->timestamp( time() ),
					'ytas_title' => $wgRequest->getVal('youtube_title'),
					'ytas_description' =>  $wgRequest->getVal('youtube_description'),
					'ytas_keywords'	=> 	 $wgRequest->getVal('youtube_keywords'),
					'ytas_category'	=> 	 $wgRequest->getVal('youtube_category')
				);
			$dbw->insert( 'ytas_meta', $fields, __METHOD__, array( 'IGNORE' ) );
			if ( $dbw->affectedRows() ) {
				$meta_id =$dbw->insertId();
		}

			$next_url = urlencode($wgTitle->getFullURL() . "?metaid={$meta_id}");

			$wgOut->addHTML(wfMsg('youtubeauthsub_uploadhere') . "<br/><br/>
					 <form action='{$url}?nexturl={$next_url}' METHOD='post' enctype='multipart/form-data' name='videoupload'>
						  <input type='file' name='file' size='50'/>
						<input type='hidden' name='token' value='{$token}'/><br/>
						<input type='submit' name='submitbtn' value='" . wfMsg('youtubeauthsub_uploadbutton') . "'/>
						</form>
						<center>
						<div id='upload_image' style='display:none;'>
					" . wfMsg('youtubeauthsub_uploading') . "
									<img src='/extensions/YouTubeAuthSub/upload.gif'>
						</div>
						</center>
					");
		}
		else {
			$wgOut->addHTML( wfMsg('youtubeauthsub_info') .

				"  <script type='text/javascript'>
	                    var gYTAS_nokeywords = '" . wfMsg('youtubeauthsub_jserror_nokeywords') . "';
	                    var gYTAS_nodesc = '" . wfMsg('youtubeauthsub_jserror_nodesc') . "';
	                    var gYTAS_notitle = '" . wfMsg('youtubeauthsub_jserror_notitle') . "';
	                </script>
	                <script type='text/javascript' src='/extensions/YouTubeAuthSub/youtubeauthsub.js'>
	                </script>
					<form action='{$wgTitle->getFullURL()}' method='POST' name='ytas_form' onsubmit='return checkYTASForm();'>
					<table cellpadding='10'>
				");
			if (!$wgYTAS_UseClientLogin) {
				$wgOut->addHTML("<input type='hidden' name='token' value='{$wgRequest->getVal('token')}'/>");
			}
			$wgOut->addHTML("
						<tr>
							<td>" . wfMsg('youtubeauthsub_title') . ":</td>
							<td><input type='text' name='youtube_title' size='40'/></td>
						</tr>
						<tr>
							<td valign='top'>" . wfMsg('youtubeauthsub_description') . ":</td>
							<td><textarea cols='100' rows='4' name='youtube_description'></textarea></td>
						</tr>
						<tr>
							<td>" . wfMsg('youtubeauthsub_keywords') . ":</td>
							<td><input type='text' name='youtube_keywords' size='40'/></td>
						</tr>");
			if (!$wgYTAS_DefaultCategory) {
				$cats = wfSpecialYouTubeGetCategories();
				$wgOut->addHTML("
						<tr>
							<td>" . wfMsg('youtubeauthsub_category') . ":</td>
							<td><select type='text' name='youtube_category'/>{$cats}</select></td>
						</tr>");
			}
			else {
				$wgOut->addHTML("<input type='hidden' name='youtube_category' value='{$wgYTAS_DefaultCategory}'/>");
			}
			$wgOut->addHTML("
						<tr>
							<td><input type='submit' value='" . wfMsg('youtubeauthsub_submit') . "'></td>
						</tr>
					</table>
				</form>");
		}
	}
}
