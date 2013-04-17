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
	 * openShowImage override.
	 * This is called before the wikitext is printed out
	 */
	protected function openShowImage() {
		global $wgEnableVideoPageRedesign, $wgOut;

		parent::openShowImage();
		if(!empty($wgEnableVideoPageRedesign)) {
			$this->renderTabs();

			// Open div for about section (closed in imageDetails);
			$wgOut->addHtml('<div data-tab-body="about" class="tabBody selected">');
			$this->renderDescriptionHeader();
		}
	}

	/**
	 * imageDetails override
	 * Image page doesn't need the wrapper, but WikiaFilePage does
	 * This is called after the wikitext is printed out
	 */
	protected function imageDetails() {
		global $wgOut, $wgEnableVideoPageRedesign, $wgJsMimeType, $wgExtensionsPath;

		if(empty($wgEnableVideoPageRedesign)) {
			parent::imageDetails();
			return;
		}

		// move these two to WikiaFilePage package after full release
		$wgOut->addStyle(AssetsManager::getInstance()->getSassCommonURL('extensions/wikia/FilePage/css/FilePage.scss'));
		$wgOut->addScript( "<script type=\"{$wgJsMimeType}\" src=\"{$wgExtensionsPath}/wikia/FilePage/js/FilePage.js\"></script>\n" );

		$app = F::app();
		$wgOut->addHtml( $app->renderView( 'FilePageController', 'fileUsage', array('type' => 'local') ) );
		$wgOut->addHtml( $app->renderView( 'FilePageController', 'fileUsage', array('type' => 'global') ) );

		// Close div from about section (opened in openShowImage)
		$wgOut->addHtml('</div>');

		$wgOut->addHtml('<div data-tab-body="history" class="tabBody">');
		parent::imageDetails();
		$wgOut->addHtml('</div>');
	}

	/**
	 * imageMetadata override
	 * Image page doesn't need the wrapper, but WikiaFilePage does
	 */
	protected function imageMetadata($formattedMetadata) {
		global $wgOut;

		$wgOut->addHtml('<div data-tab-body="metadata" class="tabBody">');
		parent::imageMetadata($formattedMetadata);
		$wgOut->addHtml('</div>');
	}

	protected function imageFooter() {
		global $wgOut;

		$wgOut->addHtml( F::app()->renderView( 'FilePageController', 'relatedPages', array() ) );
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

	protected function renderTabs() {
		global $wgOut;

		// Default tab selected
		$selectedTab = 'about';

		// Change selected tab based on previous user interaction
		if(isset($_COOKIE['WikiaFilePageTab'])) {
			$selectedTab = $_COOKIE['WikiaFilePageTab'];
		}

		$tabs = F::app()->renderPartial( 'FilePageController', 'tabs', array('showmeta' => $this->showmeta, 'selectedTab' => $selectedTab ) );
		$wgOut->addHtml($tabs);
	}

	protected function renderDescriptionHeader() {
		global $wgOut, $wgLang;

		// Contstruct the h2 with edit link
		$skin = $wgOut->getSkin();
		$headline = wfMessage('video-page-description-heading')->text();
		$args = array(
			$this->getTitle(), // title obj
			0, // section
			$headline, // heading text
			$wgLang->getCode() // lang
		);
		$editSection = call_user_func_array( array( $skin, 'doEditSectionLink' ), $args );

		$descriptionHeaderHtml = Linker::makeHeadline("2", ">", $headline, $headline, $editSection);

		// Display description text or default message
		$content = FilePageHelper::stripCategoriesFromDescription( $this->getContent() );
		$isContentEmpty = empty($content);

		$html = F::app()->renderPartial( 'FilePageController', 'description', array('isContentEmpty' => $isContentEmpty, 'descriptionHeaderHtml' => $descriptionHeaderHtml) );

		$wgOut->addHTML( $html );
	}

}