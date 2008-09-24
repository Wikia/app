<?php

require_once( "VideoImport.i18n.php" );


$wgExtensionFunctions[] = 'wfVideoImport';
$wgSpecialPageGroups['ImportVideo'] = 'media';

function wfVideoImport() {

	global $wgUser,$IP;
	include_once("includes/SpecialPage.php");

	class VideoImport extends SpecialPage {
	
		function VideoImport(){
			SpecialPage::SpecialPage("ImportVideo");
		}
		
		function execute(){
			
			# Add messages
			global $wgMessageCache, $wgVideoImportMessages;
			foreach( $wgVideoImportMessages as $key => $value ) {
				$wgMessageCache->addMessages( $wgVideoImportMessages[$key], $key );
			}
		      
		        global $IP, $wgRequest, $wgStyleVersion, $wgOut, $wgUser,$wgYoutubeAPIKey;

			if( $wgUser->isBlocked() ){
				$wgOut->blockedPage( false );
				return false;
			}
			
			if( ! $wgUser->isAllowed('edit') ){
				$login = Title::makeTitle(NS_SPECIAL, "Login");
				$wgOut->errorpage( 'videoimport-login-title', 'videoimport-login-text' );
				return true;	
			}
			
			require_once("$IP/extensions/wikia/VideoImport/YouTubeImportClass.php");

			$wgOut->addScript("<link rel='stylesheet' type='text/css' href=\"/extensions/wikia/VideoImport/VideoImport.css?{$wgStyleVersion}\"/>\n");
			$wgOut->addScript("<script type=\"text/javascript\" src=\"/extensions/wikia/VideoImport/VideoImport.js?{$wgStyleVersion}\"></script>\n");
			
			$from = urldecode($wgRequest->getVal("wpFrom"));
			$categories = urldecode($wgRequest->getVal("wpCategories"));
			$q = $wgRequest->getVal("q");
			
			$wgOut->addHTML("<script>
					var _IMPORTING_MSG = \"" . wfMsgForContent( 'videoimport_importing' ) . "\"
					var _LOADING_MSG = \"" . wfMsgForContent( 'videoimport_loading' ) . "\"
					</script>
					");
			
			if( $from ){
				$from_title = Title::newFromDBkey( $from );
				$from_url = $from_title->getFullURL();
				$from_text = $from_title->getText();
			}
		
			$importPage = Title::makeTitle(NS_SPECIAL, "ImportVideo");
		
			
			$y = new YoutubeImport( );
			
		 
			//User has select videos to import
			if( $wgRequest->wasPosted() ){
				if ( $wgRequest->getVal("ids") ){
					$videos = explode(",", $wgRequest->getVal("ids") );
					$count = 0;
					foreach($videos as $video){
						if($video){
							$video_array = explode("|", $video );
							$video_id = $video_array[0];
							$video_title = $video_array[1];
							$video_name = $y->importVideo( $video_id, $q, $categories, $video_title );
							$video_gallery_values .= "Video:" . str_replace("\"","",$video_name) . "\n";
							$count++;
						}
					}
					$wgOut->setPagetitle( wfMsgForContent( 'videoimport_importsuccess' ) );
					
					//Show success and build gallery of newly uplaoded images
					$wgOut->addHTML( wfMsgExt('videoimport_success', 'parsemag', $count) );
					
					if( $from ) $wgOut->addHTML(" " . wfMsgForContent('videoimport_return') . " <a href=\"{$from_url}\">{$from_title->getText()}</a>");
					$wgOut->addHTML(".");
					$wgOut->addHTML("<p>");
					$wgOut->addWikiText("<videogallery widths=\"200px\" heights=\"200px\" perrow=\"3\">$video_gallery_values<videogallery>");
			
					return "";
				}
			} 
			
			//Display Form for searching/selecting images
			$upload_title = Title::makeTitle(NS_SPECIAL,"AddVideo");
			if($categories){
				$categories_qs = "&wpCategories=" . urlencode($categories);
			}
			
			if (!$q) { 
				$output .= "<div class=\"import-subtitle\">" . wfMsgForContent( 'videoimport_addsubtitle') . "</div>";
			} else{
				//Display Selected Photos Section
				$output .= "<div id=\"selected-container\" class=\"selected-videos\">
						<div class=\"selected-videos-title\">" . wfMsgForContent('videoimport_selectedvideos') . "</div>
						<div class=\"selected-videos-button\">
							<input type=\"button\" class=\"site-button\" value=\"" . wfMsgForContent('videoimport_submitbutton') . "\" onclick=\"import_videos()\">
						</div>
						<div id=\"select-instructions\">
						".wfMsgForContent( 'videoimport_submitinstructions')."
						</div>
					</div>";
			}
			$output .= "<div class=\"import-left-content\">
				<div class=\"video-options\">
					<div class=\"video-options-button\">
						<a href=\"javascript:show_youtube_search();\" id=\"search_button_tb\">" . wfMsgForContent( 'videoimport_youtube_searchbutton') . "</a>
					</div> 
					<div class=\"video-options-button\">
						<a href=\"".$upload_title->escapeFullURL('wpRedirect='.urlencode($from).$categories_qs)."\">" . wfMsgForContent( 'videoimport_pastebutton') . "</a>
					</div>
					<div class=\"cleared\"></div>
			</div>";
			
			//YouTube search form (starts hidden)
			
				$output .= "<div id=\"youtube-search\" class=\"import-search\" style=\"".(($q || $from)?"display:block":"display:none")."\">
					<div class=\"import-search-padding\">".wfMsg('videoimport_description')."
						<br/><br/>
						<form name=youtube method=GET  action='" . $importPage->getFullURL() . "'><b>".wfMsg('search').
						"</b> <input type=text name=q onKeyPress=\"detEnter(event)\" value=\"" . ((!$q)?htmlspecialchars($from_text):htmlspecialchars($q) ) . "\">
						<input type=hidden name=title value=\"" .  $importPage->getPrefixedText() . "\">
						<input type=hidden name=wpCategories value=\"" .  htmlspecialchars($wgRequest->getVal("wpCategories")) . "\">
						<input type=hidden name=wpFrom value=\"" .  htmlspecialchars($wgRequest->getVal("wpFrom"))  . "\">
						<input class=\"site-button\" type=\"button\"  onclick=\"javascript:submit_youtube_search()\" value=".wfMsg('search')."></form>
						<p>
					</div>
				</div>";
	
			//User has searched for YouTube...show the results
			if ($q != '') { 
				$wgOut->setPagetitle( wfMsgForContent( 'videoimport_youtubesearchtitle' ) );
				$output .= "<form name=\"videos\" method=\"POST\" action=\"\">
					<input type=\"hidden\" name=\"ids\" id=\"ids\" value=\"\">
					</form>";
				$output .= "<a id=\"top\" name=\"top\"></a>";
				$output .= "<div id=\"youtube-results\" class=\"youtube-results\">";
				$output .= $y->getVideos(1,$q);
				$output .= "</div>";
	
			}else{
				
				$wgOut->setPagetitle( wfMsgForContent( 'videoimport_addtitle', $from_text) );	
			}
			
			$output .= "<div class=\"cleared\"></div>
				
				</div>
				<div id=\"loadingxxxx\" class=\"loading-message\" style=\"position:absolute;display:none\">
						" . wfMsg("importfreeimages_loading") . "
				</div>
				<div class=\"cleared\"></div>";
			
			$wgOut->addHTML( $output  );
			 
		}
		
		
	}
	SpecialPage::addPage( new VideoImport );
	global $wgMessageCache,$wgOut;
	$wgMessageCache->addMessage( 'importvideo', 'Import Video' );
}


