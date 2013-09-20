<?php

/**
 * This class modifies the default file page UI to include
 * tabs to separate out the different sections of the page.
 * The idea is that it's more SEO friendly and is a better
 * experience for users coming to the file page from search
 * engines.
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

	/**
	 * imageContent override
	 * Content here will appear on the "About" tab
	 */
	protected function imageContent() {
		wfProfileIn( __METHOD__ );

		$out = $this->getContext()->getOutput();

		$sectionClass = '';
		if (! $this->isDiffPage() ) {
			$this->renderTabs();
			$sectionClass = ' class="tabBody"';
		}

		// Open div for about section (closed in imageDetails);
		$out->addHtml('<div data-tab-body="about"' . $sectionClass . '>');
		$this->renderDefaultDescription();
		parent::imageContent();

		wfProfileOut( __METHOD__ );
	}

	/**
	 * imageDetails override
	 * Content here will appear on the "File History" tab
	 *
	 * Image page doesn't need the wrapper, but WikiaFilePage does
	 * This is called after the wikitext is printed out
	 */
	protected function imageDetails() {
		wfProfileIn( __METHOD__ );

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

		wfProfileOut( __METHOD__ );
	}

	/**
	 * imageMetadata override
	 * Content here will appear on the "Metadata" tab
	 *
	 * Image page doesn't need the wrapper, but WikiaFilePage does
	 */
	protected function imageMetadata($formattedMetadata) {
		wfProfileIn( __METHOD__ );

		$app = F::App();
		$out = $this->getContext()->getOutput();

		$sectionClass = '';
		if (! $this->isDiffPage() ) {
			$sectionClass = ' class="tabBody"';
		}

		$out->addHTML('<div data-tab-body="metadata"' . $sectionClass . '>');
		parent::imageMetadata($formattedMetadata);
		$out->addHTML('</div>');

		wfProfileOut( __METHOD__ );
	}

	/**
	 * Render related pages section at the bottom of a file page
	 */
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
		wfProfileIn( __METHOD__ );

		$app = F::app();
		$out = $this->getContext()->getOutput();

		$tabs = $app->renderPartial( 'FilePageController', 'tabs', array('showmeta' => $this->showmeta ) );
		$out->addHtml($tabs);

		wfProfileOut( __METHOD__ );
	}

	/**
	 * If there's no description text, render the default message
	 */
	protected function renderDefaultDescription() {
		wfProfileIn( __METHOD__ );

		$app = F::App();
		$out = $this->getContext()->getOutput();
		$isContentEmpty = false;

		// Display description text or default message, except when we're showing a diff (we want the diff to only
		// show actual content, not template injected stuff)
		if (! $app->wg->Request->getVal( 'diff' ) ) {
			$content = FilePageHelper::stripCategoriesFromDescription( $this->getContent() );
			$isContentEmpty = empty( $content );
		}

		if ( $isContentEmpty ) {
			$file = $this->getDisplayedFile();
			$editLink = $file->getTitle()->getLocalURL( array( 'action' => 'edit', 'useMessage' => 'video-page-default-description-header-and-text') );
			$html = $app->renderPartial( 'FilePageController', 'defaultDescription', array( 'editLink' => $editLink ) );
			$out->addHTML( $html );
		}

		wfProfileOut( __METHOD__ );
	}
}