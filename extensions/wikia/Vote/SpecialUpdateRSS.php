<?php

$wgExtensionFunctions[] = 'wfSpecialUpdateRSS';


function wfSpecialUpdateRSS(){
  global $wgUser,$IP;
  include_once("includes/SpecialPage.php");


class UpdateRSS extends UnlistedSpecialPage {

  function UpdateRSS(){
    SpecialPage::SpecialPage("UpdateRSS");
  }

  function execute(){
    global $wgUser, $wgOut; 
				
    require_once("RSS.php");
    $rss = new RSS();
				$rss->PageID = 0;
				$rss->StaticXML = true;
				$rss->published = 1;
				$rss->update_rss_page_categories();
				
				
   $wgOut->addHTML("RSS Updated");
  }
  
}

 

 SpecialPage::addPage( new UpdateRSS );
 global $wgMessageCache,$wgOut;
 $wgMessageCache->addMessage( 'updaterss', 'Updaterss' );
 


}
?>