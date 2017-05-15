<?php

class WikiTopicTest extends WikiaBaseTest {

	public function setUp() {
		$this->setupFile = __DIR__ . '/../CommunityPage.setup.php';
		parent::setUp();
	}

	/**
	 * @dataProvider fallbackToSitenameProvider
	 *
	 * @param string $sitename
	 * @param string $wikiTopic
	 * @param string $expectedWikiTopic
	 */
	public function testFallbackToSitename( $sitename, $wikiTopic, $expectedWikiTopic ) {
		$this->mockGlobalVariable( 'wgWikiTopic', $wikiTopic );
		$this->mockGlobalVariable( 'wgSitename', $sitename );

		$this->assertEquals( $expectedWikiTopic, WikiTopic::getWikiTopic() );
	}

	/**
	 * @dataProvider preparingWikiTopicFromSitenameProvider
	 *
	 * @param string $sitename
	 * @param string $expectedWikiTopic
	 */
	public function testPreparingWikiTopicFromSitename( $sitename, $expectedWikiTopic ) {
		$this->mockGlobalVariable( 'wgWikiTopic', null );
		$this->mockGlobalVariable( 'wgSitename', $sitename );

		$this->assertEquals( $expectedWikiTopic, WikiTopic::getWikiTopic() );
	}

	public function fallbackToSitenameProvider() {
		return [
			[ 'Wookieepedia', 'Star Wars', 'Star Wars' ],
			[ 'Wookieepedia', null, 'Wookieepedia' ],
		];
	}

	public function preparingWikiTopicFromSitenameProvider() {
		return [
			[ 'Muppet', 'Muppet' ],
			[ 'Muppet Wiki', 'Muppet' ],
			[ 'Muppet wikia', 'Muppet' ],
			[ 'Muppet Вики', 'Muppet' ],
			[ 'MuppetВики', 'MuppetВики' ],
			[ 'MediaWiki', 'MediaWiki' ],
			[ 'Mediawikia', 'Mediawikia' ],
			[ 'WikiZilla', 'WikiZilla' ],
			[ 'Greatest wiki ever', 'Greatest wiki ever' ],
			[ 'Muppet Wikia', 'Muppet' ],
			[ 'Muppet WIKIA', 'Muppet' ],
			[ 'Wikia Foobar', 'Foobar' ],
			[ 'wikia Foobar', 'Foobar' ],
			[ 'the Foobar', 'Foobar' ],
			[ 'The Foobar Wiki', 'Foobar' ],
			[ 'There And Here', 'There And Here' ],
			[ 'There And Here Wiki', 'There And Here' ],
		];
	}
}
