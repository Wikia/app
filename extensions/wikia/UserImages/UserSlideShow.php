<?php

$wgExtensionFunctions[] = 'wfSpecialUserSlideShow';

function wfSpecialUserSlideShow(){
  global $wgUser,$IP;
  include_once("includes/SpecialPage.php");


class UserSlideShow extends SpecialPage {

	
	function UserSlideShow(){
		UnlistedSpecialPage::UnlistedSpecialPage("UserSlideShow");
	}

	
	function execute(){
		global $wgRequest, $IP, $wgOut, $wgUser, $wgStyleVersion, $wgMessageCache;
		
		$wgOut->addScript("<link rel='stylesheet' type='text/css' href=\"/extensions/wikia/UserImages/UserImages.css?{$wgStyleVersion}\"/>\n");
		$wgOut->addScript("<script type=\"text/javascript\" src=\"/extensions/wikia/UserImages/UserImages.js?{$wgStyleVersion}\"></script>\n");
		
		//language messages
		require_once ( "$IP/extensions/wikia/UserImages/UserImages.i18n.php" );
		foreach( efWikiaUserImages() as $lang => $messages ){
			$wgMessageCache->addMessages( $messages, $lang );
		}
		
		//variables
		$output = "";
		$user_name = $wgRequest->getVal('user');
		$picture_number = $wgRequest->getVal('picture');
		if( !$picture_number ) $picture_number = 0;
		$previous = $picture_number-1;
		$next = $picture_number+1;
		
		//No UserName Then Assume Current User			
		if(!$user_name)$user_name = $wgUser->getName();
		$user_id = User::idFromName($user_name);
		$user =  Title::makeTitle( NS_USER  , $user_name  );
		
		//No UserName Then Error Message
		if($user_id == 0){
			$wgOut->setPagetitle( wfMsg("ui_error_message_title") );
			$wgOut->addHTML(wfMsg("ui_error_message"));
			return false;
		}
		
		//set title
		$wgOut->setPagetitle( wfMsg("ui_slideshow_title", $user_name) );
		
		//database calls
		$dbr =& wfGetDB( DB_MASTER );
		$sql_total = "SELECT count(*) as count FROM image INNER JOIN
		categorylinks on replace(cl_sortkey,' ','_')=concat('Image:',img_name)
		WHERE img_user_text = '" . addslashes($user_name) . "' 
		AND cl_to = 'Profile_Pictures'
		ORDER BY img_timestamp DESC {$limit_sql}";
	
	    $res_total = $dbr->query($sql_total);
		$row = $dbr->fetchObject($res_total);
		$total = $row->count;
		
		//database calls
		$dbr =& wfGetDB( DB_MASTER );
		
		$sql = "SELECT img_name, img_user, img_width, img_user_text, img_timestamp FROM image
		INNER JOIN categorylinks on replace(cl_sortkey,' ','_')=concat('Image:',img_name)
		WHERE img_user_text = '" . addslashes($user_name) . "' AND cl_to = 'Profile_Pictures' ORDER BY img_timestamp DESC LIMIT {$picture_number},1";
		
		$sql_preload = "SELECT img_name, img_user, img_width, img_user_text, img_timestamp FROM image 
		INNER JOIN categorylinks on replace(cl_sortkey,' ','_')=concat('Image:',img_name)
		WHERE img_user_text = '" . addslashes($user_name) . "' AND cl_to = 'Profile_Pictures' ORDER BY img_timestamp DESC LIMIT ".($picture_number+1).",3";
		
		$sql_friend = "SELECT r_user_name, r_user_name_relation, r_type, r_date, r_user_id_relation FROM user_relationship WHERE r_user_name = '" . addslashes($user_name) . "' and r_type = 1 ORDER BY RAND() LIMIT 8";
		
		$sql_friend_count = "SELECT count(*) as count FROM user_relationship WHERE r_user_name = '" . addslashes($user_name) . "' and r_type = 1";
		$res_friend_total = $dbr->query($sql_friend_count);
		$row_friend_total = $dbr->fetchObject($res_friend_total);
		$friend_total = $row_friend_total->count;
		
		$sql_new_images = "SELECT img_name, img_timestamp, (img_width / img_height) as img_ratio, img_user_text FROM image 
		INNER JOIN categorylinks on replace(cl_sortkey,' ','_')=concat('Image:',img_name)
		WHERE img_user_text <> '" . addslashes($user_name) . "'  AND cl_to = 'Profile_Pictures' AND (img_width / img_height > 1) and (img_width / img_height < 5) ORDER BY img_timestamp DESC LIMIT 0,24";
		
		$res1 = $dbr->query($sql_preload);
		$res_friend = $dbr->query($sql_friend);
		$res_new_images = $dbr->query($sql_new_images);
		$res = $dbr->query($sql);
		
		//Reset Navigation Links
		if ($next==$total) {
			$next=0;
		}
		if ($next==1) {
			$previous = ($total-1);
		}
		
		//Safe Titles
		$user_link = Title::makeTitle(NS_USER, $user_name);
		$user_image_list_link = Title::makeTitle(NS_SPECIAL, "UserImageList");
		
		//Top Stuff
		$output .= "<div class=\"slide-show-top\">
			<a href=\"".$user_link->escapeFullURL()."\">".wfMsg("ui_back_to_profile", $user_name)."</a> -
			<a href=\"".$user_image_list_link->escapeFullURL('user='.$user_name)."\">".wfMsg("ui_see_all_photos")."</a>
		</div>";
		
		
		//Loop Through Images
		
		if ($total) {
			
		
			while ($row = $dbr->fetchObject( $res ) ) {
				$image_path = $row->img_name;
				$render_image = Image::newFromName ($image_path);
				$thumb_image = $render_image->getThumbNail(600);
				
				if ($total == 1) {
					$thumbnail = $thumb_image->toHtml( array("id"=>"user-image"));
				} else {
					$thumbnail = $thumb_image->toHtml( array("id"=>"user-image", "onmouseover"=>"doHover('user-image')", "onmouseout"=>"endHover('user-image')") );
				}
					
				$picture_counter = $picture_number + 1;


				$output .= "
				<div class=\"user-image-container\" id=\"user-image-container\">
					<div class=\"user-image\">
						<p>
							".wfMsg("ui_photo_counter", $picture_counter, $total)."
						</p>
						<p>";
						
						if ($total==1) {
							$output .= "{$thumbnail}";
						} else {
							$output .= "<a href=\"javascript:loadImage('{$picture_number}', '" . addslashes($user_name) . "', 'next');\">{$thumbnail}</a>";
						}	
						
						$output .= "</p>
					</div>";

					//Bottom Navigation Links

					$output .= "<div class=\"slide-show-bottom\">
						<a href=\"javascript:loadImage('{$picture_number}', '{$user_name}', 'previous');\">".wfMsg("ui_prev")."</a> 
						<a href=\"javascript:loadImage('{$picture_number}', '{$user_name}', 'next');\">".wfMsg("ui_next")."</a> 
					</div>";

					//preload images
					$output .= "<div style=\"display:none\">";

					while ($row1 = $dbr->fetchObject($res1)) {
						$image_path_preload = $row1->img_name;
						$render_image_preload = Image::newFromName ($image_path_preload);
						$thumb_image_preload = $render_image_preload->getThumbNail(600,0,true);
						$thumbnail_preload = $thumb_image_preload->toHtml();

						$output .= "<p>{$thumbnail_preload}</p>";

					}

					$output .= "</div>";

				$output .= "</div>";

			}
			
			
		} else {
			$output .= "{$user_name} does not have any images!";
		}
		
		$output .= "<div class=\"cleared\"></div>";
		
		$wgOut->addHTML($output);
	
	}
  
 
	
}

SpecialPage::addPage( new UserSlideShow );

 


}

?>