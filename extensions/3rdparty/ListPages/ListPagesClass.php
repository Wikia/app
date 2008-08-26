<?php
class ListPages{

	//Query Variables
	var $Categories = array(), $CategoriesStr = "";
	var $ShowCount = 5;
	var $PageNo = 1,$SortBy = NULL,$Order = NULL,$Level = 1;
	
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
	var $isViewMain = 0;
	
	var $useCache = 0;
	
	function listpages(){
		$this->listid = rand();
		//require_once ('CommentClass.php');
		//require_once ('VoteClass.php');
	}
	
	function setCategory($ctg){
	    global $wgUser;
  	  	global $wgLang;
   		global $wgContLang;
		global $wgTitle;
		global $wgOut;
		$parser = new Parser();
		$ctg = str_replace("\,","#comma#",$ctg);
		$aCat = explode(",", $ctg);
		$CtgTitle = "";
		foreach($aCat as $sCat){
			if($sCat!=""){
				if($this->CategoriesStr!=""){
					$this->CategoriesStr .= ",";
				}
				$CtgTitle = Title::newFromText( $parser->transformMsg(trim( str_replace("#comma#",",",$sCat) ), $wgOut->parserOptions()) );	
				$this->CategoriesStr .= $CtgTitle->getDbKey();
	        	$this->Categories[] = $CtgTitle;
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
		$dbr =& wfGetDB( DB_MASTER);
		$sqlc = "select UNIX_TIMESTAMP(rev_timestamp) as create_date from {$dbr->tableName( 'revision' )} where rev_page=" . $pageid . " order by rev_timestamp asc limit 1";
		$res = $dbr->query($sqlc);
		$row = $dbr->fetchObject( $res );
		if($row){
			$create_date = $row->create_date;
		}
		return $create_date;
	}
	
	function getPageImage($pageid){
		$dbr =& wfGetDB( DB_MASTER);
		$sqlc = "select il_to from {$dbr->tableName( 'imagelinks' )} where il_from=" . $pageid . " limit 1";
		$res = $dbr->query($sqlc);
		$row = $dbr->fetchObject( $res );
		if($row){
			$il_to = $row->il_to;
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
		global $wgUser;
		global $wgContLang;
		$LinksCounter = 0;
		if($this->ShowCtg == 1 && $pageid!=""){
			$sk =& $wgUser->getSkin();
			$dbr =& wfGetDB( DB_SLAVE );
			$sql = "SELECT cl_to FROM " . $dbr->tableName( 'categorylinks' ) . " cl1 WHERE cl_from=" . $pageid . "  ORDER BY (select count(*) from {$dbr->tableName( 'categorylinks' )} cl2 where cl2.cl_to = cl1.cl_to) DESC LIMIT 0,5";
			$res = $dbr->query($sql);
			$Categories .= "<span class='categorylinks'>";
			while ($row = $dbr->fetchObject( $res ) ) {
				if( $LinksCounter < $LinksTotal && $this->categoryIsDate($row->cl_to)==false){
					$title = Title::makeTitle( 14, $row->cl_to);
					if($LinksCounter!=0)$Categories .= ", ";
					$Categories .=  "<a href=\"index.php?title=Category:" . $row->cl_to . "\">" . $title->getText() . "</a>" ;
					$LinksCounter++;
				}
			}
			$Categories .= "</span>";
			if($LinksCounter!=0){
				return "<span class=\"categorylinkstitle\">categories: " . $Categories . "</span>";
			}else{
				return "";
			}
		}else{
			return "";
		}
	}
	
	function getTimeStr($pageid){
		$timeArray =  $this-> dateDiff(time(),$this->getCreateDate($pageid)  );
		$timeStr = "";
		$timeStrD = $this->getTimeOffset($timeArray,"d","day");
		$timeStrH = $this->getTimeOffset($timeArray,"h","hour");
		$timeStrM = $this->getTimeOffset($timeArray,"m","minute");
		$timeStrS = $this->getTimeOffset($timeArray,"s","second");
		$timeStr = $timeStrD;
		//print "str:" . $timeStr;
		//exit();
		if($timeStr==""){
			$timeStr.=$timeStrH;
			$timeStr.=$timeStrM;
			if($timeStr=="")$timeStr.=$timeStrS;
		}
		return $timeStr;
	}
	
	function getBlurb($pagetitle){
		global $wgTitle,$wgOut;
		
		//get raw text
		$preloadTitle = Title::newFromText( $pagetitle );
		$rev=Revision::newFromTitle($preloadTitle);
		if($rev)$text = $rev->getText();
		//echo "<h1>RAW TEXT<br>===========================</h1>" . $text;
	
		//remove some problem characters
		$text =  str_replace("* ","",$text);
		$text =  str_replace("===","",$text);
		$text =  str_replace("==","",$text);
		$text =  str_replace("{{Comments}}","",$text);
		$text =  preg_replace('@<youtube[^>]*?>.*?</youtube>@si', '', $text);
		$text =  preg_replace('@<vote[^>]*?>.*?</vote>@si', '', $text);
		$text =  preg_replace('@\[\[Category:[^\]]*?].*?\]@si', '', $text);
		
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
		//$blurb_text = $text;
		$pos = strpos($blurb_text,"[");
		if($pos !== false){
			$blurb_text = substr($blurb_text,0,$pos);
		}
		
		//Take first N characters, and then make sure it ends on last full word
		$max = $this->ShowBlurb;
		if (strlen($blurb_text) > $max)$blurb_text = strrev(strstr(strrev(substr($blurb_text,0,$max)),' '));
		
		//prepare blurb font size
		$blurb_font = "<span style='font-size:";
		if($this->BlurbFontSize==1)$blurb_font .= "11px";
		if($this->BlurbFontSize==2)$blurb_font .= "12px";
		if($this->BlurbFontSize==3)$blurb_font .= "13px";
		$blurb_font.= "'>";
		
		//fix multiple whitespace, returns etc
		$blurb_text = trim($blurb_text); // remove trailing spaces
		$blurb_text = preg_replace('/\s(?=\s)/','',$blurb_text); // remove double whitespace
		$blurb_text = preg_replace('/[\n\r\t]/',' ',$blurb_text); // replace any non-space whitespace with a space
		
		//echo "<h1>FINAL=====================</h1>" . $blurb_text;
		return $blurb_font . $blurb_text. ". . . <a href=\"" . $preloadTitle->getFullURL() . "\">more</a></span>";
	}


	
	function getListPagesCache(){
		$refresh = 120;
		global $wgListPagesCacheDirectoryWrite, $wgListPagesCacheDirectoryRead;
		
		$filewrite = $wgListPagesCacheDirectoryWrite . $this->hashname;
		$fileget = $wgListPagesCacheDirectoryRead . $this->hashname;
		
		if ( $wgListPagesCacheDirectoryRead && file_exists($fileget) && (time() - @filemtime($fileget))  < $refresh ) {
			//echo 'getting cache' . $fileget;
			$output = "<!--cached-->" . file_get_contents($fileget);
		}else{
			//echo 'getting from db:' . $filewrite;
			$output  = $this->DisplayListDB();
			ignore_user_abort();
			register_shutdown_function('_cache_page_exit',$filewrite,$output);
		}
		return $output;
	}
	
	function buildSQL(){
		global $wgUser;
		$dbr =& wfGetDB( DB_SLAVE );
	    $sPageTable = $dbr->tableName( 'page' );
	    $categorylinks = $dbr->tableName( 'categorylinks' );
		
	    $sSqlSelectFrom = "SELECT distinct(page_id),page_namespace,page_title, page_counter,UNIX_TIMESTAMP(page_touched),page_id, IFNULL(comment_count,0) as comment_count, IFNULL(vote_count,0) as vote_count,  IFNULL(vote_avg,0) as vote_avg ";
		
		if($this->Order == 'EDITS'){
			$sSqlSelectFrom .= ",(select count(*) from {$dbr->tableName( 'revision' )} where page_id=rev_page ";
			$sSqlSelectFrom .= ") as Num_Edits ";
		}
		
		if($this->ShowUser == 1){
			$WhereVote = " and username = '" . $wgUser->mName . "' ";
			$WhereComment = " and Comment_Username = '" . $wgUser->mName . "' ";
		}
		if (  $this->Order == 'VOTEDON' ){
			$sSqlSelectFrom .= " ,(select vote_date from Vote WHERE vote_page_id = page_id " . $WhereVote . " order BY vote_date DESC limit 1) as LastDate ";
		}
		if (  $this->Order == 'COMMENTEDON' ){
			$sSqlSelectFrom .= " ,(select Comment_date from Comments WHERE Comment_page_id = page_id " . $WhereComment . " order BY Comment_date DESC limit 1) as LastDate ";
		}
		
		$sSqlSelectFrom .= "FROM $sPageTable";

		if($this->ShowPublished==1){
			$sSqlSelectFrom .=" INNER JOIN published_page  ";
			$sSqlSelectFrom .=" ON page_id = published_page_id  ";
		}
		
		if(count($this->Categories) > 0){
			$sSqlSelectFrom .= " INNER JOIN $categorylinks AS c";
	   	 	$sSqlSelectFrom .= ' ON page_id = c.cl_from';
		}

		if($this->ShowPublished==-1){
			$sSqlSelectFrom .= " LEFT JOIN published_page ";
	   	 	$sSqlSelectFrom .= ' ON page_id = published_page_id and published_type= ' . $this->Level . ' ';
		}
	
		$sSqlSelectFrom .= ' LEFT JOIN page_stats ON page_id=ps_page_id ';
		
		//BUILD WHERE CLAUSE
		$sSqlWhere = " WHERE 1=1";
		$sCtgSQL = "";
		if(count($this->Categories) > 0){
		 $sSqlWhere .= ' AND UPPER(c.cl_to) in (';
		 for ($i = 0; $i < count($this->Categories); $i++) {
		 	if($i>0)
				$sCtgSQL .= ",";
			$sCtgSQL .=  strtoupper($dbr->addQuotes( $this->Categories[$i]->getDbKey() ));
	   	 }
		 $sSqlWhere .= $sCtgSQL . ')';
		}
		
		if($this->ShowPublished==1)
			 $sSqlWhere .= " AND published_type=" . $this->Level . " ";
			
		if($this->ShowPublished==-1){
			$sSqlWhere .= " AND ( published_page_id IS NULL  ) ";
		}
		
		if($this->random==1){
			$randstr = wfRandom();
			$sSqlWhere .= " AND page_random>$randstr ";
		}
		
		if($this->ratingMin>0){
			$sSqlWhere .= " AND vote_count >= " . $this->ratingMin;
		}
		
		// Only Show Main Pages in lists
		$sSqlWhere .= " AND page_namespace in ( " . NS_MAIN . "," . NS_USER . "," . NS_IMAGE . ")";
		   
		// BUILD ORDER BY CLAUSE
		$sSqlOrder = " ORDER BY ";
	    if ($this->Order == 'LASTEDIT'){
	      $sSqlOrder .= 'page_touched ';
	    }else if ($this->Order == 'PAGEVIEWS'){
	      $sSqlOrder .= 'page_counter ';
		}else if ($this->Order == 'VOTES'){
			$sSqlOrder .= 'vote_count ';
		}else if ($this->Order == 'VOTE AVERAGE'){
			$sSqlOrder .= 'vote_avg ';
		}else if ($this->Order == 'COMMENTS'){
			$sSqlOrder .= 'comment_count ';
		}else if ($this->Order == 'NEW'){
			$sSqlOrder .= 'page_id ';
		}else if ($this->Order == 'EDITS'){
			$sSqlOrder .= 'Num_Edits ';
		}else if ($this->Order == 'PUBLISHEDDATE' && $this->ShowPublished==1){
			$sSqlOrder .= 'published_date ';
		}else if ($this->Order == 'VOTEDON' || $this->Order == 'COMMENTEDON'){
			$sSqlOrder .= 'LastDate ';
		}else if ($this->random == 1){
			$sSqlOrder .= ' page_random ';
			$this->SortBy = 'ASCENDING';
		}else{
			$sSqlOrder .= 'page_title ';
		}
		
		if ($this->SortBy == 'ASCENDING' )
	      $sSqlOrder .= 'ASC';
	    else
	      $sSqlOrder .= 'DESC';
		  
		// BUILD LIMIT RECORDS RETURNED
		$sSqlLimit = ' LIMIT ' .  ($this->PageNo - 1) * ($this->ShowCount-1) .',' .$this->ShowCount;
		if (  $this->Order == 'VOTEDON' || $this->Order == 'COMMENTEDON'){
			$sSqlWhere = " WHERE page_id IN ( " . $this->getPageIDs() . ")";
			$sSqlLimit = "";
		}
		return ($sSqlSelectFrom . $sSqlWhere . $sSqlOrder . $sSqlLimit);
	}
	
	function displayList(){
		if($this->useCache == 1 && $this->hashname!=""){
			return $this->getListPagesCache();
		}else{
			return $this->displayListDB();
		}
	}
	
	function displayListDB(){
		global $wgUser;
  	  	global $wgLang;
   		global $wgContLang;
		global $wgTitle;
		global $wgOut;
		
		$sk =& $wgUser->getSkin();
	
		$dbr =& wfGetDB( DB_SLAVE );
	
		//echo $this->buildSQL();
		$res = $dbr->query($this->buildSQL());
		
		if ($dbr->numRows( $res ) == 0){
			return htmlspecialchars( "No pages found." );
		}
		$output="";
		$output .= "<div id=\"ListPages".$this->listid."\">";
		$output .= "<table cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr><td>" . "\n";
		
		$ListCount=0;
		$ListCountShow=0;
		while ($row = $dbr->fetchObject( $res ) ) {
			if($ListCountShow < $this->ShowCount - 1){
				$title = Title::makeTitle( $row->page_namespace, $row->page_title);
				
				$output .= "<table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" class=\"listpageItem\">";
				
				// ** MAIN ROW
				// Picture (optional) + Title
				$output .= "<tr>";
				if($this->ShowPic == 1){
					$PageImage = $this->getPageImage($row->page_id);
					if($PageImage){
						$output .= "<td class=\"listpage\" rowspan=\"5\" valign=\"top\" style='padding-right:20px'>";
						$img = Image::newFromName($PageImage);
						$img_tag = '<img src="' . $img->getURL() . '" alt="' . $PageImage . '" width="65"/>';
						$output .=     $img_tag; //str_replace("</p>","",str_replace("<p>","",$img->getText()));
						$output .= "</td>";
					}
				}
				
				if($this->ShowVoteBox == 1){
					$output .= "<td width=\"30\">" . $this->getVoteBox($row->vote_count) . "</td><td width=\"8\"></td>";
				}
				
				if($this->ShowCommentBox == 1){
					$output .= "<td width=\"30\">" . $this->getCommentBox($row->comment_count) . "</td><td width=\"8\"></td>";
				}
				if($this->ShowDetails==1){
			  		$output .= '<td class="showdetails" ' . (($this->ShowVoteBox==1 || $this->ShowCommentBox==1) ? 'valign="top"':'') . '>';
				} else {
			  		$output .= '<td class="hidedetails" ' . (($this->ShowVoteBox==1 || $this->ShowCommentBox==1) ? 'valign="top"':'') . '>';
				}
				
				// ** Display Link
				if($row->page_namespace!=6){
			    	//$output .= $sk->makeKnownLinkObj($title, $wgContLang->convertHtml($title->getText()));
					$output .= '<a href="' . $title->getFullURL() . '" title="' . $title->getText() . '">' . $title->getText() . '</a>';
				}else{
					$CommentParser = new Parser();
					$img = $CommentParser->parse( "[[Image:" . $row->page_title . "|75px]]", $wgTitle, $wgOut->mParserOptions,true );
					$output .=    $img->getText();
				}
				$output .= "</td>";
				$output .= "</tr>";
				// ** END Main Row
				
				// ** Display Create Date
				if($this->ShowDate == 1){
					$output .= "<tr>";
					$output .= '<td class="listdate">';
					$output .= "(created " . $this->getTimeStr($row->page_id) . " ago)"; //date("D m/d/y, g:i a T",$this->getCreateDate($row->page_id) - (60 * 60 * 1));
					$output .= '</td>';
					$output .= "</tr>";
				}
				
				// ** Display Average Score + Stars Graphics
				if($this->ShowRating == 1){
					$Vote = new VoteStars($row->page_id);
					$output .= "<tr>";
					$output .= '<td class="listrating">';
					$output .=	"<table cellpadding=\"0\" cellspacing=\"0\"><tr><td><span class=\"listrating-score-title\">Score:</span> <span class=\"listrating-score\">" . number_format($row->vote_avg ,2)  . "</span></td><td>" .  $Vote->displayRating($row->vote_avg) . "</td></tr></table>";
					$output .= "</td>";
					$output .= "</tr>";
				}
				
				// ** Display Blurb of N Characters (stored in ShowBlurb)
				if($this->ShowBlurb > 0){
					$output .= "<tr>";
					$output .= "<td class=\"listblurb\">";
					$output .= $this->getBlurb($row->page_title);
					$output .= '</td>';
					$output .= "</tr>";
				}
				
				// ** Show most popular categories for current page
				if($this->ShowCtg == 1){
					$output .= "<tr>";
					$output .= "<td class=\"categorylinks\">";
					$output .= $this->getCategoryLinks($row->page_id,3);
					$output .= '</td>';
					$output .= "</tr>";
				}
				
				// ** Show Stats for page
				if($this->ShowStats == 1){
					$output .= "<tr>";
					$output .= '<td class="liststats"><span class="liststatstitle">stats</span>: ';
					if($this->Order != 'VOTES')
						$output .=  '<img src="images/voteIcon.gif" alt="v" /> ' . $row->vote_count . ' votes';
				  	if ($this->Order == 'PAGEVIEWS')
				   		$output .= ' [' . $row->page_counter . ' Views]';
				   	if ($this->Order == 'VOTES')
				   		$output .=  '<img src="images/voteIcon.gif" alt="v" /> '. $row->vote_count . ' votes';
					if ($this->Order == 'EDITS')
				   		$output .=  ' [' . $row->Num_Edits . ' Edits]';
				  	if ($this->Order == 'LATEST')
				   		$output .=  ' [Updated ' . wfTimestamp( TS_RFC2822, $row->page_touched) . ']';
					if($this->ShowRating == 1){
						$CommentLabel = "reviews";
					}else{
						$CommentLabel = "comments";
					}
					$output .= ' <img src="images/commentIcon.gif" alt="c" /> '.  $row->comment_count . ' ' . $CommentLabel .  '</td>';
				 	$output .= "</tr>";
				}
				$ListCountShow++;
				$output .= "</table>";
			}
			$ListCount++;
		}
		if($this->ShowNav==1){
			$output .= "<div id=\"listpagesnav\">";
			if($this->PageNo == 1){
				$output .= $this->getNavLink("Prev",0);
			} else {
				$output .= $this->getNavLink("Prev",-1);
			}
			$output .= "&nbsp;";
			if($ListCount > $ListCountShow){
			  	$output .= $this->getNavLink("Next",1);
			} else {
				$output .= $this->getNavLink("Next",0);
			}
			$output .= "</div>";
		}
		$output .= "</td></tr></table>";
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
		$options.= "shwctg:" . $this->ShowCtg . ",";
		$options.= "pub:" . $this->ShowPublished . ",";
		$options.= "shwpic:" . $this->ShowPic . ",";
		$options.= "shwb:'" . $this->ShowBlurb . "',";
		$options.= "bfs:'" . $this->BlurbFontSize . "',";
		$options.= "shwst:" . $this->ShowStats . ",";
		$options.= "shwdt:" . $this->ShowDate . ",";
		$options.= "shwrt:" . $this->ShowRating . ",";
		$options.= "vm:" . $this->isViewMain . ",";
		$options.= "rtmin:" . $this->ratingMin . ",";
		$options.= "shwvb:" . $this->ShowVoteBox . "";
		$options .= "}";
		
		if($this->ShowDetails==1){
			if($Direction!=0){
			$nav .= "<input type='submit' value='" . $Button . "' class='nav' onclick=\"ViewPage(" . ($this->PageNo + $Direction) . "," . $this->listid . "," . $options .")\" />";
            } else {
			$nav .= "<input type='submit' value='" . $Button . "' class='nonav' />";
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
	
	function getVoteBox($vote_count){
		$output = "<table cellpadding=\"0\" cellspacing=\"0\" border=\"0\">
		<tr><td class=\"voteboxsmall\" align=\"center\" height=\"27\" width=\"27\">" . $vote_count . "</td></tr>
		<tr><td style='font-size:10px; color:#000000;' align='center'>votes</td></tr>
		</table>";
		return $output;
	}
	
	function getCommentBox($comment_count){
		if($comment_count > 99)$comment_count = "<span style=\"font-size:11px\">" . $comment_count . "</span>";
		$output = "<table cellpadding=0 cellspacing=0 border=0>
					<tr><td class=commentboxsmall align=center height=30 width=30>" . $comment_count . "</td></tr>
				</table>";
		return $output;
	}
	
	 function dateDiff($dt1, $dt2) {
   $date1 = (strtotime($dt1) != "") ? strtotime($dt1) : $dt1;
   $date2 = (strtotime($dt2) != "") ? strtotime($dt2) : $dt2;
   $dtDiff = $date1 - $date2;
   $totalDays = intval($dtDiff/(24*60*60));
   $totalSecs = $dtDiff-($totalDays*24*60*60);
   $dif['w'] = intval($totalDays/7);
   $dif['d'] = $totalDays;
   $dif['h'] = $h = intval($totalSecs/(60*60));
   $dif['m'] = $m = intval(($totalSecs-($h*60*60))/60);
   $dif['s'] = $totalSecs-($h*60*60)-($m*60);
   return $dif;
  }

  			function getTimeOffset($time,$timeabrv,$timename){
				//return $time[$timeabrv] . $timename;
				if($time[$timeabrv]>0){
					$timeStr = $time[$timeabrv] . " " . $timename;
					if($time[$timeabrv]>1)$timeStr .= "s";
				}
				if($timeStr)$timeStr .= " ";
				return $timeStr;
			}
}

class ListPagesView extends ListPages {
	function ListPagesView(){
		return "";
	}
	
	
	function displayListDB(){
		global $wgUser;
  	  	global $wgLang;
   		global $wgContLang;
		global $wgTitle;
		global $wgOut;
		
		$sql = $this->buildSQL();
		$dbr =& wfGetDB( DB_SLAVE );
		$res = $dbr->query($sql);
		$sk =& $wgUser->getSkin();
		$this->listid = rand();
	    if ($dbr->numRows( $res ) == 0){
			return htmlspecialchars( "No pages found." );
	    }
		$output="";
		$output .= "<div id=\"ListPages".$this->listid."\">";
	    $output .= "<table cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr><td>" . "\n";
		
		$ListCount=0;
		$ListCountShow=0;
	    while ($row = $dbr->fetchObject( $res ) ) {
			if($ListCountShow < $this->ShowCount - 1){
				$output .= "<table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" class=\"listpageItem\" >";
				if($row->vote_count == NULL){
					$vote_count = 0;
				}else{
					$vote_count = $row->vote_count;
				}
				if($row->comment_count == NULL){
					$comment_count = 0;
				}else{
					$comment_count = $row->comment_count;
				}
		      	$title = Title::makeTitle( $row->page_namespace, $row->page_title);
				$output .= "<tr>";
				
				if($this->ShowPic == 1){
					$PageImage = $this->getPageImage($row->page_id);
					if($PageImage){
						$output .= "<td class=\"listpage\" rowspan=\"5\" valign=\"top\" style='padding-right:20px'>";
						$CommentParser = new Parser();
						$img = $CommentParser->parse( "[[Image:" . $PageImage . "|65px]]", $wgTitle, $wgOut->mParserOptions,true );
						$output .=     str_replace("</p>","",str_replace("<p>","",$img->getText()));
						$output .= "</td>";
					}
				}

				if($this->showVoteBox == 1){
					$output .= "<td width=\"30\">" . $this->getVoteBox($vote_count) . "</td><td width=\"8\"></td>";
				}
				if($this->ShowDetails==1){
			  		$output .= '<td class="showdetails">';
				} else {
			  		$output .= '<td class="view" valign="top">';
				}
				// ** Display Link
				if($row->page_namespace!=6){
				$output .= '<a href="' . $title->getFullURL() . '" title="' . $title->getText() . '">' . $title->getText() . '</a>';
			    	//$output .= $sk->makeKnownLinkObj($title, $wgContLang->convertHtml($title->getText()));
				}else{
					$CommentParser = new Parser();
					$img = $CommentParser->parse( "[[Image:" . $row->page_title . "|75px]]", $wgTitle, $wgOut->mParserOptions,true );
					$output .=    $img->getText();
				}
				
				$output .= "</td>";
				$output .= "</tr>";
				if($this->ShowDetails==1){
					if($this->ShowBlurb > 0){
						$output .= "<tr>";
						$output .= "<td class=\"listblurb\">";
						$output .= $this->getBlurb($row->page_title);
						$output .= '</td>';
						$output .= "</tr>";
					}
					$output .= "<tr>";
					$output .= "<td>";
					$output .= "<span class=\"listdate\">created: " . $this->getTimeStr($row->page_id) . " ago</span><br/>  "; //date("D m/d/y, g:i a T",$this->getCreateDate($row->page_id) - (60 * 60 * 1));
					$output .= "<span class=\"categorylinks\">" . $this->getCategoryLinks($row->page_id,3) . "</span>";
					$output .= "</td>";
					 $output .= "</tr>";
					 $output .= "<tr>";
					$output .= '<td class="liststats">';
				
					if($this->showVoteBoxInTitle==1){
						$output .= "<span class=\"viewStats\">" . $vote_count . "</span>";
						$output .= "<span style='font-size:11px;padding-right:7px;font-weight:800;color:#929C8B'>votes</span>";
						$output .= "<span class=\"viewStats\">" . $comment_count . "</span>";
						$output .= "<span style='font-size:11px;padding-right:7px;font-weight:800;color:#9C9C9C'>comments</span></td>";
					}
					else{
					if($this->Order != 'VOTES')
						$output .=  '<img src="images/voteIcon.gif" alt="v" /> ' . $vote_count . ' votes';
				  	if ($this->Order == 'PAGEVIEWS')
				   		$output .= ' [' . $row->page_counter . ' Views]';
				   	if ($this->Order == 'VOTES')
				   		$output .=  '<img src="images/voteIcon.gif" alt="v" /> '. $vote_count . ' votes';
					if ($this->Order == 'EDITS')
				   		$output .=  ' [' . $row->Num_Edits . ' Edits]';
				  	if ($this->Order == 'LATEST')
				   		$output .=  ' [Updated ' . wfTimestamp( TS_RFC2822, $row->page_touched) . ']';
					
					$output .= ' <img src="images/commentIcon.gif" alt="c" /> '.  $comment_count . ' comments</td>';
					}
				 	$output .= "</tr>" . "\n";
				}else{
					$output .= "<tr><td height=\"3\"></td></tr>";
				}
				$ListCountShow++;
				$output .= "</table>";
			}
			$ListCount++;
		}
		if($this->ShowNav==1){
			$output .= "<div id=\"listpagesnav\">";
			if($this->PageNo == 1){
				$output .= $this->getNavLink("Prev",0);
			} else {
				$output .= $this->getNavLink("Prev",-1);
			}
			$output .= "&nbsp;";
			if($ListCount > $ListCountShow){
			  	$output .= $this->getNavLink("Next",1);
			} else {
				$output .= $this->getNavLink("Next",0);
			}
			$output .= "</div>";
		}
		$output .= "</td></tr></table>";
		$output .= "</div>";
	    return $output;
	}
}

	function _cache_page_exit($file,$contents){
		$fp = fopen($file, "w");
		if($fp != false && flock($fp, LOCK_EX + LOCK_NB) == true ){
			fwrite($fp, $contents);
			fclose($fp);
		}
	}
?>
