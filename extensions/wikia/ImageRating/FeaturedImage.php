<?php
# Internationalisation file
require_once( "ImageRating.i18n.php" );
	
$wgExtensionFunctions[] = "wfFeaturedImage";

function wfFeaturedImage() {
    global $wgParser, $wgOut;
    $wgParser->setHook( "featuredimage", "RenderFeaturedImage" );
}

function RenderFeaturedImage($input ){
	global $wgUser, $wgTitle, $wgOut, $wgStyleVersion, $wgMemc, $IP;
	
	# Add messages
	global $wgMessageCache, $wgImageRatingMessages;
	foreach( $wgImageRatingMessages as $key => $value ) {
		$wgMessageCache->addMessages( $wgImageRatingMessages[$key], $key );
	}
	
	//needed if allowing voting inline
	$wgOut->addScript("<script type=\"text/javascript\" src=\"/extensions/Vote-Mag/Vote.js?{$wgStyleVersion}\"></script>\n");
	$wgOut->addScript("<link rel='stylesheet' type='text/css' href=\"/extensions/wikia/ImageRating/ImageRating.css?{$wgStyleVersion}\"/>\n");
	
	//needed if you want to display vote count/stars
	require_once ("$IP/extensions/Vote-Mag/VoteClass.php");
	
	//get width property passed fro hook
	getValue($width,$input,"width");
	if($width){
		$width = intval($width);
	}else{
		$width = 250;
	}
	 
	//set up Memcache
	$key = wfMemcKey( 'image', 'featured', $width );
	$data = $wgMemc->get( $key );
	$cache_expires = (   (60 * 30 ) ); 
	
	//no cache, load from db
	if(!$data){
		wfDebug( "loading featured image data from db\n" );
		
		//only check images that are less than 30 days old
		$time = ( time() - (60 * 60 * 24 * 30 ) ); 
		
		$dbr =& wfGetDB( DB_MASTER );
		$sql_top = "SELECT page_id, page_title, img_user, img_user_text FROM page, page_stats, image WHERE  page_id=ps_page_id and page_namespace=" . NS_IMAGE . " and UNIX_TIMESTAMP(img_timestamp) > {$time} ORDER BY page_id desc, vote_avg DESC, vote_count DESC LIMIT 0,1";
		$res_top = $dbr->query($sql_top);
		if($dbr->numRows($res_top) > 0){
			$row = $dbr->fetchObject($res_top);
			
			$image_title = Title::makeTitle(NS_IMAGE,$row->page_title);
			$render_top_image = Image::newFromName($row->page_title);
			$thumb_top_image = $render_top_image->getThumbNail($width,0,true);
			
			$featured_image["image_name"] = $row->page_title;
			$featured_image["image_url"] = $image_title->getFullURL();
			$featured_image["page_id"] = $row->page_id;
			$featured_image["thumbnail"] = $thumb_top_image->toHtml();
			$featured_image["user_id"] = $row->img_user;
			$featured_image["user_name"] = $row->img_user_text;
		}
		$wgMemc->set( $key, $featured_image,$cache_expires );
	}else{
		wfDebug( "loading featured image data from cache\n" );
		$featured_image = $data;
	}

	$voteClassTop = new VoteStars($featured_image["page_id"]);
	$voteClassTop->setUser($wgUser->getName(),$wgUser->getID());
	$countTop = $voteClassTop->count();
		
	$user_title = Title::makeTitle(NS_USER,$featured_image["user_name"]);
	$avatar = new wAvatar($top_image_user_id,"ml");
	
	
	$output .= "<div class=\"featured-image-main\">
				<div class=\"featured-image-container-main\">
					<a href=\"{$featured_image["image_url"]}\">{$featured_image["thumbnail"]}</a>
				</div>
				<div class=\"featured-image-user-main\">
					
					<div class=\"featured-image-submitted-main\">
						<p>" . wfMsgForContent( 'submittedby' ) . "</p>
						<p><a href=\"{$user_title->getFullURL()}\">{$avatar->getAvatarURL()}
						{$featured_image["user_name"]}</a></p>
					</div>
					
					<div class=\"image-rating-bar-main\">"
						.$voteClassTop->displayStars( $featured_image["page_id"],  $voteClassTop->getAverageVote(), false ).
						"<div class=\"image-rating-score-main\" id=\"rating_{$featured_image["page_id"]}\">
							community score: <b>".$voteClassTop->getAverageVote()."</b> ({$countTop}  ".(($countTop==1)?wfMsgForContent( 'rating' ):wfMsgForContent( 'ratingplural' )).")
						</div>
					</div>
					
				</div>
				<div class=\"cleared\"></div>
		</div>";
	return $output; 
}
?>