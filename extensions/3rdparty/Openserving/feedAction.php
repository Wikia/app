<?php
$wgExtensionFunctions[] = 'wfSpecialFeedAction';

function wfSpecialFeedAction(){
  global $wgUser,$IP;
  include_once("includes/SpecialPage.php");

	class FeedAction  extends SpecialPage {
	
	  function FeedAction(){
	    UnlistedSpecialPage::UnlistedSpecialPage("FeedAction");
	  }
	  
	    function execute(){
			global $wgSiteView, $wgOut;
			echo $_GET["Action"];
			$dbr =& wfGetDB( DB_SLAVE );
			if($wgSiteView->isUserAdmin() == true){
				if($_GET["Action"] == 1){
					$sql = "SELECT max(feed_item_order)+1 as NextOrder FROM site_view_feeds WHERE feed_mirror_id = 1";
					$res = $dbr->query($sql);
					$row = $dbr->fetchObject( $res );
					if($row){
						$Order =  $row->NextOrder;
					}
					if($Order == NULL)$Order = 1;
					
					if($_POST["id"] == 0 ){
						$sql = "INSERT INTO `site_view_feeds` "
					                                 		 ."( `feed_mirror_id`,`feed_title` , `feed_ctg`,"
					                                      ." `feed_count`, `feed_item_order`, `feed_order_by`, `feed_showdetails`,`feed_showctg`,`feed_showpic`,`feed_showblurb`)\n"
					                                      ."\tVALUES ( " . $wgSiteView->getID() . ", '" . addslashes($_POST["feedtitle"]). "' ,'" . addslashes($_POST["ctg"]) . "' ,"
					                                      ."  " . $_POST["show"] . ",  ". $Order .", '".  $_POST["orderby"] ."', ".  $_POST["det"] .", ".  $_POST["showctg"] .",".  $_POST["pic"] .", ".  $_POST["blb"] .")";
					
						$res = $dbr->query($sql);
						$sql = "SELECT @@Identity as ID FROM site_view_feeds";
						$res = $dbr->query($sql);
						$row = $dbr->fetchObject( $res );
						if($row){
							echo $row->ID;
						}
					}else{
						$sql = "UPDATE site_view_feeds SET 
								`feed_title` = '" . addslashes($_POST["feedtitle"]). "',
								`feed_ctg` = '" . addslashes($_POST["ctg"]). "',
								`feed_order_by` = '" . addslashes($_POST["orderby"]). "',
								`feed_count` = " .  $_POST["show"]. "
								WHERE feed_id = " . $_POST["id"];
						echo $sql;
						$res = $dbr->query($sql);
					}
				 
				}else if ($_GET["Action"] == 2){
					if($_POST["feed_id"]){
					$sql = "DELETE FROM `site_view_feeds` WHERE feed_id = " . $_POST["feed_id"];
					echo $sql;
					$res = $dbr->query($sql);
					}
				}else{
					if ( isset($_POST["items"]) && is_array($_POST["items"])){
						foreach ($_POST["items"] as $id => $itemOrder) {
							$sql = "UPDATE site_view_feeds SET feed_item_order = " . $itemOrder . " WHERE feed_id = " . $id;
							$res = $dbr->query($sql);
							//echo $sql;
						}
					}
				}
			}
			$wgOut->setArticleBodyOnly(true);
		}
	}
	SpecialPage::addPage( new FeedAction );
 	global $wgMessageCache,$wgOut;
 	$wgMessageCache->addMessage( 'feedaction', 'just a test extension' );
}

?>