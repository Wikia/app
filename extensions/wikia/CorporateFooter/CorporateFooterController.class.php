<?php

class CorporateFooterController extends WikiaController {

	public function index() {
		$this->interlang = WikiaPageType::isCorporatePage();
		$helper = new WikiaHomePageHelper();

		$corporateWikis = $helper->getVisualizationWikisData();
		$this->selectedLang = $this->wg->ContLang->getCode();
		$this->dropDownItems = $this->prepareDropdownItems( $corporateWikis, $this->selectedLang );

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
