<?php


	class ViewGifts extends SpecialPage {
	
		function ViewGifts(){
			SpecialPage::SpecialPage("ViewGifts");
		}
		
		function execute(){
			
			global $wgUser, $wgOut, $wgRequest, $IP, $wgMemc, $wgMessageCache, $wgStyleVersion, $wgUploadPath, $wgUserGiftsScripts;
			
			$wgOut->addScript("<link rel='stylesheet' type='text/css' href=\"{$wgUserGiftsScripts}/UserGifts.css?{$wgStyleVersion}\"/>\n");

			//language messages
			require_once ( "UserGifts.i18n.php" );
			foreach( efWikiaUserGifts() as $lang => $messages ){
				$wgMessageCache->addMessages( $messages, $lang );
			}
			
			$output = "";
			$user_name = $wgRequest->getVal('user');
			$page =  $wgRequest->getVal('page');
		
			 
			/*/
			/* Redirect Non-logged in users to Login Page
			/* It will automatically return them to the ViewGifts page
			/*/
			if($wgUser->getID() == 0 && $user_name==""){
				$login =  Title::makeTitle(NS_SPECIAL,"UserLogin");
				$wgOut->redirect( $login->escapeFullURL('returnto=Special:ViewGifts'));
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
				$wgOut->setPagetitle( wfMsg("g-error-title") );
				$wgOut->addHTML(wfMsg("g-error-message-no-user"));
				return false;
			}
	  
			/*/
			/* Config for the page
			/*/			
			$per_page = 10;
			if(!$page||!is_numeric($page) )$page=1;
			$per_row = 2;
			
			/*
			Get all Gifts for this user into the array
			*/	
			$rel = new UserGifts($user_name);

			$gifts = $rel->getUserGiftList(0,$per_page,$page);
			$total = $rel->getGiftCountByUsername($user_name); // count($relationships);

			$relationship = UserRelationship::getUserRelationshipByID($user_id,$wgUser->getID());
			
			/*
			show gift count for user
			*/
			
			$output .= $wgOut->setPagetitle( wfMsg("g-list-title", $rel->user_name) );
			
			$output .= "<div class=\"back-links\">
				".wfMsg("g-back-link", $user->getFullURL(), $rel->user_name)."
			</div>
			<div class=\"g-count\">
				".wfMsgExt("g-count", "parsemag", $rel->user_name, $total)."
			</div>";
			
			if ($gifts) {
				
				$x = 1;
				
				//safe links
				$view_gift_link = Title::makeTitle(NS_SPECIAL, "ViewGift");
				$give_gift_link = Title::makeTitle(NS_SPECIAL, "GiveGift");
				$remove_gift_link = Title::makeTitle(NS_SPECIAL, "RemoveGift");
				
				foreach ($gifts as $gift) {
					
					$giftname_length = strlen($gift["gift_name"]);
					$giftname_space = stripos($gift["gift_name"], ' ');
					
					if (($giftname_space == false || $giftname_space >= "30") && $giftname_length > 30){
						$gift_name_display = substr($gift["gift_name"], 0, 30)." ".substr($gift["gift_name"], 30, 50);
					}
					else {
						$gift_name_display = $gift["gift_name"];
					};
					
					$user_from =  Title::makeTitle(NS_USER,$gift["user_name_from"]);
					$gift_image = "<img src=\"{$wgUploadPath}/awards/" . Gifts::getGiftImage($gift["gift_id"],"l") . "\" border=\"0\" alt=\"\"/>";
					
					$output .= "<div class=\"g-item\">
						<a href=\"".$view_gift_link->escapeFullURL('gift_id='.$gift["id"])."\">{$gift_image}</a>
						<div class=\"g-title\">
							<a href=\"".$view_gift_link->escapeFullURL('gift_id='.$gift["id"])."\">{$gift_name_display}</a>";
							if ($gift["status"] == 1) {
								if( $user_name==$wgUser->getName() ){
									$rel->clearUserGiftStatus($gift["id"]);
									$rel->decNewGiftCount( $wgUser->getID() );
								}
						
								$output .= "<span class=\"g-new\">".wfMsg('g-new')."</span>";
							}
						$output .= "</div>";
						
						$output .= "<div class=\"g-from\">
							".wfMsg("g-from", $user_from->escapeFullURL(), $gift["user_name_from"])." 
						</div>
						<div class=\"g-actions\">
							<a href=\"".$give_gift_link->escapeFullURL('gift_id='.$gift["gift_id"])."\">".wfMsg("g-to-another")."</a>";
							if ($rel->user_name==$wgUser->getName()) {
								  $output .= " | <a href=\"".$remove_gift_link->escapeFullURL('gift_id='.$gift["id"])."\">".wfMsg("g-remove-gift")."</a>";
							}
						$output .= "</div>
						<div class=\"cleared\"></div>";
					$output .= "</div>";
					if($x==count($gifts) || $x!=1 && $x%$per_row ==0)$output .= "<div class=\"cleared\"></div>";
					
					$x++;	
				}
			}
			
			/**/
			/*BUILD NEXT/PREV NAV
			**/
			$numofpages = $total / $per_page; 
			
			$page_link = Title::makeTitle(NS_SPECIAL,"ViewGifts");
			
			if($numofpages>1) {
				$output .= "<div class=\"page-nav\">";
				if($page>1) { 
					$output .= "<a href=\"".$page_link->escapeFullURL('user='.$user_name.'&rel_type='.$rel_type.'&page='.($page-1))."\">".wfMsg("g-previous")."</a> ";
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
					$output .=" <a href=\"".$page_link->escapeFullURL('user='.$user_name.'&rel_type='.$rel_type.'&page='.($page+1))."\">".wfMsg("g-next")."</a>"; 
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