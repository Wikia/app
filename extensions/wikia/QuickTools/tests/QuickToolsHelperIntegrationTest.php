<?php

/**
 * @group Integration
 */
class QuickToolsHelperIntegrationTest extends WikiaDatabaseTest {
	const TARGET_USER_NAME = 'TargetUser';
	const TARGET_ANON = '8.8.8.8';

	const ADMIN_USER_ID = 4;
	const ADMIN_USER_NAME = 'AdminUser';

	const TEST_SUMMARY = 'test summary';

	private $wgDefaultExternalStoreWasFalse = true;

	/** @var QuickToolsHelper $quickToolsHelper */
	private $quickToolsHelper;

	protected function setUp() {
		global $wgDefaultExternalStore;
		parent::setUp();

		if ( $wgDefaultExternalStore ) {
			$wgDefaultExternalStore = $this->wgDefaultExternalStoreWasFalse = false;
		}

		$hooks = &Hooks::getHandlersArray();
		$hooks = [];

		$adminUser = $this->getMockBuilder( User::class )
			->setMethods( [ 'incEditCount' ] )
			->getMock();
		$adminUser->setId( static::ADMIN_USER_ID );

		$this->quickToolsHelper = new QuickToolsHelper();

		$context = new DerivativeContext( $this->quickToolsHelper->getContext() );
		$context->setUser( $adminUser );

		$this->quickToolsHelper->setContext( $context );
	}

	/**
	 * @dataProvider provideUserTimeAndExpectedTitles
	 *
	 * @param string $userName
	 * @param string $timeStamp
	 * @param string[] $expectedTitleSet
	 */
	public function testGetRollbackTitles( string $userName, string $timeStamp, array $expectedTitleSet ) {
		$titleSet = $this->quickToolsHelper->getRollbackTitles( $userName, $timeStamp );

		$this->assertContainsOnly( Title::class, $titleSet );

		foreach ( $titleSet as $title ) {
			$this->assertContains( $title->getText(), $expectedTitleSet );
		}
	}

	public function provideUserTimeAndExpectedTitles(): Generator {
		yield [ static::TARGET_USER_NAME, '', [ 'TestArticleOne', 'TestArticle2', 'TestTalkPage' ] ];
		yield [ static::TARGET_USER_NAME, '20110101000000', [ 'TestArticle2', 'TestTalkPage' ] ];
		yield [ static::TARGET_ANON, '', [ 'TestAnonArticle' ] ];
	}

	/**
	 * @dataProvider provideUserTimeCombinationsThatHaveNoResults
	 *
	 * @param string $userName
	 * @param string $timeStamp
	 */
	public function testGetRollbackTitlesNoResults( string $userName, string $timeStamp ) {
		$titleSet = $this->quickToolsHelper->getRollbackTitles( $userName, $timeStamp );

		$this->assertEmpty( $titleSet );
	}

	public function provideUserTimeCombinationsThatHaveNoResults(): Generator {
		yield [ static::TARGET_USER_NAME, '20180101000000' ];
		yield [ 'UserWithNoEdits', '' ];
		yield [ static::TARGET_ANON, '20180101000000' ];
		yield [ '0.0.0.0', '20180101000000' ];
	}

	public function testCannotRollbackNonExistingArticle() {
		$title = Title::makeTitle( NS_MAIN, 'TitleDoesNotExist' );

		$result =
			$this->quickToolsHelper->rollbackTitle( $title, static::TARGET_USER_NAME, '',
				static::TEST_SUMMARY );

		$this->assertFalse( $result );
	}

	/**
	 * @dataProvider provideTitleUserTimeAndExpectedContent
	 *
	 * @param string $userName
	 * @param string $article
	 * @param string $timeStamp
	 * @param string $contentAfterRollback
	 */
	public function testRollback(
		string $userName, string $article, string $timeStamp, string $contentAfterRollback
	) {
		$title = Title::makeTitle( NS_MAIN, $article );

		$result =
			$this->quickToolsHelper->rollbackTitle( $title, $userName, $timeStamp,
				static::TEST_SUMMARY );

		$this->assertTrue( $result );

		$latestRevisionId = $title->getLatestRevID( Title::GAID_FOR_UPDATE );
		$latestRevision = Revision::newFromId( $latestRevisionId, Revision::READ_LATEST );

		$this->assertEquals( static::TEST_SUMMARY, $latestRevision->getComment() );
		$this->assertEquals( static::ADMIN_USER_ID, $latestRevision->getUser() );
		$this->assertEquals( $contentAfterRollback, $latestRevision->getRawText() );
	}

	public function provideTitleUserTimeAndExpectedContent(): Generator {
		yield [ static::TARGET_USER_NAME, 'TestArticle2', '', 'RevisionToRevertTo' ];
		yield [ static::TARGET_USER_NAME, 'TestArticle2', '20100101000000', 'RevisionToRevertTo' ];
	}

	protected function tearDown() {
		parent::tearDown();

		if ( !$this->wgDefaultExternalStoreWasFalse ) {
			$GLOBALS['wgDefaultExternalStore'] = true;
		}
	}

	protected function getDataSet() {
		return $this->createYamlDataSet( __DIR__ . '/fixtures/quick_tools.yaml' );
	}
}
