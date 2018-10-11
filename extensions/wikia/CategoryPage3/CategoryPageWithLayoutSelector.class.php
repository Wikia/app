<?php

use Wikia\Template\PHPEngine;

class CategoryPageWithLayoutSelector extends CategoryPage {
	const LAYOUT_CATEGORY_EXHIBITION = 'category-exhibition';
	const LAYOUT_CATEGORY_PAGE3 = 'category-page3';
	const LAYOUT_MEDIAWIKI = 'mediawiki';

	/**
	 * @throws Exception
	 */
	public function openShowCategory() {
		$output = $this->getContext()->getOutput();

		// Use ResourceLoader for scripts because it uses single request to lazy load all scripts
		// TODO split scripts when we have alphabet shortcuts
		$output->addModules( 'ext.wikia.CategoryPage3.scripts' );

		// Use AssetsManager for styles because it bundles all styles and blocks render so there is no FOUC
		// TODO extract layout selector styles
		\Wikia::addAssetsToOutput( 'category_page3_scss' );

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
				'currentLayout' => $this->getCurrentLayout()
			] )
			->render( 'extensions/wikia/CategoryPage3/templates/CategoryPage3_layoutSelector.php' );
	}

	/**
	 * @throws Exception
	 */
	protected function getCurrentLayout() {
		throw new Exception( 'getCurrentLayout method needs to be overriden' );
	}
}
