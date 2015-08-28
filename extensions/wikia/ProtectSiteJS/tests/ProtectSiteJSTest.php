<?php

class ProtectSiteJSTest extends WikiaBaseTest {
	public function setUp() {
		$this->setupFile = __DIR__ . '/../ProtectSiteJS_setup.php';
		parent::setUp();
	}

	/**
	 * @dataProvider handlerProvider
	 */
	public function testHandler( $testData, $expectedResult ) {
		$outputMock = $this->getMock( 'OutputPage', [ 'addHTML', 'addWikiMsg' ] );
		$this->mockGlobalVariable( 'wgOut', $outputMock );

		$title = Title::makeTitle( $testData['namespace'], $testData['title'] );
		$this->mockGlobalVariable( 'wgTitle', $title );

		$this->mockGlobalVariable( 'wgCityId', $testData['wikiId'] );

		$userMock = $this->getMock( 'User', [ 'getName', 'getEffectiveGroups', 'isAllowed' ] );

		$userMock->expects( $this->any() )
			->method( 'getName' )
			->will( $this->returnValue( $testData['username'] ) );

		$userMock->expects( $this->any() )
			->method( 'isAllowed' )
			->with( 'editinterfacetrusted' )
			->will( $this->returnValue( $testData['editinterfacetrusted'] ) );

		$userMock->expects( $this->once() )
			->method( 'getEffectiveGroups' )
			->will( $this->returnValue( $testData['groups'] ) );

		$this->mockGlobalVariable( 'wgUser', $userMock );

		$result = ProtectSiteJS::handler();

		$this->assertSame( $result, $expectedResult );
	}

	public function handlerProvider() {
		return [
			[
				[
					'title' => 'Foo.js',
					'namespace' => NS_MEDIAWIKI,
					'username' => 'SomeUser',
					'groups' => [ 'sysop' ],
					'editinterfacetrusted' => false,
					'wikiId' => 147,
				],
				false
			],
			[
				[
					'title' => 'Foo.js',
					'namespace' => NS_USER,
					'username' => 'SomeUser',
					'groups' => [ 'sysop' ],
					'editinterfacetrusted' => false,
					'wikiId' => 147,
				],
				false
			],
			[
				[
					'title' => 'Foo.js',
					'namespace' => NS_MAIN,
					'username' => 'SomeUser',
					'groups' => [ 'sysop' ],
					'editinterfacetrusted' => false,
					'wikiId' => 147,
				],
				false
			],
			[
				[
					'title' => 'Foo.js',
					'namespace' => NS_MEDIAWIKI,
					'username' => 'SomeUser',
					'groups' => [ 'staff' ],
					'editinterfacetrusted' => false,
					'wikiId' => 147,
				],
				true
			],
			[
				[
					'title' => 'Foo.js',
					'namespace' => NS_MEDIAWIKI,
					'username' => 'SomeUser',
					'groups' => [ 'sysop' ],
					'editinterfacetrusted' => true,
					'wikiId' => 147,
				],
				true
			],
			[
				[
					'title' => 'SomeUser/common.js',
					'namespace' => NS_MEDIAWIKI,
					'username' => 'SomeUser',
					'groups' => [],
					'editinterfacetrusted' => false,
					'wikiId' => 147,
				],
				false
			],
			[
				[
					'title' => 'SomeUser/common.js',
					'namespace' => NS_USER,
					'username' => 'SomeUser',
					'groups' => [],
					'editinterfacetrusted' => false,
					'wikiId' => 147,
				],
				true
			],
			[
				[
					'title' => 'SomeUser/wikia.js',
					'namespace' => NS_USER,
					'username' => 'SomeUser',
					'groups' => [],
					'editinterfacetrusted' => false,
					'wikiId' => 147,
				],
				true
			],
			[
				[
					'title' => 'SomeUser/monobook.js',
					'namespace' => NS_USER,
					'username' => 'SomeUser',
					'groups' => [],
					'editinterfacetrusted' => false,
					'wikiId' => 147,
				],
				true
			],
			[
				[
					'title' => 'SomeUser/global.js',
					'namespace' => NS_USER,
					'username' => 'SomeUser',
					'groups' => [],
					'editinterfacetrusted' => false,
					'wikiId' => Wikia::COMMUNITY_WIKI_ID,
				],
				true
			],
			[
				[
					'title' => 'SomeUser/global.js',
					'namespace' => NS_USER,
					'username' => 'SomeUser',
					'groups' => [],
					'editinterfacetrusted' => false,
					'wikiId' => 147,
				],
				false
			],
			[
				[
					'title' => 'SomeUser/foo.js',
					'namespace' => NS_USER,
					'username' => 'SomeUser',
					'groups' => [],
					'editinterfacetrusted' => false,
					'wikiId' => 147,
				],
				false
			],
		];
	}
}
