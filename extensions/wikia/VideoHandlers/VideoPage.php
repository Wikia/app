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
		global $wgOut, $wgTitle, $wgRequest;
		
		$timestamp = $wgRequest->getInt('t', 0);
		
		if ( $timestamp > 0 ) {
			$img = wfFindFile( $this->mTitle, $timestamp );
			if ( !($img instanceof LocalFile && $img->exists()) ) {
				$img = $this->img;
			}
		} else {
			$img = $this->img;
		}

		$wgOut->addHTML( '<div class="fullImageLink" id="file">'.$img->getEmbedCode( self::$videoWidth ).$this->getVideoInfoLine().'</div>' );
	}
	
	protected function getVideoInfoLine() {
		global $wgWikiaVideoProviders;
		
		$detailUrl = $this->img->getProviderDetailUrl();
		$provider = $this->img->getProviderName();
		$providerUrl = $this->img->getProviderHomeUrl();
		
		$link = '<a href="' . $detailUrl . '" class="external" target="_blank">' . $this->mTitle->getText() . '</a>';
		$providerLink = '<a href="' . $providerUrl . '" class="external" target="_blank">' . $provider . '</a>';
		$s = '<div id="VideoPageInfo">' . wfMsgExt( 'videohandler-video-details', array('replaceafter'), $link, $providerLink )  . '</div>';
		return $s;
	}

	public function getDuplicates() {

		$handler = $this->img->getHandler();
		if ( $handler instanceof VideoHandler && $handler->isBroken() ) {
			return $this->dupes = array();
		} else {
			$dupes = parent::getDuplicates();
			$finalDupes = array();
			foreach( $dupes as $dupe ){
				if ( $dupe->getProviderName() != $this->img->getProviderName() ) continue;
				if ( $dupe->getVideoId() != $this->img->getVideoId() ) continue;
				$finalDupes[] = $dupe;
			}
			return $finalDupes;
		}
	}

	public function getUploadUrl() {
		$this->loadFile();
		$uploadTitle = SpecialPage::getTitleFor( 'WikiaVideoAdd' );
		return $uploadTitle->getFullUrl( array(
			'name' => $this->img->getName()
		 ) );
	}
}
