<?php

if( !defined( 'MEDIAWIKI' ) )
	die( 1 );

/**
 * Special handling for video description pages in Oasis
 * Content is grouped into tabs; Tab states are remembered with LocalStorage
 *
 * @ingroup Media
 * @author Hyun
 * @author Liz Lee
 * @author Garth Webb
 * @author Saipetch
 */
class VideoPageTabbed extends ImagePageTabbed {

	/**
	 * Render the video player
	 */
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

	/**
	 * Display info about the video below the video player
	 */
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

	/**
	 * @return String Url where user can re-upload the file
	 */
	public function getUploadUrl() {
		$this->loadFile();
		return FilePageHelper::getUploadUrl( $this->getDisplayedFile() );
	}
}
