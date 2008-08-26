<?php
$wgExtensionFunctions[] = 'wfSpecialSiteScoutUpdate';

function wfSpecialSiteScoutUpdate(){
  global $wgUser,$IP;
  include_once("includes/SpecialPage.php");

	class SiteScoutUpdate  extends SpecialPage {
	
	  function SiteScoutUpdate(){
	    UnlistedSpecialPage::UnlistedSpecialPage("SiteScoutUpdate");
	  }
	  
	  function execute(){
			global $wgSiteView, $wgOut,$wgMimeType, $wgOutputEncoding;
			$wgMimeType = "text/xml";
			$wgOutputEncoding = "UTF-8";
			require_once( 'SiteScoutClass.php' );
			
			$Scout = new SiteScoutXML;
			$Scout->setShowEdits($_GET["edits"]);
			$Scout->setShowVotes($_GET["votes"]);
			$Scout->setShowComments($_GET["comments"]);
			$Scout->setShowNetworkUpdates($_GET["networkupdates"]);
			$Scout->setTimestamp($_GET["timestamp"]);
			$output =  $Scout->displayItems();
			echo $output;
		
			// This line removes the navigation and everything else from the
 			// page, if you don't set it, you get what looks like a regular wiki
 			// page, with the body you defined above.
 			$wgOut->setArticleBodyOnly(true);
		}
	}
	
	SpecialPage::addPage( new SiteScoutUpdate );
 	global $wgMessageCache,$wgOut;
 	$wgMessageCache->addMessage( 'sitescoutupdate', 'just a test extension' );
}
?>
