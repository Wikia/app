<?php


$wgExtensionFunctions[] = 'wfSpecialEmailThis';

function wfSpecialEmailThis(){
  global $wgUser,$IP;
  include_once("includes/SpecialPage.php");

	class EmailThis  extends SpecialPage {
	
	  function EmailThis(){
	    UnlistedSpecialPage::UnlistedSpecialPage("EmailThis");
	  }
	  
	    function execute(){
			global $wgSiteView, $wgOut;
			if(!$_POST["emailto"]){
				$this->displayEmailForm();
			}else{
				global $wgUser, $wgTitle;
				$wgTitle = Title::newFromID($_POST["pageid"]);
				//send email
				$to = $_POST["emailto"];
				$headers = "From: " . $_POST["yourname"] . "<" . $_POST["emailfrom"] . ">";
				$subject = "Wikia.com: " . $this->getPageName($_POST["pageid"]);
				$body = "You have received this ArmchairGM.com mail from:\n"; 
				$body .= "===============================================\n";
				$body .= $_POST["yourname"] . "\n";
				
				$body .= $_POST["emailfrom"] . "\n\n";
					if($_POST["message"]){
					$body .= "Message from sender\n";
					$body .= "===============================================\n";
					$body .= $_POST["message"];
					$body .= "\n\n";
				}
				$body .=  "The article: '" . $wgTitle->getText() . "' is located at " . $wgTitle->getFullURL() . "\n\n";
			
				$body .= "\n\n";
				$body .= "* Please note, the sender's email address has not been verified.";
				//echo $body;
				if (mail($to, $subject, $body, $headers)) {
					
					$dbr =& wfGetDB( DB_SLAVE );
					$sql = "INSERT INTO `Emailed_Pages` "
			                                 ."( `emailed_page_id`, `email_to`,"
			                                 ." `name_from`, `email_from`, `wiki_username`, `sent_date`)\n"
			                                 ."\tVALUES ( ". $_POST["pageid"] . ", '" . $_POST["emailto"] . "' ,"
			                                 ." '" . $_POST["yourname"] . "','" . $_POST["emailfrom"] . "','" . $wgUser->mName . "', '".date("Y-m-d H:i:s")."')";
					$res = $dbr->query($sql);							 
											 
					echo("<p>Message successfully sent!</p>");
				}else{
					echo("<p>Message delivery failed...</p>");
				}
				
				
			}
			
				
			// This line removes the navigation and everything else from the
 			// page, if you don't set it, you get what looks like a regular wiki
 			// page, with the body you defined above.
 			$wgOut->setArticleBodyOnly(true);
			
		}
		
		function displayEmailForm(){
			$output = '<form  name="emailform" method="post"  enctype="multipart/form-data">
					   <span class="title">friend\'s email</span><br>
					   <input type=text tabindex="1" name=emailto style="width:300px;" class="createbox"><br><br>
					   <span class="title">your name</span><br>
					   <input type=text tabindex="2" name=yourname style="width:300px;" class="createbox"><br><br>
					   <span class="title">your email</span><br>
					   <input type=text tabindex="3" name=emailfrom style="width:300px;" class="createbox"><br><br>
					   <span class="title">message</span><br>
					   <textarea tabindex="4" accesskey="," name="message" rows="5" cols="60" class="createbox"></textarea><br><br>
					   <input tabindex="5" id="wpSave" type="button" onclick=sendEmail() value="send" name="wpSave" accesskey="s" title="Save your changes [alt-s]"/ class="createsubmit">
					   <input type="hidden" value="' . $_GET["pageid"] . '" name="pageid" />
					   </form>';
			echo $output;
		}
		
		function getPageName($pageid){
			$dbr =& wfGetDB( DB_SLAVE );
			$sql = "SELECT page_namespace,page_title FROM {$dbr->tableName( 'page' )} WHERE page_id = " . $pageid;
			$res = $dbr->query($sql);
		
			while ($row = $dbr->fetchObject( $res ) ) {
				$title = Title::makeTitle( $row->page_namespace, $row->page_title);
				return $title->getText();
			}
		}
		
	}

 SpecialPage::addPage( new EmailThis );
 global $wgMessageCache,$wgOut;
 $wgMessageCache->addMessage( 'emailthis', 'just a test extension' );


}







?>
