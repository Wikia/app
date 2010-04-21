<?php
# Alert the user that this is not a valid entry point to MediaWiki if they try to access the special pages file directly.
if (!defined('MEDIAWIKI')) {
        echo <<<EOT
This file is not meant to be run by itself, but only as a part of MediaWiki
EOT;
        exit( 1 );
}
 


class Advertisement
{
	//public fields for ad values
  public $ad_id = 0;
  public $ad_link_url = "";
  public $ad_link_text = "";
  public $ad_text = "";
  public	$wiki_db = "";
	public	$page_id = "";
	public $page_original_url = "";
	//public $page_name = "";
	public $user_email = "";
	public $ad_price = 0;
	public $ad_months = 1;
	public $ad_status = 0;
	public $last_pay_date ='0000-00-00';
 
	public function Save(){
		global $wgExternalSharedDB;
		$saveArray = array(
			'ad_link_url' => $this->ad_link_url,
			'ad_link_text' => $this->ad_link_text,
			'ad_text' => $this->ad_text,
			'wiki_db' => $this->wiki_db,
			'page_id' => $this->page_id,
			'page_original_url' => $this->page_original_url,
			'user_email' => $this->user_email,
			'ad_price' => $this->ad_price,
			'ad_months' => $this->ad_months,
			'ad_status' => $this->ad_status,
			'last_pay_date' => $this->last_pay_date);

		$dbw = wfGetDB( DB_MASTER, array(), $wgExternalSharedDB );
		if($this->ad_id > 0){
			//UPDATE
			$cond = array('ad_id'=>$this->ad_id);
			$dbw->update('advert_ads',$saveArray,$cond,__METHOD__);
		}else{
			//INSERT
			$dbw->Insert('advert_ads',$saveArray,__METHOD__);
			$this->ad_id = $dbw->insertId();
		}
		self::FlushAdCache($this->wiki_db,$this->page_id);
	}
	
	
	/**
	 * load from database
	 * 
	 * @param $adID int
	 * @return void
	 * @public
	 */
	public function LoadFromDB($adID=0){
		$id = 0;
		if($adID > 0){
			$id = $adID;
		} else if($this->ad_id != 0){
			$id = $this->ad_id;
		}
		$ad = self::LoadAdsFromDB(array('ad_id'=>$id),1);
		if(is_array($ad) && count($ad)>0){
			foreach($ad[0] as $field=>$value){
				$this->$field = $value;
			}
			return true;
		}else return false;
	}
	
	/**
	 * load from database, uses globals to load ads for current article
	 *
	 * NOTE: if $limit is ever greater than ten (the default retrieved from the database)
	 * then this will need to be reworked
	 *
	 * @return Advertisement Array
	 * @public
	 */
	public static function GetAdsForCurrentPage($limit=2){
		global $wgTitle;
		global $wgDBname;
		global $wgMemc;
		$pageid = $wgTitle->getArticleID();
		//check for cached results
		$key = wfMemcKey( 'advertisements:'.$wgDBname.':'.$pageid);
		$adlist = $wgMemc->get( $key );
		if(!is_array($adlist)){
			$adlist = self::FlushAdCache($wgDBname,$pageid);
		}
		if(is_array($adlist)){
			if($limit == 0 || count($adlist)<= $limit){
				return $adlist;
			}
			return array_slice($adlist,0,$limit);
		}
	}
	
	public static function FlushAdCache($dbname,$pageid){
		global $wgMemc;
		//check for cached results
		$key = wfMemcKey( 'advertisements:'.$dbname.':'.$pageid);
		$fields = array('ad_id','ad_link_url','ad_link_text', 'ad_text','wiki_db','page_id');
		$params = array('wiki_db' => $dbname,	'page_id'=> $pageid,'ad_status > 0','`last_pay_date` >= DATE_SUB(NOW(), INTERVAL `ad_months` MONTH) ');
		$adcache = self::LoadAdsFromDB($params);
		$wgMemc->set( $key, $adcache, 60*60*24 );
		return $adcache;
	}
	
	/**
	 * load from database, uses globals to load ads for current article
	 *
	 * @return Advertisement Array
	 * @public
	 */
	public static function LoadAdsFromDB($paramAry=array(),$limit=10,$start=0){
		global $wgExternalSharedDB;
		$result = false;
		$fields = '*';
		$dbr = wfGetDB( DB_SLAVE, array(), $wgExternalSharedDB );
		//$dbr = wfGetDB( DB_SLAVE,$wgExternalSharedDB );

		$res = $dbr->select(
			'advert_ads',
			$fields,
			$paramAry,
			__METHOD__,
			array('ORDER BY' => 'ad_price DESC','LIMIT' =>$limit,'OFFSET'=>$startlimit)
		);
		if( $res->numRows() > 0 ) {
		//or use fetchRow
			while( $row = $res->fetchObject() ) {
				$ad = new Advertisement();
				foreach($row as $key=>$value){
					$ad->$key = $value;
				}
				$ads[]=$ad;
			}
			$result = $ads;
			$res->free();
		}		
		return $result;
	}
	
	/**
	 * load from http post values
   *
	 * @return void
	 * @public
	 */
	public function LoadFromPost(){
		global $wgRequest,$wgDBname;
		$this->ad_id=$wgRequest->getText('ad_id');
		$this->ad_link_url = $wgRequest->getText('ad_link_url');
		if(strtolower(mb_substr($this->ad_link_url,0,7))=="http://"){
			$this->ad_link_url = mb_substr($this->ad_link_url,7);
		}
		$this->ad_link_text = $wgRequest->getText('ad_link_text');
		$this->ad_text = $wgRequest->getText('ad_text');
		$this->ad_price = $wgRequest->getText('ad_price');
		$this->ad_months = $wgRequest->getText('ad_months');
		$this->user_email = $wgRequest->getText('user_email');
		//pageName is local page name, eg, "Sandbox" or "Main_page"
		$pageName = $wgRequest->getText('page_name');
		$this->wiki_db = $wgDBname;
		if($pageName != ""){
			//$this->page_name = $pageName;
			//load the title object
			$pageTitle = Title::newFromText($pageName);
			if($pageTitle != null){
				$this->page_id = $pageTitle->getArticleID() + 0;//coerce to an int
				$this->page_original_url = $pageTitle->getFullURL();
			}
		}
	}
	
	/**
	 * Outputs the html for this ad
	 *
	 * @return string
	 * @public
	 */
	public function OutPutHTML(){
		$text = '<div class="sponsorad">';
		$text .= '<a href="http://'.$this->ad_link_url.'">'.$this->ad_link_text.'</a><br />'.$this->ad_text.'<br /><br />'."\n";
		$text .= "</div>\n";
		return $text;
	}
	
	/**
	 * Outputs the wikitext for this ad
	 *
	 * @return string
	 * @public
	 */
	public function OutPutWikiText(){
		$text = wfMsgForContent( 'sponsor-template', $this->ad_link_url, $this->ad_link_text, $this->ad_text );
		return $text;
	}
	
	/**
	 * validate this advertisement
	 *
	 * @return boolean true if valid, array of strings describing errors if not
	 * @public
	 */
	public function validate(){
		//some of these could be a lot more specific, but it's a start
		$errs = array();
		if($this->id != '' && !is_int($this->id)) $errs[]="Invalid ID";
		if(strlen($this->ad_link_url) > 250) $errs[]="Ad URL cannot exceed 250 chars";
		if(strlen($this->ad_link_text) > 250) $errs[]="Ad link text cannot exceed 250 chars";
		if(strlen($this->ad_text) > 500) $errs[]="Ad text cannot exceed 500 chars";
		if(strpos(strtolower($this->ad_text),'<script') !== false) $errs[]="Ad text cannot contain any script";
		if(strlen($this->wiki_db) > 250) $errs[]="Wiki database cannot exceed 250 chars";
		if(!is_int($this->page_id)) $errs[]="Invalid page id";
		if(!is_int($this->ad_price)) $errs[]="Invalid ad price";
		if(!is_int($this->ad_months)) $errs[]="Invalid months";

		$title = Title::newFromID( $this->page_id );
		if ( !is_object( $title ) || !$title->exists() || $title->getNamespace() != NS_MAIN ) {
			$errs[] = "Invalid page name (non-existant or not a regular page)";
		}

		if(count($errs) > 0) return $errs;
		return true;
	}
}

/**
 * Handles the display of ads
 */

Class AdDisplay
{
 
  //wrapper function for specific hooks (method signature appropriate for certain hook(s)
  public static function OutputAdvertisementAfterArticleFetch(&$article, &$content){
  	if(!self::ArticleCanShowAd()) return true;
		$content .= self::OutputAdvertisement();
    return true;
  }
  
  public static function OutputAdvertisementOutputPageParserOutput( &$out, $parseroutput ){
		if(!self::ArticleCanShowAd()) return true;
		$parseroutput->setText(self::OutputAdvertisement());
		return true;
  }
  
  //use this one
  public static function OutputAdvertisementOutputHook( &$out, &$text ){
		if(!self::ArticleCanShowAd()) return true;
		wfLoadExtensionMessages( 'SponsorPage' );
		$text.= self::OutputAdvertisement();
		return true;
  }
  
  public static function OutputAdvertisementParserAfterTidy($parser, &$text) { 
		if(!self::ArticleCanShowAd()) return true;
		$text.= self::OutputAdvertisement();
		return true;
	}
  
  //for testing
  public static function PurgeArticle(){
		global $wgArticle;
		$page = $wgArticle->getTitle()->getText();
		$wgArticle->doPurge();
		return true;
  }
  
  //Note that some hooks may or may not render wikitext, so plan accordingly
  public static function OutputAdvertisement() {
	global $wgParser;
	global $wgTitle;
	$ads = Advertisement::GetAdsForCurrentPage();
	$adtext = wfMsg('sponsor-header');
	$adtext .= '<div class="sponsormsg">';
	$adtext .= '<ul>';
	if(is_array($ads)){
		foreach($ads as $ad){
			$adtext .= $ad->OutPutWikiText();
		}
	}
	if(!is_array($ads) || count($ads) < 2 ){
		$adtext .= self::ShowSponsorMessage();
	}
	$adtext .= '</ul>';
	$adtext .= '</div>';
	return $adtext;
  }
  
  /**
	 * Shows the sponsorship message
   * Later, use a wfmsg for the actual message
   *
	 * @return string
	 * @public
	 */
  public static function ShowSponsorMessage(){
		global $wgTitle, $wgParser;
		$page = $wgTitle->getText();
		$specPage = Title::newFromText("Special:Sponsor");
		$specUrl = $specPage->getLocalURL("page_name=".$page);
		$fullUrl = $specPage->getFullUrl(array("page_name"=>$page));
		$text = wfMsg( 'sponsor-msg', $fullUrl );
		return $text;
  }
  
   public static function ShowSponsorMessageOld(){
		global $wgTitle, $wgParser;
		$page = $wgTitle->getText();
		$specPage = Title::newFromText("Special:Sponsor");
		$specUrl = $specPage->getLocalURL("page_name=".$page);
		$text = "\n".'<div class="sponsormsg" style="border:1px black solid; padding:2em;">';
		$text .= '<p><a href="'.$specUrl.'">Sponsor this page</a></p>';
		$text .= "</div>\n";
		return $text;
  }
  
  /**
	 * See if we're on a page that can have ads (main namespace only, but not main_page)
	 * assumes using MediaWiki:Mainpage for name of main page
   *
	 * @return bool
	 * @private
	 */
  private static function ArticleCanShowAd(){
		global $wgTitle;
		if(!isset($wgTitle)) return false;
		$page = $wgTitle->getText();
		$mainpage = wfMsg('Mainpage');
		//Only show ads in main namespace, but not on the main page
		if($mainpage == $page || $wgTitle->getNamespace() != NS_MAIN ) return false;
		return true;
  }
}
?>
