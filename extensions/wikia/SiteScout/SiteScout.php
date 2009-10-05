<?php
$wgExtensionFunctions[] = 'wfSpecialSiteScoutPage';
$wgExtensionFunctions[] = 'wfSiteScoutReadLang';

function wfSpecialSiteScoutPage(){
  global $wgUser,$IP;
  global $wgArticle;

  include_once("includes/SpecialPage.php");

	class SiteScoutPage  extends UnlistedSpecialPage {
	
	  function __construct(){
	    parent::__construct("SiteScout");
	  }
	  
	    function execute(){
			global $wgSiteView, $wgOut, $wgParser, $wgStyleVersion, $wgRequest, $wgUploadPath, $wgMemc;
			global $wgUser, $wgDBname;

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
				
			$options = array('scout_edits', 'scout_votes', 'scout_comments', 'scout_network_updates');
			$output = '';
			
			foreach ( $options as $key ) {
				$val = $wgMemc->get( wfMemcKey( $key, $wgUser->getId() ) );
				$options[$key] = ( isset($val) ) ? $val : null;
			}
			
			extract($options);
		
			$show_edits = $wgRequest->getVal('edits', null);
			$show_votes = $wgRequest->getVal('votes', null);
			$show_comments = $wgRequest->getVal('comments', null);
			$show_network_updates = $wgRequest->getVal('networkupdates', null);
			
			if ( isset( $scout_edits ) && !isset($show_edits) ) {
				$show_edits = $scout_edits;
			} else {
				if ( isset($show_edits) ) {
					$wgMemc->set( wfMemcKey( "scout_edits", $wgUser->getId() ), $show_edits );
				} else {
					$show_edits = 1;
				}
			}
	
			if ( isset( $scout_votes ) ) {
				$show_votes = $scout_votes;
			} else {
				if ( isset($show_votes) ) {
					$wgMemc->set( wfMemcKey( "scout_votes", $wgUser->getId() ), $show_votes );
				} else {
					$show_votes = 1;
				}
			}
			
			if ( isset( $scout_comments ) ) {
				$show_comments = $scout_comments;
			} else {
				if ( isset($show_comments) ) {
					$wgMemc->set( wfMemcKey( "scout_comments", $wgUser->getId() ), $show_comments );
				} else {
					$show_comments = 1;
				}
			}
			
			if ( isset( $scout_network_updates ) ) {
				$show_network_updates = $scout_network_updates;
			} else {
				if ( isset($show_network_updates) ) {
					$wgMemc->set( wfMemcKey( "scout_network_updates", $wgUser->getId() ), $show_network_updates );
				} else {
					$show_network_updates = 1;
				}
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
