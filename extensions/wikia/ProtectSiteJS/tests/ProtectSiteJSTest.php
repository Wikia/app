<?php

class ProtectSiteJSTest extends WikiaBaseTest {
	public function setUp() {
		$this->setupFile = __DIR__ . '/../ProtectSiteJS_setup.php';
		parent::setUp();
	}

	/**
	 * @dataProvider handlerProvider
	 */
	public function testHandler( $testData, $expectedResult, $message ) {
		$outputMock = $this->getMock( 'OutputPage', [ 'addHTML', 'addWikiMsg' ] );
		$this->mockGlobalVariable( 'wgOut', $outputMock );

		$title = Title::makeTitle( $testData['namespace'], $testData['title'] );
		$this->mockGlobalVariable( 'wgTitle', $title );

		$this->mockGlobalVariable( 'wgCityId', $testData['wikiId'] );
		$this->mockGlobalVariable( 'wgEnableContentReviewExt', $testData['wgEnableContentReviewExt'] );
		$this->mockGlobalVariable( 'wgUseSiteJs', $testData['wgUseSiteJs'] );

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

		$this->assertSame( $result, $expectedResult, $message );
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
					'wgEnableContentReviewExt' => false,
					'wgUseSiteJs' => true,
				],
				false,
				'Admins cannot edit MediaWiki JS pages',
			],
			[
				[
					'title' => 'Foo.js',
					'namespace' => NS_USER,
					'username' => 'SomeUser',
					'groups' => [ 'sysop' ],
					'editinterfacetrusted' => false,
					'wikiId' => 147,
					'wgEnableContentReviewExt' => false,
					'wgUseSiteJs' => true,
				],
				false,
				'Admins cannot edit User JS pages',
			],
			[
				[
					'title' => 'Foo.js',
					'namespace' => NS_MAIN,
					'username' => 'SomeUser',
					'groups' => [ 'sysop' ],
					'editinterfacetrusted' => false,
					'wikiId' => 147,
					'wgEnableContentReviewExt' => false,
					'wgUseSiteJs' => true,
				],
				false,
				'Admins cannot edit other namespace JS pages',
			],
			[
				[
					'title' => 'Foo.js',
					'namespace' => NS_MEDIAWIKI,
					'username' => 'SomeUser',
					'groups' => [ 'staff' ],
					'editinterfacetrusted' => false,
					'wikiId' => 147,
					'wgEnableContentReviewExt' => false,
					'wgUseSiteJs' => true,
				],
				true,
				'Staff can edit MediaWiki JS pages',
			],
			[
				[
					'title' => 'Foo.js',
					'namespace' => NS_MEDIAWIKI,
					'username' => 'SomeUser',
					'groups' => [ 'sysop' ],
					'editinterfacetrusted' => true,
					'wikiId' => 147,
					'wgEnableContentReviewExt' => false,
					'wgUseSiteJs' => true,
				],
				true,
				'Admins with editinterfacetrusted can edit MediaWiki JS pages',
			],
			[
				[
					'title' => 'SomeUser/common.js',
					'namespace' => NS_MEDIAWIKI,
					'username' => 'SomeUser',
					'groups' => [],
					'editinterfacetrusted' => false,
					'wikiId' => 147,
					'wgEnableContentReviewExt' => false,
					'wgUseSiteJs' => true,
				],
				false,
				'Valid user JS subpage names cannot be edited in other namespaces',
			],
			[
				[
					'title' => 'SomeUser/chat.js',
					'namespace' => NS_USER,
					'username' => 'SomeUser',
					'groups' => [],
					'editinterfacetrusted' => false,
					'wikiId' => 147,
					'wgEnableContentReviewExt' => false,
					'wgUseSiteJs' => true,
				],
				true,
				'Valid user JS subpages can be edited by the user',
			],
			[
				[
					'title' => 'SomeUser/common.js',
					'namespace' => NS_USER,
					'username' => 'SomeUser',
					'groups' => [],
					'editinterfacetrusted' => false,
					'wikiId' => 147,
					'wgEnableContentReviewExt' => false,
					'wgUseSiteJs' => true,
				],
				true,
				'Valid user JS subpages can be edited by the user',
			],
			[
				[
					'title' => 'SomeUser/wikia.js',
					'namespace' => NS_USER,
					'username' => 'SomeUser',
					'groups' => [],
					'editinterfacetrusted' => false,
					'wikiId' => 147,
					'wgEnableContentReviewExt' => false,
					'wgUseSiteJs' => true,
				],
				true,
				'Valid user JS subpages can be edited by the user',
			],
			[
				[
					'title' => 'SomeUser/monobook.js',
					'namespace' => NS_USER,
					'username' => 'SomeUser',
					'groups' => [],
					'editinterfacetrusted' => false,
					'wikiId' => 147,
					'wgEnableContentReviewExt' => false,
					'wgUseSiteJs' => true,
				],
				true,
				'Valid user JS subpages can be edited by the user',
			],
			[
				[
					'title' => 'SomeUser/global.js',
					'namespace' => NS_USER,
					'username' => 'SomeUser',
					'groups' => [],
					'editinterfacetrusted' => false,
					'wikiId' => Wikia::COMMUNITY_WIKI_ID,
					'wgEnableContentReviewExt' => false,
					'wgUseSiteJs' => true,
				],
				true,
				'User global JS subpage can be edited by the user on central wikia',
			],
			[
				[
					'title' => 'SomeUser/global.js',
					'namespace' => NS_USER,
					'username' => 'SomeUser',
					'groups' => [],
					'editinterfacetrusted' => false,
					'wikiId' => 147,
					'wgEnableContentReviewExt' => false,
					'wgUseSiteJs' => true,
				],
				false,
				'User global JS subpage cannot be edited on wikias other than central',
			],
			[
				[
					'title' => 'SomeUser/foo.js',
					'namespace' => NS_USER,
					'username' => 'SomeUser',
					'groups' => [],
					'editinterfacetrusted' => false,
					'wikiId' => 147,
					'wgEnableContentReviewExt' => false,
					'wgUseSiteJs' => true,
				],
				false,
				'Invalid user JS subpages cannot be edited',
			],
			[
				[
					'title' => 'Foo.js',
					'namespace' => NS_MEDIAWIKI,
					'username' => 'SomeUser',
					'groups' => [ 'sysop' ],
					'editinterfacetrusted' => false,
					'wikiId' => 147,
					'wgEnableContentReviewExt' => true,
					'wgUseSiteJs' => true,
				],
				true,
				'Admins can edit MediaWiki JS pages if content review is enabled',
			],
			[
				[
					'title' => 'Foo.js',
					'namespace' => NS_MAIN,
					'username' => 'SomeUser',
					'groups' => [ 'sysop' ],
					'editinterfacetrusted' => false,
					'wikiId' => 147,
					'wgEnableContentReviewExt' => true,
					'wgUseSiteJs' => true,
				],
				false,
				'Admins cannot edit non-MediaWiki JS pages if content review is enabled',
			],
			[
				[
					'title' => 'SomeOtherUser/foo.js',
					'namespace' => NS_USER,
					'username' => 'SomeUser',
					'groups' => [ 'sysop' ],
					'editinterfacetrusted' => false,
					'wikiId' => 147,
					'wgEnableContentReviewExt' => true,
					'wgUseSiteJs' => true,
				],
				false,
				"Admins cannot edit other user's JS pages even if content review is enabled",
			],
			[
				[
					'title' => 'SomeUser/foo.js',
					'namespace' => NS_USER,
					'username' => 'SomeUser',
					'groups' => [],
					'editinterfacetrusted' => false,
					'wikiId' => 147,
					'wgEnableContentReviewExt' => true,
					'wgUseSiteJs' => true,
				],
				false,
				'Invalid user JS subpages cannot be edited even if content review is enabled',
			],
			[
				[
					'title' => 'Foo.js',
					'namespace' => NS_MEDIAWIKI,
					'username' => 'SomeUser',
					'groups' => [ 'sysop' ],
					'editinterfacetrusted' => false,
					'wikiId' => 147,
					'wgEnableContentReviewExt' => true,
					'wgUseSiteJs' => false,
				],
				false,
				'Admins cannot edit MediaWiki JS pages if content review is enabled but site JS is disabled',
			],
			[
				[
					'title' => 'Foo.js',
					'namespace' => NS_MEDIAWIKI_TALK,
					'username' => 'SomeUser',
					'groups' => [ 'sysop' ],
					'editinterfacetrusted' => false,
					'wikiId' => 147,
					'wgEnableContentReviewExt' => false,
					'wgUseSiteJs' => false,
				],
				true,
				'Edits to *.js talk pages are allowed',
			],
			[
				[
					'title' => 'SomeOtherUser/foo.js',
					'namespace' => NS_USER_TALK,
					'username' => 'SomeUser',
					'groups' => [],
					'editinterfacetrusted' => false,
					'wikiId' => 147,
					'wgEnableContentReviewExt' => false,
					'wgUseSiteJs' => true,
				],
				true,
				'Edits to *.js talk pages are allowed',
			],
		];
	}
}
