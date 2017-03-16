<?php

class PremiumPageHeaderController extends WikiaController {

	public function wikiHeader() {
		global $wgCityId;

		$themeSettings = new ThemeSettings();
		$settings = $themeSettings->getSettings();

		$backgroundImageUrl = ( new SiteAttributeService() )
				->getApiClient()
				->getAttribute( $wgCityId, 'heroImage' )
				->getValue() ?? '';

		$this->setVal( 'backgroundImageUrl', $backgroundImageUrl );
		$this->setVal( 'wordmarkText', $settings['wordmark-text'] );
		$this->setVal( 'tallyMsg', wfMessage( 'pph-total-articles', SiteStats::articles() )->parse() );
		$this->setVal( 'addNewPageHref', SpecialPage::getTitleFor( 'CreatePage' )->getLocalURL() );
		$this->setVal( 'mainPageURL', Title::newMainPage()->getLocalURL() );
	}

	public function navigation() {
		$this->setVal( 'data', ( new NavigationModel() )->getLocalNavigationTree( NavigationModel::WIKI_LOCAL_MESSAGE ) );
		$this->setVal( 'explore', $this->getExplore() );
		$this->setVal( 'discuss', $this->getDiscuss() );
	}

	private function getExplore() {
		$explore = [
			[ 'title' => 'WikiActivity', 'tracking' => 'explore-activity' ],
			[ 'title' => 'Random', 'tracking' => 'explore-random' ],
			[ 'title' => 'Community', 'tracking' => 'explore-community' ],
			[ 'title' => 'Videos', 'tracking' => 'explore-videos' ],
			[ 'title' => 'Images', 'tracking' => 'explore-images' ]
		];

		$children = array_map( function ( $page ) {
			$title = Title::newFromText( $page['title'], NS_SPECIAL );
			if ( $title && $title->isKnown() ) {
				return [
					'text' => $title->getText(),
					'href' => $title->getLocalURL(),
					'tracking' => $page['tracking']
				];
			}
			return [];
		}, $explore );

		return [
			'text' => wfMessage( 'pph-explore' )->escaped(),
			'children' => array_filter( $children, function ( $child ) {
				return !empty( $child );
			} )
		];
	}

	private function getDiscuss() {
		global $wgEnableDiscussionsNavigation, $wgEnableDiscussions, $wgEnableForumExt;

		$href = !empty( $wgEnableDiscussionsNavigation ) && !empty( $wgEnableDiscussions ) && empty( $wgEnableForumExt ) ?
			'/d' : Title::newFromText( 'Forum', NS_SPECIAL )->getLocalURL();

		return [
			'text' => wfMessage( 'pph-discuss' )->escaped(),
			'href' => $href
		];
	}
}
