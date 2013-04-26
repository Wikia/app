<?php

if( !defined( 'MEDIAWIKI' ) )
	die( 1 );

/**
 * Special handling for video description pages
 *
 * @ingroup Media
 */
class WikiaVideoPage extends WikiaImagePage {

	protected static $videoWidth = 670;

	protected function openShowImage(){
		global $wgOut, $wgRequest, $wgEnableVideoPageRedesign;
		wfProfileIn( __METHOD__ );
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

		$app = F::app();
		$autoplay = $app->wg->VideoPageAutoPlay;

		// JS for VideoBootstrap
		$embedCode = $img->getEmbedCode( self::$videoWidth, $autoplay );
		$embedCode['htmlPreloaded'] = 1; // Tell JS that HTML will already be loaded on the page.
		$wgOut->addHTML('<script type="text/javascript">window.playerParams = '.json_encode( $embedCode ).';</script>');

		if ( empty($wgEnableVideoPageRedesign) ) {
			$wgOut->addHTML( '<div class="fullImageLink" id="file">'.$embedCode['html'].$this->getVideoInfoLine().'</div>' );
		} else {
			$imageLink = '<div class="fullImageLink" id="file">'.$embedCode['html'].'</div>';

			$wgOut->addHTML($imageLink);

			$captionDetails = array(
				'expireDate' => $img->getExpirationDate(),
				'provider' => $img->getProviderName(),
				'providerUrl' => $img->getProviderHomeUrl(),
				'detailUrl' => $img->getProviderDetailUrl(),
				'views' => MediaQueryService::getTotalVideoViewsByTitle( $img->getTitle()->getDBKey() ),
			);

			$caption = $app->renderView( 'FilePageController', 'videoCaption', $captionDetails );

			$wgOut->addHTML($caption);
		}

		wfProfileOut( __METHOD__ );
	}

	protected function getVideoInfoLine() {
		global $wgWikiaVideoProviders;

		$img = $this->getDisplayedFile();
		$detailUrl = $img->getProviderDetailUrl();
		$provider = $img->getProviderName();
		if ( !empty($provider) ) {
			$providerName = explode( '/', $provider );
			$provider = array_pop( $providerName );
		}
		$providerUrl = $img->getProviderHomeUrl();

		$link = '<a href="' . $detailUrl . '" class="external" target="_blank">' . $this->mTitle->getText() . '</a>';
		$providerLink = '<a href="' . $providerUrl . '" class="external" target="_blank">' . $provider . '</a>';
		$s = '<div id="VideoPageInfo">' . wfMsgExt( 'videohandler-video-details', array('replaceafter'), $link, $providerLink )  . '</div>';
		return $s;
	}

	public function getDuplicates() {

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
	}

	public static function getVideosCategory() {

		$cat = F::app()->wg->ContLang->getFormattedNsText( NS_CATEGORY );
		return ucfirst($cat) . ':' . wfMsgForContent( 'videohandler-category' );
	}

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
