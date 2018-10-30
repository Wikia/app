<?php


class LanguageWikisIndexController extends WikiaSpecialPageController {

	public function __construct() {
		parent::__construct( 'LanguageWikisIndex' );
	}

	public function index() {
		$this->specialPage->setHeaders();

		Wikia::addAssetsToOutput( 'language_wikis_index_scss' );

		$this->setVal( 'langWikis', WikiFactory::getLanguageWikis() );

		if ( $this->isClosedWiki() ) {
			$this->setVal( 'intro', $this->msg( 'languagewikisindex-intro-closed' )->escaped() );
		} else {
			$this->setVal( 'intro', $this->msg( 'languagewikisindex-intro' )->escaped() );
		}

		$createNewWikiLink = GlobalTitle::newFromText( 'CreateNewWiki', NS_SPECIAL, Wikia::COMMUNITY_WIKI_ID )->getFullURL();

		$this->setVal( 'cnwLink', $createNewWikiLink );

		$this->setVal( 'links', [
			'cnw' => $createNewWikiLink,
			'fandom' => '//fandom.wikia.com',
			'fandom-university' => GlobalTitle::newFromText( 'FANDOM University', NS_MAIN, Wikia::COMMUNITY_WIKI_ID )->getFullURL(),
		] );
	}

	private function isClosedWiki() {
		global $wgCityId;
		return $wgCityId !== WikiFactory::LANGUAGE_WIKIS_INDEX &&
			!WikiFactory::isPublic( $wgCityId );
	}
}
