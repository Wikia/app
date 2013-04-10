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
	 * Image page doesn't need the wrapper, but WikiaFilePage does
	 */
	protected function imageDetails($showmeta, $formattedMetadata) {
		global $wgEnableVideoPageRedesign, $wgJsMimeType, $wgExtensionsPath;

		if(empty($wgEnableVideoPageRedesign)) {
			parent::imageDetails($showmeta, $formattedMetadata);
			return;
		}

		// move these two to WikiaFilePage package after full release
		$this->getContext()->getOutput()->addStyle( AssetsManager::getInstance()->getSassCommonURL( 'extensions/wikia/FilePage/css/FilePage.scss' ) );
		$this->getContext()->getOutput()->addScript( "<script type=\"{$wgJsMimeType}\" src=\"{$wgExtensionsPath}/wikia/FilePage/js/FilePage.js\"></script>\n" );

		$app = F::app();
		$this->getContext()->getOutput()->addHTML( $app->renderView( 'FilePageController', 'fileUsage', array('type' => 'local') ) );
		$this->getContext()->getOutput()->addHTML( $app->renderView( 'FilePageController', 'fileUsage', array('type' => 'global') ) );
		$this->getContext()->getOutput()->addHTML( $app->renderPartial( 'FilePageController', 'seeMore', array() ) );
		$this->getContext()->getOutput()->addHTML( '<div class="more-info-wrapper">' );
		parent::imageDetails( $showmeta, $formattedMetadata );
		$this->getContext()->getOutput()->addHTML( '</div>' );
		$this->getContext()->getOutput()->addHTML( $app->renderView( 'FilePageController', 'relatedPages', array() ) );
	}

	/**
	 * imageListing override.
	 * for WikiaFilePage, imageListing will be printed under additionalDetails()
	 */
	protected function imageListing() {
		global $wgEnableVideoPageRedesign;

		if(empty($wgEnableVideoPageRedesign)) {
			parent::imageListing();
			return;
		}

		// do nothing on purpose
	}

	protected function openShowImage() {
		global $wgEnableVideoPageRedesign;

		parent::openShowImage();
		if(!empty($wgEnableVideoPageRedesign)) {
			$this->renderDescriptionHeader();
		}
	}

	protected function renderDescriptionHeader() {
		// Display description text or default message
		$content = FilePageHelper::stripCategoriesFromDescription( $this->getContent() );
		$isContentEmpty = empty( $content );

		$html = F::app()->renderPartial( 'FilePageController', 'description', array( 'isContentEmpty' => $isContentEmpty ) );

		$this->getContext()->getOutput()->addHTML( $html );
	}

}