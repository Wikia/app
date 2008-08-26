<?php

/**
 *
 */
class Link{

	
	/**
	 * Constructor
	 * @private
	 */
	/* private */ function __construct() {

		
	}
	
	static $link_types = array(
		1 => "Arrest Report",
		2 => "Awesome",
		3 => "Cool",
		4 => "Funny",
		6 => "Interesting",
		7 => "Obvious",
		8 => "OMG WTF?!?",
		9 => "Rumor",
		10 => "Scary",
		11 => "Stupid"
	);

	static function getSubmitLinkURL(){
		$title = Title::makeTitle( NS_SPECIAL, "LinkSubmit");
		return $title->escapeFullURL();
	}
	
	static function getLinkAdminURL(){
		$title = Title::makeTitle( NS_SPECIAL, "LinkApprove");
		return $title->escapeFullURL();
	}
	
	static function getHomeLinkURL(){
		$title = Title::makeTitle( NS_SPECIAL, "LinksHome");
		return $title->escapeFullURL();
	}
	
	static function canAdmin(){
		global $wgUser;

		if( $wgUser->isAllowed("linkadmin") || in_array( "linkadmin", $wgUser->getGroups() ) ){
			return true;
		}
		
		return false;
	}
	
	public static function isURL($code){
		$text = ereg("^(http|https|ftp)://(www\.)?.*$", $code );
		if($text){
			return true;
		}else{
			return false;
		}
	}
	
	public function addLink($title, $desc, $url, $type){		
		global $wgUser;
		
		$dbr =& wfGetDB( DB_MASTER );

		$dbr->insert( '`link`',
		array(
			'link_name' => $title,
			'link_page_id' => 0,
			'link_url' => $url,
			'link_description' => $desc,
			'link_type' => $type,
			'link_status' => 0,
			'link_submitter_user_id' => $wgUser->getID(),
			'link_submitter_user_name' => $wgUser->getName(),
			'link_submit_date' => date("Y-m-d H:i:s"),
			), $fname
		);
		$stats = new UserStatsTrack( $wgUser->getID() , $wgUser->getName());
		$stats->incStatField("links_submitted");
		
	}

	public function approveLink($id){
		
		$link = $this->getLink($id);
		
		//create wiki page
		$link_title = Title::makeTitleSafe( NS_LINK, $link["title"] );
		$article = new Article( $link_title );
		$article->doEdit( $link["url"], "new link" );
		$new_page_id = $article->getID();
		
		//tie link record to wiki page
		$dbw =& wfGetDB( DB_MASTER );
		$dbw->update( '`link`',
			array( /* SET */
			'link_page_id' => $new_page_id,
			'link_approved_date' => date("Y-m-d H:i:s")
			), array( /* WHERE */
			'link_id' => $id
			), ""
		);
		
		$stats = new UserStatsTrack( $link["user_id"] , $link["user_name"] );
		$stats->incStatField("links_approved");
	}

	public function getLinkByPageID($page_id){
		global $wgOut;
		
		if( !is_numeric($page_id) ) return "";
		
		$dbr =& wfGetDB( DB_SLAVE );
		$sql = "SELECT link_name, link_url, link_description, link_type, link_status, link_page_id,
			link_submitter_user_id, link_submitter_user_name
			from link
			WHERE link_page_id = {$page_id} LIMIT 0,1";
		
		$res = $dbr->query($sql);
		$row = $dbr->fetchObject( $res );

		if($row){
			$link["id"]= $row->link_id;
			$link["title"]= $row->link_name;
			$link["url"]= $row->link_url;
			$link["type"]= $row->link_type;
			$link["description"]= $wgOut->parse($row->link_description,false);
			$link["type_name"] = self::getLinkType( $row->link_type );
			$link["status"]= $row->link_status;
			$link["page_id"]= $row->link_page_id;
			$link["user_id"]= $row->link_submitter_user_id;
			$link["user_name"]= $row->link_submitter_user_name;
			
			
		}
		return $link;
	}

	static function getLinkTypes( ){
		global $wgLinkFilterTypes;
		
		if( is_array( $wgLinkFilterTypes ) ){
			return $wgLinkFilterTypes;
		}else{
			return self::$link_types;
		}
	}
	
	static function getLinkType( $index ){
		global $wgLinkFilterTypes;
		
		if( is_array( $wgLinkFilterTypes ) ){
			return $wgLinkFilterTypes[ $index ];
		}else{
			return self::$link_types[ $index ];
		}
	}
	
	public function getLink($id){
		global $wgOut;
		
		if( !is_numeric($id) ) return "";
		
		$dbr =& wfGetDB( DB_SLAVE );
		$sql = "SELECT link_name, link_url, link_description, link_type, link_status, link_page_id,
			link_submitter_user_id, link_submitter_user_name
			from link
			WHERE link_id = {$id} LIMIT 0,1";
		$res = $dbr->query($sql);
		$row = $dbr->fetchObject( $res );
		if($row){
			$link["id"]= $row->link_id;
			$link["title"]= $row->link_name;
			$link["url"]= $row->link_url;
			$link["description"]= $wgOut->parse($row->link_description,false);
			$link["type"]= $row->link_type;
			$link["type_name"] = self::getLinkType( $row->link_type );
			$link["status"]= $row->link_status;
			$link["page_id"]= $row->link_page_id;
			$link["user_id"]= $row->link_submitter_user_id;
			$link["user_name"]= $row->link_submitter_user_name;
			
		}
		return $link;
	}
}

class LinkList{
	
	/**
	 * Constructor
	 * @private
	 */
	/* private */ function __construct() {

		
	}
	
	public function getLinkList($status,$type, $limit=0,$page=0,$order="link_submit_date"){
		global $wgUser, $wgOut, $wgParser;
		$dbr =& wfGetDB( DB_SLAVE );
		
		$params['ORDER BY'] = "$order desc";
		if($limit)$params['LIMIT'] = $limit;
		if($page)$params["OFFSET"] = $page * $limit - ($limit); 
		
		if( $type > 0 ){
			$where["link_type"] = $type;
		}
		if( is_numeric( $status ) ){
			$where["link_status"] = $status;
		}
		
		$dbr =& wfGetDB( DB_MASTER );
		$res = $dbr->select( '`link` LEFT JOIN wikia_page_stats on link_page_id = ps_page_id', 
				array('link_id','link_page_id','link_type','link_status', 'link_name', 'link_description', 'link_url',
					'link_submitter_user_id', 'link_submitter_user_name', 
					'link_submit_date', 'UNIX_TIMESTAMP(link_submit_date) as submit_timestamp', 'UNIX_TIMESTAMP(link_approved_date) as approved_timestamp',
					'comment_count'
				),
			$where, __METHOD__, 
			$params
		);
		$links = array();
		while ($row = $dbr->fetchObject( $res ) ) {
			$link_page = Title::makeTitleSafe( NS_LINK, $row->link_name);
			 $links[] = array(
				 "id"=>$row->link_id,"timestamp"=>($row->submit_timestamp ) , "approved_timestamp"=>($row->approved_timestamp ),
				 "url"=>$row->link_url, "title" => $row->link_name, "description" => ($row->link_description),"page_id" => $row->page_id,
				 "type"=>$row->link_type,"status"=>$row->link_status, "type_name" => Link::getLinkType( $row->link_type ),
				 "user_id"=>$row->link_submitter_user_id, "user_name"=>$row->link_submitter_user_name,
				 "wiki_page" => $link_page->escapeFullURL(), "comments" => (($row->comment_count)?$row->comment_count:0)
				 );
		}
		return $links;
	}

	public function getLinkListCount($status,$type){
		global $wgUser;
		$dbr =& wfGetDB( DB_SLAVE );
	
		
		if( $type > 0 ){
			$where["link_type"] = $type;
		}
		if( is_numeric( $status ) ){
			$where["link_status"] = $status;
		}
		
		$dbr =& wfGetDB( DB_MASTER );
		$s = $dbr->selectrow( '`link` ', 
				array('count(*) as count'
				),
			$where, __METHOD__, 
			$params
		);
		
		return $s->count;
	}	
	
	function updateRSS( $count = 10 ){

		global $wgUser, $wgSitename;
		global $wgLang;
		global $wgContLang;
		global $wgOut;
		global $IP;
		global $wgPasswordSender, $wgDBname, $wgServer, $wgRSSDirectory;

		if( !$wgRSSDirectory ){
			return "";
		}
		
		$xml = '<?xml version="1.0"?>';
	
		$xml .= '<rss version="2.0" xmlns:content="http://purl.org/rss/1.0/modules/content/" xmlns:feedburner="http://rssnamespace.org/feedburner/ext/1.0">';
		
		$xml .= '<channel>';
		$xml .= '<title>' . $wgSitename . ' ' . 'Links</title>';
		$xml .= '<link>' . $wgServer . '</link>';
		$xml .= '<description>A Wikia Wiki.</description>';
		$xml .= '<language>en-us</language>';
		$xml .= '<pubDate>' . date("r") . '</pubDate>';
		$xml .= '<managingEditor>' . $wgPasswordSender . '</managingEditor>';
		$xml .= '<webMaster>' . $wgPasswordSender . '</webMaster>';
		
		$links = $this->getLinkList(LINK_APPROVED_STATUS, $type, $count, 0);
		
		foreach($links as $link){
			
			$url = parse_url( $link["url"] );
			$domain = $url["host"];
			
			$xml .= '<item>';
			$xml .= '<title>[' . $link["type_name"] . '] ' . $link["title"] . '</title>';
			$xml .= '<description><![CDATA[' . $domain . ']]></description>';
			$xml .= '<link>' . $link["wiki_page"] . '</link>';
			//$xml .= '<pubDate>' . $this->get_rfc_date($link["approved_timestamp"]) . '</pubDate>';
			$xml .= '<guid isPermaLink="true">' . $link["wiki_page"]  . '</guid>';
			$xml .= '</item>';
		}
		$xml .= '</channel>';
		$xml .= '</rss>';
		
		$outputFile = "links";

		$fp = fopen($wgRSSDirectory . "/" . $outputFile . ".xml", "w") or die();
		fwrite($fp, $xml);
		fclose($fp);
		
	}
	
	function get_rfc_date($datestr){
		 $newstime = $datestr; //the date of your item in the database
		 list($date, $hours) = split(' ', $newstime);
		 list($year,$month,$day) = split('-',$date);
		 list($hour,$min,$sec) = split(':',$hours);
		 //returns the date ready for the rss feed
		  $date = date("r", (mktime($hour, $min, $sec, $month, $day, $year)) - 60 * 60 * 4);
		 return $date;
	}
}
	
?>