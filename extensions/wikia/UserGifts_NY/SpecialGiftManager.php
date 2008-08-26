<?php
class GiftManager extends SpecialPage {

	function GiftManager(){
		UnlistedSpecialPage::UnlistedSpecialPage("GiftManager");
	}
	
	function execute(){
		global $wgUser, $wgOut, $wgRequest, $wgSiteView, $IP;

		
		$wgOut->setPagetitle( "Gifts Manager" );
		
		if( $wgUser->isAnon() || !$this->canUserManage() ){
			$wgOut->errorpage( "error", "badaccess" );
		}
		
		$css = "<style>
		.view-form {font-weight:800;font-size:12px;font-color:#666666}
		.view-status {font-weight:800;font-size:12px;background-color:#FFFB9B;color:#666666;padding:5px;margin-bottom:5px;}
		</style>";
		$wgOut->addHTML($css);
		
		if(count($_POST)){
			if(!($_POST["id"])){
				$gift_id = Gifts::addGift($_POST["gift_name"],$_POST["gift_description"],$_POST["access"]);
				$wgOut->addHTML("<span class='view-status'>The gift has been created</span><br><br>");
			}else{
				$gift_id = $_POST["id"];
				Gifts::updateGift($gift_id,$_POST["gift_name"],$_POST["gift_description"],$_POST["access"]);
				$wgOut->addHTML("<span class='view-status'>The gift has been saved</span><br><br>");
			}
			
			$wgOut->addHTML($this->displayForm($gift_id));
		}else{
			$gift_id = $wgRequest->getVal( 'id' );
			if($gift_id || $wgRequest->getVal( 'method' )=="edit"){
				$wgOut->addHTML($this->displayForm($gift_id));
			}else{
				
				if ( $this->canUserCreateGift() ){
					$wgOut->addHTML("<div><b><a href=\"/index.php?title=Special:GiftManager&method=edit\">+ Add New Gift</a></b></div><p>");
				}
				$wgOut->addHTML($this->displayGiftList());
			}
		}
	}
	
	function canUserManage(){
		global $wgUser, $wgMaxCustomUserGiftCount;
		
		if( $wgUser->isBlocked() ){
			return false;
		}
		
		if( $wgMaxCustomUserGiftCount > 0 ){
			return true;
		}
		
		if( $wgUser->isAllowed("giftadmin") || in_array('giftadmin', $wgUser->getGroups() ) ){
			return true;
		}
		
		
		return false;
		
	}

	function canUserDelete(){
		global $wgUser;
		
		if( $wgUser->isBlocked() ){
			return false;
		}
		
		if( $wgUser->isAllowed("giftadmin") || in_array('giftadmin', $wgUser->getGroups() ) ){
			return true;
		}
		
		
		return false;
		
	}
	
	function canUserCreateGift(){
		global $wgUser, $wgMaxCustomUserGiftCount;
		
		if( $wgUser->isBlocked() ){
			return false;
		}
		
		$created_count = Gifts::getCustomCreatedGiftCount($wgUser->getID());
		if( $wgUser->isAllowed("giftadmin") || in_array('giftadmin',($wgUser->getGroups())) || ($wgMaxCustomUserGiftCount > 0 && $created_count < $wgMaxCustomUserGiftCount ) ){
			return true;
		}else{
			return false;
		}
	}
	
	function displayGiftList(){
		$output = "<div>";
		$gifts = Gifts::getManagedGiftList($per_page,$page);
		if($gifts){
			foreach ($gifts as $gift) {
				$output .= "<div class=\"Item\" >
				<a href=\"/index.php?title=Special:GiftManager&amp;id={$gift["id"]}\">{$gift["gift_name"]}</a> " . (( $this->canUserDelete() )?"<a href=\"" . Title::makeTitle(NS_SPECIAL,"RemoveMasterGift")->escapeFulLURL("gift_id={$gift["id"]}") . "\" style=\"font-size:10px;color:red;\">delete</a>":"") . "
					</div>\n";
			}
		}
		$output .= "</div>";
		return "<div id=\"views\">" . $output . "</div>";
	}

	
	function displayForm($gift_id){
		global $wgUser, $wgOut;
		
		if( !$gift_id && !$this->canUserCreateGift() ){
			return $this->displayGiftList();
		}
		$form .= "<div><b><a href=\"/index.php?title=Special:GiftManager\">View Gift List</a></b></div><p>";
		
		if($gift_id){
			$gift = Gifts::getGift($gift_id);
			if( $wgUser->getID() != $gift["creator_user_id"] && ( !in_array('giftadmin', $wgUser->getGroups() ) && !$wgUser->isAllowed("delete") ) ){
				$wgOut->errorpage( "error", "badaccess" );
			}
		}

		
		$form .=  '<form action="" method="POST" enctype="multipart/form-data" name="gift">';
		
		$form .= '<table border="0" cellpadding="5" cellspacing="0" width="500">';
		
		$form .=  '<tr>
		<td width="200" class="view-form">gift name</td>
		<td width="695"><input type="text" size="45" class="createbox" name="gift_name" value="'. $gift["gift_name"] . '"/></td>
		</tr>
		<tr>
		<td width="200" class="view-form" valign="top">gift description</td>
		<td width="695"><textarea class="createbox" name="gift_description" rows="2" cols="30">'. $gift["gift_description"] . '</textarea></td>
		</tr>';
		if( $gift_id ){
			$creator = Title::makeTitle( NS_USER, $gift["creator_user_name"] );
			$form .=  '<tr>
			<td class="view-form">created by</td><td><a href="' . $creator->escapeFullURL() . '">' . $gift["creator_user_name"] . '</a></td>
			</tr>';
			
		}
		global $wgUploadPath;
		if( ! in_array('giftadmin', $wgUser->getGroups() ) ){
			$form .= "<input type=hidden name=\"access\" value=\"1\">";
		}else{
			$form .=  '<tr>
				<td class="view-form">gift access</td><td><select name="access"><option value=0 ' . (($gift["access"]==0)?"selected":"") . '>public</option><option value=1 ' . (($gift["access"]==1)?"selected":"") . '>personal</option></select></td>
			</tr>';
		}
	
		if($gift_id){
			$gift_image = "<img src=\"{$wgUploadPath}/awards/" . Gifts::getGiftImage($gift_id,"l") . "\" border=\"0\" alt=\"gift\" />";
			$form .=  '<tr>
			<td width="200" class="view-form" valign="top">gift image</td>
			<td width="695">' . $gift_image . '
			<p>
			<a href="/index.php?title=Special:GiftManagerLogo&gift_id=' . $gift_id . '">add/replace image</a>
			</td>
			</tr>';
		}
		
		$form .=  '
		
		<tr>
		<td colspan="2">
		<input type=hidden name="id" value="' . $gift["gift_id"] . '">
		<input type="button" class="createbox" value="' . (($gift["gift_id"])?"edit":"create gift") . '" size="20" onclick="document.gift.submit()" />
		<input type="button" class="createbox" value="cancel" size="20" onclick="history.go(-1)" />
		</td>
		</tr>
		</table>
		
		</form>';
		return $form;
	}
}


?>