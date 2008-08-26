<?php

$wgExtensionFunctions[] = 'wfSpecialAaron';

function wfSpecialAaron(){
  global $wgUser,$IP;
  include_once("includes/SpecialPage.php");


class UserImageList extends SpecialPage {

	
	function UserImageList(){
		UnlistedSpecialPage::UnlistedSpecialPage("UserImageList");
	}

	
	function execute(){
		global $wgRequest, $IP, $wgOut, $wgUser, $wgMessageCache;
		
		$wgOut->addScript("<link rel='stylesheet' type='text/css' href=\"/extensions/wikia/UserImages/UserImages.css?{$wgStyleVersion}\"/>\n");
		$wgOut->addScript("<script type=\"text/javascript\" src=\"/extensions/wikia/UserImages/UserImages.js?{$wgStyleVersion}\"></script>\n");
		
		//language messages
		require_once ( "UserImages.i18n.php" );
		foreach( efWikiaUserImages() as $lang => $messages ){
			$wgMessageCache->addMessages( $messages, $lang );
		}
		
		//variables
		$output = "";
		$user_name = $wgRequest->getVal('user');
		$page =  $wgRequest->getVal('page');
		$per_page = 10;
		if(!$page)$page=1;
		
		//No UserName Then Assume Current User			
		if(!$user_name)$user_name = $wgUser->getName();
		$user_id = User::idFromName($user_name);
		$user =  Title::makeTitle( NS_USER  , $user_name  );
		
		//No UserName Then Error Message
		if($user_id == 0){
			$wgOut->setPagetitle( "Woops!" );
			$wgOut->addHTML("The user you are trying to view does not exist.");
			return false;
		}
		
		//set title
		$wgOut->setPagetitle( "Gallery of Photos From {$user_name}" );
		
		//Add Limit to SQL
		$per_page = 15;
		$limit=$per_page;
		
		if ($limit > 0) {
				$limitvalue = 0;
				if($page)$limitvalue = $page * $limit - ($limit); 
				$limit_sql = " LIMIT {$limitvalue},{$limit} ";
		}
		
		//database calls
		$dbr =& wfGetDB( DB_MASTER );
		$sql_total = "SELECT count(*) as count FROM image 
		INNER JOIN
		categorylinks on replace(cl_sortkey,' ','_')=concat('Image:',img_name)
		WHERE img_user_text = '" . addslashes($user_name) . "'
		AND cl_to = 'Profile_Pictures'
		";
	    $res_total = $dbr->query($sql_total);
		$row = $dbr->fetchObject($res_total);
		$total = $row->count;
		
	
		$sql = "SELECT img_name, img_user, img_user_text, img_timestamp FROM image INNER JOIN
		categorylinks on replace(cl_sortkey,' ','_')=concat('Image:',img_name)
		WHERE img_user_text = '" . addslashes($user_name) . "' 
		AND cl_to = 'Profile_Pictures'
		ORDER BY img_timestamp DESC {$limit_sql}";
		$res = $dbr->query($sql);
		
		//safe titles
		$user_link = Title::makeTitle(NS_USER, $user_name);
		$user_slide_show_link = Title::makeTitle(NS_SPECIAL, "UserSlideShow");
		
		//Top Nav
		$output .= "<div class=\"slide-show-top\">
			<a href=\"".$user_link->escapeFullURL()."\">".wfMsg("ui_back_to_profile", $user_name)."</a> -
			<a href=\"".$user_slide_show_link->escapeFullURL("user=".$user_name."&picture=0")."\">".wfMsg("ui_slideshow")."</a>
		</div>";
		
		
		$output .= "<div class=\"user-gallery-container\">";
		
		if ($total) {
		
			//Loop Through Images
			$per_row = 5;
			$x = 1;

			if(!$page)$page=1;

			while ($row = $dbr->fetchObject( $res ) ) {
				$image_path = $row->img_name;
				$render_image = Image::newFromName ($image_path);
				$thumb_image = $render_image->getThumbNail(128);
				$thumbnail = $thumb_image->toHtml();
				$image_id = "user-image-{$x}";
				$image_link = Title::makeTitle(NS_IMAGE, $image_path);
				

				$output .= "<div class=\"user-gallery-image\" id=\"{$image_id}\" onmouseover=\"doHover('{$image_id}')\" onmouseout=\"endHover('{$image_id}')\">
					<a href=\"".$image_link->escapeFullURL()."\">{$thumbnail}</a>
				</div>";
				if($x!=1 && $x%$per_row ==0) {
					$output .= "<div class=\"cleared\"></div>";
				}
				$x++;
			}
		
		$output .= "<div class=\"cleared\"></div>
		</div>";


			//Page Nav

			$numofpages = $total / $per_page; 
			$user_image_list_link = Title::makeTitle(NS_SPECIAL, "UserImageList");
			
			if($numofpages>1) {
				$output .= "<div class=\"page-nav\">";
				if($page > 1) { 
					$output .= "<a href=\"".$user_image_list_link->escapeFullURL("user=".$user_name."&page=".($page-1))."\">".wfMsg("ui_prev")."</a> ";
				}


				if(($total % $per_page) != 0)$numofpages++;
				if($numofpages >=9)$numofpages=9+$page;

				for($i = 1; $i <= $numofpages; $i++) {
					if($i == $page) {
					    $output .=($i." ");
					} else {
					    $output .="<a href=\"".$user_image_list_link->escapeFullURL("user=".$user_name."&page=".$i)."\">$i</a> ";
					}
				}

				if(($total - ($per_page * $page)) > 0){
					$output .=" <a href=\"".$user_image_list_link->escapeFullURL("user=".$user_name."&page=".($page+1))."\">".wfMsg("ui_next")."</a>"; 
				}
				$output .= "</div>";
			}
			
		} else {
				$output .= "{$user_name} does not have any images!</div>";
		}
		
		$output .= "<div class=\"cleared\"></div>";
		
		
		
		$wgOut->addHTML($output);
	
	}
  
 
	
}

SpecialPage::addPage( new UserImageList );

 


}

?>