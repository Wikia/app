<?php

if( !defined( 'MEDIAWIKI' ) )
	die( 1 );

/**
 * Special handling for video description pages in Oasis
 *
 * @ingroup Media
 */
class VideoPageTabbed extends ImagePageTabbed {

	protected function openShowImage(){
		global $wgOut, $wgRequest, $wgEnableVideoPageRedesign;
		wfProfileIn( __METHOD__ );

		$timestamp = $wgRequest->getInt('t', 0);

		$file = $this->getDisplayedFile();

		FilePageHelper::setVideoFromTimestamp( $timestamp, $this->mTitle, $file);

		F::build('JSMessages')->enqueuePackage('VideoPage', JSMessages::EXTERNAL);

		$imageLink = FilePageHelper::getVideoPageEmbedHTML( $file );

		$caption = $this->getCaptionLine( $file );

		$wgOut->addHTML($imageLink . $caption);

		wfProfileOut( __METHOD__ );
	}

	protected function getCaptionLine($img) {
		$app = F::app();

		$captionDetails = array(
			'expireDate' => $img->getExpirationDate(),
			'provider' => $img->getProviderName(),
			'providerUrl' => $img->getProviderHomeUrl(),
			'detailUrl' => $img->getProviderDetailUrl(),
			'views' => MediaQueryService::getTotalVideoViewsByTitle( $img->getTitle()->getDBKey() ),
		);

		$caption = $app->renderView( 'FilePageController', 'videoCaption', $captionDetails );

		return $caption;
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
