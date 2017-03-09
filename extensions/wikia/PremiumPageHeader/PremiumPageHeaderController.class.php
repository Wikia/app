<?php

class PremiumPageHeaderController extends WikiaController {

	public function wikiHeader() {
		$themeSettings = new ThemeSettings();
		$settings = $themeSettings->getSettings();

		$this->setVal( 'wordmarkText', $settings["wordmark-text"] );

		// fixme we should define new message for tally
		$this->setVal( 'tallyMsg',
			wfMessage( 'oasis-total-articles-mainpage', SiteStats::articles() )->parse() );

		$this->setVal( 'addNewPageHref', SpecialPage::getTitleFor( 'CreatePage' )->getLocalURL() );

	}

	public function navigation() {
		$this->setVal( 'data', ( new NavigationModel() )->getLocalNavigationTree( NavigationModel::WIKI_LOCAL_MESSAGE ) );
		$this->setVal( 'explore', $this->getExplore() );
		$this->setVal( 'discuss', $this->getDiscuss() );
	}

	private function getExplore() {
		$explore = [
			'WikiActivity',
			'Random',
			'Community',
			'Videos',
			'Images',
		];

		return [
			'text' => 'Explore',
			'children' => array_map( function ( $page ) {
				$title = Title::newFromText( $page, NS_SPECIAL );
				return [
					'text' => $title->getText(),
					'textEscaped' => $title->getEscapedText(),
					'href' => $title->getLocalURL()
				];
			}, $explore )
		];
	}

	private function getDiscuss() {
		global $wgEnableDiscussionsNavigation, $wgEnableDiscussions, $wgEnableForumExt;

		$href = !empty( $wgEnableDiscussionsNavigation ) && !empty( $wgEnableDiscussions ) && empty( $wgEnableForumExt ) ?
			'/d' : Title::newFromText( 'Forum', NS_SPECIAL )->getLocalURL();

		return [
			'text' => 'Discuss',
			'href' => $href
		];
	}
}
