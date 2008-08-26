<?php
$wgExtensionFunctions[] = 'wfSpecialCreatePageChk';

function wfSpecialCreatePageChk(){
  global $wgUser,$IP;
  include_once("includes/SpecialPage.php");

	class CreatePageChk  extends SpecialPage {
	
	  function CreatePageChk(){
	    UnlistedSpecialPage::UnlistedSpecialPage("CreatePageChk");
	  }
	  
	  function execute(){
	  	global $wgOut;
		$title = str_replace (" ", "_", $_POST["pagetitle"]);
		$dbr =& wfGetDB( DB_SLAVE );
		$sql = "SELECT * FROM {$dbr->tableName( 'page' )} WHERE page_title = " . $dbr->addQuotes($title);
		$result = $dbr->query($sql);
		$found=false;
		while ($row = $dbr->fetchObject( $result ) ) {
			$found=true;
		}
		if($found==true){
			print "Page exists";
		}else{
			print "OK";
		}
		
		// This line removes the navigation and everything else from the
 		// page, if you don't set it, you get what looks like a regular wiki
 		// page, with the body you defined above.
 		$wgOut->setArticleBodyOnly(true);
	}
	}
	
	SpecialPage::addPage( new CreatePageChk );
 	global $wgMessageCache,$wgOut;
 	$wgMessageCache->addMessage( 'createpagechk', 'just a test extension' );
 
 }
?>
