<?php

class WikiTopicTest extends WikiaBaseTest {

	private $communityi18n= [
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
		$mock = $this->getMock( 'Message', ['plain'] );
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
		$mock = $this->getMock( 'Message', ['plain'] );
		$mock->expects( $this->any() )->method( 'plain' )->willReturn( $this->communityi18n[$lang] );
		$this->mockGlobalFunction( 'wfMessage', $mock );

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
			[ 'Muppet', 'Muppet', 'en' ],
			[ 'Muppet Wiki', 'Muppet Community', 'en' ],
			[ 'Muppet wikia', 'Muppet Comunidad', 'es' ],
			[ 'Muppet Вики', 'Muppet Сообщество', 'ru' ],
			[ 'MuppetВики', 'MuppetВики', 'ru' ],
			[ 'MediaWiki', 'MediaWiki', 'en' ],
			[ 'Mediawikia', 'Mediawikia', 'en' ],
			[ 'WikiZilla', 'WikiZilla', 'fr' ],
			[ 'Greatest wiki ever', 'Greatest wiki ever', 'en' ],
			[ 'Muppet Wikia', 'Muppet Community', 'en' ],
			[ 'Muppet WIKIA', 'Muppet Comunidad', 'es' ],
			[ 'Wikia Foobar', 'Communauté Foobar', 'fr' ],
			[ 'wikia Foobar', 'Społeczność Foobar', 'pl' ],
			[ 'the Foobar', 'Foobar', 'en' ],
			[ 'The Foobar Wiki', 'Foobar Comunidad', 'es' ],
			[ 'There And Here', 'There And Here', 'fr' ],
			[ 'There And Here Wiki', 'There And Here Społeczność', 'pl' ],
		];
	}
}
