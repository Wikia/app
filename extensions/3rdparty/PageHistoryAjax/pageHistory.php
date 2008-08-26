<?php
$wgExtensionFunctions[] = 'wfSpecialPageHistoryAJAX';

function wfSpecialPageHistoryAJAX(){
  global $wgUser,$IP;
  include_once("includes/SpecialPage.php");

	class PageHistoryAJAX  extends SpecialPage {
	
	  function PageHistoryAJAX(){
	    UnlistedSpecialPage::UnlistedSpecialPage("PageHistoryAJAX");
	  }
	  
	  function execute(){
		require_once( 'includes/PageHistory.php' );
		global $wgOut, $wgTitle;
			if($_GET["pid"] != ""){
				$dbr =& wfGetDB( DB_SLAVE );
				$sql = "SELECT page_namespace,page_title FROM {$dbr->tableName( 'page' )} WHERE page_id = " . $_GET["pid"];
				$res = $dbr->query($sql);
				
				while ($row = $dbr->fetchObject( $res ) ) {
					$title = Title::makeTitle( $row->page_namespace, $row->page_title);
					$title2= $title->getText();
				}
			}
				
			if($title2!=""){
				$wgTitle = Title::newFromURL( $title2 );
				$wgArticle = new Article($wgTitle);
				$wgOut->setSquidMaxage( $wgSquidMaxage );
				$h = new PageHistory($wgArticle);
				$h->History();
			}
			// This line removes the navigation and everything else from the
 			// page, if you don't set it, you get what looks like a regular wiki
 			// page, with the body you defined above.
 			$wgOut->setArticleBodyOnly(true);
		}
	}
	
	SpecialPage::addPage( new PageHistoryAJAX );
 	global $wgMessageCache,$wgOut;
 	$wgMessageCache->addMessage( 'pagehistoryajax', 'just a test extension' );
}
?>
