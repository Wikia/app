<?php

class ContentReviewHelperTest extends WikiaBaseTest {

	public function setUp() {
		$this->setupFile = __DIR__ . '/../ContentReview.setup.php';
		parent::setUp();
	}

	/**
	 * @param $isJsPage
	 * @param $inNamespace
	 * @param $contentType
	 * @param $expected
	 * @dataProvider shouldPageContentBeReplacedData
	 */
	public function testShouldPageContentBeReplaced( $isJsPage, $inNamespace, $contentType, $expected ) {
		$titleMock = $this->getMock( '\Title', [ 'isJsPage', 'inNamespace' ] );
		$titleMock->expects( $this->once() )
			->method( 'isJsPage' )
			->willReturn( $isJsPage );

		$titleMock->expects( $this->any() )
			->method( 'inNamespace' )
			->willReturn( $inNamespace );

		$value = ( new Wikia\ContentReview\Helper() )->shouldPageContentBeReplaced( $titleMock, $contentType );
		$this->assertEquals( $expected, $value );
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
	 * @param bool $isJsPage
	 * @param bool $userCan
	 * @param bool $expected
	 */
	public function testUserCanEditJsPage( $isJsPage, $userCan, $expected ) {
		$titleMock = $this->getMock( 'Title', [ 'isJsPage', 'userCan' ] );

		$titleMock->expects( $this->any() )
			->method( 'isJsPage' )
			->willReturn( $isJsPage );
		$titleMock->expects( $this->any() )
			->method( 'userCan' )
			->willReturn( $userCan );

		$userMock = $this->getMock( 'User' );

		$this->assertEquals( $expected, $this->getHelper()->userCanEditJsPage( $titleMock, $userMock ) );
	}

	/**
	 * @param int $latestReviewedId
	 * @param int $oldId
	 * @param bool $expected
	 * @param string $message
	 * @dataProvider hasPageApprovedIdProvider
	 */
	public function testHasPageApprovedId( $latestReviewedId, $oldId, $expected, $message ) {
		$modelMock = $this->getMock( 'Wikia\ContentReview\Models\CurrentRevisionModel', [ 'getLatestReviewedRevision' ] );
		$modelMock->expects( $this->once() )
			->method( 'getLatestReviewedRevision' )
			->willReturn( $latestReviewedId );

		$this->assertEquals( $expected, $this->getHelper()->hasPageApprovedId( $modelMock, 0, 0, $oldId ), $message );
	}

	public function shouldPageContentBeReplacedData() {
		$goodMimeType = 'text/javascript';
		$badMimeType = 'text/css';
		return [
			[
				false, // isJsPage()
				false, // inNamespace()
				$badMimeType,
				false, // expected
			],
			[
				false, // isJsPage()
				true, // inNamespace()
				$badMimeType,
				false, // expected
			],
			[
				false, // isJsPage()
				false, // inNamespace()
				$goodMimeType,
				false, // expected
			],
			[
				false, // isJsPage()
				true, // inNamespace()
				$goodMimeType,
				true, // expected
			],
			[
				true, // isJsPage()
				false, // inNamespace()
				$badMimeType,
				true, // expected
			],
		];
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
			[ true, true, true ],
			[ true, false, false ],
			[ false, true, false ],
			[ false, false, false ],
		];
	}

	public function hasPageApprovedIdProvider() {
		return [
			[
				[
					'revision_id' => '100',
				],
				100,
				true,
				'Latest approved ID exists and matches the provided oldid',
			],
			[
				[
					'revision_id' => '100',
				],
				101,
				false,
				'Latest approved ID exists and does not match the provided oldid',
			],
			[
				[],
				101,
				false,
				'Latest approved ID does not exist',
			],
		];
	}

	/**
	 * @return \Wikia\ContentReview\Helper
	 */
	private function getHelper() {
		return new \Wikia\ContentReview\Helper();
	}
}
