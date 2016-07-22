<?php

class WikiHeaderController extends WikiaController {

	/**
	 * @var string WORDMARK_TYPE_GRAPHIC Image wordmark
	 */
	const WORDMARK_TYPE_GRAPHIC = 'graphic';

	public function Index() {
		OasisController::addBodyClass( 'wikinav2' );

		$themeSettings = new ThemeSettings();
		$settings = $themeSettings->getSettings();

		$this->wordmarkText = $settings["wordmark-text"];
		$this->wordmarkType = $settings["wordmark-type"];
		$this->wordmarkSize = $settings["wordmark-font-size"];
		$this->wordmarkFont = $settings["wordmark-font"];

		if ( $this->wordmarkType == self::WORDMARK_TYPE_GRAPHIC ) {
			wfProfileIn( __METHOD__ . 'graphicWordmarkV2' );
			$this->wordmarkUrl = $themeSettings->getWordmarkUrl();
			$imageTitle = Title::newFromText( $themeSettings::WordmarkImageName, NS_IMAGE );
			if ( $imageTitle instanceof Title ) {
				$attributes = [];
				$file = wfFindFile( $imageTitle );
				if ( $file instanceof File ) {
					$attributes[] = 'width="' . $file->width . '"';
					$attributes[] = 'height="' . $file->height . '"';

					if ( !empty( $attributes ) ) {
						$this->wordmarkStyle = ' ' . implode( ' ', $attributes ) . ' ';
					}
				}
			}
			wfProfileOut( __METHOD__ . 'graphicWordmarkV2' );
		}

		$this->mainPageURL = Title::newMainPage()->getLocalURL();

		$this->displaySearch = !empty( $this->wg->EnableAdminDashboardExt ) && AdminDashboardLogic::displayAdminDashboard( $this, $this->wg->Title );
		$this->setVal( 'displayHeader', !$this->wg->HideNavigationHeaders );
		$this->displayHeaderButtons = !WikiaPageType::isWikiaHubMain();

		$this->hiddenLinks = [
			'watchlist' => SpecialPage::getTitleFor( 'Watchlist' )->getLocalURL(),
			'random' => SpecialPage::getTitleFor( 'Random' )->getLocalURL(),
			'recentchanges' => SpecialPage::getTitleFor( 'RecentChanges' )->getLocalURL(),
		];
	}

	public function Wordmark() {
		$themeSettings = new ThemeSettings();
		$settings = $themeSettings->getSettings();

		$this->wordmarkText = $settings['wordmark-text'];
		$this->wordmarkType = $settings['wordmark-type'];
		$this->wordmarkSize = $settings['wordmark-font-size'];
		$this->wordmarkFont = $settings['wordmark-font'];
		$this->wordmarkFontClass = !empty( $settings["wordmark-font"] ) ? "font-{$settings['wordmark-font']}" : '';
		$this->wordmarkUrl = '';
		if ( $this->wordmarkType == self::WORDMARK_TYPE_GRAPHIC ) {
			wfProfileIn( __METHOD__ . 'graphicWordmark' );
			$this->wordmarkUrl = $themeSettings->getWordmarkUrl();
			$imageTitle = Title::newFromText( $themeSettings::WordmarkImageName, NS_IMAGE );
			if ( $imageTitle instanceof Title ) {
				$attributes = [ ];
				$file = wfFindFile( $imageTitle );
				if ( $file instanceof File ) {
					$attributes [] = 'width="' . $file->width . '"';
					$attributes [] = 'height="' . $file->height . '"';

					if ( !empty( $attributes ) ) {
						$this->wordmarkStyle = ' ' . implode( ' ', $attributes ) . ' ';
					}
				}
			}
			wfProfileOut( __METHOD__ . 'graphicWordmark' );
		}

		$this->mainPageURL = Title::newMainPage()->getLocalURL();
	}
}
