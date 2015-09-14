<?php

class ContentReviewHelperTest extends WikiaBaseTest {
	public function setUp() {
		$this->setupFile = __DIR__ . '/../ContentReview.setup.php';
		parent::setUp();
	}

	/**
	 * @dataProvider replaceWithLastApprovedRevisionProvider
	 * Test for \Wikia\ContentReview\Hooks::onRawPageViewBeforeOutput hook
	 */
	public function testReplaceWithLastApprovedRevision( $params, $textExpected, $message ) {

		/* @var \Title $titleMock */
		$titleMock = $this->getMockBuilder( '\Title' )
			->disableOriginalConstructor()
			->setMethods( [ 'getArticleID', 'getLatestRevID', 'isJsPage' ] )
			->getMock();
		$titleMock->method( 'getArticleID' )
			->will( $this->returnValue( $params['pageId'] ) );
		$titleMock->method( 'getLatestRevID' )
			->will( $this->returnValue( $params['latestRevId'] ) );
		$titleMock->method( 'isJsPage' )
			->will( $this->returnValue( $params['isJsPage'] ) );

		/* @var \Wikia\ContentReview\Models\CurrentRevisionModel $currentRevisionModelMock */
		$currentRevisionModelMock = $this->getMockBuilder( '\Wikia\ContentReview\Models\CurrentRevisionModel' )
			->disableOriginalConstructor()
			->setMethods( [ 'getLatestReviewedRevision' ] )
			->getMock();
		$currentRevisionModelMock->method( 'getLatestReviewedRevision' )
			->will( $this->returnValue( $params['latestApprovedRevData'] ) );

		/* @var \Revision $revisionMock */
		$revisionMock = $this->getMockBuilder( '\Revision' )
			->disableOriginalConstructor()
			->setMethods( [ 'getRawText' ] )
			->getMock();
		$revisionMock->method( 'getRawText' )
			->will( $this->returnValue( $params['latestApprovedRevText'] ) );

		$this->mockGlobalVariable( 'wgJsMimeType', $params['wgJsMimeType'] );

		/* @var \Wikia\ContentReview\Helper $helperMock */
		$helperMock = $this->getMockBuilder( '\Wikia\ContentReview\Helper' )
			->disableOriginalConstructor()
			->setMethods( [ 'getCurrentRevisionModel', 'getRevisionById', 'isContentReviewTestModeEnabled' ] )
			->getMock();
		$helperMock->method( 'getCurrentRevisionModel' )
			->will( $this->returnValue( $currentRevisionModelMock ) );
		$helperMock->method( 'isContentReviewTestModeEnabled' )
			->will( $this->returnValue( $params['isContentReviewTestModeEnabled'] ) );
		$helperMock->method( 'getRevisionById' )
			->will( $this->returnValue( $revisionMock ) );

		$helperMock->replaceWithLastApproved( $titleMock, $params['contentType'], $params['text'] );

		$this->assertEquals( $textExpected, $params['text'], $message );
	}

	/**
	 * @dataProvider userCanEditJsPageProvider
	 * @param bool $inNamespace
	 * @param bool $isJsPage
	 * @param bool $userCan
	 * @param bool $expected
	 */
	public function testUserCanEditJsPage( $inNamespace, $isJsPage, $userCan, $expected ) {
		$titleMock = $this->getMock( 'Title', [ 'inNamespace', 'isJsPage', 'userCan' ] );

		$titleMock->expects( $this->any() )
			->method( 'inNamespace' )
			->willReturn( $inNamespace );
		$titleMock->expects( $this->any() )
			->method( 'isJsPage' )
			->willReturn( $isJsPage );
		$titleMock->expects( $this->any() )
			->method( 'userCan' )
			->willReturn( $userCan );

		$userMock = $this->getMock( 'User' );
		$helper = new \Wikia\ContentReview\Helper();

		$this->assertEquals( $expected, $helper->userCanEditJsPage( $titleMock, $userMock ) );
	}

	public function replaceWithLastApprovedRevisionProvider() {
		$pageId = 123;
		$revId1 = 566;
		$revId2 = 567;
		$revIdNull = null;
		$textEmpty = '';
		$text1 = '';
		$text2 = '';
		$jsType = 'jstype';
		return [
			[
				[
					'pageId' => $pageId,
					'latestRevId' => $revId1,
					'isJsPage' => true,
					'contentType' => 'no impact in this test, random 6519846169498',
					'latestApprovedRevData' => [
						'revision_id' => $revId1
					],
					'latestApprovedRevText' => 'revision text',
					'isContentReviewTestModeEnabled' => false,
					'text' => $text1,
				],
				$text1,
				'Latest revision id same as latest approved revision',
			],
			[
				[
					'pageId' => $pageId,
					'latestRevId' => $revId2,
					'isJsPage' => true,
					'contentType' => 'no impact in this test, random 4563786783453',
					'latestApprovedRevData' => [
						'revision_id' => $revId1
					],
					'latestApprovedRevText' => $text1,
					'isContentReviewTestModeEnabled' => false,
					'text' => $text2,
				],
				$text1,
				'Current text replaced with last approved revision',
			],
			[
				[
					'pageId' => $pageId,
					'latestRevId' => $revId2,
					'isJsPage' => true,
					'contentType' => 'no impact in this test',
					'latestApprovedRevData' => [
						'revision_id' => $revIdNull
					],
					'latestApprovedRevText' => $text1,
					'isContentReviewTestModeEnabled' => false,
					'text' => $text2,
				],
				$textEmpty,
				'No approved revision. Text empty.',
			],
			[
				[
					'pageId' => $pageId,
					'latestRevId' => $revId2,
					'isJsPage' => false,
					'contentType' => $jsType,
					'wgJsMimeType' => $jsType,
					'latestApprovedRevData' => [
						'revision_id' => $revIdNull
					],
					'latestApprovedRevText' => $text1,
					'isContentReviewTestModeEnabled' => false,
					'text' => $text2,
				],
				$text1,
				'Is not isJsPage but is wgJsMimeType. Text replaced with last approved revision',
			],
			[
				[
					'pageId' => $pageId,
					'latestRevId' => $revId2,
					'isJsPage' => true,
					'contentType' => 'no impact in this test, random 1519849198824',
					'latestApprovedRevData' => [
						'revision_id' => $revId1
					],
					'latestApprovedRevText' => $text1,
					'isContentReviewTestModeEnabled' => true,
					'text' => $text2,
				],
				$text2,
				'Test mode enabled. Text unchanged',
			],
		];
	}

	public function userCanEditJsPageProvider() {
		return [
			[ true, true, true, true ],
			[ true, true, false, false ],
			[ true, false, true, false ],
			[ true, false, false, false ],
			[ false, false, false, false ],
			[ false, false, true, false ],
			[ false, true, false, false ],
			[ false, true, true, false ],
		];
	}
}
