<?php

class CorporateFooterController extends WikiaController {

	public function index() {
		$this->interlang = WikiaPageType::isCorporatePage();
		$this->response->addAsset( 'extensions/wikia/CorporateFooter/styles/CorporateFooter.scss' );

		$helper = new WikiaHomePageHelper();
		$wikisIncludedInCorporateFooterDropdown = $helper->getWikisIncludedInCorporateFooterDropdown();

		$this->selectedLang = $this->wg->ContLang->getCode();
		$this->dropDownItems = $this->prepareDropdownItems( $wikisIncludedInCorporateFooterDropdown, $this->selectedLang );

		if ( $this->app->wg->EnableWAMPageExt ) {
			$wamModel = new WAMPageModel();
			$this->wamPageUrl = $wamModel->getWAMMainPageUrl();
		}
	}

	protected function prepareDropdownItems( $corpWikis, $selectedLang ) {
		$results = array();

		foreach ( $corpWikis as $lang => $wiki ) {
			if ( $lang !== $selectedLang ) {
				$results[ ] = array( 'class' => $lang, 'href' => $wiki[ 'url' ], 'text' => '', 'title' => $wiki[ 'wikiTitle' ] );
			}
		}

		return $results;
	}

}
