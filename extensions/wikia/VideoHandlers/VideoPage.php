<?php

if( !defined( 'MEDIAWIKI' ) )
	die( 1 );

/**
 * Special handling for video description pages
 *
 * @ingroup Media
 */
class WikiaVideoPage extends ImagePage {
	
	protected static $videoWidth = 660;

	function openShowImage(){
		global $wgOut, $wgTitle;
		$wgOut->addHTML( '<div class="fullImageLink" id="file">'.$this->img->getEmbedCode($wgTitle->getArticleId(), self::$videoWidth).$this->getVideoInfoLine().'</div>' );
	}
	
	protected function getVideoInfoLine() {
		global $wgWikiaVideoProviders;
		
		$detailUrl = $this->img->getProviderDetailUrl();
		$provider = $this->img->getProviderName();
		$providerUrl = $this->img->getProviderHomeUrl();
		
		$link = '<a href="' . $detailUrl . '" class="external" target="_blank">' . $this->mTitle->getText() . '</a>';
		$s = '<div id="VideoPageInfo">' . wfMsgExt( 'videohandler-video-details', array('replaceafter'), $link, $providerUrl, $provider )  . '</div>';
		return $s;
	}

	protected function imageHistory() {
		global $wgOut;

		$this->loadFile();
		$pager = new ImageHistoryPseudoPager( $this );
		$wgOut->addHTML( $pager->getBody() );
		$wgOut->preventClickjacking( $pager->getPreventClickjacking() );

		$this->img->resetHistory(); // free db resources

		// no upload links 
	}
}
