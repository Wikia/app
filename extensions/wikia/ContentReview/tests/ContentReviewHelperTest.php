<?php

class ContentReviewHelperTest extends WikiaBaseTest {

	public function setUp() {
		$this->setupFile = __DIR__ . '/../ContentReview.setup.php';
		parent::setUp();
	}

	/**
	 * @param bool $isJsPage
	 * @param bool $inNamespace
	 * @param string $contentType
	 * @param bool $expected
	 * @dataProvider shouldPageContentBeReplacedData
	 */
	public function testIsPageForReview( $isJsPage, $inNamespace, $contentType, $expected ) {
		$titleMock = $this->getMock( '\Title', [ 'isJsPage', 'inNamespace' ] );
		$titleMock->expects( $this->once() )
			->method( 'isJsPage' )
			->willReturn( $isJsPage );

		$titleMock->expects( $this->any() )
			->method( 'inNamespace' )
			->willReturn( $inNamespace );

		$value = ( new Wikia\ContentReview\Helper() )->isPageReviewed( $titleMock, $contentType );
		$this->assertEquals( $expected, $value );
	}

	/**
	 * Test for \Wikia\ContentReview\Hooks::onRawPageViewBeforeOutput hook
	 *
	 * To review different cases - check the documentation of the dataProvider.
	 *
	 * @dataProvider replaceWithLastApprovedRevisionProvider
	 * @param bool $isPageReviewed
	 * @param int $latestRevID
	 * @param array $latestReviewedRevision
	 * @param bool $isTestModeEnabled
	 * @param bool $revisionExists
	 * @param string $originalText
	 * @param string $lastReviewedText
	 * @param string $expectedText
	 */
	public function testReplaceWithLastApprovedRevision( $isPageReviewed, $latestRevID,
		array $latestReviewedRevision, $isTestModeEnabled, $revisionExists, $originalText, $lastReviewedText, $expectedText
	) {
		/**
		 * Case 1 - if a page does not qualify to be reviewed just return the original text.
		 */
		if ( !$isPageReviewed ) {
			$mockTitle = $this->getMock( '\Title' );

			$mockHelper = $this->getMock( '\Wikia\ContentReview\Helper', [ 'isPageReviewed' ] );
			$mockHelper->expects( $this->once() )
				->method( 'isPageReviewed' )
				->willReturn( $isPageReviewed );

			$textReturn = $mockHelper->replaceWithLastApproved( $mockTitle, 'text/css', $originalText );
		} else {
			$mockContentType = 'text/javascript';

			/* @var \Title $titleMock */
			$titleMock = $this->getMock( '\Title', [ 'getArticleID', 'getLatestRevID' ] );
			$titleMock->expects( $this->once() )
				->method( 'getLatestRevID' )
				->willReturn( $latestRevID );

			/* @var \Wikia\ContentReview\Models\CurrentRevisionModel $currentRevisionModelMock */
			$currentRevisionModelMock = $this->getMock( 'Wikia\ContentReview\Models\CurrentRevisionModel', [
				'getLatestReviewedRevision'
			] );
			$currentRevisionModelMock->expects( $this->once() )
				->method( 'getLatestReviewedRevision' )
				->willReturn( $latestReviewedRevision );

			/* @var \Wikia\ContentReview\Helper $helperMock */
			$helperMock = $this->getMock( '\Wikia\ContentReview\Helper', [
				'isPageReviewed',
				'getCurrentRevisionModel',
				'isContentReviewTestModeEnabled',
				'getRevisionById',
			] );
			$helperMock->expects( $this->once() )
				->method( 'isPageReviewed' )
				->willReturn( $isPageReviewed );
			$helperMock->expects( $this->once() )
				->method( 'getCurrentRevisionModel' )
				->willReturn( $currentRevisionModelMock );
			$helperMock->expects( $this->any() )
				->method( 'isContentReviewTestModeEnabled' )
				->willReturn( $isTestModeEnabled );

			/**
			 * Handle Case 4 and Case 5 - if the Revision does not exist the value returned
			 * by getRevisionById is `false` to match the values returned by the original method.
			 */
			if ( $revisionExists ) {
				/* @var \Revision $revisionMock */
				$revisionMock = $this->getMockBuilder( '\Revision' )
					->disableOriginalConstructor()
					->setMethods( [ 'getRawText' ] )
					->getMock();
				$revisionMock->expects( $this->any() )
					->method( 'getRawText' )
					->willReturn( $lastReviewedText );
			} else {
				$revisionMock = false;
			}

			$helperMock->expects( $this->any() )
				->method( 'getRevisionById' )
				->willReturn( $revisionMock );

			$textReturn = $helperMock->replaceWithLastApproved( $titleMock, $mockContentType, $originalText );
		}

		$this->assertEquals( $expectedText, $textReturn );
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
		$originalText = 'This is the original text.';
		$lastReviewedText = 'This is the last reviewed text.';
		$emptyText = '';

		return [
			/**
			 * Case 1 - a page does not qualify to be reviewed (isPageReviewed === false).
			 */
			[
				false, // isPageReviewed()
				0, // getLatestRevID()
				[], // getLatestReviewedRevision()
				false, // isContentReviewTestModeEnabled()
				false, // $revisionExists
				$originalText,
				$lastReviewedText,
				$originalText, // $expectedText
			],
			/**
			 * Case 2 - Latest rev_id matches the last reviewed rev_id
			 */
			[
				true, // isPageReviewed()
				100, // getLatestRevID()
				[ 'revision_id' => 100 ], // getLatestReviewedRevision()
				false, // isContentReviewTestModeEnabled()
				false, // $revisionExists
				$originalText,
				$lastReviewedText,
				$originalText, // $expectedText
			],
			/**
			 * Case 3 - Test mode is enabled
			 */
			[
				true, // isPageReviewed()
				100, // getLatestRevID()
				[ 'revision_id' => 99 ], // getLatestReviewedRevision()
				true, // isContentReviewTestModeEnabled()
				false, // $revisionExists
				$originalText,
				$lastReviewedText,
				$originalText, // $expectedText
			],
			/**
			 * Case 4 - You want to get a reviewed revision but it does not exist (e.g. for new, unreviewed pages)
			 */
			[
				true, // isPageReviewed()
				99, // getLatestRevID()
				[ 'revision_id' => 100 ], // getLatestReviewedRevision()
				false, // isContentReviewTestModeEnabled()
				false, // $revisionExists
				$originalText,
				$lastReviewedText,
				$emptyText, // $expectedText
			],
			/**
			 * Case 5 - You get the latest approved revision.
			 */
			[
				true, // isPageReviewed()
				99, // getLatestRevID()
				[ 'revision_id' => 100 ], // getLatestReviewedRevision()
				false, // isContentReviewTestModeEnabled()
				true, // $revisionExists
				$originalText,
				$lastReviewedText,
				$lastReviewedText, // $expectedText
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
