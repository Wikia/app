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
class FilePageTabbed extends WikiaFilePage {

	/**
	 * TOC override so Wikia File Page does not return any TOC
	 *
	 * @param $metadata Boolean - doesn't matter
	 * @return String - will return empty string to add
	 */
	protected function showTOC( $metadata ) {
		return '';
	}

	protected function isDiffPage() {
		$app = F::App();
		$isDiff = false;

		if ( $app->wg->Request->getVal( 'diff' ) ) {
			$isDiff = true;
		}

		return $isDiff;
	}

	protected function imageContent() {
		$out = $this->getContext()->getOutput();
		$app = F::App();

		$sectionClass = '';
		if (! $this->isDiffPage() ) {
			$this->renderTabs();
			$sectionClass = ' class="tabBody"';
		}

		// Open div for about section (closed in imageDetails);
		$out->addHtml('<div data-tab-body="about"' . $sectionClass . '>');
		$this->renderDescriptionHeader();
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

		$out->addHTML( $app->renderView( 'FilePageController', 'fileUsage', array('type' => 'local') ) );
		$out->addHTML( $app->renderView( 'FilePageController', 'fileUsage', array('type' => 'global') ) );

		// Close div from about section (opened in imageContent)
		$out->addHTML('</div>');

		$sectionClass = '';
		if (! $this->isDiffPage() ) {
			$sectionClass = ' class="tabBody"';
		}

		$out->addHTML('<div data-tab-body="history"' . $sectionClass . '>');
		parent::imageDetails();
		$out->addHTML('</div>');
	}

	/**
	 * imageMetadata override
	 * Image page doesn't need the wrapper, but WikiaFilePage does
	 */
	protected function imageMetadata($formattedMetadata) {
		$app = F::App();
		$out = $this->getContext()->getOutput();

		$sectionClass = '';
		if (! $this->isDiffPage() ) {
			$sectionClass = ' class="tabBody"';
		}

		$out->addHTML('<div data-tab-body="metadata"' . $sectionClass . '>');
		parent::imageMetadata($formattedMetadata);
		$out->addHTML('</div>');
	}

	protected function imageFooter() {
		$out = $this->getContext()->getOutput();
		$out->addHTML( F::app()->renderView( 'FilePageController', 'relatedPages', array() ) );
	}

	/**
	 * imageListing override. We're using "appears in these..." section instead
	 */
	protected function imageListing() {
		return;
	}

	protected function renderTabs() {
		$app = F::app();
		$out = $this->getContext()->getOutput();

		$tabs = $app->renderPartial( 'FilePageController', 'tabs', array('showmeta' => $this->showmeta ) );
		$out->addHtml($tabs);
	}

	/* TODO: Rename this and clean up the logic a bit.
	 * 1) We're no longer rendering a description header, so function name doesn't make sense.
	 * 2) If content is empty, simply output default message.  We don't need a template for this.
	 */
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

	/**
	 * Display info about the video below the video player
	 */
	protected function getVideoInfoLine( $file ) {
		$app = F::app();

		$captionDetails = array(
			'expireDate' => $file->getExpirationDate(),
			'provider' => $file->getProviderName(),
			'providerUrl' => $file->getProviderHomeUrl(),
			'detailUrl' => $file->getProviderDetailUrl(),
			'views' => MediaQueryService::getTotalVideoViewsByTitle( $file->getTitle()->getDBKey() ),
		);

		$caption = $app->renderView( 'FilePageController', 'videoCaption', $captionDetails );

		return $caption;
	}

}