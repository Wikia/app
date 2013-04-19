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
		$app = F::App();

		if ( empty($app->wg->EnableVideoPageRedesign) ) {
			return parent::showTOC($metadata);
		}
		return '';
	}

	protected function imageContent() {
		$out = $this->getContext()->getOutput();

		$app = F::App();
		if ( !empty($app->wg->EnableVideoPageRedesign) ) {
			if (! $app->wg->Request->getVal( 'diff' ) ) {
				$this->renderTabs();
			}

			// Open div for about section (closed in imageDetails);
			$out->addHtml('<div data-tab-body="about" class="tabBody selected">');
			$this->renderDescriptionHeader();
		}

		parent::imageContent();
	}

	/**
	 * imageDetails override
	 * Image page doesn't need the wrapper, but WikiaFilePage does
	 * This is called after the wikitext is printed out
	 */
	protected function imageDetails() {
		$app = F::App();
		$out = $this->getContext()->getOutput();

		if ( empty($app->wg->EnableVideoPageRedesign) ) {
			parent::imageDetails();
			return;
		}

		// move these two to WikiaFilePage package after full release
		$out->addStyle( AssetsManager::getInstance()->getSassCommonURL( 'extensions/wikia/FilePage/css/FilePage.scss' ) );
		$out->addScript( '<script type="'.$app->wg->JsMimeType.'" src="'.$app->wg->ExtensionsPath.'/wikia/FilePage/js/FilePage.js"></script>'."\n" );

		$out->addHTML( $app->renderView( 'FilePageController', 'fileUsage', array('type' => 'local') ) );
		$out->addHTML( $app->renderView( 'FilePageController', 'fileUsage', array('type' => 'global') ) );

		// Close div from about section (opened in openShowImage)
		$out->addHTML('</div>');

		$out->addHTML('<div data-tab-body="history" class="tabBody">');
		parent::imageDetails();
		$out->addHTML('</div>');
	}

	/**
	 * imageMetadata override
	 * Image page doesn't need the wrapper, but WikiaFilePage does
	 */
	protected function imageMetadata($formattedMetadata) {
		$out = $this->getContext()->getOutput();
		$out->addHTML('<div data-tab-body="metadata" class="tabBody">');
		parent::imageMetadata($formattedMetadata);
		$out->addHTML('</div>');
	}

	protected function imageFooter() {
		$out = $this->getContext()->getOutput();
		$out->addHTML( F::app()->renderView( 'FilePageController', 'relatedPages', array() ) );
	}

	/**
	 * imageListing override.
	 * for WikiaFilePage, imageListing will be printed under additionalDetails()
	 */
	protected function imageListing() {
		$app = F::App();

		if ( empty($app->wg->EnableVideoPageRedesign) ) {
			parent::imageListing();
			return;
		}
	}

	protected function renderTabs() {
		$out = $this->getContext()->getOutput();

		$tabs = F::app()->renderPartial( 'FilePageController', 'tabs', array('showmeta' => $this->showmeta ) );
		$out->addHtml($tabs);
	}

	protected function renderDescriptionHeader() {
		$app = F::App();
		$out = $this->getContext()->getOutput();

		// Display description text or default message, except when we're showing a diff (we want the diff to only
		// show actual content, not template injected stuff)
		if (! $app->wg->Request->getVal( 'diff' ) ) {
			$content = FilePageHelper::stripCategoriesFromDescription( $this->getContent() );
			$isContentEmpty = empty( $content );
		} else {
			$isContentEmpty = false;
		}

		$html = $app->renderPartial( 'FilePageController', 'description', array( 'isContentEmpty' => $isContentEmpty ) );

		$out->addHTML( $html );
	}

}