<?php

global $wgUser, $wgTitle;

$dbr =& wfGetDB( DB_MASTER );

$output = "
	   <script language=\"javascript\">
	   
	   	var numReplaces = 0;
	   	var replaceID = 0;
		var replaceSrc = '';
		var oldHtml = '';
	   
	   	function showUploadFrame(){
			new Effect.Appear('upload-container');   
		}
		
		function uploadError(message){
			$('mini-gallery-' + replaceID).innerHTML = oldHtml;
			$('upload-frame-errors').innerHTML = message;
			$('imageUpload-frame').src = 'index.php?title=Special:MiniAjaxUpload&wpThumbWidth=75';
			
			$('upload-container').show();
		}

		function textError(message){
			$('upload-frame-errors').innerHTML = message;
		}
		
		function completeImageUpload(){
			
			$('upload-frame-errors').innerHTML = '';
			oldHtml = $('mini-gallery-' + replaceID).innerHTML;
			Element.setStyle('mini-gallery-' + replaceID, { border: '2px solid red', width:'75px' });
			for(x=7;x>0;x--){
				if($('mini-gallery-' + (x-1) ).innerHTML!=''){
					$('mini-gallery-' + (x) ).addClassName('mini-gallery');
				}
				$('mini-gallery-' + (x) ).innerHTML = $('mini-gallery-' + (x-1) ).innerHTML.replace('slideShowLink('+(x-1)+')','slideShowLink('+(x)+')')
			}
			$('mini-gallery-0').innerHTML ='<img height=\"75\" width=\"75\" src=\"../../images/common/ajax-loader-white.gif\">';
			
			$('mini-gallery-nopics').hide();
		 
		}

		function uploadComplete(imgSrc, imgName, imgDesc){
			replaceSrc = imgSrc;
			
			$('upload-frame-errors').innerHTML = '';
			
			$('imageUpload-frame').onload = function(){ 
				var idOffset = -1 - numReplaces;
				$('mini-gallery-0' ).addClassName('mini-gallery');
				$('mini-gallery-0').innerHTML = '<a href=\"javascript:slideShowLink(' + idOffset + ')\">' + replaceSrc + '</a>';			
				
				replaceID = (replaceID == 7) ? 0 : (replaceID + 1);
				numReplaces += 1;
				
				
			}
			
			$('imageUpload-frame').src = 'index.php??title=Special:MiniAjaxUpload&wpThumbWidth=75';
		}
		
		function slideShowLink(id){
			window.location = 'index.php?title=Special:UserSlideShow&user={$username}&picture=' + ( numReplaces + id );	
		}
		
		function doHover(divID) {
			$(divID).setStyle({backgroundColor: '#4B9AF6'});
		}

		function endHover(divID){
			$(divID).setStyle({backgroundColor: ''});
		}
		
	   </script>";


		//database calls
		$sql = "SELECT img_name, img_user, img_user_text, img_timestamp FROM image INNER JOIN categorylinks on replace(cl_sortkey,' ','_')=concat('Image:',img_name) WHERE img_user_text='" . addslashes($username) . "' AND cl_to = 'Profile_Pictures' ORDER BY img_timestamp DESC LIMIT 8;";

		$sql_total = "SELECT COUNT(img_name) as gallery_count FROM image INNER JOIN categorylinks on replace(cl_sortkey,' ','_')=concat('Image:',img_name) WHERE img_user_text='" . addslashes($username) . "' AND cl_to = 'Profile_Pictures'";
		
		$res = $dbr->query($sql);
		$res_total = $dbr->query($sql_total);
		$row_total = $dbr->fetchObject( $res_total );
		$total = $row_total->gallery_count;
	
		//output mini gallery
		$output .= "<h1 class=\"user-profile-title\">Pictures</h1>
	   <p class=\"profile-sub-links\" style=\"margin-bottom: 15px;\">";
	   	   
		if ($total > 0) {
			
			if($wgUser->getName() == $username) {
				$output .= "<a href=\"javascript:showUploadFrame()\">Upload Picture</a> - ";
			}

			$output .= "<a href=\"index.php?title=Special:UserSlideShow&user={$username}&picture=0\">Slideshow</a> -
			<a href=\"index.php?title=Special:UserImageList&user={$username}\">Gallery</a>";
			
		} else {
			
			if($wgUser->getName() == $username) {
				$output .= "<a href=\"javascript:showUploadFrame()\">Upload Picture</a>";
			}
			
		}
		
	   $output .= "</p>	   
	   <div class=\"user-mini-gallery-body\">";

$num = 0;
$per_row = 4;

while ($row = $dbr->fetchObject( $res ) ) {
	
	$image_path = $row->img_name;
	$image = Image::newFromName( $image_path );
	$thumb = $image->getThumbnail( 75, 0, true );
	$thumbnail = $thumb->toHtml();
	
	
	
	$output .= "
	<div id=\"mini-gallery-{$num}\" class=\"mini-gallery\">
		<a href=\"index.php?title=Image:{$image_path}\">{$thumbnail}</a>
	</div>";
	
	if( ( $num + 1 ) % $per_row == 0 ) {
		$output .= "<div class=\"cleared\"></div>";
	}
	
	$num++;
}

for($i = $num; $i < 8; $i++){
	$output .= "<div id=\"mini-gallery-{$i}\"></div>";
	
	if( ($i+1) % $per_row == 0 ) {
		$output .= "<div class=\"cleared\"></div>";
	}
}

if ($num > 0) {
	$output .= "<div id=\"mini-gallery-nopics\" style=\"display:none;\"></div>";
} else {
	$output .= "<div id=\"mini-gallery-nopics\" style=\"margin:0px 0px 18px 0px;\"> {$wgTitle->getText()} has not uploaded any pictures. <img src=\"images/common/emoticon-sad.gif\" style=\"vertical-align:middle;\"/></div>";
}

	
//'

$output .= "
<div class=\"cleared\"></div>
<style>
				body {
					margin:0px;
					padding:0px;
					font-family:arial;
				}
				
				.upload-form td {
					padding:0px 0px 9px 0px;
					font-size:13px;
				}
				
				input.startButton {
					background-color:#89C46F;
					border:1px solid #6B6B6B;
					color:#FFFFFF;
					font-size:12px;
					font-weight:bold;
					margin:10px 0px 0px;
					padding:3px;
					cursor:pointer;
					cursor:hand;
				}
</style>

<div id=\"upload-frame-errors\" class=\"upload-frame-errors\" style=\"margin:0px 0px 10px 0px;color:red; font-size:14px; font-weight:bold;\"></div>

<div id=\"upload-container\" style=\"display:none; height: 160px;\">
		<iframe id=\"imageUpload-frame\" class=\"imageUpload-frame\" width=\"410\" 
			scrolling=\"no\" frameborder=\"0\" src=\"?title=Special:MiniAjaxUpload&wpThumbWidth=75\">
		</iframe>
	</div>
</div>";

?>
