<?php

use Wikia\Template\PHPEngine;

abstract class CategoryPageWithLayoutSelector extends CategoryPage {
	const LAYOUT_CATEGORY_EXHIBITION = 'category-exhibition';
	const LAYOUT_CATEGORY_PAGE3 = 'category-page3';
	const LAYOUT_MEDIAWIKI = 'mediawiki';

	abstract protected function getCurrentLayout();

	/**
	 * @throws Exception
	 */
	public function openShowCategory() {
		$output = $this->getContext()->getOutput();

		// Use ResourceLoader for scripts because it uses single request to lazy load all scripts
		$output->addModules( 'ext.wikia.CategoryPage3.categoryLayoutSelector.scripts' );

		// Use AssetsManager for styles because it bundles all styles and blocks render so there is no FOUC
		\Wikia::addAssetsToOutput( 'category_page3_layout_selector_scss' );

		if ( $this->getContext()->getUser()->isLoggedIn() ) {
			$output->addHTML( $this->getHTML() );
		}
	}

	/**
	 * @return string
	 * @throws Exception
	 */
	private function getHTML(): string {
		return ( new PhpEngine() )->clearData()
			->setData( [
				'categoryExhibitionAllowed' => $this->isCategoryExhibitionAllowed(),
				'currentLayout' => $this->getCurrentLayout()
			] )
			->render( 'extensions/wikia/CategoryPage3/templates/layout-selector.php' );
	}

	private function isCategoryExhibitionAllowed(): bool {
		$title = $this->getContext()->getTitle();
		$wikiPage = new WikiPage( $title );

		return !CategoryExhibitionHooks::isExhibitionDisabledForTitle( $title, $wikiPage );
	}
}
