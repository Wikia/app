<?php
$wgExtensionFunctions[] = 'wfSpecialUserMenuAction';


function wfSpecialUserMenuAction(){
  global $wgUser,$IP;
  include_once("includes/SpecialPage.php");

class UserMenuAction extends UnlistedSpecialPage {

  function UserMenuAction(){
    UnlistedSpecialPage::UnlistedSpecialPage("UserMenuAction");
  }

  function execute(){
global $wgUser, $wgOut;
$dbr =& wfGetDB( DB_SLAVE );

if ( isset($_POST["menu"]) && is_array($_POST["menu"])){
	$menuArray = implode("|",$_POST["menu"]);
	//$menuArray = "HOME|MLB|NBA";
	$sql = "SELECT user_id FROM user_menu WHERE user_id = " . $wgUser->mId;
	$res = $dbr->query($sql);
	$row = $dbr->fetchObject( $res );
	if($row){
		$sql = "UPDATE user_menu SET user_menuitems = '" . addslashes ($menuArray) . "' WHERE user_id = " . $wgUser->mId;
	}else{
		$sql = "INSERT INTO user_menu (user_id,user_menuitems) VALUES ( " . $wgUser->mId . ",'" . addslashes ($menuArray) . "')" ;
	}
	$res = $dbr->query($sql);

}

$wgOut->setArticleBodyOnly(true);
}

}

 SpecialPage::addPage( new UserMenuAction );
 global $wgMessageCache,$wgOut;
 //$wgMessageCache->addMessage( 'commenteaction', 'comment action' );
 


}
?>