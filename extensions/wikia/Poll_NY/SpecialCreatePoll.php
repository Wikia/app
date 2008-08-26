<?php

$wgExtensionFunctions[] = 'wfSpecialCreatePoll';


function wfSpecialCreatePoll(){
	global $wgUser,$IP;
	include_once("includes/SpecialPage.php");


	class CreatePoll extends SpecialPage {
	
		function CreatePoll(){
			UnlistedSpecialPage::UnlistedSpecialPage("CreatePoll");
		}
		
		function execute(){
			
			global $wgUser, $wgOut, $wgRequest, $IP, $wgMemc, $wgStyleVersion, $wgContLang, $wgSupressPageTitle, $wgPollScripts;
		
			global $wgMessageCache;
			require_once ( "Poll.i18n.php" );
			foreach( efWikiaPoll() as $lang => $messages ){
				$wgMessageCache->addMessages( $messages, $lang );
			}
		
			$wgSupressPageTitle=true;

			$wgOut->addScript("<script type=\"text/javascript\" src=\"{$wgPollScripts}/Poll.js?{$wgStyleVersion}\"></script>\n");
			$wgOut->addScript("<link rel='stylesheet' type='text/css' href=\"{$wgPollScripts}/Poll.css?{$wgStyleVersion}\"/>\n");
			
			if( $wgUser->isBlocked() ){
				$wgOut->blockedPage( false );
				return false;
			}
			/*/
			/* Redirect Non-logged in users to Login Page
			/* It will automatically return them to the ViewGifts page
			/*/
			if($wgUser->getID() == 0 ){
				$wgOut->setPagetitle( "Woops!" );
				$login =  Title::makeTitle( NS_SPECIAL  , "Login"  );
				$wgOut->redirect( $login->getFullURL("returnto=Special:CreatePoll")  );
				return false;
			}
			
			/*/
			/*Create Poll Thresholds based on User Stats
			/*/
			global $wgCreatePollThresholds;
			if( is_array( $wgCreatePollThresholds ) && count( $wgCreatePollThresholds ) > 0 ){
				
				$can_create = true;
				
				$stats = new UserStats( $wgUser->getID(), $wgUser->getName() );
				$stats_data = $stats->getUserStats();
				
				$threshold_reason = "";
				foreach( $wgCreatePollThresholds as $field => $threshold ){
					if ( $stats_data[ $field ] < $threshold ){
						$can_create = false;
						$threshold_reason .= (($threshold_reason)?", ":"") . "$threshold $field";
					}
				}
					
				if( $can_create == false ){
					$wgSupressPageTitle = false;
					$wgOut->setPageTitle( wfMsg('poll_create_threshold_title') );
					$wgOut->addHTML( wfMsg("poll_create_threshold_reason", $threshold_reason) );
					return "";
				}
			}
			
			
			
			
			if($wgRequest->wasPosted() && $_SESSION["alreadysubmitted"] == false){
				$_SESSION["alreadysubmitted"] = true;
				
				//Add Poll  
				$poll_title = Title::makeTitleSafe( NS_POLL, $wgRequest->getVal("poll_question") );
				
				//Put Choices in Wiki Text (so we can track changes)
				$choices = "";
				for($x=1;$x<=5;$x++){
					if( $wgRequest->getVal("answer_{$x}") ){
						$choices .= $wgRequest->getVal("answer_{$x}") . "\n";
					}
				}
				
				//Create Poll Wiki Page
				$article = new Article($poll_title);
				$article->doEdit( "<userpoll>$choices</userpoll>\n{{Poll Bottom}}\n\n[[" . $wgContLang->getNsText( NS_CATEGORY ) . ":" . wfMsgForContent( 'poll_category' ) . "]]\n
							[[" . $wgContLang->getNsText( NS_CATEGORY ) . ":" . wfMsgForContent( 'poll_category_user' ) . " {$wgUser->getName()}]]\n
							[[" . $wgContLang->getNsText( NS_CATEGORY ) . ": {{subst:CURRENTMONTHNAME}} {{subst:CURRENTDAY}}, {{subst:CURRENTYEAR}}]]\n\n__NOEDITSECTION__", wfMsgForContent( 'poll_edit_desc' ) );
				
				$new_page_id = $article->getID();
				 
				$p = new Poll();
				$poll_id = $p->add_poll_question( $wgRequest->getVal("poll_question"), $wgRequest->getVal("poll_image_name"),$new_page_id );
				
				//Add Choices
				for($x=1;$x<=5;$x++){
					if( $wgRequest->getVal("answer_{$x}") ){
						$p->add_poll_choice($poll_id, $wgRequest->getVal("answer_{$x}") ,$x);
					}
				}
				
				//clear user profile cache
				global $wgMemc;
				$key = wfMemcKey( 'user', 'profile', 'polls' , $wgUser->getID() );
				$wgMemc->delete( $key );
			
				//Redirect to new Poll Page
				$wgOut->redirect( $poll_title->getFullURL() );
				
			}else{
				$_SESSION["alreadysubmitted"] = false;
				$wgOut->addHTML($this->displayForm());
				
			}
				
			
		}
	

		function displayForm(){
			global $wgUser, $wgOut, $wgUploadPath, $wgRequest;
			
			$iframe_title = Title::makeTitle(NS_SPECIAL, "PollAjaxUpload");
			$wgOut->setHTMLTitle( wfMsg( 'pagetitle', wfMsgForContent( 'poll_create_title' ) ) );
	
			$form .= "<script>
					function update_answer_boxes(){
						for(x=1;x<=4;x++){
						
							if(\$(\"answer_\"+x).value){
								YAHOO.widget.Effects.Show(\"poll_answer_\"+(x+1));
								
							}
						}
					}
					
					function reset_upload(){
						\$('imageUpload-frame').src=\"" . $iframe_title->escapeFullURL("wpThumbWidth=75") . "\"
						YAHOO.widget.Effects.Show(\"imageUpload-frame\");
					}
					
					function completeImageUpload(){
						\$('poll_image').innerHTML ='<div style=\"margin:0px 0px 10px 0px;\"><img height=\"75\" width=\"75\" src=\"{$wgUploadPath}/common/ajax-loader-white.gif\"></div>';
					}
					
					function uploadError(error){
						\$(\"poll_image\").innerHTML = error + '<p>';
						reset_upload()
					}
					
					function uploadComplete(img_tag,img_name){
						\$(\"poll_image\").innerHTML = img_tag + '<p><a href=\'javascript:reset_upload();\'>Upload New Image</a></p>';
						document.form1.poll_image_name.value = img_name 
						YAHOO.widget.Effects.Hide(\"imageUpload-frame\");
					}
					
					function create_poll(){
					
						answers=0;
						for(x=1;x<=4;x++){
							
							if(\$(\"answer_\"+x).value){
								answers++;
							}
						}
						
						if(answers<2){
							alert(\"You must have at least two answer choices\");
							return '';
						}
						
						if(!\$(\"poll_question\").value){
							alert(\"You must enter a question\");
							return '';
						}
						
						if(\$(\"poll_question\").value.indexOf('#') > -1){
							alert(\"# is an invalid character for the poll question.\")
							return '';
						}
						\$(\"poll_question\").value = \$(\"poll_question\").value.replace('&','%26')
						
						var url = \"index.php?action=ajax\";
						var pars = \"rs=wfPollTitleExists&rsargs[]=\"+escape(\$(\"poll_question\").value)
						var callback = {
							success: function( req ) {
								if(req.responseText.indexOf(\"OK\")>=0){
									document.form1.submit();

								}else{
									alert(\"Please choose another poll name\");
								}
							}
						};
						var request = YAHOO.util.Connect.asyncRequest('POST', url, callback, pars);
					}
			
				</script>";
			
				
			$form .= "
			<div class=\"create-poll-top\">
				<h1>" . wfMsgForContent( 'poll_create_title' ) . "</h1>
				" . wfMsgForContent( 'poll_instructions' ) . "
				<p><input type=\"button\" class=\"site-button\" value=\"" . wfMsgForContent( 'poll_take_button' ) . "\" onclick=\"goto_new_poll();\"/></p>
			</div>
			<div class=\"create-poll-question-and-answer\">
				
				<form action=\"\" method=\"post\" enctype=\"multipart/form-data\" name=\"form1\">
				<input type=\"hidden\" name=\"poll_image_name\" id=\"poll_image_name\">
				
				<h1>
				 " . wfMsgForContent( 'poll_question_label' ) . "
				</h1>
				<div class=\"create-poll-question\">
					<input type=\"text\" id=\"poll_question\" name=\"poll_question\" class=\"createbox\" style=\"width:450px\" value=\"" . htmlspecialchars( $wgRequest->getVal("wpDestName") , ENT_QUOTES) . "\" />
				</div>
				
				
				<div class=\"create-poll-answers\">
				<h1>" . wfMsgForContent( 'poll_choices_label' ) . "</h1>
					<div class=\"create-poll-answer\" id=\"poll_answer_1\"><span class=\"create-poll-answer-number\">1.</span><input type=\"text\" id=\"answer_1\" name=\"answer_1\"/></div>
					<div class=\"create-poll-answer\" id=\"poll_answer_2\"><span class=\"create-poll-answer-number\">2.</span><input type=\"text\" id=\"answer_2\" name=\"answer_2\" onKeyUp=\"update_answer_boxes();\" /></div>
					<div class=\"create-poll-answer\" id=\"poll_answer_3\" style=\"display:none;\"><span class=\"create-poll-answer-number\">3.</span><input type=\"text\" id=\"answer_3\" name=\"answer_3\" onKeyUp=\"update_answer_boxes();\" /></div>
					<div class=\"create-poll-answer\" id=\"poll_answer_4\" style=\"display:none;\"><span class=\"create-poll-answer-number\">4.</span><input type=\"text\" id=\"answer_4\" name=\"answer_4\" onKeyUp=\"update_answer_boxes();\" /></div>
					<div class=\"create-poll-answer\" id=\"poll_answer_5\" style=\"display:none;\"><span class=\"create-poll-answer-number\">5.</span><input type=\"text\" id=\"answer_5\" name=\"answer_5\"/></div>
					
				</div>
				
			  </form>
			
			  </div>
			
			  <div class=\"create-poll-image\">
			  	<h1>" . wfMsgForContent( 'poll_image_label' ) . "</h1>
				<div id=\"poll_image\"></div>
				
				<!-- 
				<div id=\"fake-form\" style=\"display:block;height:70px;\">
					<input type=\"file\" size=\"40\" disabled/>
					<div style=\"margin:9px 0px 0px 0px;\">
						<input type=\"button\" value=\"FUpload\"/>
					</div>
				</div>
				 -->
				<div id=\"real-form\" style=\"display:block;height:70px;\">
					<iframe id=\"imageUpload-frame\" class=\"imageUpload-frame\" width=\"410\"
					scrolling=\"no\" frameborder=\"0\" donload=\"check_iframe()\" src=\"" . $iframe_title->escapeFullURL("wpThumbWidth=75") . "\">
					</iframe>
				</div>
			 </div>
		
			 <div class=\"create-poll-buttons\">
				<input type=\"button\" class=\"site-button\" value=\"" . wfMsgForContent( 'poll_create_button' ) . "\" size=\"20\" onclick=\"create_poll()\" />
				<input type=\"button\" class=\"site-button\" value=\"" . wfMsgForContent( 'poll_cancel_button' ) . "\" size=\"20\" onclick=\"history.go(-1)\" />
			</div>";
			  return $form;
		}
	}

	SpecialPage::addPage( new CreatePoll );
	global $wgMessageCache,$wgOut;
	$wgMessageCache->addMessage( 'addpoll', 'Create Poll' );
}

?>