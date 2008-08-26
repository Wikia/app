<?php
class RSS{

	var $PageID = 0;
	var $published = 0;
	var $published_level = 1;
	var $order = 0;
	var $StaticXML = true;
	
	function get_rfc_date($datestr){
		 $newstime = $datestr; //the date of your item in the database
		 list($date, $hours) = split(' ', $newstime);
		 list($year,$month,$day) = split('-',$date);
		 list($hour,$min,$sec) = split(':',$hours);
		 //returns the date ready for the rss feed
		  $date = date("r", (mktime($hour, $min, $sec, $month, $day, $year)) - 60 * 60 * 4);
		 return $date;
	}
	
	function update_rss_category($Category){
		$dbr =& wfGetDB( DB_MASTER );
		if($this->published == 0){
			$DateSQL = " (select DATE_FORMAT(DATE_SUB(`rev_timestamp` , INTERVAL 4 HOUR ),'%Y-%m-%d %H:%i:%s') from {$dbr->tableName( 'revision' )} where rev_page=page_id order by rev_timestamp asc limit 1) as published_date, ";
		}else{
			$DateSQL = " published_date, ";
		}
		$sql = "SELECT page_namespace,page_title, " . $DateSQL . " page_id FROM page ";
		
		if($this->published){
			$sql .=" INNER JOIN published_page  ";
			$sql .=" ON page_id = published_page_id  ";
		}
		
		$sql .= " INNER JOIN {$dbr->tableName( 'categorylinks' )} AS c";
 	 	$sql .= " ON page_id = c.cl_from ";
		$sql .= " WHERE cl_to = '" . $Category  . "' ";
		
		if($this->published){
			$sql .= " AND published_type = " . $this->published_level  . " ";
		} 
		
		$sql .= " ORDER BY ";
		
		if($this->order==0){
			$sql .= " published_date DESC  ";
		}else{
			$sql .= " page_touched DESC  ";
		}
		$sql .= " LIMIT 15";

		//$result = mysql_query($sql);

		return $this->generate_xml($sql,$Category);
	}
	
	function update_rss_page_categories(){
		$dbr =& wfGetDB( DB_MASTER );
	
			$sql = "SELECT page_namespace,page_title,published_date,page_id FROM page ";
			$sql .=" INNER JOIN published_page  ";
			$sql .=" ON page_id = published_page_id  ";
			$sql .= " INNER JOIN {$dbr->tableName( 'categorylinks' )} AS c";
   	 			$sql .= " ON page_id = c.cl_from ";
				
			$sql .=" WHERE published_type=1  ";
			$sql .= " and cl_to IN ('News','Opinions','Questions','Gossip','Articles') ";
			$sql .= " ORDER BY published_date DESC LIMIT 15 ";

			$this->generate_xml($sql,$Category);
	}
	
	function fix_xml($str){
		$str = str_replace ("&", "&amp;",  $str );
		return $str;
	}
	
	function categoryIsDate($ctg){
		if( strtotime(str_replace("_"," ",$ctg) ) != "" ){
			return true;
		}else{
			return false;
		}
	}
	
	function generate_xml($sql,$Category){
		//echo $sql;
		//exit();
		global $wgUser, $wgSitename;
		global $wgLang;
		global $wgContLang;
		global $wgOut;
		global $IP;
		global $wgPasswordSender, $wgDBname, $wgServer, $wgRSSDirectory;
		
		global $wgArticlePath, $wgServer;
			
		$dbr =& wfGetDB( DB_MASTER );
		$result = $dbr->query($sql);
		
		$sk =& $wgUser->getSkin();
		if($Category == ""){
			$RSSTitle = $wgSitename . ".wikia Main Page";
		}else{
			$RSSTitle = str_replace( '_', ' ', $Category );;
		}


		$xml = '<?xml version="1.0"?>';
	
		$xml .= '<rss version="2.0" xmlns:content="http://purl.org/rss/1.0/modules/content/" xmlns:wfw="http://wellformedweb.org/CommentAPI/" xmlns:feedburner="http://rssnamespace.org/feedburner/ext/1.0">';
		
		$xml .= '<channel>';
		$xml .= '<title>' . $RSSTitle . '</title>';
		$xml .= '<link>' . $wgServer . '</link>';
		$xml .= '<description>A Wikia Wiki.</description>';
		$xml .= '<language>en-us</language>';
		$xml .= '<pubDate>' . date("r") . '</pubDate>';
		$xml .= '<managingEditor>' . $wgPasswordSender . '</managingEditor>';
		$xml .= '<webMaster>' . $wgPasswordSender . '</webMaster>';
		 while ($row = $dbr->fetchObject( $result ) ) {
			$title = Title::makeTitle( $row->page_namespace , $row->page_title );
			
			//get raw text
			$rev=Revision::newFromTitle($title);
			if($rev)$text = $rev->getText();
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
			global $wgContLang;
			$text =  preg_replace("@\[\[" . $wgContLang->getNsText( NS_CATEGORY ) . ":[^\]]*?].*?\]@si", '', $text);
		
			 
			
			//start looking at text after content, and force no Table of Contents
			$pos = strpos($text,"<!--start text-->");
			if($pos !== false){
				$text = substr($text,$pos);
			}
		
	
			
			$wgArticlePath_old = $wgArticlePath; //$wgServer . $wgArticlePath;
			$wgArticlePath = $wgServer . $wgArticlePath;

			
			$text = "__NOTOC__ " . $text;
			$BlurbParser = new Parser();
			$blurb_text = $BlurbParser->parse( $text, $title, $wgOut->ParserOptions(),false );
			$blurb_text = $blurb_text->getText();
			$blurb_text =  preg_replace('/&lt;comments&gt;&lt;\/comments&gt;/i', '', $blurb_text);
			$blurb_text =  preg_replace('/&lt;vote&gt;&lt;\/vote&gt;/i', '', $blurb_text);

			$wgArticlePath = $wgArticlePath_old;

			
			//cheap hack to fix non-existing wiki links
			$blurb_text = str_replace("<a href=\"/index.php?", "<a href=\"{$wgServer}/index.php?", $blurb_text);
	
			$fullText = $blurb_text;
			$blurb_text = strip_tags($blurb_text);
			
			//Take first N characters, and then make sure it ends on last full word
			$max = 300;
			if (strlen($blurb_text) > $max)$blurb_text = strrev(strstr(strrev(substr($blurb_text,0,$max)),' '));
	
			//Build Technorati Tags
			
			$wgRSSCategories = array ("Opinions","News","Gossip","Questions","Articles");
			
			if($wgSitename=="ArmchairGM"){
				$wgTechnoratiMainTag= "Sports";
			}else{
				$wgTechnoratiMainTag= $wgSitename;
			}
			
			$TechnoratiTags = "<a href=\"http://technorati.com/tag/{$wgTechnoratiMainTag}\" rel=\"tag\">{$wgTechnoratiMainTag}</a>";
			$dbr =& wfGetDB( DB_MASTER );
			$sql2 = "SELECT cl_to FROM " . $dbr->tableName( 'categorylinks' ) . "  WHERE cl_from=" . $row->page_id;
			
			$res2 = $dbr->query($sql2);
			while ($row2 = $dbr->fetchObject( $res2 ) ) {
				$title2 = Title::makeTitle( 14, $row2->cl_to);
				$thisTag = $title2->getText();
				if(strpos($thisTag,"Opinions by") === false){
					foreach($wgRSSCategories as $rsscategory){
						$thisTag = str_replace($rsscategory,"",$thisTag);
					}
					$thisTag = trim($thisTag);
					if($thisTag && !$this->categoryIsDate($thisTag) ){
						$thisTagURL = str_replace(" ","+",$thisTag);
						$TechnoratiTags .= ", <a href=\"http://technorati.com/tag/{$thisTagURL}\" rel=\"tag\">{$thisTag}</a>";
					}
				}
			}
			
			$fullText .= "tags: {$TechnoratiTags}";
			//end tags
			
			$xml .= '<item>';
			$xml .= '<title>' . $this->fix_xml($title->getText()) . '</title>';
			$xml .= '<description><![CDATA[' . $this->fix_xml( $blurb_text ) . ']]></description><content:encoded><![CDATA[' . $this->fix_xml($fullText) . ']]></content:encoded>';
			$xml .= '<link>' . $title->getFullURL() . '</link>';
			$xml .= '<pubDate>' . $this->get_rfc_date($row->published_date) . '</pubDate>';
			$xml .= '<comments>' . $title->getFullURL() . '#allcomments</comments>';
			$xml .= '<guid isPermaLink="true">' . $title->getFullURL()  . '</guid>';
			$xml .= '</item>';
		}
		$xml .= '</channel>';
		$xml .= '</rss>';
		
		if($this->StaticXML == true){
			if($Category != ""){
				$outputFile = $Category;
			}else{
				$outputFile = "popular";
			}
			$fp = fopen($wgRSSDirectory . $outputFile . ".xml", "w") or die();
			fwrite($fp, $xml);
			fclose($fp);
		}else{
			return $xml;
			//$wgOut->setSyndicated( true );
			//$wgOut->addHTML( $xml );
		}
		
	}
}
?>