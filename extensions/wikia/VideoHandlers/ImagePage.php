<?php

if( !defined( 'MEDIAWIKI' ) )
	die( 1 );

/**
 * This is an override and extension of includes/ImagePage.php
 * As Wikia, we want to output a different markup structure and css for File pages than default MediaWiki.
 * WikiaVideoPage will inherit off of this class
 *
 * @ingroup Media
 * @author Hyun
 */
class WikiaImagePage extends ImagePage {

	/**
	 * TOC override so Wikia File Page does not return any TOC
	 *
	 * @param $metadata Boolean - doesn't matter
	 * @return String - will return empty string to add
	 */
	protected function showTOC( $metadata ) {
		global $wgEnableVideoPageRedesign;
		if(empty($wgEnableVideoPageRedesign)) {
			return parent::showTOC($metadata);
		}
		return '';
	}
	
	/**
	 * imageDetails override
	 * Image page doesn't need the wrapper, but VideoPage does
	 */
	protected function imageDetails($showmeta, $formattedMetadata) {
		global $wgOut, $wgEnableVideoPageRedesign, $wgJsMimeType, $wgExtensionsPath;
		
		if(empty($wgEnableVideoPageRedesign)) {
			parent::imageDetails($showmeta, $formattedMetadata);
			return;
		}
		
		// add these two to VideoPage package after full release
		$wgOut->addStyle(AssetsManager::getInstance()->getSassCommonURL('extensions/wikia/VideoHandlers/css/VideoPage.scss'));
		$wgOut->addScript( "<script type=\"{$wgJsMimeType}\" src=\"{$wgExtensionsPath}/wikia/VideoHandlers/js/VideoPage.js\"></script>\n" );
		
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
		global $wgEnableVideoPageRedesign;
		
		if(empty($wgEnableVideoPageRedesign)) {
			parent::imageListing();
			return;
		}
	
		// do nothing on purpose
	}

}