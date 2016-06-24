<?php

class WikiTopicTest extends WikiaBaseTest {

	public function setUp() {
		$this->setupFile = __DIR__ . '/../CommunityPage.setup.php';
		parent::setUp();
	}

	/**
	 * @dataProvider fallbackToSitenameProvider
	 */
	public function testFallbackToSitename( $sitename, $wikiTopic, $expectedWikiTopic ) {
		$this->mockGlobalVariable( 'wgWikiTopic', $wikiTopic );
		$this->mockGlobalVariable( 'wgSitename', $sitename );
		$this->assertEquals( $expectedWikiTopic, WikiTopic::getWikiTopic() );
	}

	/**
	 * @dataProvider preparingWikiTopicFromSitenameProvider
	 */
	public function testPreparingWikiTopicFromSitename( $sitename, $expectedWikiTopic ) {
		$this->mockGlobalVariable( 'wgWikiTopic', null );
		$this->mockGlobalVariable( 'wgSitename', $sitename );
		$this->assertEquals( $expectedWikiTopic, WikiTopic::getWikiTopic() );
	}

	public function fallbackToSitenameProvider() {
		return [
			[ 'Wookiepedia', 'Star Wars', 'Star Wars' ],
			[ 'Wookiepedia', null, 'Wookiepedia' ],
		];
	}

	public function preparingWikiTopicFromSitenameProvider() {
		return [
			[ 'Muppet', 'Muppet' ],
			[ 'Muppet Wiki', 'Muppet' ],
			[ 'Muppet wiki', 'Muppet' ],
			[ 'MediaWiki', 'Media' ],
			[ 'Mediawiki', 'Media' ],
			[ 'WikiZilla', 'WikiZilla' ],
			[ 'Greatest wiki ever', 'Greatest wiki ever' ],
			[ 'Muppet Wikia', 'Muppet' ],
			[ 'Muppet WIKIA', 'Muppet' ],
		];
	}
}
