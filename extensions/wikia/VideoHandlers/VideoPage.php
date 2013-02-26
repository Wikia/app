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

	/**
	 * TOC override so Video Page does not return any TOC
	 *
	 * @param $metadata Boolean - doesn't matter
	 * @return String - will return empty string to add
	 */
	protected function showTOC( $metadata ) {
		return '';
	}
	
	/**
	 * imageDetails override
	 * Image page doesn't need the wrapper, but VideoPage does
	 */
	protected function imageDetails($showmeta, $formattedMetadata) {
		global $wgOut;
		$app = F::app();
		$wgOut->addHtml( $app->renderView( 'VideoPageController', 'fileUsage', array('type' => 'local') ) );
		$wgOut->addHtml( $app->renderView( 'VideoPageController', 'fileUsage', array('type' => 'global') ) );
		$wgOut->addHtml( $app->renderPartial( 'VideoPageController', 'seeMore', array() ));
		$wgOut->addHtml('<div class="more-info-wrapper">');
		parent::imageDetails($showmeta, $formattedMetadata);
		$wgOut->addHtml('</div>');
		$wgOut->addHtml( $app->renderView( 'VideoPageController', 'relatedPages', array() ) );
	}
	
	/**
	 * imageListing override.
	 * for VideoPage, imageListing will be printed under additionalDetails()
	 */
	protected function imageListing() {
		// do nothing on purpose
	}

	function openShowImage(){
		global $wgOut, $wgRequest, $wgJsMimeType, $wgExtensionsPath;
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

		$autoplay = F::app()->wg->VideoPageAutoPlay;

		F::build('JSMessages')->enqueuePackage('VideoPage', JSMessages::EXTERNAL);
		
		
		$wgOut->addStyle(AssetsManager::getInstance()->getSassCommonURL('extensions/wikia/VideoHandlers/css/VideoPage.scss'));
		$wgOut->addScript( "<script type=\"{$wgJsMimeType}\" src=\"{$wgExtensionsPath}/wikia/VideoHandlers/js/VideoPage.js\"></script>\n" );

		$html = '';
		$html .= '<div class="fullImageLink" id="file">'.$img->getEmbedCode( self::$videoWidth, $autoplay ).$this->getVideoInfoLine().'</div>';	/* hyun remark 2013-02-19 - do we still need this? */

		$captionDetails = array(
			'provider' => $img->getProviderName(),
			'providerUrl' => $img->getProviderHomeUrl(),
			'detailUrl' => $img->getProviderDetailUrl(),
		);
		$html .= F::app()->renderView( 'VideoPageController', 'videoCaption', $captionDetails );
		
		$wgOut->addHTML( $html );
		
		
		/* hyun remark 2013-02-19 - add video caption here */
		
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
