<?php

if( !defined( 'MEDIAWIKI' ) )
	die( 1 );

/**
 * Special handling for video description pages in Oasis
 *
 * @ingroup Media
 */
class WikiaVideoPageOasis extends WikiaImagePageOasis {

	protected function openShowImage(){
		global $wgOut, $wgRequest, $wgEnableVideoPageRedesign;
		wfProfileIn( __METHOD__ );

		// TODO: figure out what this timestamp thing is being used for; If it's needed for all skins, move it to a different place.
		$timestamp = $wgRequest->getInt('t', 0);

		if ( $timestamp > 0 ) {
			$img = wfFindFile( $this->mTitle, $timestamp );
			if ( !($img instanceof LocalFile && $img->exists()) ) {
				$img = $this->getDisplayedFile();
			}
		} else {
			$img = $this->getDisplayedFile();
		}

		F::build('JSMessages')->enqueuePackage('VideoPage', JSMessages::EXTERNAL);

		$imageLink = FilePageHelper::getVideoPageVideoEmbedHTML( $img, $this->mTitle->getText()	 );

		$wgOut->addHTML($imageLink);

		$captionDetails = array(
			'expireDate' => $img->getExpirationDate(),
			'provider' => $img->getProviderName(),
			'providerUrl' => $img->getProviderHomeUrl(),
			'detailUrl' => $img->getProviderDetailUrl(),
			'views' => MediaQueryService::getTotalVideoViewsByTitle( $img->getTitle()->getDBKey() ),
		);
		$caption = F::app()->renderView( 'FilePageController', 'videoCaption', $captionDetails );

		$wgOut->addHTML($caption);

		wfProfileOut( __METHOD__ );
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
