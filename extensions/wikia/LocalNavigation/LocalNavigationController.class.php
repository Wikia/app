<?php

class LocalNavigationController extends WikiaController {

	const WORDMARK_MAX_WIDTH = 160;
	const WORDMARK_MAX_HEIGHT = 45;

	public function Index() {
		Wikia::addAssetsToOutput( 'local_navigation_scss' );
		Wikia::addAssetsToOutput( 'local_navigation_js' );
	}

	public function menu() {
		$menuNodes = $this->getMenuNodes();
		$this->response->setVal('menuNodes', $menuNodes);
	}

	public function menuLevel2() {
		$nodes = $this->request->getVal('nodes', []);
		$this->response->setVal('nodes', $nodes);
		$more = $this->request->getVal('more', ['href' => '#', 'text' => '']);
		$this->response->setVal('more', $more);
	}

	public function menuLevel3() {
		$nodes = $this->request->getVal('nodes', []);
		$this->response->setVal('nodes', $nodes);
		$more = $this->request->getVal('more', ['href' => '#', 'text' => '']);
		$this->response->setVal('more', $more);
	}

	private function getMenuNodes () {
		$navigationModel = new NavigationModel();
		$localNavigation = $navigationModel->getLocalNavigationTree( NavigationModel::WIKI_LOCAL_MESSAGE );
		$onTheWikiNavigation = $navigationModel->getOnTheWikiNavigationTree( NavigationModel::WIKIA_GLOBAL_VARIABLE );
		return array_merge( $localNavigation, $onTheWikiNavigation );
	}

	public function Wordmark() {

		$themeSettings = new ThemeSettings();
		$settings = $themeSettings->getSettings();

		$wordmarkURL = '';
		if ( $settings['wordmark-type'] == 'graphic' ) {
			wfProfileIn( __METHOD__ . 'graphicWordmark' );
			$imageTitle = Title::newFromText( $themeSettings::WordmarkImageName, NS_IMAGE );
			$file = wfFindFile( $imageTitle );
			if ( $file instanceof File ) {
				$wordmarkURL = $file->createThumb(
					self::WORDMARK_MAX_WIDTH,
					self::WORDMARK_MAX_HEIGHT
				);
			}
			wfProfileOut( __METHOD__ . 'graphicWordmark' );
		}

		$mainPageURL = Title::newMainPage()->getLocalURL();

		$this->response->setVal( 'mainPageURL', $mainPageURL );
		$this->response->setVal( 'wordmarkText', $settings['wordmark-text'] );
		$this->response->setVal( 'wordmarkFontSize', $settings['wordmark-font-size'] );
		$this->response->setVal( 'wordmarkUrl', $wordmarkURL );
	}
}
