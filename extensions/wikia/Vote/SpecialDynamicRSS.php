<?php
$wgExtensionFunctions[] = 'wfSpecialDynamicRSS';

function wfSpecialDynamicRSS(){
  global $wgUser,$IP;
  include_once("$IP/includes/SpecialPage.php");

	class DynamicRSS  extends SpecialPage {
	
	  function DynamicRSS(){
	    UnlistedSpecialPage::UnlistedSpecialPage("RSS");
	  }
	  
	  function execute(){
			global $wgSiteView, $wgOut,$wgMimeType, $wgOutputEncoding, $IP;
			require_once( "$IP/extensions/Vote-Mag/RSS.php" );
			$wgMimeType = "text/xml";
			$wgOutputEncoding = "UTF-8";
			$Category = ($_GET["Category"]);
			
			$published = ($_GET["published"]);
			if(!$published)$published = 0;
			
			$published_level = ($_GET["level"]);
			if(!$published_level)$published_level = 1;
			
			$order = ($_GET["order"]);
			if(!$order)$order = 0;
			
			$rss = new RSS();
			$rss->StaticXML = false;
			$rss->published = $published;
			$rss->published_level = $published_level;
			$rss->order = $order;
			$output = $rss->update_rss_category($Category);
	
			echo $output;
			// This line removes the navigation and everything else from the
 			// page, if you don't set it, you get what looks like a regular wiki
 			// page, with the body you defined above.
 			$wgOut->setArticleBodyOnly(true);
		}
	}
	
	SpecialPage::addPage( new DynamicRSS );
 	global $wgMessageCache,$wgOut;
 	//$wgMessageCache->addMessage( 'sitescoutupdate', 'just a test extension' );
}
?>