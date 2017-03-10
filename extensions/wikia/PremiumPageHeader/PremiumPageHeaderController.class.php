<?php

class PremiumPageHeaderController extends WikiaController {

	public function wikiHeader() {
		$themeSettings = new ThemeSettings();
		$settings = $themeSettings->getSettings();

		$this->setVal( 'wordmarkText', $settings["wordmark-text"] );

		$this->setVal( 'tallyMsg',
			wfMessage( 'pph-total-articles', SiteStats::articles() )->parse() );

		$this->setVal( 'addNewPageHref', SpecialPage::getTitleFor( 'CreatePage' )->getLocalURL() );

		$this->setVal( 'mainPageURL', Title::newMainPage()->getLocalURL() );

	}

	public function navigation() {
		$this->setVal( 'data',
			( new NavigationModel() )->getLocalNavigationTree( NavigationModel::WIKI_LOCAL_MESSAGE ) );
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
					'textEscaped' => htmlspecialchars( $title->getText() ),
					'href' => $title->getLocalURL(),
				];
			}, $explore ),
		];
	}

	private function getDiscuss() {
		global $wgEnableDiscussionsNavigation, $wgEnableDiscussions, $wgEnableForumExt;

		$href =
			!empty( $wgEnableDiscussionsNavigation ) && !empty( $wgEnableDiscussions ) &&
			empty( $wgEnableForumExt )
				? '/d'
				: Title::newFromText( 'Forum', NS_SPECIAL )
				->getLocalURL();

		return [
			'text' => 'Discuss',
			'href' => $href,
		];
	}

	public function articleHeader() {
		$skinVars = $this->app->getSkinTemplateObj()->data;
		$this->setVal( 'displaytitle', $skinVars['displaytitle'] );
		$this->setVal( 'title', $skinVars['title'] );

		$categoryLinks = $this->getContext()->getOutput()->getCategoryLinks()['normal'];
		$visibleCategoriesLimit = 4;
		if(count($categoryLinks) > 4) {
			$visibleCategoriesLimit = 3;
		}
		$visibleCategories = array_slice($categoryLinks, 0, $visibleCategoriesLimit);
		$moreCategories = array_slice($categoryLinks, $visibleCategoriesLimit);

		$this->setVal( 'visibleCategoriesLength', count($visibleCategories) );
		$this->setVal( 'visibleCategories', $visibleCategories );
		$this->setVal( 'moreCategoriesLength', count($moreCategories) );
		$this->setVal( 'moreCategories', $moreCategories );
	}
}
