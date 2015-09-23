<?php

class ContentReviewHelperTest extends WikiaBaseTest {

	public function setUp() {
		$this->setupFile = __DIR__ . '/../ContentReview.setup.php';
		parent::setUp();
	}

	/**
	 * @param $titleData
	 * @param string $contentType
	 * @param bool $expected
	 * @param $message
	 * @dataProvider isPageForReviewTestData
	 */
	public function testIsPageForReview( $titleData, $contentType, $expected, $message ) {
		$title = Title::makeTitle( $titleData['titleNamespace'], $titleData['titleText'] );
		$value = ( new Wikia\ContentReview\Helper() )->isPageReviewed( $title, $contentType );
		$this->assertEquals( $expected, $value, $message );
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
	public function testReplaceWithLastApprovedRevision( $isPageReviewed, $latestRevID, array $latestReviewedRevision,
		$isTestModeEnabled, $revisionExists, $originalText, $lastReviewedText, $expectedText, $message
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
				$revisionMock = null;
			}

			$helperMock->expects( $this->any() )
				->method( 'getRevisionById' )
				->willReturn( $revisionMock );

			$textReturn = $helperMock->replaceWithLastApproved( $titleMock, $mockContentType, $originalText );
		}

		$this->assertEquals( $expectedText, $textReturn, $message );
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

	public function isPageForReviewTestData() {
		$goodMimeType = 'text/javascript';
		$badMimeType = 'text/css';
		return [
			[
				[
					'titleText' => 'TestArticle',
					'titleNamespace' => NS_MAIN,
				],
				$badMimeType,
				false, // expected
				'A regular article from the Main namespace should not be reviewed.',
			],
			[
				[
					'titleText' => 'TestArticle',
					'titleNamespace' => NS_MEDIAWIKI,
				],
				$badMimeType,
				false, // expected
				'A non-JS article from MediaWiki namespace should not be reviewed.',
			],
			[
				[
					'titleText' => 'TestArticle',
					'titleNamespace' => NS_MAIN,
				],
				$goodMimeType,
				false, // expected
				'An article from the Main namespace should not be reviewed, even if its mimetype is JS. This one is for the sake of scripts from dev.wikia.com.',
			],
			[
				[
					'titleText' => 'TestArticle',
					'titleNamespace' => NS_MEDIAWIKI,
				],
				$goodMimeType,
				true, // expected
				'An article from the MediaWiki namespace with a JS mimetype should be reviewed, even if its name does not end with .js.',
			],
			[
				[
					'titleText' => 'TestArticle.js',
					'titleNamespace' => NS_MEDIAWIKI,
				],
				$badMimeType,
				true, // expected
				'An article from the MediaWiki namespace with a name ending with .js should be reviewed, even if the mimetype is not JS.',
			],
			[
				[
					'titleText' => 'TestArticle.js',
					'titleNamespace' => NS_MEDIAWIKI,
				],
				$goodMimeType,
				true, // expected
				'A JS article from the MediaWiki namespace should be reviewed.',
			],
		];
	}

	public function replaceWithLastApprovedRevisionProvider() {
		$originalText = 'This is the original text.';
		$lastReviewedText = 'This is the last reviewed text.';
		$emptyText = '';

		return [
			[
				false, // isPageReviewed()
				0, // getLatestRevID()
				[], // getLatestReviewedRevision()
				false, // isContentReviewTestModeEnabled()
				false, // $revisionExists
				$originalText,
				$lastReviewedText,
				$originalText, // $expectedText
				$message = 'Case 1 - a page does not qualify to be reviewed (isPageReviewed === false).',
			],
			[
				true, // isPageReviewed()
				100, // getLatestRevID()
				[ 'revision_id' => 100 ], // getLatestReviewedRevision()
				false, // isContentReviewTestModeEnabled()
				true, // $revisionExists
				$originalText,
				$lastReviewedText,
				$originalText, // $expectedText
				$message = 'Case 2 - Latest rev_id matches the last reviewed rev_id',
			],
			[
				true, // isPageReviewed()
				100, // getLatestRevID()
				[ 'revision_id' => 99 ], // getLatestReviewedRevision()
				true, // isContentReviewTestModeEnabled()
				true, // $revisionExists
				$originalText,
				$lastReviewedText,
				$originalText, // $expectedText
				$message = 'Case 3 - Test mode is enabled',
			],
			[
				true, // isPageReviewed()
				99, // getLatestRevID()
				[ 'revision_id' => 100 ], // getLatestReviewedRevision()
				false, // isContentReviewTestModeEnabled()
				false, // $revisionExists
				$originalText,
				$lastReviewedText,
				$emptyText, // $expectedText
				$message = 'Case 4 - You want to get a reviewed revision but it does not exist (e.g. for new, unreviewed pages)',
			],
			[
				true, // isPageReviewed()
				99, // getLatestRevID()
				[ 'revision_id' => 100 ], // getLatestReviewedRevision()
				false, // isContentReviewTestModeEnabled()
				true, // $revisionExists
				$originalText,
				$lastReviewedText,
				$lastReviewedText, // $expectedText
				$message = 'Case 5 - You get the latest approved revision.',
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
