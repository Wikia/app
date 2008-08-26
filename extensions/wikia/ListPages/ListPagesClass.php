<?php
class ListPages{

	//Query Variables
	var $Categories = array(), $CategoriesStr = "";
	var $ShowCount = 5;
	var $PageNo = 1, $SortBy = NULL, $Order = NULL, $Level = 1;
	
	var $ShowDetails = 1;
	var $ShowPublished = 0;
	var $ShowUser = 0;
	var $random = 0;
	var $ShowNav = 1;
	var $ShowCtg = 0;
	var $ShowPic = 0;
	var $ShowBlurb = 0;
	var $ShowStats = 1;
	var $ShowDate = 1;
	var $ShowRating = 0;
	var $ratingMin = 0;
	var $listid = 0;
	var $BlurbFontSize = 2;
	var $ShowVoteBox = 0;
	var $ShowCommentBox = 0;
	
	
	function __construct() {
		$this->listid = rand();
	}
	
	function setCategory($ctg){
		global $wgUser, $wgOut; 
		
		$parser = new Parser();
		$ctg = $parser->transformMsg( $ctg, $wgOut->parserOptions() );
		
		$ctg = str_replace("\,","#comma#",$ctg);
		$aCat = explode(",", $ctg);
		
		foreach($aCat as $sCat){
			if($sCat!=""){
				$CtgTitle = Title::newFromText(  trim( str_replace("#comma#",",",$sCat) )   );	
				if (is_object ($CtgTitle)) {
					if($this->CategoriesStr!=""){
						$this->CategoriesStr .= ",";
					}

					$this->CategoriesStr .= $CtgTitle->getDbKey();
					$this->Categories[] = $CtgTitle;
				}
			}
		}
	}
	
	function setShowCount($count){
		$this->ShowCount = IntVal( $count ) + 1;
	}
	
	function setSortBy($sort){
		$this->SortBy = strtoupper($sort);
	}
	
	function setOrder($order){
		$this->Order = strtoupper($order);
	}
	
	function setShowDetails($details){
		$this->details = $details;
		if(strtoupper($details)=="HIDE" || strtoupper($details) == 0){
			$this->ShowDetails = 0;
		}else{
			$this->ShowDetails = 1;
		}
	}
	
	function setLevel($level){
		if(is_numeric($level)){
			$this->Level = $level;
		}
	}
	
	function setPageNo($page){
		if($page && is_numeric($page)){
			$this->PageNo = $page;
		}else{
			$this->PageNo = 1;
		}
	}
	
	function setShowPublished($show){
		if(strtoupper($show)=="YES" || strtoupper($show) == 1){
			$this->ShowPublished = 1;
		}else if(strtoupper($show)=="NO" || strtoupper($show) == -1){
			$this->ShowPublished = -1;
		}else{
			$this->ShowPublished = 0;
		}
	}
	
	function setShowBlurb($details){
		if(is_numeric($details) ){
			$this->ShowBlurb = $details;
		}else{
			$this->ShowBlurb = 0;
		}
	}
	
	function setHash($input){
		if( $input ){
			global $wgDBname;
			$this->hashname = md5($wgDBname.$input);
		}
	}
	
	function setBlurbFontSize($details){
		if(is_numeric($details) && $details < 4){
			$this->BlurbFontSize = $details;
		}else{
			if( strtoupper($details) == "SMALL"){
				$this->BlurbFontSize = 1;
			}else if ( strtoupper($details) == "MEDIUM"){
				$this->BlurbFontSize = 2;
			}else{
				$this->BlurbFontSize = 3;
			}
		}
	}
	
	function setBool($name,$value){
		if(strlen($value) > 0 ){
			if(strtoupper($value)=="ON" || strtoupper($value)=="YES" || strtoupper($value) == 1){
				$this->$name = 1;
			}else{
				$this->$name = 0;
			}
		}
	}
	
	function setRatingMin($num){
		if(is_numeric($num))$this->ratingMin = $num ;
	}
	
	function getCreateDate($pageid){
		global $wgMemc;
		
		$key = wfMemcKey( 'page', 'create_date', $pageid );
		$data = $wgMemc->get( $key );
		if( !$data){
			$dbr =& wfGetDB( DB_SLAVE);
			$sqlc = "select UNIX_TIMESTAMP(rev_timestamp) as create_date from {$dbr->tableName( 'revision' )} where rev_page=" . $pageid . " order by rev_timestamp asc limit 1";
			$res = $dbr->query($sqlc);
			$row = $dbr->fetchObject( $res );
			if($row){
				$create_date = $row->create_date;
			}
			$wgMemc->set( $key, $create_date );
		}else{
			wfDebug( "loading create_date for page {$pageid} from cache\n" );
			$create_date = $data;
		}
		return $create_date;
	}
	
	function getPageImage($pageid){
		global $wgMemc;
		
		$key = wfMemcKey( 'listpages', 'page', 'image', $pageid );
		$data = $wgMemc->get( $key );
		if(!$data){
			$dbr =& wfGetDB( DB_SLAVE);
			$sqlc = "select il_to from {$dbr->tableName( 'imagelinks' )} where il_from=" . $pageid . " limit 1";
			$res = $dbr->query($sqlc);
			$row = $dbr->fetchObject( $res );
			if($row){
				$il_to = $row->il_to;
			}
			$wgMemc->set( $key, $il_to, 60 );
		}else{
			wfDebug( "loading listpage image for page {$pageid} from cache\n" );
			$il_to = $data;
		}
		return $il_to;
	}
	
	function categoryIsDate($ctg){
		if( strtotime(str_replace("_"," ",$ctg) ) != "" ){
			return true;
		}else{
			return false;
		}
	}
	
	function getCategoryLinks($pageid,$LinksTotal=3){
		global $wgUser, $wgMemc;

		$LinksCounter = 0;
		if($this->ShowCtg == 1 && $pageid!=""){
			$category_links = array();
			$key = wfMemcKey( 'listpages', 'categorylinks', $pageid, 'links', 5 );
			$data = $wgMemc->get( $key );
			if(!$data){
				$dbr =& wfGetDB( DB_SLAVE );
				$sql = "SELECT cl_to FROM " . $dbr->tableName( 'categorylinks' ) . " cl1 WHERE cl_from=" . $pageid . "  ORDER BY (select count(*) from {$dbr->tableName( 'categorylinks' )} cl2 where cl2.cl_to = cl1.cl_to) DESC LIMIT 0,5";
				$res = $dbr->query($sql);
				while ($row = $dbr->fetchObject( $res ) ) {
					$category_links[] = array("cl_to"=>$row->cl_to);
				}
				$wgMemc->set( $key, $category_links, 60 * 10 );
			}else{
				wfDebug( "loading listpages categorylinks for page {$pageid} from cache\n" );
				$category_links = $data;
			}
			
			$Categories .= "<span class='categorylinks'>";
			foreach($category_links as $category_link){
				if( $LinksCounter < $LinksTotal && $this->categoryIsDate($category_link["cl_to"])==false){
					$title = Title::makeTitle( NS_CATEGORY, $category_link["cl_to"]);
					if($LinksCounter!=0)$Categories .= ", ";
					$Categories .=  "<a href=\"{$title->getFullURL()}\">" . $title->getText() . "</a>" ;
					$LinksCounter++;
				}
			}
			$Categories .= "</span>";
			if($LinksCounter!=0){
				return "<span class=\"categorylinkstitle\">" . wfMsg("listpages_categories") . ": " . $Categories . "</span>";
			}else{
				return "";
			}
		}else{
			return "";
		}
	}
	
	function getTimeStr($pageid){
		return get_time_ago($this->getCreateDate($pageid));
	}
	
	function getBlurb($pagetitle, $namespace){
		global $wgTitle, $wgOut, $wgContLang;
		
		//get raw text
		$title = Title::makeTitle($namespace, $pagetitle);
		$article = new Article( $title );
		$text = $article->getContent();
	
		//remove some problem characters
		$text =  str_replace("* ","",$text);
		$text =  str_replace("===","",$text);
		$text =  str_replace("==","",$text);
		$text =  str_replace("{{Comments}}","",$text);
		$text =  preg_replace('@<youtube[^>]*?>.*?</youtube>@si', '', $text);
		$text =  preg_replace('@<video[^>]*?>.*?</video>@si', '', $text);
		$text =  preg_replace('@<comments[^>]*?>.*?</comments>@si', '', $text);
		$text =  preg_replace('@<vote[^>]*?>.*?</vote>@si', '', $text);
		$text =  preg_replace("@\[\[Video:[^\]]*?].*?\]@si", '', $text);
		$text =  preg_replace("@\[\[" . $wgContLang->getNsText( NS_CATEGORY ) . ":[^\]]*?].*?\]@si", '', $text);
		
		//start looking at text after content, and force no Table of Contents
		$pos = strpos($text,"<!--start text-->");
		if($pos !== false){
			$text = substr($text,$pos);
		}
		
		$text = "__NOTOC__ " . $text;
		
		//run text through parser
		$BlurbParser = new Parser();
		$blurb_text = $BlurbParser->parse( $text, $wgTitle, $wgOut->parserOptions(),true );
		$blurb_text = strip_tags($blurb_text->getText());
		
		
		$blurb_text =  preg_replace('/&lt;comments&gt;&lt;\/comments&gt;/i', '', $blurb_text);
		$blurb_text =  preg_replace('/&lt;vote&gt;&lt;\/vote&gt;/i', '', $blurb_text);
		
		
		//$blurb_text = $text;
		$pos = strpos($blurb_text,"[");
		if($pos !== false){
			$blurb_text = substr($blurb_text,0,$pos);
		}
		
		//Take first N characters, and then make sure it ends on last full word
		$max = $this->ShowBlurb;
		if (strlen($blurb_text) > $max)$blurb_text = strrev(strstr(strrev(substr($blurb_text,0,$max)),' '));
		
		//prepare blurb font size
		$blurb_font = "<span class=\"listpages-blurb-size-";
		if($this->BlurbFontSize==1)$blurb_font .= "small";
		if($this->BlurbFontSize==2)$blurb_font .= "medium";
		if($this->BlurbFontSize==3)$blurb_font .= "large";
		$blurb_font.= "\">";
		
		//fix multiple whitespace, returns etc
		$blurb_text = trim($blurb_text); // remove trailing spaces
		$blurb_text = preg_replace('/\s(?=\s)/','',$blurb_text); // remove double whitespace
		$blurb_text = preg_replace('/[\n\r\t]/',' ',$blurb_text); // replace any non-space whitespace with a space
		
		//echo "<h1>FINAL=====================</h1>" . $blurb_text;
		return $blurb_font . $blurb_text. ". . . <a href=\"" . $title->escapeFullURL() . "\">more</a></span>";
	}


	
	function buildSQL(){
		$dbr =& wfGetDB( DB_SLAVE );
			
		$page_table = $dbr->tableName( 'page' );
		$category_links_table = $dbr->tableName( 'categorylinks' );
		
		//SELECT FIELDS
		$fields = array(
				"page_id","page_namespace","page_title", "page_counter","UNIX_TIMESTAMP(page_touched)", 
				"IFNULL(comment_count,0) as comment_count",
				"IFNULL(vote_count,0) as vote_count",
				"IFNULL(vote_avg,0) as vote_avg"
				);
		
		//FROM
		$tables = $page_table;
		
		if( $this->ShowPublished == 1 ){
			$tables .=" INNER JOIN published_page  ";
			$tables .=" ON page_id = published_page_id  ";
		}
		
		if( count( $this->Categories ) > 0 ){
			$tables .= " INNER JOIN $category_links_table AS c";
			$tables .= ' ON page_id = c.cl_from';
		}
		
		if( $this->ShowPublished == -1 ){
			$tables .= " LEFT JOIN published_page ";
			$tables .= ' ON page_id = published_page_id and published_type= ' . $this->Level . ' ';
		}
		
		$tables .= ' LEFT JOIN wikia_page_stats ON page_id=ps_page_id ';
		
		//BUILD WHERE CLAUSE
		$where = array();
		
		$category_where = "";
		if(count($this->Categories) > 0){
			$category_where .= ' c.cl_to in (';
			for ( $i = 0; $i < count($this->Categories); $i++ ) {
				if($i>0)$category_where .= ",";
				$category_where .=  ( $dbr->addQuotes( $this->Categories[$i]->getDbKey() ) );
			}
			$category_where .=  ')';
			
			$where[] = $category_where;
		}

		if( $this->ShowPublished == 1 ){
			$where[] = "published_type=" . $this->Level;
		}
			
		if( $this->ShowPublished == -1 ){
			$where[] = "published_page_id IS NULL";
		}
		
		if( $this->random ==1 ){
			$randstr = wfRandom();
			$where[] = "page_random > $randstr";
		}
		
		if( $this->ratingMin > 0 ){
			$where[] = "vote_count >= " . $this->ratingMin;
		}

		$params = array();
		
		// BUILD ORDER BY CLAUSE
		switch( $this->Order ){
			case "LASTEDIT":
				$order = "page_touched";
			break;
			case "PAGEVIEWS":
				$order = "page_counter";
			break;
			case "VOTES":
				$order = "vote_count";
			break;	
			case "VOTE AVERAGE":
				$order = "vote_avg";
			break;	
			case "COMMENTS":
				$order = "comment_count";
			break;	
			case "NEW":
				$order = "page_id";
			break;	
			case "EDITS":
				$order = "Num_Edits";
			break;
			default:
				$order = "page_title";
			break;
		}
		
		//some special cases
		if ($this->Order == 'PUBLISHEDDATE' && $this->ShowPublished==1){
			$order = "published_date";
		}
		
		if( $this->random == 1 ){
			$order = "page_random";
			$this->SortBy = 'ASCENDING';
		}
		
		if ( $this->SortBy == 'ASCENDING' ){
			$sort = 'ASC';
		}else{
			$sort = 'DESC';
		}
		  
		$order_by = "{$order} {$sort}";
		
		if ($this->Order == 'VOTE AVERAGE'){
		       $order_by .= ',vote_count desc,page_title asc '; 
		}
		
		$params["ORDER BY"] = $order_by;
		$params["LIMIT"] =  $this->ShowCount;
		$params["OFFSET"] = ($this->PageNo - 1) * ($this->ShowCount-1);
		$res = $dbr->select( $tables, $fields, $where, __METHOD__, $params);
				
		return $res;
	}
	
	function getListCache(){
		global $wgMemc;
		
		$key = wfMemcKey( 'listpages', 'list', str_replace(" ","","category:{$this->CategoriesStr}:level:{$this->Level}:showpublished:{$this->ShowPublished}:sort:{$this->Order}:count:{$this->ShowCount}:order:{$this->SortBy}:ratingmin:{$this->ratingMin}") );
		$data = $wgMemc->get( $key );
		if($data && $this->PageNo==1){
			wfDebug( "Cache hit for listpage  \n" );
			return $data;
		}
	}
	
	function getListDB(){
		global $wgMemc;
		
		wfDebug( "Cache miss for listpage  \n" );
		
		$res = $this->buildSQL();
		$list_pages = array();
		
		$dbr =& wfGetDB( DB_SLAVE );
		while ($row = $dbr->fetchObject( $res ) ) {
			$list_pages[] = array(
			 "page_id"=>$row->page_id,"page_title"=>$row->page_title , "page_touched" => $row->page_touched,
			 "page_namespace"=>$row->page_namespace,"vote_count"=>$row->vote_count,
			 "comment_count"=>$row->comment_count,"vote_avg"=>$row->vote_avg
			 );
	
		}
		if($this->PageNo==1){
			$key = wfMemcKey( 'listpages', 'list', str_replace(" ","","category:{$this->CategoriesStr}:level:{$this->Level}:showpublished:{$this->ShowPublished}:sort:{$this->Order}:count:{$this->ShowCount}:order:{$this->SortBy}:ratingmin:{$this->ratingMin}") );
			$wgMemc->set( $key, $list_pages,60 );
		}
		
		return $list_pages;
	}
	
	function displayList(){
		global $wgUser, $wgLang, $wgContLang, $wgTitle, $wgOut, $wgMemc, $wgUploadPath, $wgVoteDirectory;
	
		if( $this->ShowRating == 1 ){
			require_once ("$wgVoteDirectory/VoteClass.php");
		}
		
		$list_pages = $this->getListCache();
		if( !$list_pages ){
			$list_pages = $this->getListDB();
		}
 
		if (count($list_pages) == 0){
			return htmlspecialchars( "No pages found." );
		}
		
		$output = "";
		$output .= "<div class=\"listpages-container\" id=\"ListPages".$this->listid."\">";
		
	 	$ListCount=0;
		$ListCountShow=0;
		$last_page_id = 0;
		foreach($list_pages as $list_page){
			if($last_page_id <> $list_page["page_id"]){
				$last_page_id = $list_page["page_id"];
				if($ListCountShow < $this->ShowCount - 1){
					
					$title = Title::makeTitle( $list_page["page_namespace"], $list_page["page_title"]);
					
					$output .= "<div class=\"listpages-item\">\n";
					
					// ** MAIN ROW
					// Picture (optional) + Title
					if($this->ShowPic == 1){
						$PageImage = $this->getPageImage( $list_page["page_id"] );
						
						if($PageImage){
							//load mediawiki image object to get thumbnail tag
							$img = Image::newFromName($PageImage);
							$thumb = $img->getThumbnail( 65, 0 , true );
							$img_tag = $thumb->toHtml();
							
							$output .= "<div class=\"listpages-image\">{$img_tag}</div>\n";
						}
					}
					
					if( $this->ShowVoteBox == 1 ){
						$output .= "<div class=\"listpages-votebox\">\n";
						$output .= 	"<div class=\"listpages-votebox-number\">{$list_page["vote_count"]}</div>\n";
						$output .= 	"<div class=\"listpages-votebox-text\">".wfMsgExt("listpages_votes", "parsemag", $list_page["vote_count"] )."</div>\n";
						$output .= "</div>\n";
					}
					
					if( $this->ShowCommentBox == 1 ){
						$output .= "<div class=\"listpages-votebox\">\n";
						$output .= 	"<div class=\"listpages-commentbox-number\">{$list_page["comment_count"]}</div>\n";
						$output .= "</div>\n";
					}
			
					
					// ** Display Link
					
					$output .= "<a href=\"{$title->escapeFullURL()}\">{$title->getText()}</a>";
					
					// ** END Main Row
					
					// ** Display Create Date
					if($this->ShowDate == 1){
						$output .= "<div class=\"listpages-date\">";
						$output .= "(" . wfMsg("time_created") . " " . $this->getTimeStr($list_page["page_id"]) . " " . wfMsg("time_ago") . ")";
						$output .= "</div>";
			
					}
					
					// ** Display Average Score + Stars Graphics
					if($this->ShowRating == 1){	
						$Vote = new VoteStars( $list_page["page_id"] );
				
						$id = $this->listid . "_" . $ListCount;
						$voted = $Vote->UserAlreadyVoted();
						if($voted){
							$rating = $voted;
						}else{
							$rating = $list_page["vote_avg"];
						}
						$output .= "<div class=\"listpages-rating\">\n";
						$output .=	"<div id=\"rating_stars_{$id}\">" .  $Vote->displayStars($id,$rating,$Vote->UserAlreadyVoted()) . "</div>\n";
						$output .=	"<div id=\"rating_{$id}\" class=\"rating-total\">" . $Vote->displayScore() . "</div>\n";
						$output .= "</div>\n";
					}
					
					// ** Display Blurb of N Characters (stored in ShowBlurb)
					if( $this->ShowBlurb > 0 ){
						$output .= "<div class=\"listpages-blurb\">\n";
						$output .= $this->getBlurb($list_page["page_title"], $list_page["page_namespace"]);
						$output .= "\n</div>\n";
					}
					
					// ** Show most popular categories for current page
					if($this->ShowCtg == 1){
						$output .= "<div class=\"listpages-categories\">\n";
						$output .= $this->getCategoryLinks( $list_page["page_id"], 3 );
						$output .= "\n</div>\n";
					}
					
					// ** Show Stats for page
					if($this->ShowStats == 1){
						$output .= "<div class=\"listpages-stats\">\n";
						$output .=  "<img src=\"{$wgUploadPath}/common/voteIcon.gif\" alt=\"v\" border=\"0\" /> {$list_page["vote_count"]} " . wfMsgExt("listpages_votes", "parsemag", $list_page["vote_count"] );
						
						if ($this->Order == 'LATEST'){
							$output .=  wfMsg("listpages_updated") . " " . wfTimestamp( TS_RFC2822, $list_page["page_touched"] );
						}
						
						$output .= " <img src=\"{$wgUploadPath}/common/comment.gif\" alt=\"c\" border=\"0\" /> {$list_page["comment_count"]} " . wfMsgExt("listpages_comments", "parsemag", $list_page["comment_count"] );
						$output .= "</div>";
					}
					$ListCountShow++;
					$output .= "</div>\n";
					$output .= "<div class=\"cleared\"></div>\n";
				}
			}
			$ListCount++;
		}
		
		if($this->ShowNav==1){
			$output .= "<div class=\"listpages-nav-buttons\">";
			if($this->PageNo == 1){
				$output .= $this->getNavLink("Prev",0);
			} else {
				$output .= $this->getNavLink("Prev",-1);
			}
			if($ListCount > $ListCountShow){
			  	$output .= $this->getNavLink("Next",1);
			} else {
				$output .= $this->getNavLink("Next",0);
			}
			$output .= "</div>";
		}
		
		$output .= "</div>";
		return $output;
	}
	function getNavLink($Button,$Direction){
		$nav = "";
		
		$options = "{";
		$options .= "shw:'" .  ($this->ShowCount-1) . "',";
		$options.= "ctg:'" . $this->CategoriesStr . "',";
		$options.= "ord:'" . urlencode ($this->Order) . "',";
		$options.= "srt:'" .  $this->SortBy  . "',";
		$options.= "lv:'" . $this->Level . "',";
		$options.= "det:'". $this->ShowDetails . "',";
		$options.= "shwctg:'" . $this->ShowCtg . "',";
		$options.= "pub:'" . $this->ShowPublished . "',";
		$options.= "shwpic:'" . $this->ShowPic . "',";
		$options.= "shwb:'" . $this->ShowBlurb . "',";
		$options.= "bfs:'" . $this->BlurbFontSize . "',";
		$options.= "shwst:'" . $this->ShowStats . "',";
		$options.= "shwdt:'" . $this->ShowDate . "',";
		$options.= "shwrt:'" . $this->ShowRating . "',";
		$options.= "rtmin:'" . $this->ratingMin . "',";
		$options.= "shwvb:'" . $this->ShowVoteBox . "'";
		$options .= "}";
		
		if($this->ShowDetails==1){
			if($Direction!=0){
			$nav .= "<input type='submit' value='" . $Button . "' class='listpage-button' onclick=\"ViewPage(" . ($this->PageNo + $Direction) . "," . $this->listid . "," . $options .")\" />";
            } else {
			$nav .= "<input type='submit' value='" . $Button . "' class='listpage-button-off' />";
			}
		} else {
		
		  if($Direction!=0){
		    $nav .= "<a href=\"javascript:;\" onclick=\"javascript:ViewPage(" . ($this->PageNo + $Direction) . "," . $this->listid . ",". $options .")\">" . $Button . "</a>";
          } else {
		    $nav .= '<a href="#" class="nonavnodetails">' . $Button . '</a>';
		  }
		}
		return $nav; 
	}


}



?>
