<?php

class WikiTopicTest extends WikiaBaseTest {

	private $communityi18n = [
		'en' => 'Community',
		'es' => 'Comunidad',
		'fr' => 'Communauté',
		'pl' => 'Społeczność',
		'ru' => 'Сообщество'
	];

	public function setUp() {
		$this->setupFile = __DIR__ . '/../CommunityPage.setup.php';
		parent::setUp();
	}

	/**
	 * @dataProvider fallbackToSitenameProvider
	 */
	public function testFallbackToSitename( $sitename, $wikiTopic, $expectedWikiTopic, $lang ) {
		$this->mockGlobalVariable( 'wgWikiTopic', $wikiTopic );
		$this->mockGlobalVariable( 'wgSitename', $sitename );
		$mock = $this->getMock( 'Message', [ 'plain' ] );
		$mock->expects( $this->any() )->method( 'plain' )->willReturn( $this->communityi18n[$lang] );
		$this->mockGlobalFunction( 'wfMessage', $mock );

		$this->assertEquals( $expectedWikiTopic, WikiTopic::getWikiTopic() );
	}

	/**
	 * @dataProvider preparingWikiTopicFromSitenameProvider
	 */
	public function testPreparingWikiTopicFromSitename( $sitename, $expectedWikiTopic, $lang ) {
		$this->mockGlobalVariable( 'wgWikiTopic', null );
		$this->mockGlobalVariable( 'wgSitename', $sitename );
		$mock = $this->getMock( 'Message', [ 'plain' ] );
		$mock->expects( $this->any() )->method( 'plain' )->willReturn( $this->communityi18n[$lang] );
		$this->mockGlobalFunction( 'wfMessage', $mock );

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
