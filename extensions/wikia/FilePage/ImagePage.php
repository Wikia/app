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
			$wgOut->addHtml('<div data-tab-body="about" class="tabBody">');
			$this->renderDescriptionHeader();
		}
	}

	/**
	 * imageDetails override
	 * Image page doesn't need the wrapper, but WikiaFilePage does
	 * This is called after the wikitext is printed out
	 */
	protected function imageDetails() {
		global $wgEnableVideoPageRedesign, $wgJsMimeType, $wgExtensionsPath;

		if(empty($wgEnableVideoPageRedesign)) {
			parent::imageDetails();
			return;
		}

		$app = F::app();
		$this->getContext()->getOutput()->addHTML( $app->renderView( 'FilePageController', 'fileUsage', array('type' => 'local') ) );
		$this->getContext()->getOutput()->addHTML( $app->renderView( 'FilePageController', 'fileUsage', array('type' => 'global') ) );

		// Close div from about section (opened in openShowImage)
		$this->getContext()->getOutput()->addHTML('</div>');

		$this->getContext()->getOutput()->addHTML('<div data-tab-body="history" class="tabBody">');
		parent::imageDetails();
		$this->getContext()->getOutput()->addHTML('</div>');
	}

	/**
	 * imageMetadata override
	 * Image page doesn't need the wrapper, but WikiaFilePage does
	 */
	protected function imageMetadata($formattedMetadata) {
		$this->getContext()->getOutput()->addHTML('<div data-tab-body="metadata" class="tabBody">');
		parent::imageMetadata($formattedMetadata);
		$this->getContext()->getOutput()->addHTML('</div>');
	}

	protected function imageFooter() {
		$this->getContext()->getOutput()->addHTML( F::app()->renderView( 'FilePageController', 'relatedPages', array() ) );
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
		global $wgOut, $wgUser;

		$tabs = F::app()->renderPartial( 'FilePageController', 'tabs', array('showmeta' => $this->showmeta ) );
		$wgOut->addHtml($tabs);
	}

	protected function renderDescriptionHeader() {
		// Display description text or default message
		$content = FilePageHelper::stripCategoriesFromDescription( $this->getContent() );
		$isContentEmpty = empty( $content );

		$html = F::app()->renderPartial( 'FilePageController', 'description', array( 'isContentEmpty' => $isContentEmpty ) );

		$this->getContext()->getOutput()->addHTML( $html );
	}

}