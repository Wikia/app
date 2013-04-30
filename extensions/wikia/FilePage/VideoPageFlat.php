<?php

if( !defined( 'MEDIAWIKI' ) )
	die( 1 );

/**
 * Special handling for video description pages in skins that aren't Oasis
 *
 * @ingroup Media
 */
class VideoPageFlat extends ImagePage {

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

	// TODO: Move this out and handle it differently.  It's no longer being called as of MW 1.19
	/*public function getDuplicates() {

		wfProfileIn( __METHOD__ );
		$img =  $this->getDisplayedFile();
		$handler = $img->getHandler();
		if ( $handler instanceof VideoHandler && $handler->isBroken() ) {
			$res = $this->dupes = array();
		} else {
			$dupes = parent::getDuplicates();
			$finalDupes = array();
			foreach( $dupes as $dupe ) {
		                if ( WikiaFileHelper::isFileTypeVideo( $dupe ) && $dupe instanceof WikiaLocalFile ) {
		                    if ( $dupe->getProviderName() != $img->getProviderName() ) continue;
		                    if ( $dupe->getVideoId() != $img->getVideoId() ) continue;
		                    $finalDupes[] = $dupe;
		                }
			}
			$res = $finalDupes;
		}
		wfProfileOut( __METHOD__ );
		return $res;
	}*/

	// TODO: Move this somewhere else so it can continue to override ImagePage::getUploadUrl() for all video pages on all skins
	public function getUploadUrl() {
		wfProfileIn( __METHOD__ );
		$this->loadFile();
		$uploadTitle = SpecialPage::getTitleFor( 'WikiaVideoAdd' );
		wfProfileOut( __METHOD__ );
		return $uploadTitle->getFullUrl( array(
			'name' => $this->getDisplayedFile()->getName()
		 ) );
	}
}
