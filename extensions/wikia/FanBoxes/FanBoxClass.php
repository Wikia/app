<?php

//GLOBAL VIDEO NAMESPACE REFERENCE
if( !defined( 'NS_FANTAG' ) ) {
	define( 'NS_FANTAG', 600 );
}

class FanBox{
	
	var	$name,
		$title,
		$exists,
		$create_date,
		$type,
		$fantag_id,
		$fantag_title,
		$fantag_left_text,
		$fantag_left_textcolor,
		$fantag_left_bgcolor,
		$fantag_right_text,
		$fantag_right_textcolor,
		$fantag_right_bgcolor, 
		$fantag_image_name,
		$fantag_left_textsize,
		$fantag_right_textsize,								
		$userft_fantag_id;
	
	public function __construct( $title ) {
		if( !is_object( $title ) ) {
			throw new MWException( 'Video constructor given bogus title.' );
		}
		$this->title =& $title;
		$this->name = $title->getDBkey();
		$this->dataLoaded = false;
	}
	
	/**
	 * Create a Fantag object from a fantag name
	 *
	 * @param string $name name of the video, used to create a title object using Title::makeTitleSafe
	 * @public
	 */
	public static function newFromName( $name ) {
		$title = Title::makeTitleSafe( NS_FANTAG, $name );
		
		if ( is_object( $title ) ) {
			return new FanBox( $title );
		} else {
			return NULL;
		}
	}
	
	//insert info into fantag database when user creates fantag
	
	public function addFan($fantag_left_text,$fantag_left_textcolor,$fantag_left_bgcolor,$fantag_right_text,$fantag_right_textcolor,$fantag_right_bgcolor, $fantag_image_name, $fantag_left_textsize, $fantag_right_textsize, $categories){
		global $wgUser, $wgContLang;
		
		$dbr = wfGetDB( DB_MASTER );
		
		$descTitle = $this->getTitle();
		$desc = "new userbox";
		$article = new Article( $descTitle );
		
		$categories_wiki = "";
		if($categories){
			$categories_a = explode(",", $categories);
			foreach($categories_a as  $category  ){
				$categories_wiki .= "[[" . $wgContLang->getNsText( NS_CATEGORY ) . ": " . trim($category) . "]]\n";
			}
		}
		$article = new Article( $this->title );
	
		$article_content = $this->buildWikiText() . "\n\n" . $this->getBaseCategories() . "\n" . $categories_wiki . "\n__NOEDITSECTION__";
		
		if( $descTitle->exists() ) {
			# Invalidate the cache for the description page
			$descTitle->invalidateCache();
			$descTitle->purgeSquid();
		} else {
			// New fantag; create the description page.
			$article->doEdit($this->buildWikiText() . "\n\n" . $article_content, $desc);
		}
		
		# Test to see if the row exists using INSERT IGNORE
		# This avoids race conditions by locking the row until the commit, and also
		# doesn't deadlock. SELECT FOR UPDATE causes a deadlock for every race condition.
		$dbr->insert( 'fantag',
			array(
				'fantag_title' => $this->getName(),
				'fantag_left_text' => $fantag_left_text,
				'fantag_left_textcolor' => $fantag_left_textcolor,
				'fantag_left_bgcolor' => $fantag_left_bgcolor,
				'fantag_right_text' => $fantag_right_text,
				'fantag_right_textcolor' => $fantag_right_textcolor,
				'fantag_right_bgcolor' => $fantag_right_bgcolor,
				'fantag_date' => date("Y-m-d H:i:s"),
				'fantag_pg_id' => $article->getID(),
				'fantag_user_id' => $wgUser->getID(),
				'fantag_user_name' => $wgUser->getName(),
				'fantag_image_name' => $fantag_image_name,
				'fantag_left_textsize' => $fantag_left_textsize,
				'fantag_right_textsize' => $fantag_right_textsize,								
			),
			__METHOD__,
			'IGNORE'
		);
		return $dbr->insertId();
		
	}
	
	//insert info into user_fantag table when user creates fantag or grabs it
	
	public function addUserFan($userft_fantag_id){
		global $wgUser;
		
		$dbr = wfGetDB( DB_MASTER );
		$dbr->insert( '`user_fantag`',
		array(
			'userft_fantag_id' => $userft_fantag_id,
			'userft_user_id' => $wgUser->getID(),
			'userft_user_name' => $wgUser->getName(),
			'userft_date' => date("Y-m-d H:i:s"),
			), __METHOD__
		);	

	}
	
	public function buildWikiText(){
		$output = "";
		$output .= "left_text:{$this->getFanBoxLeftText()}\n";
		$output .= "left_textcolor:{$this->getFanBoxLeftTextColor()}\n";
		$output .= "left_bgcolor:{$this->getFanBoxLeftBgColor()}\n";
		$output .= "right_text:{$this->getFanBoxRightText()}\n";
		$output .= "right_textcolor:{$this->getFanBoxRightTextColor()}\n";
		$output .= "right_bgcolor:{$this->getFanBoxRightBgColor()}\n";
		$output .= "left_textsize:{$this->getFanBoxLeftTextSize()}\n";
		$output .= "right_textsize:{$this->getFanBoxRightTextSize()}\n";
			
		$output = "<!--{$output}-->";
		return $output;			
	}
	
	public function getBaseCategories(){
		global $wgUser, $wgContLang;
		$creator = $this->getUserName();
		if( !$creator) $creator = $wgUser->getName();
		$ctg = "";
		$ctg .= "{{DEFAULTSORT:{{PAGENAME}}}}";
		$ctg .= "[[" . $wgContLang->getNsText( NS_CATEGORY ) . ":Userboxes]]\n";
		return $ctg;
	}
	
	//update fan
	
	public function updateFan($fantag_left_text,$fantag_left_textcolor,$fantag_left_bgcolor,$fantag_right_text,$fantag_right_textcolor,$fantag_right_bgcolor, $fantag_image_name, $fantag_left_textsize, $fantag_right_textsize, $fanboxid, $categories){
		global $wgUser, $wgMemc, $wgContLang;
		
		$dbr = wfGetDB( DB_MASTER );
		
		$dbr->update( 'fantag',
			array( 	'fantag_left_text' => $fantag_left_text,
				'fantag_left_textcolor' => $fantag_left_textcolor,
				'fantag_left_bgcolor' => $fantag_left_bgcolor,
				'fantag_right_text' => $fantag_right_text,
				'fantag_right_textcolor' => $fantag_right_textcolor,
				'fantag_right_bgcolor' => $fantag_right_bgcolor,
				'fantag_image_name' => $fantag_image_name,
				'fantag_left_textsize' => $fantag_left_textsize,
				'fantag_right_textsize' => $fantag_right_textsize,								
				),
			array( 'fantag_pg_id' => $fanboxid ),
			__METHOD__ );	
		$key = wfMemcKey( 'fantag', 'page', "$this->name" );
		$wgMemc->delete( $key );
		
		$categories_wiki = "";
		if($categories){
	
			$categories_a = explode(",", $categories);
			foreach($categories_a as  $category  ){
				$categories_wiki .= "[[" . $wgContLang->getNsText( NS_CATEGORY ) . ": " . trim($category) . "]]\n";
			}
		}
		$article = new Article( $this->title );
	
		$article_content = $this->buildWikiText() . "\n" . $this->getBaseCategories() . "\n" . $categories_wiki . "\n__NOEDITSECTION__";
		
		$article->doEdit($article_content, "update fan tag");
	}
	
	
	//remove fantag from user_fantag table when user removes it
	
		function removeUserFanBox($userft_fantag_id){
		global $wgUser;
		$dbr =& wfGetDB( DB_MASTER );
		$sql = "DELETE FROM user_fantag WHERE userft_user_name = '{$wgUser->getName()}' && userft_fantag_id = {$userft_fantag_id}";
		$res = $dbr->query($sql);
		
	}

	
	//change count of fantag when user adds or removes it
	
	function changeCount ($FanBoxId, $Number){
		global $wgUser;
		$dbr =& wfGetDB( DB_MASTER );

		$sql = "SELECT fantag_count FROM fantag WHERE fantag_id= {$FanBoxId}";		
		$res = $dbr->query($sql);
		$row = $dbr->fetchObject( $res );
		$count=$row->fantag_count;
		
		$sql2 = "UPDATE fantag SET fantag_count={$count}+{$Number} WHERE fantag_id= {$FanBoxId}";
		$res2 = $dbr->query($sql2);
	}
	

	
	/**
	 * Try to load fan metadata from memcached. Returns true on success.
	 */
	private function loadFromCache() {
		global $wgMemc;
		
		wfProfileIn( __METHOD__ );
		$this->dataLoaded = false;
		
		$key = wfMemcKey( 'fantag', 'page', "$this->name" );
		$data = $wgMemc->get( $key );

		if (!empty($data) && is_array($data) ){			
			$this->id = $data["id"];			
			$this->left_text = $data["lefttext"];
			$this->left_textcolor = $data["lefttextcolor"];
			$this->left_bgcolor = $data["leftbgcolor"];
			$this->right_text = $data["righttext"];
			$this->right_textcolor = $data["righttextcolor"];
			$this->right_bgcolor = $data["rightbgcolor"];
			$this->fantag_image = $data["fantagimage"];
			$this->left_textsize = $data["lefttextsize"];
			$this->right_textsize = $data["righttextsize"];
			$this->pg_id = $data["pgid"];
			$this->user_id = $data["userid"];
			$this->user_name = $data["username"];
			$this->dataLoaded = true;
			$this->exists = true;
		}
		
		
		if ( $this->dataLoaded ) {
			wfDebug( "loaded Fan:$this->name from cache\n" );
			wfIncrStats( 'video_cache_hit' );
		} else {
			wfIncrStats( 'video_cache_miss' );
		}

		wfProfileOut( __METHOD__ );
		return $this->dataLoaded;
	}
	
	/**
	 * Save the fan data to memcached
	 */
	private function saveToCache() {
		global $wgMemc;
		$key = wfMemcKey( 'fantag', 'page', "$this->name" );
		if ( $this->exists()   ) {
			$cachedValues = array(
				'id'    => $this->id,
				'lefttext'       => $this->left_text,
				'lefttextcolor'  => $this->left_textcolor,
				'leftbgcolor' => $this->left_bgcolor,
				'righttext' => $this->right_text,
				'righttextcolor' => $this->right_textcolor,
				'rightbgcolor' => $this->right_bgcolor,
				'fantagimage' => $this->fantag_image,
				'lefttextsize' => $this->left_textsize, 
				'righttextsize' => $this->right_textsize,
				'userid' => $this->user_id,
				'username' => $this->user_name,
				'pgid' => $this->pg_id);
			$wgMemc->set( $key, $cachedValues, 60 * 60 * 24 * 7 ); // A week
		} else {
			// However we should clear them, so they aren't leftover
			// if we've deleted the file.
			$wgMemc->delete( $key );
		}
	}
		
	function loadFromDB() {
		wfProfileIn( __METHOD__ );

		$dbr = wfGetDB( DB_MASTER );
	
		$row = $dbr->selectRow( 'fantag',
			array( 'fantag_id', 'fantag_left_text', 'fantag_left_textcolor', 'fantag_left_bgcolor', 
				'fantag_user_id', 'fantag_user_name',
				'fantag_right_text', 'fantag_right_textcolor', 'fantag_right_bgcolor', 'fantag_image_name', 'fantag_left_textsize', 'fantag_right_textsize', 'fantag_pg_id'),
			array( 'fantag_title' => $this->name ), __METHOD__ );
		if ( $row ) {
			$this->id = $row->fantag_id;			
			$this->left_text = $row->fantag_left_text;
			$this->exists = true;
			$this->left_textcolor = $row->fantag_left_textcolor;
			$this->left_bgcolor = $row->fantag_left_bgcolor;
			$this->right_text = $row->fantag_right_text;
			$this->right_textcolor = $row->fantag_right_textcolor;
			$this->right_bgcolor = $row->fantag_right_bgcolor;
			$this->fantag_image = $row->fantag_image_name;
			$this->left_textsize = $row->fantag_left_textsize;
			$this->right_textsize = $row->fantag_right_textsize;
			$this->pg_id = $row->fantag_pg_id;
			$this->user_id = $row->fangtag_user_id;
			$this->user_name = $row->fantag_user_name;
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
	
	public function outputFanBox(){
		global $wgTitle, $wgOut;

		$tagParser = new Parser();
		
		if($this->getFanBoxImage()){
			$fantag_image_width = 45;
			$fantag_image_height = 53;
			$fantag_image = Image::newFromName( $this->getFanBoxImage());
			$fantag_image_url = $fantag_image->createThumb($fantag_image_width, $fantag_image_height);
			$fantag_image_tag = '<img alt="" src="' . $fantag_image_url . '"/>';
		};
				
		if ($this->getFanBoxLeftText() == ""){
			$fantag_leftside = $fantag_image_tag;
		}
		else {
			$fantag_leftside = $this->getFanBoxLeftText();
			$fantag_leftside  = $tagParser->parse($fantag_leftside, $wgTitle, $wgOut->parserOptions(), false );
			$fantag_leftside  = $fantag_leftside->getText();
			 
		}
		
		$fantag_title =  Title::makeTitle( NS_FANTAG  , $this->name);
		$individual_fantag_id = $this->getFanBoxId();

		
		
		if ($this-> getFanBoxPageID() == $wgTitle->getArticleID()) {
			$fantag_perma ="";
		}
		else {
			$fantag_perma ="<a class=\"perma\" style=\"font-size:8px; color:".$this->getFanBoxRightTextColor()." \" href=\"".$fantag_title->escapeFullURL()."\" title=\"{$this->name}\">perma</a>";
		}
		
		if ($this->getFanBoxLeftTextSize() == "mediumfont"){
			$leftfontsize= "14px";
		}
		if ($this->getFanBoxLeftTextSize() == "bigfont"){
			$leftfontsize= "20px";
		}
		
		if ($this->getFanBoxRightTextSize() == "smallfont"){
			$rightfontsize= "12px";
		}
		if ($this->getFanBoxRightTextSize() == "mediumfont"){
			$rightfontsize= "14px";
		}

		$right_text = $this->getFanBoxRightText();
		$right_text  = $tagParser->parse($right_text, $wgTitle, $wgOut->parserOptions(), false );
		$right_text  = $right_text->getText();

		$output = "";
		$output.="<input type=\"hidden\" name=\"individualFantagId\" value=\"$this->getFanBoxId()\">
			<div class=\"individual-fanbox\" id=\"individualFanbox".$individual_fantag_id."\">
				<div class=\"permalink-container\">
					$fantag_perma
				</div>
				<table  class=\"fanBoxTable\" onclick=\"javascript:openFanBoxPopup('fanboxPopUpBox{$individual_fantag_id}','individualFanbox{$individual_fantag_id}')\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" >
					<tr>
						<td id=\"fanBoxLeftSideOutput\" style=\"color:".$this->getFanBoxLeftTextColor()." ;font-size:$leftfontsize\" bgcolor=\"".$this->getFanBoxLeftBgColor()."\">".$fantag_leftside."</td> 
						<td id=\"fanBoxRightSideOutput\" style=\"color:".$this->getFanBoxRightTextColor()." ;font-size:$rightfontsize\" bgcolor=\"".$this->getFanBoxRightBgColor()."\">".   $right_text  ."</td>
				</tr>
				</table>
			</div>		
		";

		return $output;
	}
	

	
	//check if user has fanbox and output the right (add vs remove) popupbox
	
	public function checkIfUserHasFanBox() {
		global $wgUser;
		
		$dbr =& wfGetDB( DB_MASTER );
		$sql = "SELECT count(*) as count
			FROM user_fantag
			WHERE userft_user_name = '{$wgUser->getName()}' && userft_fantag_id = '{$this->getFanBoxId()}'";
		$res = $dbr->query($sql);
		$row = $dbr->fetchObject( $res );
		if($row){
			$check_fanbox_count=$row->count;
		}
		return $check_fanbox_count;
	}

	public function outputIfUserHasFanBox() {
		$fanboxtitle = $this->getTitle();
		$fanboxtitle = $fanboxtitle->getText();
		$individual_fantag_id = $this->getFanBoxId();
		

		$output .= "
			<div class=\"fanbox-pop-up-box\" id=\"fanboxPopUpBox".$individual_fantag_id."\">
			<table cellpadding=\"0\" cellspacing=\"0\" width=\"258px\"><tr><td align=\"center\">". wfMsgForContent( 'fanbox_remove_fanbox' ) ."<tr><td align=\"center\">
			<input type=\"button\" value=\"Remove\" size=\"20\" onclick=\"closeFanboxAdd('fanboxPopUpBox{$individual_fantag_id}','individualFanbox{$individual_fantag_id}'); showMessage(2, '$fanboxtitle', $individual_fantag_id) \" />
			<input type=\"button\" value=\"Cancel\" size=\"20\" onclick=\"closeFanboxAdd('fanboxPopUpBox{$individual_fantag_id}','individualFanbox{$individual_fantag_id}')\" />
			</td></table>
			</div>";
			
	return $output;

	}

	public function outputIfUserDoesntHaveFanBox() {
		$fanboxtitle = $this->getTitle();
		$fanboxtitle = $fanboxtitle->getText();
		$individual_fantag_id = $this->getFanBoxId();
		
		$output .= "
			<div class=\"fanbox-pop-up-box\" id=\"fanboxPopUpBox".$individual_fantag_id."\">
			<table cellpadding=\"0\" cellspacing=\"0\" width=\"258px\"><tr><td align=\"center\">". wfMsgForContent( 'fanbox_add_fanbox' ) ."<tr><td align=\"center\">
			<input type=\"button\" value=\"Add\" size=\"20\" onclick=\"closeFanboxAdd('fanboxPopUpBox{$individual_fantag_id}','individualFanbox{$individual_fantag_id}'); showMessage(1, '$fanboxtitle', $individual_fantag_id) \"/>
			<input type=\"button\" value=\"Cancel\" size=\"20\" onclick=\"closeFanboxAdd('fanboxPopUpBox{$individual_fantag_id}','individualFanbox{$individual_fantag_id}')\" />
			</td></table>
			</div>";

	return $output;
	}

	public function outputIfUserNotLoggedIn() {
			$login =  Title::makeTitle( NS_SPECIAL  , "UserLogin"  );
			$output .= "<div class=\"fanbox-pop-up-box\"  id=\"fanboxPopUpBox\">
			<table cellpadding=\"0\" cellspacing=\"0\" width=\"258px\"><tr><td align=\"center\">". wfMsgForContent( 'fanbox_add_fanbox_login' ) ." <a href=\"{$login->getFullURL()}\">". wfMsgForContent( 'fanbox_login' ) ."</a><tr><td align=\"center\">
			<input type=\"button\" value=\"Cancel\" size=\"20\" onclick=\"closeFanboxAdd('fanboxPopUpBox{$individual_fantag_id}','individualFanbox{$individual_fantag_id}')\" />
			</td></table>
			</div>";
	return $output;

	}
	
	/**
	 * Return the name of this fanbox
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
	
			
	//for fanboxes
	
	public function getFanBoxId() {
		$this->load();
		return $this->id;
	}
	
	public function getFanBoxLeftText() {
		$this->load();
		return $this->left_text;
	}

	public function getFanBoxLeftTextColor() {
		$this->load();
		return $this->left_textcolor;
	}
	
	public function getFanBoxLeftBgColor() {
		$this->load();
		return $this->left_bgcolor;
	}
	
	public function getFanBoxRightText() {
		$this->load();
		return $this->right_text;
	}

	public function getFanBoxRightTextColor() {
		$this->load();
		return $this->right_textcolor;
	}
	
	public function getFanBoxRightBgColor() {
		$this->load();
		return $this->right_bgcolor;
	}

	public function getFanBoxImage() {
		$this->load();
		return $this->fantag_image;
	}
	
	public function getFanBoxLeftTextSize() {
		$this->load();
		return $this->left_textsize;
	}
	
	public function getFanBoxRightTextSize() {
		$this->load();
		return $this->right_textsize;
	}

	public function getFanBoxPageID() {
		$this->load();
		return $this->pg_id;
	}
	
	public function getUserID() {
		$this->load();
		return $this->user_id;
	}
	
	public function getUserName() {
		$this->load();
		return $this->user_name;
	}
	
	/**
	 * Return if the Video exists
	 * @public
	 */
	public function exists() {
		$this->load();
		return $this->exists;
	}

	
	public function getEmbedThisCode() {
		$embedtitle = Title::makeTitle(NS_FANTAG, $this->getName())->getPrefixedDBkey();
		return "[[$embedtitle]]";
	}
	

	

	
}

?>
