<?php

$wgExtensionFunctions[] = 'wfSpecialCreateCollabLib';


function wfSpecialCreateCollabLib(){
	global $wgUser,$IP;
	include_once("includes/SpecialPage.php");


	class CreateCollabLib extends SpecialPage {
	
		function CreateCollabLib(){
			SpecialPage::SpecialPage("CreateCollabLib");
		}
		
		function execute(){
			
			global $wgUser, $wgOut, $wgRequest, $IP, $wgMemc, $wgStyleVersion, $wgContLang, $wgSupressPageTitle;
		
			global $wgMessageCache;
			require_once ( "$IP/extensions/wikia/CollabLibs/CollabLib.i18n.php" );
			foreach( efWikiaCollabLib() as $lang => $messages ){
				$wgMessageCache->addMessages( $messages, $lang );
			}
		
			
			$wgOut->addScript("<script type=\"text/javascript\" src=\"/extensions/wikia/CollabLibs/CollabLib.js?{$wgStyleVersion}\"></script>\n");
			$wgOut->addScript("<link rel='stylesheet' type='text/css' href=\"/extensions/wikia/CollabLibs/CollabLib.css?{$wgStyleVersion}\"/>\n");
			
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
				$login =  Title::makeTitle( NS_SPECIAL  , "Userlogin"  );
				$wgOut->redirect( $login->getFullURL("returnto=Special:CreateCollabLib")  );
				return false;
			}
			
			if($wgRequest->wasPosted() && $_SESSION["alreadysubmitted"] == false && $wgRequest->getVal("collablib_title") != "" ){
				$_SESSION["alreadysubmitted"] = true;
				
				//Add Story  
				$title = Title::makeTitleSafe( NS_COLLABLIB_TEMPLATE, $wgRequest->getVal("collablib_title") );
				
				//Create Story Wiki Page
				$article = new Article($title);
				$article->doEdit( $wgRequest->getVal("collablib_text") . "\n\n[[" . $wgContLang->getNsText( NS_CATEGORY ) . ":" . wfMsgForContent( 'collablib_category' ) . "]]\n
							[[" . $wgContLang->getNsText( NS_CATEGORY ) . ": {{subst:CURRENTMONTHNAME}} {{subst:CURRENTDAY}}, {{subst:CURRENTYEAR}}]]\n\n__NOEDITSECTION__", wfMsgForContent( 'collablib_edit_desc' ) );
				
				$new_page_id = $article->getID();
				 
				//Redirect to new Page
				$wgOut->redirect( $title->getFullURL() );
				
			}else{
				$_SESSION["alreadysubmitted"] = false;
				$wgOut->addHTML($this->displayForm());
				
			}
				
			
		}
	

		function displayForm(){
			global $wgUser, $wgOut, $wgUploadPath;
			
			$wgOut->setHTMLTitle( wfMsg( 'pagetitle', wfMsgForContent( 'collablib_create_title' ) ) );
	
			
			$form .= "
			<div class=\"create-collablib-top\">
				<h1>" . wfMsgForContent( 'collablib_create_title' ) . "</h1>
				" . wfMsgForContent( 'collablib_create_instructions' ) . "
			</div>
			<div class=\"create-collablib\">
				
				<form action=\"\" method=\"post\"  name=\"form1\">
				
				
				<h1>
				 " . wfMsgForContent( 'collablib_title_label' ) . "
				</h1>
				
				<div class=\"create-collablib-title\">
					<input type=\"text\" id=\"collablib_title\" name=\"collablib_title\" class=\"createbox\" style=\"width:450px\"/>
				</div>
				
				 
				<h1>" . wfMsgForContent( 'collablib_text_label' ) . "</h1>
				<div> " . wfMsgForContent( 'collablib_text_instructions' ) . "</div>
				<div class=\"create-collablib-text\">
					<textarea id=\"collablib_text\" name=\"collablib_text\" class=\"createbox\" rows=\"10\" cols=\"45\"></textarea>
				</div>
			 
				
			  </form>
			
			  </div>
			
			
		
			 <div class=\"create-collablib-buttons\">
				<input type=\"button\" class=\"site-button\" value=\"" . wfMsgForContent( 'collablib_create_button' ) . "\" size=\"20\" onclick=\"document.form1.submit()\" />
				<input type=\"button\" class=\"site-button\" value=\"" . wfMsgForContent( 'collablib_cancel_button' ) . "\" size=\"20\" onclick=\"history.go(-1)\" />
			</div>";
			  return $form;
		}
	}

	SpecialPage::addPage( new CreateCollabLib );
	global $wgMessageCache,$wgOut;
	$wgMessageCache->addMessage( 'createcollablib', 'Create CollabLib' );
}

?>
