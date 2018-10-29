<?php


class LanguageWikisIndexController extends WikiaSpecialPageController {

	public function __construct() {
		parent::__construct( 'LanguageWikisIndex' );
	}

	public function index() {
		$this->specialPage->setHeaders();

		Wikia::addAssetsToOutput( 'language_wikis_index_scss' );

		$this->setVal( 'langWikis', WikiFactory::getLanguageWikis() );

		$createNewWikiLink = GlobalTitle::newFromText( 'CreateNewWiki', NS_SPECIAL, Wikia::COMMUNITY_WIKI_ID )->getFullURL();

		$this->setVal( 'cnwLink', $createNewWikiLink );

		$this->setVal( 'links', [
			'cnw' => $createNewWikiLink,
			'fandom' => '//fandom.wikia.com',
			'help' => GlobalTitle::newFromText( 'Contents', NS_HELP, Wikia::COMMUNITY_WIKI_ID )->getFullURL(),
		] );
	}

}
