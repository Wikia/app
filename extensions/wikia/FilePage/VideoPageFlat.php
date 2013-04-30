<?php

if( !defined( 'MEDIAWIKI' ) )
	die( 1 );

/**
 * Special handling for video file pages in skins that aren't Oasis
 * No tabs will be applied and the current goal is to keep this as much like core mediawiki as possible
 *
 * @ingroup Media
 * @author Hyun
 * @author Liz Lee
 * @author Garth Webb
 * @author Saipetch
 */
class VideoPageFlat extends ImagePage {

	/**
	 * Render the video player
	 */
	protected function openShowImage(){
		global $wgOut, $wgRequest, $wgEnableVideoPageRedesign;
		wfProfileIn( __METHOD__ );

		$timestamp = $wgRequest->getInt('t', 0);

		$file = $this->getDisplayedFile();

		FilePageHelper::setVideoFromTimestamp( $timestamp, $this->mTitle, $file);

		$imageLink = FilePageHelper::getVideoPageEmbedHTML( $file );

		$imageLink .= $this->getVideoInfoLine( $file );

		$wgOut->addHTML($imageLink);

		wfProfileOut( __METHOD__ );
	}

	/**
	 * Display info about the video below the video player
	 */
	protected function getVideoInfoLine( $file ) {
		global $wgWikiaVideoProviders;

		$detailUrl = $file->getProviderDetailUrl();
		$provider = $file->getProviderName();
		if ( !empty($provider) ) {
			$providerName = explode( '/', $provider );
			$provider = array_pop( $providerName );
		}
		$providerUrl = $file->getProviderHomeUrl();

		$link = '<a href="' . $detailUrl . '" class="external" target="_blank">' . $this->mTitle->getText() . '</a>';
		$providerLink = '<a href="' . $providerUrl . '" class="external" target="_blank">' . $provider . '</a>';
		$s = '<div id="VideoPageInfo">' . wfMsgExt( 'videohandler-video-details', array('replaceafter'), $link, $providerLink )  . '</div>';
		return $s;
	}

	/**
	 * @param $title Title
	 * @return WikiVideoFilePage
	 */
	protected function newPage( Title $title ) {
		// Overload mPage with a file-specific page
		return new WikiVideoFilePage( $title );
	}

	/**
	 * @return String Url where user can re-upload the file
	 */
	public function getUploadUrl() {
		$this->loadFile();
		return FilePageHelper::getUploadUrl( $this->getDisplayedFile() );
	}
}
