<?php
$wgExtensionFunctions[] = 'wfSpecialSiteScoutUpdate';

function wfSpecialSiteScoutUpdate(){
  global $wgUser,$IP;
  include_once("includes/SpecialPage.php");

	class SiteScoutUpdate  extends UnlistedSpecialPage {
	
	  function SiteScoutUpdate(){
	    parent::__construct("SiteScoutUpdate");
	  }
	  
	  function execute(){
			global $wgSiteView, $wgOut,$wgMimeType, $wgOutputEncoding, $wgRequest;
			$wgMimeType = "text/xml";
			$wgOutputEncoding = "UTF-8";
			require_once( 'SiteScoutClass.php' );
			
			$Scout = new SiteScoutXML;
			$Scout->setShowEdits( $wgRequest->getVal('edits', 0) );
			$Scout->setShowVotes( $wgRequest->getVal('votes', 0) );
			$Scout->setShowComments( $wgRequest->getVal('comments', 0) );
			$Scout->setShowNetworkUpdates( $wgRequest->getVal('networkupdates', 0) );
			$Scout->setTimestamp( $wgRequest->getVal('timestamp', 0) );
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
