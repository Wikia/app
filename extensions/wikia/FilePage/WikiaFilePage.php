<?php

/**
 * This class overrides MW's ImagePage.  It's used as a base class for all
 * customizations to file pages (both image and video) and in all skins.
 *
 * @ingroup Media
 * @author Hyun
 * @author Liz Lee
 * @author Garth Webb
 * @author Saipetch
 */
class WikiaFilePage extends ImagePage {

	const VIDEO_WIDTH = 670;

	/**
	 * Override the default action behavior for videos
	 *
	 * @return array - Associative array of action to class that should handle that action
	 */
	public function getActionOverrides() {
		if ( $this->isVideo() ) {
			return array( 'revert' => 'WikiaRevertVideoAction' );
		} else {
			return parent::getActionOverrides();
		}
	}

	/**
	 * Test for whether the current file page represents a video
	 * @return bool - true if the file is a video, false if not
	 */
	protected function isVideo() {
		$file = $this->getDisplayedFile();

		return WikiaFileHelper::isVideoFile( $file );
	}

	/**
	 * Render the image or video
	 */
	protected function openShowImage(){
		if ( $this->isVideo() ) {
			$this->openShowVideo();
		} else {
			parent::openShowImage();
		}
	}

	protected function openShowVideo() {
		wfProfileIn( __METHOD__ );

		$app = F::app();

		JSMessages::enqueuePackage('VideoPage', JSMessages::EXTERNAL);

		$file = $this->getDisplayedFile();

		//If a timestamp is specified, show the archived version of the video (if it exists)
		$timestamp = $app->wg->Request->getInt('t', 0);
		if ( $timestamp > 0 ) {
			$archiveFile = wfFindFile( $this->mTitle, $timestamp );
			if ( $archiveFile instanceof LocalFile && $archiveFile->exists()) {
				$file = $archiveFile;
			}
		}

		$autoplay = $app->wg->VideoPageAutoPlay;

		// JS for VideoBootstrap
		$embedCode = $file->getEmbedCode( self::VIDEO_WIDTH, $autoplay );

		// Tell JS that HTML will already be loaded on the page.
		$embedCode['htmlPreloaded'] = 1;

		// HTML is no longer needed in VideoBootstrap
		$html = $embedCode['html'];
		unset($embedCode['html']);

		$videoDisplay = '<script type="text/javascript">window.playerParams = '.json_encode( $embedCode ).';</script>';

		$videoDisplay .= '<div class="fullImageLink" id="file">' . $html . '</div>';

		$videoDisplay .= $this->getVideoInfoLine( $file );

		$app->wg->Out->addHTML($videoDisplay);

		wfProfileOut( __METHOD__ );
	}

	/**
	 * Display info about the video below the video player: provider, views, expiration date (if any)
	 */
	public function getVideoInfoLine( $file ) {
		wfProfileIn( __METHOD__ );

		$app = F::app();

		$captionDetails = array(
			'expireDate' => $file->getExpirationDate(),
			'provider' => $file->getProviderName(),
			'providerUrl' => $file->getProviderHomeUrl(),
			'detailUrl' => $file->getProviderDetailUrl(),
			'views' => MediaQueryService::getTotalVideoViewsByTitle( $file->getTitle()->getDBKey() ),
		);

		$caption = $app->renderView( 'FilePageController', 'videoCaption', $captionDetails );

		wfProfileOut( __METHOD__ );

		return $caption;
	}

	/**
	 * @return String Url where user can re-upload the file
	 */
	public function getUploadUrl() {
		wfProfileIn( __METHOD__ );

		if ( $this->isVideo() ) {
			$this->loadFile();
			$file = $this->getDisplayedFile();
			$uploadTitle = SpecialPage::getTitleFor( 'WikiaVideoAdd' );
			$name = $file->getName();
			$url = $uploadTitle->getFullUrl( array( 'name' => $name ) );
		} else {
			$url = parent::getUploadUrl();
		}

		wfProfileOut( __METHOD__ );

		return $url;
	}

	/**
	 * Overwrite  mPage with a file-specific page
	 *
	 * @param $title Title
	 * @return WikiVideoFilePage
	 */
	protected function newPage( Title $title ) {
		return new WikiaWikiFilePage( $title );
	}

}