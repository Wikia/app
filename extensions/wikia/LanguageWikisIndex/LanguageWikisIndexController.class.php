<?php


class LanguageWikisIndexController extends WikiaSpecialPageController {

	public function __construct() {
		parent::__construct( 'LanguageWikisIndex', '', false );
	}

	public function index() {
		global $wgCityId;

		$this->specialPage->setHeaders();

		$this->getOutput()->setRobotPolicy( 'noindex,follow' );

		Wikia::addAssetsToOutput( 'language_wikis_index_scss' );

		$this->setVal( 'langWikis', WikiFactory::getLanguageWikis() );

		$isClosed = $this->isClosedWiki();
		if ( $isClosed ) {
			$this->setVal( 'intro', $this->msg( 'languagewikisindex-intro-closed' )->escaped() );
		} else {
			$this->setVal( 'intro', $this->msg( 'languagewikisindex-intro' )->escaped() );
		}

		$createNewWikiLink = GlobalTitle::newFromText( 'CreateNewWiki', NS_SPECIAL, Wikia::COMMUNITY_WIKI_ID )->getFullURL();

		$this->setVal( 'cnwLink', $createNewWikiLink );

		$this->setVal( 'wikiIsCreatable', ( !$isClosed ||
			( WikiFactory::getFlags( $wgCityId ) & WikiFactory::FLAG_FREE_WIKI_URL ) ) );

		$this->setVal( 'links', [
			'cnw' => $createNewWikiLink,
			'fandom' => '//fandom.wikia.com',
			'fandom-university' => GlobalTitle::newFromText( 'FANDOM University', NS_MAIN, Wikia::COMMUNITY_WIKI_ID )->getFullURL(),
		] );
	}

	private function isClosedWiki() {
		global $wgCityId;

		return !LanguageWikisIndexHooks::isEmptyDomainWithLanguageWikis() &&
			!WikiFactory::isPublic( $wgCityId );
	}
}
