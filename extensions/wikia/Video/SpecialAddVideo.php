<?php

require_once( "Video.i18n.php" );


$wgExtensionFunctions[] = 'wfAddVideo';


function wfAddVideo() {

	global $wgUser,$IP;
	include_once("includes/SpecialPage.php");

	class AddVideo extends SpecialPage {
	
		function AddVideo(){
			SpecialPage::SpecialPage("AddVideo");
		}
		
		function execute(){

		        global $IP, $wgRequest, $wgStyleVersion, $wgOut, $wgUser ;

			$wgOut->addScript("<link rel='stylesheet' type='text/css' href=\"/extensions/wikia/Video/Video.css?{$wgStyleVersion}\"/>\n");
			
			if( $wgUser->isBlocked() ){
				$wgOut->blockedPage( false );
				return false;
			}
			
			$from = $wgRequest->getVal("wpFrom");
			$categories = $wgRequest->getVal("wpCategories");
			$destination = $wgRequest->getVal("destName");
			if( !$destination ) $destination = $wgRequest->getVal("wpDestName");
			
			//posted items
			$video_code = $wgRequest->getVal("wpVideo");
			$title = str_replace("#","",$wgRequest->getVal("wpTitle"));
			$categories = $wgRequest->getVal("wpCategories");
			
			$page_title=wfMsgForContent( 'video_addvideo_title' );
			if($destination)$page_title=wfMsgForContent( 'video_addvideo_title' )." for ".str_replace("_", " ", $destination);
			
			$wgOut->setPagetitle( $page_title );
				
			if($destination)$title = $destination;
			
			if( $from ){
				$from_title = Title::newFromDBkey( $from );
				$from_url = $from_title->getFullURL();
				$from_text = $from_title->getText();
			}
		
			$output .= "<div class=\"add-video-container\">
			<form name=\"videoadd\" action=\"\" method=\"POST\">";
			
			$output .= "<p class=\"addvideo-subtitle\">" . wfMsgExt( 'video_addvideo_instructions','parse') . "</p>";
			$output .= "<table border=\"0\" cellpadding=\"3\" cellspacing=\"5\">";
			$output .= "<tr>";
			
			if(!$destination){
				
				$output .= "<td><label for='wpTitle'>" . wfMsgHtml( 'video_addvideo_title_label' ) . "</label></td><td>";
				
				$output .= wfElement("input", array(
							"type"=>"text",
							"name" => "wpTitle",
							"size" => "30",
							"value" => $wgRequest->getVal("wpTitle"),
							)
						);
				$output .= "</td></tr>";
			}
			
			$output .= "<tr>
				<td valign=\"top\">".wfMsg("video_addvideo_embed_label")."</td>
				<td><textarea rows=\"5\" cols=\"65\" name=\"wpVideo\" id=\"wpVideo\">".$wgRequest->getVal("wpVideo")."</textarea></td>
			</tr>
			<tr>
				<td></td>
				<td>
					<input type='checkbox' name='wpWatchthis' id='wpWatchthis' $watchChecked value='true' />
					<label for='wpWatchthis'>" . wfMsgHtml( 'watchthisupload' ) . "</label>
				
				</td>
	</tr>";

				$output .= "<tr>
					<td></td><td>";
					$output .= wfElement("input", array(
						"type"=>"button",
						"value" => wfMsg("video-addvideo_button"),
						"onclick" => "document.videoadd.submit();",
						) 
					);
					$output .= "</td>
				</tr>";
			$output .= "</table>
			</form>
			</div>";
			
			if( $wgRequest->wasPosted() ){
				
				$video = Video::newFromName($title);
				
				//Page title for Video has already been taken
				if( $video->exists() && !$destination ){
					$error = "<div class=\"video-error\">" . wfMsgForContent( 'video_addvideo_exists') . "</div>";
					$wgOut->addHTML( $error ); 
				}else{
				
					//Get URL based on user input
					//it could be a straight URL to the page or the embed code
					if ( $video->isURL( $video_code ) ){
						$url = $video_code;
					}else {
						$url_from_embed =  $video->getURLfromEmbedCode( $video_code );	
						if (  $video->isURL( $url_from_embed ) ){
							$url = $url_from_embed;
						}
					}
					$provider = $video->getProviderByURL($url);
					if(!$url || $provider=="unknown"){
						$error = "<div class=\"video-error\">" . wfMsgForContent( 'video_addvideo_invalidcode') . "</div>";
						$wgOut->addHTML( $error ); 
					}else{
						$video->addVideo($url,$provider,$categories, $wgRequest->getVal("wpWatchthis") );
						$wgOut->redirect( $video->title->getFullURL() );
					}
	
				}
			} 
			
			$wgOut->addHTML( $output  );
			 
		}
	
	}
	SpecialPage::addPage( new AddVideo );
	global $wgMessageCache,$wgOut;
	$wgMessageCache->addMessage( 'addvideo', 'Add Video' );
}
?>
