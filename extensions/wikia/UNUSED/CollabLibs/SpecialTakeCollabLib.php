<?php

$wgCollabLibReplaces;
function replace_collablib($matches){
	global $lib_num, $wgCollabLibReplaces;
	
	$collablib = $wgCollabLibReplaces[$lib_num];
	$lib_num++;
	 
	return $collablib;
}


$wgExtensionFunctions[] = 'wfSpecialTakeCollabLib';


function wfSpecialTakeCollabLib(){
	global $wgUser,$IP;
	include_once("includes/SpecialPage.php");


	class TakeCollabLib extends SpecialPage {
	
		function TakeCollabLib(){
			SpecialPage::SpecialPage("TakeCollabLib");
		}
		
		function execute(){
			
			global $wgUser, $wgOut, $wgRequest, $IP, $wgMemc, $wgStyleVersion, $wgContLang, $wgSupressPageTitle;
		
			
			global $wgMessageCache;
			require_once ( "$IP/extensions/wikia/CollabLibs/CollabLib.i18n.php" );
			foreach( efWikiaCollabLib() as $lang => $messages ){
				$wgMessageCache->addMessages( $messages, $lang );
			}
		

			$template = $wgRequest->getVal("collablib");
			
			//load in content
			$this->title = Title::makeTitleSafe( NS_COLLABLIB_TEMPLATE, $template );
			$article = new Article( $this->title );
			
			$this->article_content = $article->getContent();
			
			if(! $article->exists() ){
				return "Template does not exist";
			}
			
			$wgOut->addScript("<script type=\"text/javascript\" src=\"/extensions/wikia/CollabLibs/CollabLib.js?{$wgStyleVersion}\"></script>\n");
			$wgOut->addScript("<link rel='stylesheet' type='text/css' href=\"/extensions/wikia/CollabLibs/CollabLib.css?{$wgStyleVersion}\"/>\n");
			
			if( $wgUser->isBlocked() ){
				$wgOut->blockedPage( false );
				return false;
			}
			
			
			if($wgRequest->wasPosted() && $_SESSION["alreadysubmittedxx"] == false  ){
				$_SESSION["alreadysubmitted"] = true;
				
				global $lib_num;
				global $wgCollabLibReplaces;
				
				//make collablib
				//preg_match_all("/\/\/(.*?)\/\//i",$this->article_content,$matches );
				
				for($x = 1; $x <= $wgRequest->getVal("field_count"); $x++ ){
					$wgCollabLibReplaces[] = $wgRequest->getVal("field_" . $x);
				}
				
				
				$lib_num = 0;
				$collablib = preg_replace_callback ( "/\/\/(.*?)\/\//i"  , "replace_collablib"  , $this->article_content );
				 
				//Add CollabLib
				$title = Title::makeTitleSafe( NS_COLLABLIB, $this->title->getText() . " by User " . $wgUser->getName() );
				
				//Create Story Wiki Page
				$article = new Article($title);
				$article->doEdit( $collablib . "\n\n[[" . $wgContLang->getNsText( NS_CATEGORY ) . ":" . wfMsgForContent( 'collablib_category' ) . "]]\n
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
			global $wgUser, $wgOut, $wgUploadPath, $wgRequest;
			
			
			
			
			 
			preg_match_all("/\/\/(.*?)\/\//i",$this->article_content,$matches );
			 
			$wgOut->setHTMLTitle( wfMsg( 'pagetitle', wfMsgForContent( 'collablib_take_title' ) ) );
	
			
			$form .= "
			<div class=\"take-collablib-top\">
				<h1>" . wfMsgForContent( 'collablib_take_title' ) . "</h1>
				" . wfMsgForContent( 'collablib_take_instructions' ) . "
			</div>
			<div class=\"take-collablib\">
				
				<form action=\"\" method=\"post\"  name=\"form1\">
				
				
				<h1>
				 " . $this->title->getText() . "
				</h1>
				<div class=\"create-story-title\">
				";
				
				$fields = $matches[1];
				$x = 0;
				foreach($fields as $field){
					$x++;
					$form .= "<div><b>{$field}</b>: <input type=\"text\" name=\"field_{$x}\" class=\"createbox\" style=\"width:450px\"/></div>";
					
				}
				
				$form .= "</div>
			 
				</div>
				<input type=\"hidden\" name=\"field_count\" value=\"{$x}\">
			  </form>
			
			  </div>
			
			
		
			 <div class=\"take-collablib-buttons\">
				<input type=\"button\" class=\"site-button\" value=\"" . wfMsgForContent( 'collablib_take_button' ) . "\" size=\"20\" onclick=\"document.form1.submit()\" />
				<input type=\"button\" class=\"site-button\" value=\"" . wfMsgForContent( 'collablib_cancel_button' ) . "\" size=\"20\" onclick=\"history.go(-1)\" />
			</div>";
			  return $form;
		}
	}

	SpecialPage::addPage( new TakeCollabLib );
	global $wgMessageCache,$wgOut;
	$wgMessageCache->addMessage( 'takecollablib', 'Take CollabLib' );
}

?>