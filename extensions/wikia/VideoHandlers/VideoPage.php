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
		$wgOut->addHTML( '<div class="fullImageLink" id="file">'.$this->img->getEmbedCode( self::$videoWidth).$this->getVideoInfoLine().'</div>' );
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

	public function getUploadUrl() {
		$this->loadFile();
		$uploadTitle = SpecialPage::getTitleFor( 'WikiaVideoAdd' );
		return $uploadTitle->getFullUrl( array(
			'name' => $this->img->getName()
		 ) );
	}
}
