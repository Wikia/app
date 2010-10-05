<?php

/**
 * Handles the display of ads
 */

class AdDisplay {

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
		global $wgUser;

		if ( $wgUser->isLoggedIn() ) {
			return true;
		}

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
		global $wgTitle, $wgSponsorAdsLimit;

		$ads = Advertisement::GetAdsForCurrentPage();
		$adtext = wfMsg('sponsor-header');
		$adtext .= '<div class="sponsormsg">';
		$adtext .= '<ul>';
		if(is_array($ads)){
			foreach($ads as $ad){
				$adtext .= $ad->OutPutWikiText();
			}
		}
		$adtext .= '</ul>';



		$adtext .= '</div>';
		return $adtext;
	}

	/**
	 * Shows the sponsorship message
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
