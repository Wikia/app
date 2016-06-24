<?php

class WikiTopicTest extends WikiaBaseTest {

	public function setUp() {
		$this->setupFile = __DIR__ . '/../CommunityPage.setup.php';
		parent::setUp();
	}
	/**
	 * @dataProvider FormingWikiTopicProvider
	 */
	public function testFormingWikiTopic( $sitename, $expectedWikiTopic ) {
		$this->mockGlobalVariable( 'wgWikiTopic', null );
		$this->mockGlobalVariable( 'wgSitename', $sitename );
		$this->assertEquals( $expectedWikiTopic, WikiTopic::getWikiTopic() );
	}

	public function FormingWikiTopicProvider() {
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
