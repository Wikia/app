<?php
/**
 *
 * @package MediaWiki
 * @subpackage SpecialPage
 * @author Jakub Kurcek
 *
 */

class RelatedVideo extends SpecialPage {
//	var $mName, $mPassword, $mRetype, $mReturnto, $mCookieCheck, $mPosted;
//	var $mAction, $mCreateaccount, $mCreateaccountMail, $mMailmypassword;
//	var $mLoginattempt, $mRemember, $mEmail, $mBrowser;
//	var $err;

	var $playerWidth = 635;
	var $playerHeight = 450;
	var $playerRelatedNo = 12;


	function  __construct() {
		parent::__construct( "RelatedVideo" , '' /*restriction*/);
		wfLoadExtensionMessages("RelatedVideo");
	}

	/**
	 * showRandomVideo - displays Special:RelatedVideo with random Video.
	 * Content of the video depends on categories selected in $wgRelatedVideoCategories
	 * Doesn't show related videos gallery below.
	 *
	 * @return void
	 */
	
	private function showRandomVideo(){

		global $wgExtensionsPath, $wgRequest, $wgServer, $wgOut, $wgWikiaRelatedVideoSid, $wgSupressPageSubtitle, $wgRelatedVideoCategories;

		$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
		$oTmpl->set_vars(
			array(
				'playerWidth'	=> $this->playerWidth,
				'playerHeight'  => $this->playerHeight,
				'videoSid'	=> $wgWikiaRelatedVideoSid,
				'categories'	=> $wgRelatedVideoCategories
			)
		);
		$randomPlayer	= $oTmpl->execute( "randommovie" );
		// $boxAdvert	= $oTmpl->execute( "boxadvert" ); // disabled for now
		$boxAdvert	= '';

		$oTmpl->set_vars(
			array(
				'embededVideo'	=> $randomPlayer,
				'embededTitle'  => wfMsg('related-video-random-video'),
				'related'	=> array(),
				'server'	=> $wgServer,
				'boxAdvert'	=> $boxAdvert
			)
		);
		$wgOut->addHTML( $oTmpl->execute( "page" ) );
	}

	/**
	 * execute - standard Special:RelatedVideos page.
	 *
	 * @param $videoId int
	 *
	 * @return void
	 */

	function execute( $videoId = 0 ) {
		global $wgExtensionsPath, $wgRequest, $wgServer, $wgOut, $wgWikiaRelatedVideoSid, $wgSupressPageSubtitle, $wgRelatedVideoCategories;
		
		$wgSupressPageSubtitle = true;
		$this->mName = $wgRequest->getText( 'wpName' );
		$this->mRealName = $wgRequest->getText( 'wpContactRealName' );
		$this->mWhichWiki = $wgRequest->getText( 'wpContactWikiName' );
		$this->mProblem = $wgRequest->getText( 'wpContactProblem' );
		$this->mProblemDesc = $wgRequest->getText( 'wpContactProblemDesc' );
		$this->mPosted = $wgRequest->wasPosted();
		$this->mAction = $wgRequest->getVal( 'action' );
		$this->mEmail = $wgRequest->getText( 'wpEmail' );
		$this->mBrowser = $wgRequest->getText( 'wpBrowser' );
		$this->mCCme = $wgRequest->getCheck( 'wgCC' );
		
		$video = (int)$videoId;
		$wgOut->addStyle( wfGetSassUrl( 'extensions/wikia/RelatedVideo/css/RelatedVideo.scss' ) );

		// if no videoId or video from id doesn't exist displays RandomVideo.			
		if ( empty( $videoId ) ){
			$this->showRandomVideo();
		} else {
			$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );

			// 5min video API url.
			$FiveMinApiParams = array(
			    "auto_start=true",
			    "width={$this->playerWidth}",
			    "height={$this->playerHeight}",
			    "num_related_return={$this->playerRelatedNo}",
			    "sid={$wgWikiaRelatedVideoSid}",
			    "cbCustomID=fiveMinAdaptvCompanionDiv"
			);
			$url = "http://api.5min.com/video/$videoId/info.xml?".implode('&', $FiveMinApiParams);
			
			$relatedVideoRSS = RelatedVideoRSS::newFromUrl( $url );

			// $boxAdvert	= $oTmpl->execute( "boxadvert" ); // disabled for now
			$boxAdvert	= '';
			$player		= $relatedVideoRSS->getPlayer();

			if(!empty($player)){
				// small hack, adding few attributes that cannot be added through standard 5min Video API call. Forces advert to spawn in defined div ( not under video ).
				$player = str_replace("&sid={$wgWikiaRelatedVideoSid}","&sid={$wgWikiaRelatedVideoSid}&hasCompanion=true&cbLocation=Custom&cbCustomID=video_companion" , $player);

				$oTmpl->set_vars(
					array(
						'embededVideo'	=> $player,
						'embededTitle'  => $relatedVideoRSS->getTitle(),
						'related'	=> $relatedVideoRSS->getRelated(),
						'server'	=> $wgServer,
						'boxAdvert'	=> $boxAdvert
					)
				);
				$wgOut->addHTML( $oTmpl->execute( "page" ) );
			} else {
				$this->showRandomVideo();
			}
		}
	}
}

