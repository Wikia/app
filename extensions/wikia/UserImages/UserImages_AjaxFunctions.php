<?php
$wgAjaxExportList [] = 'wfSlideShow';
function wfSlideShow($pic_num, $user, $direction) {
	$dbr =& wfGetDB( DB_MASTER );
	
	$sql_total = "SELECT count(*) as count FROM image INNER JOIN
		categorylinks on replace(cl_sortkey,' ','_')=concat('Image:',img_name) WHERE img_user_text = '" . addslashes($user) . "' AND cl_to = 'Profile_Pictures'
	";
    $res_total = $dbr->query($sql_total);
	$row = $dbr->fetchObject($res_total);
	$total = $row->count;
	$next = $pic_num + 1;
	$previous = $pic_num - 1;
	
	if ($next == ($total)) {
		$next = 0;
	}
	
	if ($next==1) {
		$previous = ($total-1);
	}
	
	//image directions
	if ($direction == "next") {
		$pic_num = $next;
		
	} else if ($direction == "previous") {
		$pic_num = $previous;
	}
	
	
	$sql = "SELECT img_name, img_user, img_user_text, img_timestamp FROM image
	INNER JOIN categorylinks on replace(cl_sortkey,' ','_')=concat('Image:',img_name)
	WHERE img_user_text = '".addslashes($user)."' 
	AND cl_to = 'Profile_Pictures'
	ORDER BY img_timestamp DESC LIMIT {$pic_num},1";
	
	$res = $dbr->query($sql);
	
	if ($pic_num < $total) {
		$sql_preload = "SELECT img_name, img_user, img_width, img_user_text, img_timestamp FROM image
		INNER JOIN categorylinks on replace(cl_sortkey,' ','_')=concat('Image:',img_name)
		WHERE img_user_text = '".addslashes($user)."' 
		AND cl_to = 'Profile_Pictures'
		ORDER BY img_timestamp DESC LIMIT ".($pic_num+1).",3";
	}
	
	$res1 = $dbr->query($sql_preload);
	
	$row = $dbr->fetchObject($res);
	$row1 = $dbr->fetchObject($res1);
	
	if ($row) {
		
		$image_path = $row->img_name;
		$render_image = Image::newFromName ($image_path);
		$thumb_image = $render_image->getThumbNail( 600 );
		$thumbnail = $thumb_image->toHtml( array("id"=>"user-image", "onmouseover"=>"doHover('user-image')", "onmouseout"=>"endHover('user-image')") );
		$user_name = addslashes($user);
		$picture_counter = $pic_num + 1;
				
		$divcontent = "
		<div class=\"user-image\">
			<p>
				Photo {$picture_counter} of $total
			</p>
			<p>
				<a href=\"javascript:loadImage('{$pic_num}', '".addslashes($user_name)."', 'next');\">{$thumbnail}</a>
			</p>
		</div>
		
		<div class=\"slide-show-bottom\">
			<ul>
				<li><a href=\"javascript:loadImage('{$pic_num}', '".addslashes($user_name)."', 'previous');\">Previous</a></i> 
				<li><a href=\"javascript:loadImage('{$pic_num}', '".addslashes($user_name)."', 'next');\">Next</a></li>
			</ul> 
		</div>";
		
		
		$output .= "<div style=\"display:none\">";

		while ($row1 = $dbr->fetchObject($res1)) {
			$image_path_preload = $row1->img_name;
			$render_image_preload = Image::newFromName ($image_path_preload);
			$thumb_image_preload = $render_image_preload->getThumbNail(600,0,true);
			$thumbnail_preload = $thumb_image_preload->toHtml();

			$output .= "<p>{$thumbnail_preload}</p>";

		}

		$output .= "</div>";
		
		
		
		return $divcontent;
	} else {
		return false;
	}
	
}



?>