<?php
class ViewSystemGifts extends SpecialPage {

	function ViewSystemGifts(){
		SpecialPage::SpecialPage("ViewSystemGifts");
	}
	
	function execute(){
		
		global $wgUser, $wgOut, $wgRequest, $IP, $wgMemc, $wgUploadPath, $wgMessageCache, $wgSystemGiftsScripts;
		
		$wgOut->addScript("<link rel='stylesheet' type='text/css' href=\"{$wgSystemGiftsScripts}/SystemGift.css?{$wgStyleVersion}\"/>\n");

		//language messages
		require_once ( "SystemGift.i18n.php" );
		foreach( efWikiaSystemGift() as $lang => $messages ){
			$wgMessageCache->addMessages( $messages, $lang );
		}
		
		/**/
		$output = "";
		$user_name = $wgRequest->getVal('user');
		$page =  $wgRequest->getVal('page');

		/*/
		/* Redirect Non-logged in users to Login Page
		/* It will automatically return them to the ViewGifts page
		/*/
		if($wgUser->getID() == 0 && $user_name==""){
			$wgOut->setPagetitle( wfMsg("ga-error-title") );
			$login =  Title::makeTitle(NS_SPECIAL, "UserLogin");
			$wgOut->redirect( $login->escapeFullURL('returnto=Special:ViewSystemGifts') );
			return false;
		}
		
		/*/
		/* If no user is set in the URL, we assume its the current user
		/*/			
		if(!$user_name)$user_name = $wgUser->getName();
		$user_id = User::idFromName($user_name);
		$user =  Title::makeTitle( NS_USER  , $user_name  );
		$user_safe = urlencode($user_name);
		/*/
		/* Error message for username that does not exist (from URL)
		/*/			
		if($user_id == 0){
			$wgOut->setPagetitle( wfMsg("ga-error-title") );
			$wgOut->addHTML(wfMsg("ga-error-message-no-user"));
			return false;
		}
  
		/*/
		/* Config for the page
		/*/			
		$per_page = 10;
		if(!$page || !is_numeric($page) )$page=1;
		$per_row = 2;
		
		/*
		Get all Gifts for this user into the array
		*/	
		$rel = new UserSystemGifts($user_name);

		$gifts = $rel->getUserGiftList(0,$per_page,$page);
		$total = $rel->getGiftCountByUsername($user_name); // count($relationships);

		$relationship = UserRelationship::getUserRelationshipByID($user_id,$wgUser->getID());
		
		/*
		show gift count for user
		*/
		
		$output .= $wgOut->setPagetitle( wfMsg("ga-title", $rel->user_name) );
		
		$output .= "<div class=\"back-links\">
			".wfMsg("ga-back-link", $wgUser->getUserPage()->escapeFullURL(), $rel->user_name)."
		</div>";
		
		$output .= "<div class=\"ga-count\">
			".wfMsgExt("ga-count","parsemag", $rel->user_name, $total)."
		</div>";
		
		//safelinks
		$view_system_gift_link = Title::makeTitle(NS_SPECIAL,"ViewSystemGift");
		
		if ($gifts) {
			$x = 1;
			foreach ($gifts as $gift) {
				$gift_image = "<img src=\"{$wgUploadPath}/awards/" . SystemGifts::getGiftImage($gift["gift_id"],"ml") . "\" border=\"0\" alt=\"\" />";
				
				$output .= "<div class=\"ga-item\">
					{$gift_image}
					<a href=\"".$view_system_gift_link->escapeFullURL('gift_id='.$gift["id"])."\">{$gift["gift_name"]}</a>";
						
					if ($gift["status"] == 1) {
						if( $user_name==$wgUser->getName() ){
							$rel->clearUserGiftStatus($gift["id"]);
							$rel->decNewSystemGiftCount( $wgUser->getID() );
						}
						$output .= "<span class=\"ga-new\">".wfMsg('ga-new')."</span>";
					}
					
					$output .= "<div class=\"cleared\"></div>
				</div>";
				if($x==count($gifts) || $x!=1 && $x%$per_row ==0)$output .= "<div class=\"cleared\"></div>";
				
				$x++;	
			}
		}
		
		/**/
		/*BUILD NEXT/PREV NAV
		**/
		$numofpages = $total / $per_page; 
		
		$page_link = Title::makeTitle(NS_SPECIAL,"ViewSystemGifts");
		
		if($numofpages>1) {
			$output .= "<div class=\"page-nav\">";
			if($page>1) { 
				$output .= "<a href=\"".$page_link->escapeFullURL('user='.$user_name.'&rel_type='.$rel_type.'&page='.($page-1))."\">".wfMsg("ga-previous")."</a> ";
			}
			
			
			if(($total % $per_page) != 0)$numofpages++;
			if($numofpages >=9 && $page < $total)$numofpages=9+$page;
			if($numofpages >= ($total / $per_page) )$numofpages = ($total / $per_page)+1;
			
			for($i = 1; $i <= $numofpages; $i++){
				if($i == $page) {
				    $output .=($i." ");
				} else {
				    $output .="<a href=\"".$page_link->escapeFullURL('user='.$user_name.'&rel_type='.$rel_type.'&page='.$i)."\">$i</a> ";
				}
			}
	
			if(($total - ($per_page * $page)) > 0){
				$output .=" <a href=\"".$page_link->escapeFullURL('user='.$user_name.'&rel_type='.$rel_type.'&page='.($page+1))."\">".wfMsg("ga-next")."</a>"; 
			}
			$output .= "</div>";
		}
		/**/
		/*BUILD NEXT/PREV NAV
		**/
		
		$wgOut->addHTML($output);
		
	}

}


?>