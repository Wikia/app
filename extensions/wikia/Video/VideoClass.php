<?php

//GLOBAL VIDEO NAMESPACE REFERENCE
if ( !defined('NS_VIDEO') ) {
	define( 'NS_VIDEO', 400 );
}

class Video{
	
	var	$name,
		$title,
		$exists,
		$height,
		$width,
		$ratio,
		$url,
		$submitter_user_name,
		$submitter_user_id,
		$create_date,
		$type;
	
	public function __construct( $title ) {
		if( !is_object( $title ) ) {
			throw new MWException( 'Video constructor given bogus title.' );
		}
		$this->title =& $title;
		$this->name = $title->getDBkey();
		$this->height = 400;
		$this->width = 400;
		$this->ratio = 1;
		$this->dataLoaded = false;
	}
	
	/**
	 * Create an Video object from an video name
	 *
	 * @param string $name name of the video, used to create a title object using Title::makeTitleSafe
	 * @public
	 */
	public static function newFromName( $name ) {
		$title = Title::makeTitleSafe( NS_VIDEO, $name );
		if ( is_object( $title ) ) {
			return new Video( $title );
		} else {
			return NULL;
		}
	}
	
	public function addVideo($url, $type, $categories, $watch=""){
		global $wgUser;
		
		$dbr = wfGetDB( DB_MASTER );
	
		$now = $dbr->timestamp();
		
		$desc = "added video [[" . Title::makeTitle(NS_VIDEO,$this->getName())->getPrefixedText() . "]]";
		# Test to see if the row exists using INSERT IGNORE
		# This avoids race conditions by locking the row until the commit, and also
		# doesn't deadlock. SELECT FOR UPDATE causes a deadlock for every race condition.
		$dbr->insert( 'video',
			array(
				'video_name' => $this->getName(),
				'video_url'=> $url,
				'video_type' => $type,
				'video_user_id' => $wgUser->getID(),
				'video_user_name' => $wgUser->getName(),
				'video_timestamp' => $now
			),
			__METHOD__,
			'IGNORE'
		);

		$category_wiki_text = "";
		if( $dbr->affectedRows() == 0 ) {
			$desc = "updated video [[" . Title::makeTitle(NS_VIDEO,$this->getName())->getPrefixedText() . "]]";
			
			//clear cache
			global $wgMemc;
			$key = wfMemcKey( 'video', 'page', str_replace(" ", "_", $this->getName()) );
			$wgMemc->delete( $key );
			
			# Collision, this is an update of a video
			# Insert previous contents into oldvideo
			$dbr->insertSelect( 'oldvideo', 'video',
				array(
					'ov_name' => 'video_name',
					'ov_archive_name' => $dbr->addQuotes( gmdate( 'YmdHis' ) . "!{$this->getName()}" ),
					'ov_url'=> 'video_url',
					'ov_type' => 'video_type',
					'ov_user_id' => 'video_user_id',
					'ov_user_name' => 'video_user_name',
					'ov_timestamp' => 'video_timestamp'
				), array( 'video_name' => $this->getName() ), __METHOD__
			);

			# Update the current video row
			$dbr->update( 'video',
				array( /* SET */
					'video_url'=> $url,
					'video_type' => $type,
					'video_user_id' => $wgUser->getID(),
					'video_user_name' => $wgUser->getName(),
					'video_timestamp' => $now
				), array( /* WHERE */
					'video_name' => $this->getName()
				), __METHOD__
			);
		} 
		
		$descTitle = $this->getTitle();
		$article = new Article( $descTitle );
		$minor = false;
		$watch = $watch || $wgUser->isWatched( $descTitle );
		$suppressRC = true; // There's already a log entry, so don't double the RC load
		
		if( $categories ){
			$categories .= "|Videos";
		}else{
			$categories = "Videos";
		}
		
		//Loop through category variable and individually build Category Tab for Wiki text
		if($categories){
			$categories_array = explode( "|", $categories );
			foreach($categories_array as $ctg){
				$ctg = trim($ctg);
				if($ctg){
					$tag = "[[Category:{$ctg}]]";
					if( strpos($category_wiki_text, $tag) === false ){
						$category_wiki_text .= "\n{$tag}";
					}
				}
			}
		}
	
		if( $descTitle->exists() ) {
			# Invalidate the cache for the description page
			$descTitle->invalidateCache();
			$descTitle->purgeSquid();
		} else {
			// New video; create the description page.
			// Supress the recent changes bc it will appear in the log/video
			$article->doEdit( $category_wiki_text, $desc, EDIT_SUPPRESS_RC );
		}

		if( $watch ) {
			$wgUser->addWatch( $descTitle );
		}
			
		# Add the log entry
		$log = new LogPage( 'video' );
		$log->addEntry( 'video', $descTitle, $desc );

		# Commit the transaction now, in case something goes wrong later
		# The most important thing is that videos don't get lost, especially archives
		$dbr->immediateCommit();
		
	
	}
	/**
	 * Try to load video metadata from memcached. Returns true on success.
	 */
	private function loadFromCache() {
		global $wgMemc;
		
		wfProfileIn( __METHOD__ );
		$this->dataLoaded = false;
		
		$key = wfMemcKey( 'video', 'page', "$this->name" );
		$data = $wgMemc->get( $key );
		
		if (!empty($data) && is_array($data) ){
			$this->url = $data["url"];
			$this->type = $data["type"];
			$this->submitter_user_id = $data["user_id"];
			$this->submitter_user_name = $data["user_name"];
			$this->create_date = $data["create_date"];
			$this->dataLoaded = true;
			$this->exists = true;
		}
		
		
		if ( $this->dataLoaded ) {
			wfDebug( "loaded Video:$this->name from cache\n" );
			wfIncrStats( 'video_cache_hit' );
		} else {
			wfIncrStats( 'video_cache_miss' );
		}

		wfProfileOut( __METHOD__ );
		return $this->dataLoaded;
	}
	
	/**
	 * Save the video data to memcached
	 */
	private function saveToCache() {
		global $wgMemc;
		$key = wfMemcKey( 'video', 'page', "$this->name" );
		if ( $this->exists()   ) {
			$cachedValues = array(
				'url'    => $this->url,
				'type'       => $this->type,
				'user_id'  => $this->submitter_user_id,
				'user_name' => $this->submitter_user_name,
				'create_date' => $this->create_date);
			$wgMemc->set( $key, $cachedValues, 60 * 60 * 24 * 7 ); // A week
		} else {
			// However we should clear them, so they aren't leftover
			// if we've deleted the file.
			$wgMemc->delete( $key );
		}
	}
	
	/**
	 * Load video from the DB
	 */
	function loadFromDB() {
		wfProfileIn( __METHOD__ );

		$dbr = wfGetDB( DB_MASTER );
	
		$row = $dbr->selectRow( 'video',
			array( 'video_url', 'video_type', 'video_user_name', 'video_user_id', 'video_timestamp' ),
			array( 'video_name' => $this->name ), __METHOD__ );
		if ( $row ) {
			$this->url = $row->video_url;
			$this->exists = true;
			$this->type = $row->video_type;
			$this->submitter_user_name = $row->video_user_name;
			$this->submitter_user_id = $row->video_user_id; 
			$this->create_date = $row->video_timestamp; 
		} 
	 
		# Unconditionally set loaded=true, we don't want the accessors constantly rechecking
		$this->dataLoaded = true;
		wfProfileOut( __METHOD__ );
	}
	
	/**
	 * Load image metadata from cache or DB, unless already loaded
	 */
	function load() {
		if ( !$this->dataLoaded ) {
			if ( !$this->loadFromCache() ) {
				$this->loadFromDB();
				$this->saveToCache();
			}
			$this->dataLoaded = true;
		}
	}
	
	
	/**
	 * Return the name of this video
	 * @public
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * Return the associated title object
	 * @public
	 */
	public function getTitle() {
		return $this->title;
	}
	
	/**
	 * Return the url of this video
	 * @public
	 */
	public function getURL() {
		$this->load();
		return strip_tags($this->url);
	}
	
	/**
	 * Return the type of this video
	 * @public
	 */
	public function getType() {
		$this->load();
		return $this->type;
	}
	
	/**
	 * Return if the Video exists
	 * @public
	 */
	public function exists() {
		$this->load();
		return $this->exists;
	}

	public function getEmbedCode(){
		switch( $this->getType() ){
			case "youtube":
			$provider = new YouTubeVideo($this);
			break;
			case "google":
			$provider = new GoogleVideo($this);
			break;
			case "metacafe":
			$provider = new MetaCafeVideo($this);
			break;
			case "myspace":
			$provider = new MySpaceVideo($this);
			break;
			case "dailymotion":
			$provider = new DailyMotionVideo($this);
			break;
			case "thenewsroom":
			$provider = new NewsRoomVideo($this);
			break;
			default:
			$provider = new FlashVideo($this);
			break;
		 
		}
		
		return $provider->getEmbedCode();
	}
	
	public static function isURL($code){
		return preg_match('%^(?:http|https|ftp)://(?:www\.)?.*$%i', $code) ? true : false;
	}
	
	public static function getURLfromEmbedCode($code){
		preg_match("/embed .*src=(\"([^<\"].*?)\"|\'([^<\"].*?)\'|[^<\"].*?)(.*flashvars=(\"([^<\"].*?)\"|\'([^<\"].*?)\'|[^<\"].*?\s))?/i",$code,$matches );
		
		if( $matches[2] ){
			$embed_code = $matches[2];
		}
		//some providers (such as myspace) have flashvars='' in the embed code, and the base url in the src=''
		//so we need to grab the flashvars and append it to get the real url
		$flash_vars = $matches[6];
		if( $flash_vars ){
			if(strpos("?",$flash_vars) !== false){
				$embed_code .= "&";
			}else{
				$embed_code .= "?";
			}
			$embed_code .= $flash_vars;
		}
		return $embed_code;
	}
	
	public static function getProviderByURL($url){
		
		$text = preg_match("/youtube\.com/i", $url );
		if($text){
			return "youtube";
		}
		$text = preg_match("/metacafe\.com/i", $url );
		if($text){
			return "metacafe";
		}
		$text = preg_match("/google\.com/i", $url );
		if($text){
			return "google";
		}
		$text = preg_match("/myspace(tv)?\.com/i", $url );
		if($text){
			return "myspace";
		}
		$text = preg_match("/dailymotion\.com/i", $url );
		if($text){
			return "dailymotion";
		}
		$text = preg_match("/thenewsroom\.com/i", $url );
		if($text){
			return "thenewsroom";
		}
		if(!$text){
			return "unknown";
		}
	}
	
	public function setWidth($width){
		if( is_numeric($width) ){
			$this->width = $width;
		}
	}
	
	public function setHeight($height){
		if(  is_numeric($height) ){
			$this->height = $height;
		}
	}
	
	public function getWidth() {
		return $this->width;
	}
	
	public function getHeight() {
		return floor($this->getWidth() / $this->ratio);
		//return $this->height;
	}
	
	
	public function getEmbedThisCode() {
		$video_name = htmlspecialchars( $this->getName(), ENT_QUOTES );
		return "[[Video:{$video_name}|{$this->getWidth()}px]]";
		//return "<video name=\"{$this->getName()}\" width=\"{$this->getWidth()}\" height=\"{$this->getHeight()}\"></video>";
	}
	

	
	/**
	 * Return the image history of this video, line by line.
	 * starts with current version, then old versions.
	 * uses $this->historyLine to check which line to return:
	 *  0      return line for current version
	 *  1      query for old versions, return first one
	 *  2, ... return next old version from above query
	 *
	 * @public
	 */
	function nextHistoryLine() {
		$dbr = wfGetDB( DB_SLAVE );

		if ( empty($this->historyLine) ) {// called for the first time, return line from cur
			$this->historyRes = $dbr->select( 'video',
				array(
					'video_url',
					'video_type',
					'video_user_id','video_user_name',
					'video_timestamp',
					"'' AS ov_archive_name"
				),
				array( 'video_name' => $this->title->getDBkey() ),
				__METHOD__
			);
			if ( 0 == $dbr->numRows( $this->historyRes ) ) {
				return FALSE;
			}
		} else if ( $this->historyLine == 1 ) {
			$this->historyRes = $dbr->select( 'oldvideo',
				array(
					'ov_url AS video_url',
					'ov_type AS video_type',
					'ov_user_id AS video_user_id',
					'ov_user_name AS video_user_name',
					'ov_timestamp AS video_timestamp',
					'ov_archive_name'
				),
				array( 'ov_name' => $this->title->getDBkey() ),
				__METHOD__,
				array( 'ORDER BY' => 'ov_timestamp DESC' )
			);
		}
		$this->historyLine ++;

		return $dbr->fetchObject( $this->historyRes );
	}

	/**
	 * Reset the history pointer to the first element of the history
	 * @public
	 */
	function resetHistory() {
		$this->historyLine = 0;
	}	
	
}



class YouTubeVideo extends FlashVideo{
	
	var	$video,
		$id,
		$url;
		
	
	public function __construct( $video ) {
		if( !is_object( $video ) ) {
			throw new MWException( 'youtube constructor given bogus video object.' );
		}
		$this->video =& $video;
		$this->video->ratio = 640/385;
		$this->id = $this->extractYouTubeID( $this->video->getURL() );
		$this->url = "http://www.youtube.com/v/{$this->id}";
		return $this;
	}
	
	
	private function extractYoutubeID(){
		
		//standard youtube url
		$url = $this->video->getURL();
		$standard_youtube_inurl = strpos( strtoupper( $url ), "WATCH?V=");
		
		$id = "";
		if( $standard_youtube_inurl !== false){
			$id = substr( $url , $standard_youtube_inurl+8, strlen($url) );
		}
		if( empty($id) ){
			$id_test = str_replace("http://www.youtube.com/v/","",$url);
			if( $id_test != $url ){
				$id = $id_test;	
			}
		}
		return $id;
		
	}

}

class GoogleVideo extends FlashVideo{
	
	var	$video,
		$id,
		$url;
		
	
	public function __construct( $video ) {
		if( !is_object( $video ) ) {
			throw new MWException( 'youtube constructor given bogus video object.' );
		}
		$this->video =& $video;
		$this->video->ratio = 425/355;
		$this->id = $this->extractID( $this->video->getURL() );
		$this->url = "http://video.google.com/googleplayer.swf?docId={$this->id}";
		return $this;
	}
	
	
	private function extractID(){
		
		//standard google browser url
		$url = $this->video->getURL();
		$standard_inurl = strpos( strtoupper( $url ), "VIDEOPLAY?DOCID=");
		
		if( $standard_inurl !== false){
			$id = substr( $url , $standard_inurl+ strlen("VIDEOPLAY?DOCID=") , strlen($url) );
		}
		if(!$id){
			$id_test = preg_replace("%http\:\/\/video\.google\.com\/googleplayer\.swf\?docId=%i", "", $url);
			if( $id_test != $url ){
				$id = $id_test;	
			}
		}
		return $id;
		
	}

}

class MySpaceVideo extends FlashVideo{
	
	var	$video,
		$id,
		$url;
		
	
	public function __construct( $video ) {
		if( !is_object( $video ) ) {
			throw new MWException( 'myspace constructor given bogus video object.' );
		}
		$this->video =& $video;
		$this->video->ratio = 430/346;
		$this->id = $this->extractID( $this->video->getURL() );
		$this->url = "http://lads.myspace.com/videos/vplayer.swf?m={$this->id}&v=2&type=video";
		return $this;
	}
	
	
	private function extractID(){
		$url = $this->video->getURL();
		//http://myspacetv.com/index.cfm?fuseaction=vids.individual&videoid=1388509
		//http://lads.myspace.com/videos/vplayer.swf?m=1505336&v=2&type=video
		$id = preg_replace("%http\:\/\/(vids\.|www\.)?myspace(tv)?\.com/index\.cfm\?fuseaction=vids\.individual&VideoID=%i", "", $url);
		$id = preg_replace("%http\:\/\/(vids\.|www\.|lads\.)?myspace(tv)?\.com\/videos\/vplayer\.swf\?m=%i", "", $id);
		//$id = preg_replace("%&v=2&type=video%i", "", $id); 
		return $id;
	}

}

class DailyMotionVideo extends FlashVideo{
	
	var	$video,
		$id,
		$url;
		
	
	public function __construct( $video ) {
		if( !is_object( $video ) ) {
			throw new MWException( 'DailyMotionVideo constructor given bogus video object.' );
		}
		$this->video =& $video;
		$this->video->ratio = 425/335;
		$this->id = $this->extractID( $this->video->getURL() );
		$this->url = "http://www.dailymotion.com/swf/{$this->id}";
		return $this;
	}
	
	
	private function extractID(){
		$url = $this->video->getURL();
		$id = preg_replace("%http\:\/\/www\.dailymotion\.com\/(swf|video)\/%i", "", $url);
	
		return $id;
	}

}

class MetaCafeVideo extends FlashVideo{
	public function __construct (&$video){
		parent::__construct($video);
		$this->video->ratio = 400/345;
		$this->url = $this->video->getURL();
		$this->extractID( $this->video->getURL() );
	}
	
	private function extractID(){
		//standard google browser url
		$url = $this->video->getURL();
		$standard_inurl = strpos( strtoupper( $url ), "HTTP://WWW.METACAFE.COM/WATCH/");
		
		if( $standard_inurl !== false){
			$id = substr( $url , $standard_inurl+ strlen("HTTP://WWW.METACAFE.COM/WATCH/") , strlen($url) );
			$last_char = substr( $id,-1 ,1 );
			
			if($last_char == "/"){
				$id = substr( $id , 0 , strlen($id)-1 );
			}
			$this->url = "http://www.metacafe.com/fplayer/{$id}.swf";
		}
	}
}

class NewsRoomVideo extends FlashVideo{
	public function __construct (&$video){
		parent::__construct($video);
		$this->video->width = 300;
		$this->video->height = 325;
		$this->video->ratio = 300/325;
	}
}

class FlashVideo{
	
	var	$video,
		$id,
		$url;
	
	public function __construct( $video ) {
		if( !is_object( $video ) ) {
			throw new MWException( 'flash video constructor given bogus video object.' );
		}

		$this->video =& $video;
		$this->url = $this->video->getURL();
		return $this;
	}

	public function getEmbedCode(){
		$output = "";
		$output .= "<object width=\"{$this->video->getWidth()}px\" height=\"{$this->video->getHeight()}px\">";
		$output .= "<param name=\"movie\" value=\"{$this->url}\" ></param>";
		$output .= "<param name=\"wmode\" value=\"transparent\" ></param>";
		$output .= "<embed  wmode=\"transparent\" base=\".\" allowScriptAccess=\"always\" src=\"{$this->url}\" type=\"application/x-shockwave-flash\" width=\"{$this->video->getWidth()}px\" height=\"{$this->video->getHeight()}px\">";
		$output .= "</embed>";
		$output .= "</object>";
		return $output;
	}

}
?>
