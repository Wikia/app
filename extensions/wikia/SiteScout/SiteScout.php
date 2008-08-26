<?php
$wgExtensionFunctions[] = 'wfSpecialSiteScoutPage';
$wgExtensionFunctions[] = 'wfSiteScoutReadLang';

function wfSpecialSiteScoutPage(){
  global $wgUser,$IP;
  global $wgArticle;

  include_once("includes/SpecialPage.php");

	class SiteScoutPage  extends SpecialPage {
	
	  function SiteScoutPage(){
	    UnlistedSpecialPage::UnlistedSpecialPage("SiteScout");
	  }
	  
	    function execute(){
			global $wgSiteView, $wgOut, $wgParser, $wgStyleVersion, $wgRequest, $wgUploadPath;

			require_once ('extensions/wikia/SiteScout/SiteScoutClass.php');
		 
			$wgOut->setPagetitle( "Site Scout" );
			$wgOut->addScript("<link rel='stylesheet' type='text/css' href=\"/extensions/wikia/SiteScout/sitescout.css?{$wgStyleVersion}\"/>\n");
			$wgOut->addScript("<script type=\"text/javascript\" src=\"/extensions/wikia/SiteScout/SiteScout.js?{$wgStyleVersion}\"></script>\n");
			$wgOut->addScript("<script>YAHOO.util.Event.on(window, 'load', function () {start_scout()});</script>");
			
			$wgOut->addHTML("<script>
				var _NEW = \"" . wfMsgForContent( 'sitescout_new' ) . "\"
				var _MINOR = \"" . wfMsgForContent( 'sitescout_minor' ) . "\"
				var wgUploadPath = \"" . $wgUploadPath . "\"
			</script>
			");
				
			$output = '';
		
			if ( isset( $_COOKIE['scout_edits'] ) ) {
				$show_edits = $_COOKIE['scout_edits'];
			}else{
				$show_edits = $wgRequest->getVal('edits');
				if(!isset($show_edits))$show_edits=1;
			}
	
			if ( isset( $_COOKIE['scout_votes'] ) ) {
				$show_votes = $_COOKIE['scout_votes'];
			}else{
				$show_votes = $wgRequest->getVal('votes');
				if(!isset($show_votes))$show_votes=1;
			}
			
			if ( isset( $_COOKIE['scout_comments'] ) ) {
				$show_comments = $_COOKIE['scout_comments'];
			}else{
				$show_comments = $wgRequest->getVal('comments');
				if(!isset($show_comments))$show_comments=1;
			}
			
			if ( isset( $_COOKIE['scout_network_updates'] ) ) {
				$show_network_updates = $_COOKIE['scout_network_updates'];
			}else{
				$show_network_updates = $wgRequest->getVal('networkupdates');
				if(!isset($show_network_updates))$show_network_updates=1;
			}
			$Scout = new SiteScoutHTML;
			$Scout->setShowVotes($show_votes);
			$Scout->setShowEdits($show_edits);
			$Scout->setShowComments($show_comments);
			$Scout->setShowNetworkUpdates($show_network_updates);
			$output .= $Scout->getControls();
			$output .=  $Scout->getHeader() . $Scout->displayItems();
			
			$output .= '<script language="javascript">
 				itemMax = 30;timestamp = ' .  time() . ';</script>';
			$wgOut->addHtml($output);
		}
	}
	
	SpecialPage::addPage( new SiteScoutPage );
 	global $wgMessageCache,$wgOut;
 	$wgMessageCache->addMessage( 'sitescout', 'just a test extension' );
}

//read in localisation messages
function wfSiteScoutReadLang(){
	global $wgMessageCache, $IP;
	require_once ( "SiteScout.i18n.php" );
	foreach( efWikiaSiteScout() as $lang => $messages ){
		$wgMessageCache->addMessages( $messages, $lang );
	}
}
 
?>
