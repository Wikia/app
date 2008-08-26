<?php


require_once( "ImageRating.i18n.php" );

$wgExtensionFunctions[] = 'wfImageRating';

function wfImageRating(){
  global $wgUser,$IP;
  include_once("includes/SpecialPage.php");


class ImageRating extends SpecialPage {

	
	function ImageRating(){
		UnlistedSpecialPage::UnlistedSpecialPage("ImageRating");
	}

	
	function execute(){
		global $wgRequest, $IP, $wgOut, $wgUser, $wgMemc, $wgStyleVersion, $wgContLang, $wgVoteDirectory, $wgVoteScripts;
	 
		# Add messages
		global $wgMessageCache, $wgImageRatingMessages;
		foreach( $wgImageRatingMessages as $key => $value ) {
			$wgMessageCache->addMessages( $wgImageRatingMessages[$key], $key );
		}
	
		$wgOut->addScript("<script type=\"text/javascript\" src=\"{$wgVoteScripts}/Vote.js?{$wgStyleVersion}\"></script>\n");
		$wgOut->addScript("<script type=\"text/javascript\" src=\"/extensions/wikia/ImageRating/ImageRating.js?{$wgStyleVersion}\"></script>\n");
		$wgOut->addScript("<link rel='stylesheet' type='text/css' href=\"/extensions/wikia/ImageRating/ImageRating.css?{$wgStyleVersion}\"/>\n");
			$wgOut->addHTML("<script>
				var _CATEGORY_NS_NAME = \"" . $wgContLang->getNsText( NS_CATEGORY ) . "\"
			</script>
			");
		
		require_once ("{$wgVoteDirectory}/VoteClass.php");
				
		
		//page
		$page = $wgRequest->getVal('page');
		$type = $wgRequest->getVal('type'); 
		$category = $wgRequest->getVal('category'); 
		if(!$page || !is_numeric($page) )$page=1;
		if(!$type)$type="new";
		
		
		
		//sql limit based on page
		$per_page = 5;
		$limit=$per_page;
		
		if ($limit > 0) {
			$limitvalue = 0;
			if($page)$limitvalue = $page * $limit - ($limit); 
			$limit_sql = " LIMIT {$limitvalue},{$limit} ";
		}
		
		if( $category ){
			$CtgTitle = Title::newFromText( trim($category). ' Images' );	
			$CtgKey = strtoupper($CtgTitle->getDbKey());
			$category_join = " INNER JOIN categorylinks on cl_from=page_id ";
			$category_where = "  AND UPPER(cl_to) = '{$CtgKey}' ";
		}
		 
		//database calls
		$dbr =& wfGetDB( DB_SLAVE );
		
		switch($type){
			
			case "best":
				$sql = "SELECT page_id, page_title, vote_avg FROM page INNER JOIN wikia_page_stats ON page_id=ps_page_id {$category_join} WHERE page_namespace=" . NS_IMAGE . " {$category_where} ORDER BY vote_avg DESC, vote_count DESC {$limit_sql}";
				$sql_count = "SELECT COUNT(*) as total_ratings FROM page INNER JOIN wikia_page_stats ON page_id=ps_page_id {$category_join} WHERE page_namespace=" . NS_IMAGE . " {$category_where} ";
	
				$res_count = $dbr->query($sql_count);
				$row_count = $dbr->fetchObject($res_count);
				$total = $row_count->total_ratings;
				$wgOut->setPageTitle(wfMsgForContent( 'bestheading',$category ));
				break;
				
			case "popular":
				
				$sql = "SELECT page_id, page_title, vote_avg FROM page INNER JOIN wikia_page_stats ON page_id=ps_page_id {$category_join} WHERE page_namespace=" . NS_IMAGE . " {$category_where} and vote_count > 1 ORDER BY page_id DESC,vote_avg DESC, vote_count DESC {$limit_sql}";
				$sql_count = "SELECT COUNT(*) as total_ratings FROM page INNER JOIN wikia_page_stats ON page_id=ps_page_id {$category_join} WHERE page_namespace=" . NS_IMAGE . " {$category_where} ";
				 
				$res_count = $dbr->query($sql_count);
				$row_count = $dbr->fetchObject($res_count);
				$total = $row_count->total_ratings;
				$wgOut->setPageTitle( wfMsgForContent( 'popularheading',$category ));
				break;
				
			case "new":
				$sql = "SELECT page_id, page_title, vote_avg FROM page LEFT JOIN wikia_page_stats on page_id=ps_page_id  {$category_join} WHERE page_namespace=" . NS_IMAGE . " {$category_where} ORDER BY page_id DESC {$limit_sql}";
	
				$total = SiteStats::images();
				$wgOut->setPageTitle(wfMsgForContent( 'newheading' ,$category));
				break;
		}
		
		
		
		//variables
		$x = 1;
		
		//Build Nav
		$menu = array(
			wfMsgForContent( 'newheading',$category )  => "new",
			wfMsgForContent( 'popularheading',$category ) => "popular",
			wfMsgForContent( 'bestheading',$category )  => "best"
			
			);
		
		$output .= "<div class=\"image-rating-menu\">
			<h2>" . wfMsgForContent( 'menutitle' ) . "</h2>";
			
		foreach($menu as $title=>$qs){
			if ($type!=$qs){
				$output.= "<p><a href=\"" . Title::makeTitle(NS_SPECIAL, "ImageRating")->escapeFullURL("type={$qs}" . (($category)?"&category={$category}":"") ) . "\">{$title}</a><p>";
			} else {
				$output .= "<p><b>{$title}</b></p>";
			}
		}
		$upload_title = Title::makeTitle(NS_SPECIAL,"Upload");
		$output .= "<p><b><a href=\"{$upload_title->getFullURL()}\">Upload Images</a></b></p>";
			
		$output .= "</div>";
		
		$output .= "<div class=\"image-ratings\">";

		/*
		//set up Memcache
		$width = 250;
		$key = wfMemcKey( 'image', 'featured', "category:{$category}:width:{$width}" );
		$data = $wgMemc->get( $key );
		$cache_expires = (   (60 * 30 ) ); 
	
		//no cache, load from db
		if(!$data){
			wfDebug( "loading featured image data from db\n" );
			
			//only check images that are less than 30 days old
			$time = ( time() - (60 * 60 * 24 * 30 ) ); 
			
			$dbr =& wfGetDB( DB_SLAVE );
			$sql_top = "SELECT page_id, page_title, img_user, img_user_text, vote_avg FROM wikia_page_stats, image, page {$category_join} WHERE  page_id=ps_page_id and img_name = page_title and page_namespace=" . NS_IMAGE . " and UNIX_TIMESTAMP(img_timestamp) > {$time} {$category_where} ORDER BY page_id desc, vote_avg DESC, vote_count DESC LIMIT 0,1";
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
				$featured_image["vote_avg"] = number_format($row->vote_avg,2);
			}
			$wgMemc->set( $key, $featured_image,$cache_expires );
		}else{
			wfDebug( "loading featured image data from cache\n" );
			$featured_image = $data;
		}
 
		*/
		
		/*
		if($featured_image["page_id"]){
			$user_title = Title::makeTitle(NS_USER,$featured_image["user_name"]);
			$avatar = new wAvatar($featured_image["user_id"],"ml");
		
			
			$voteClassTop = new VoteStars($featured_image["page_id"]);
			$voteClassTop->setUser($wgUser->getName(),$wgUser->getID());
			$countTop = $voteClassTop->count();
			
			$output .= "<div class=\"featured-image\">
				<h2>" . wfMsgForContent( 'featuredheading' ) . "</h2>
					<div class=\"featured-image-container\">
						<a href=\"{$featured_image["image_url"]}\">{$featured_image["thumbnail"]}</a>
					</div>
					<div class=\"featured-image-user\">
						
						<div class=\"featured-image-submitted-main\">
							<p>" . wfMsgForContent( 'submittedby' ) . "</p>
							<p><a href=\"{$user_title->getFullURL()}\">{$avatar->getAvatarURL()}
							{$featured_image["user_name"]}</a></p>
						</div>
						
						<div class=\"image-rating-bar-main\">"
							.$voteClassTop->displayStars( $featured_image["page_id"],  $featured_image["vote_avg"], false ).
							"<div class=\"image-rating-score-main\" id=\"rating_{$featured_image["page_id"]}\">
								community score: <b>{$featured_image["vote_avg"]}</b> ({$countTop}  ".(($countTop==1)?wfMsgForContent( 'rating' ):wfMsgForContent( 'ratingplural' )).")
							</div>
						</div>
						
					</div>
					<div class=\"cleared\"></div>
			</div>";
		}
		*/
		
		$output .= "<h2>" . wfMsgForContent( 'ratetitle' ) . "</h2>";
		
		
		$key = wfMemcKey( 'image', 'list', "type:{$type}:category:{$category}:per:{$per_page}" );
		$data = $wgMemc->get( $key );
		if($data && $page == 0){
			$image_list = $data;
			wfDebug( "Cache hit for image rating list\n" );
		}else{
			wfDebug( "Cache miss for image rating list\n" );
			$image_list = array();
			$res = $dbr->query($sql);
			while ( $row = $dbr->fetchObject($res) ) {
				$image_list[] = array(
				 "page_id"=>$row->page_id,"page_title"=>$row->page_title ,
				 "vote_avg"=>number_format($row->vote_avg,2)
				 );
			}
			if($page==1){
				$wgMemc->set( $key, $image_list,60 );
			}
		}
		
		foreach	($image_list as $image){
			
			$image_path = $image["page_title"];
			$image_id = $image["page_id"];
			$vote_avg =  $image["vote_avg"];
			
			$render_image = Image::newFromName($image_path);
			if( is_object($render_image) )$thumb_image = $render_image->getThumbNail(120,120,true);
			if( is_object($thumb_image) )$thumbnail = $thumb_image->toHtml();
			
			$voteClass = new VoteStars($image_id);
			$voteClass->setUser($wgUser->getName(),$wgUser->getID());
			$count = $voteClass->count();
			
			if ($x !== $per_page) {
				$output .= "<div class=\"image-rating-row\">";
			} else {
				$output .= "<div class=\"image-rating-row-bottom\">";
			}
			
				$output .= "<div class=\"image-rating-container\">
					<div class=\"image-for-rating\">
						<a href=\"" . Title::makeTitle(NS_IMAGE, $image_path)->escapeFullURL() . "\">{$thumbnail}</a>
					</div>
				
					<div class=\"image-rating-bar\">"
						.$voteClass->displayStars( $image_id,  $vote_avg, false ).
						"<div class=\"image-rating-score\" id=\"rating_{$image_id}\">
							community score: <b>".$vote_avg."</b> ({$count}  ".(($count==1)?wfMsgForContent( 'rating' ):wfMsgForContent( 'ratingplural' )).")
						</div>
					</div>
				</div>";
				
				$sql_category = "SELECT cl_to, cl_sortkey, cl_from FROM categorylinks WHERE cl_from={$image_id}";
				$res_category = $dbr->query($sql_category);
				$category_total =$dbr->numRows($res_category);
				$output .= "<div id=\"image-categories-container-{$image_id}\" class=\"image-categories-container\">
					<h2>" . wfMsgForContent( 'categorytitle' ) . "</h2>";
			
					$per_row = 3;
					$category_x = 1;
			
					while ( $row_category = $dbr->fetchObject($res_category) ) {
					
					$image_category = str_replace("_", " ", $row_category->cl_to);
					$category_id = "category-button-{$image_id}-{$category_x}";
					
					$output .= "<div class=\"category-button\" id=\"{$category_id}\" onclick=\"window.location='" . Title::makeTitle(NS_CATEGORY, $row_category->cl_to)->escapeFullURL() . "'\" onmouseover=\"doHover('{$category_id}')\" onmouseout=\"endHover('{$category_id}')\">
						$image_category
					</div>";
					
					if($category_x==$category_total || $category_x!=1 && $category_x%$per_row ==0)$output .= "<div  class=\"cleared\"></div>";
					
					$category_x++;
					 
				}
			
				$output .= "<div class=\"cleared\" id=\"image-categories-container-end-{$image_id}\"></div>
				<div class=\"image-categories-add\">
				" .wfMsgForContent( 'addbutton' ) . "<br/><input type=\"text\" size=\"22\" id=\"category-{$image_id}\" onKeyPress=\"detEnter(event,{$image_id})\" /> <input type=\"button\" value=\"add\" class=\"site-button\"  onclick=\"add_category({$image_id})\" />	
				</div>
					
		
			</div>";
			
			$output .= "<div class=\"cleared\"></div>
		</div>";
			
		$x++;
		$categories="";
			
	}
		
		$output .= "</div>
		<div class=\"cleared\"></div>";
		
		
		$numofpages = $total / $per_page; 
		$link = Title::makeTitle(NS_SPECIAL, "ImageRating");
		$prev_link="page=" . ($page-1) . "&type={$type}" . (($category)?"&category={$category}":"");
		$next_link="page=" . ($page+1) . "&type={$type}" . (($category)?"&category={$category}":"");
		
		if($numofpages>1){
			$output .= "<div class=\"rate-image-navigation\">";
			if($page > 1){ 
				$output .= "<a href=\"".$link->escapeFullURL($prev_link)."\">".wfMsg('prevlink')."</a> ";
			}
			
			
				if(($total % $per_page) != 0)$numofpages++;
				if($numofpages >=9 && $page < $total)$numofpages=9+$page;
				if($numofpages >= ($total / $per_page) )$numofpages = ($total / $per_page)+1;
			
			for($i = 1; $i <= $numofpages; $i++){
				if($i == $page){
				    $output .=($i." ");
				}else{
				    $output .="<a href=\"".$link->escapeFullURL("page=$i&type={$type}" . (($category)?"&category={$category}":""))."\">$i</a> ";
				}
			}
	
			if(($total - ($per_page * $page)) > 0){
				$output .=" <a href=\"".$link->escapeFullURL($next_link)."\">".wfMsg('nextlink')."</a>"; 
			}
			$output .= "</div>";
		}
		
		$wgOut->addHTML($output);
	
	}
  
 
	
}

SpecialPage::addPage( new ImageRating );

 


}

?>