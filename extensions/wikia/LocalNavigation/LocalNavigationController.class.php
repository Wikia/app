<?php

class LocalNavigationController extends WikiaController {

	const WORDMARK_MAX_WIDTH = 160;
	const WORDMARK_MAX_HEIGHT = 45;

	public function Index() {
		Wikia::addAssetsToOutput( 'local_navigation_scss' );
		Wikia::addAssetsToOutput( 'local_navigation_oasis_scss' );
		Wikia::addAssetsToOutput( 'local_navigation_js' );
	}

	public function menu() {
		$menuNodes = $this->getMenuNodes();
		$this->setVal('menuNodes', $menuNodes);
	}

	public function menuLevel2() {
		$nodes = $this->getVal('nodes', []);
		$this->setVal('nodes', $nodes);
		$more = $this->getVal('more', null);
		$this->setVal('more', $more);
	}

	public function menuLevel3() {
		$nodes = $this->getVal('nodes', []);
		$this->setVal('nodes', $nodes);
		$more = $this->getVal('more', null);
		$this->setVal('more', $more);
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
		$wordmarkStyle = '';

		if ( $settings['wordmark-type'] == 'graphic' ) {
			wfProfileIn( __METHOD__ . 'graphicWordmark' );
			$imageTitle = Title::newFromText( $themeSettings::WordmarkImageName, NS_IMAGE );
			$wordmarkURL = $themeSettings->getWordmarkUrl();

			if ($imageTitle instanceof Title) {
				$file = wfFindFile( $imageTitle );
				$attributes = [];

				if ( $file instanceof File ) {
					$attributes [] = 'width="' . $file->width . '"';
					$attributes [] = 'height="' . $file->height . '"';

					if (!empty($attributes)) {
						$wordmarkStyle = ' ' . implode(' ', $attributes) . ' ';
					}
				}
			}
			wfProfileOut( __METHOD__ . 'graphicWordmark' );
		}

		$mainPageURL = Title::newMainPage()->getLocalURL();

		$this->setVal( 'mainPageURL', $mainPageURL );
		$this->setVal( 'wordmarkText', $settings['wordmark-text'] );
		$this->setVal( 'wordmarkFontSize', $settings['wordmark-font-size'] );
		$this->setVal( 'wordmarkUrl', $wordmarkURL );
		$this->setVal( 'wordmarkStyle', $wordmarkStyle );
	}
}
