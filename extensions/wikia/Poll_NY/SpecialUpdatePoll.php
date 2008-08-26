<?php

$wgExtensionFunctions[] = 'wfSpecialUpdatePoll';


function wfSpecialUpdatePoll(){
	global $wgUser,$IP;
	include_once("includes/SpecialPage.php");


	class UpdatePoll extends SpecialPage {
	
		function UpdatePoll(){
			UnlistedSpecialPage::UnlistedSpecialPage("UpdatePoll");
		}
		
		function execute(){
			
			global $wgUser, $wgOut, $wgRequest, $IP, $wgMemc, $wgStyleVersion, $wgPollScripts;

		$wgOut->addScript("<script type=\"text/javascript\" src=\"{$wgPollScripts}/Poll.js?{$wgStyleVersion}\"></script>\n");
		$wgOut->addScript("<link rel='stylesheet' type='text/css' href=\"{$wgPollScripts}/Poll.css?{$wgStyleVersion}\"/>\n");

			global $wgMessageCache;
			require_once ( "Poll.i18n.php" );
			foreach( efWikiaPoll() as $lang => $messages ){
				$wgMessageCache->addMessages( $messages, $lang );
			}
			
			/*/
			/* Redirect Non-logged in users to Login Page
			/* It will automatically return them to the ViewGifts page
			/*/
			if($wgUser->getID() == 0 ){
				$wgOut->setPagetitle( "Woops!" );
				$login =  Title::makeTitle( NS_SPECIAL  , "UserLogin"  );
				$wgOut->redirect( $login->getFullURL()  );
				return false;
			}
			
			if($wgRequest->wasPosted() && $_SESSION["alreadysubmitted"] == false){
				$_SESSION["alreadysubmitted"] = true;
				$p = new Poll();
				$poll_info = $p->get_poll( $wgRequest->getVal("id") ); 
				 
				
				//Add Choices
				for($x=1;$x<=5;$x++){
					if( $wgRequest->getVal("poll_answer_{$x}") ){
						$dbr =& wfGetDB( DB_MASTER );
				
						$dbr->update( 'poll_choice',
						array( 'pc_text' => $wgRequest->getVal("poll_answer_{$x}") ),
						array( 'pc_poll_id' => $poll_info["id"],'pc_order' => $x ),
						__METHOD__ );
					}
				}
				
				//update image
				if( $wgRequest->getVal("poll_image_name") ){
						$dbr =& wfGetDB( DB_MASTER );
				
						$dbr->update( 'poll_question',
						array( 'poll_image' => $wgRequest->getVal("poll_image_name") ),
						array( 'poll_id' => $poll_info["id"] ),
						__METHOD__ );
				}
				
				
				$poll_page = Title::newFromID($wgRequest->getVal("id"));
				if( $wgRequest->getVal("prev_poll_id") ){
					$prev_qs = "&prev_id=".$wgRequest->getVal("prev_poll_id");
				}
				//Redirect to new Poll Page
				$wgOut->redirect( $poll_page->getFullURL() . $prev_qs);
				
			}else{
				$_SESSION["alreadysubmitted"] = false;
				$wgOut->addHTML($this->displayForm());
				
			}
				
			
		}
	

		function displayForm(){
			global $wgUser, $wgOut, $wgRequest, $wgUploadPath;
			
			$p = new Poll();
			$poll_info = $p->get_poll( $wgRequest->getVal("id") ); 
		
			if(!$poll_info["id"] || !($wgUser->isAllowed("protect") || $wgUser->getID() == $poll_info["user_id"])){
				$wgOut->setPagetitle( "Woops!" );
				$wgOut->addHTML( wfMsgForContent( 'poll_edit_invalid_access') );
				return false;
			}
			
			if( $poll_info["image"]){
				$poll_image_width = 150;
				$poll_image = Image::newFromName( $poll_info["image"] );
				$poll_image_url = $poll_image->createThumb($poll_image_width);
				$poll_image_tag = '<img width="' . ($poll_image->getWidth() >= $poll_image_width ? $poll_image_width : $poll_image->getWidth()) . '" alt="" src="' . $poll_image_url . '"/>';
			}
			
			$poll_page = Title::newFromID($wgRequest->getVal("id"));
			if( $wgRequest->getVal("prev_poll_id") ){
				$prev_qs = "&prev_id=".$wgRequest->getVal("prev_poll_id");
			}
			$form .= "
			<script>
				function reset_upload(){
					//Element.hide('real-form');
					//Element.show('fake-form');
					\$('imageUpload-frame').src=\"?title=Special:PollAjaxUpload&wpThumbWidth=75\"
					\$(\"imageUpload-frame\").show();
				}
					
				function completeImageUpload(){
					\$('poll_image').innerHTML ='<div style=\"margin:0px 0px 10px 0px;\"><img height=\"75\" width=\"75\" src=\"{$wgUploadPath}/common/ajax-loader-white.gif\"></div>';
				}
					
				function uploadComplete(img_tag,img_name){
					\$(\"poll_image\").innerHTML = img_tag + '<p><a href=\'javascript:reset_upload();\'>Upload New Image</a></p>';
					document.form1.poll_image_name.value = img_name;
					\$(\"imageUpload-frame\").hide();
				}
			</script>";
			
			$wgOut->setPagetitle(  wfMsgForContent( 'poll_edit_title' ) . " - {$poll_info["question"]}" );
			
			
			$form .= "<div class=\"update-poll-left\">
				<form action=\"\" method=\"post\" enctype=\"multipart/form-data\" name=\"form1\">
				<input type=\"hidden\" name=\"poll_id\" value=\"{$poll_info["id"]}\">
				<input type=\"hidden\" name=\"prev_poll_id\" value=\"". $wgRequest->getVal("prev_id") . "\">
				<input type=\"hidden\" name=\"poll_image_name\" id=\"poll_image_name\">
				
				<h1>" . wfMsgForContent( 'poll_edit_answers' ) . "</h1>";
				
				$x = 1;
				foreach($poll_info["choices"] as $choice){
					$form .= "<div class=\"update-poll-answer\"><span class=\"update-poll-answer-number\">{$x}.</span> <input type=\"text\" tabindex=\"{$x}\" id=\"poll_answer_{$x}\" name=\"poll_answer_{$x}\" value=\"" . htmlspecialchars($choice["choice"],ENT_QUOTES) . "\"/></div>";
					$x++;
				}
				
			$form .= "</div>
			
			
			
			 <div class=\"update-poll-right\">
				<h1>" . wfMsgForContent( 'poll_edit_image' ) . "</h1>
				<div id=\"poll_image\" class=\"update-poll-image\">{$poll_image_tag}</div>
					
				<!--
					<div id=\"fake-form\" style=\"display:block;height:70px;\">
						<input type=\"file\" size=\"40\" disabled/>
						<div style=\"margin:9px 0px 0px 0px;\">
							<input type=\"button\" value=\"Upload\"/>
						</div>
					</div>
					-->
					<div id=\"real-form\" style=\"display:block;height:70px;\">
						<iframe id=\"imageUpload-frame\" class=\"imageUpload-frame\" width=\"410\" 
						scrolling=\"no\" frameborder=\"0\" donload=\"check_iframe(event, this.contentWindow)\" src=\"index.php?title=Special:PollAjaxUpload&wpThumbWidth=75\">
						</iframe>
					</div>
					
			 </div>
			 <div class=\"cleared\"></div>
			 <div class=\"update-poll-warning\">".wfMsgExt("copyrightwarning", "parse")."</div>
			 <div class=\"update-poll-buttons\">
				<input type=\"button\" class=\"site-button\" value=\"" . wfMsgForContent( 'poll_edit_button' ) . "\" size=\"20\" onclick=\"document.form1.submit()\" />
				<input type=\"button\" class=\"site-button\" value=\"" . wfMsgForContent( 'poll_cancel_button' ) . "\" size=\"20\" onclick=\"window.location='" . $poll_page->getFullURL() . $prev_qs . "'\" />
			</div>
			</form>";
			return $form;
		}
	}

	SpecialPage::addPage( new UpdatePoll );
 
}

?>
