<?php

class ContentReviewStatusesServiceTest extends WikiaBaseTest {

	public function setUp() {
		$this->setupFile = __DIR__ . '/../ContentReview.setup.php';
		parent::setUp();
	}

	/**
	 *
	 * @dataProvider getStatusKeyDataProvider
	 *
	 * @param $status
	 * @param $statusKey
	 */
	public function testGetStatusKey( $status, $expectedStatusKey ) {
		$contentReviewStatusesService = new Wikia\ContentReview\ContentReviewStatusesService();
		$statusKey = $contentReviewStatusesService->getStatusKey( $status );

		$this->assertEquals( $expectedStatusKey, $statusKey );
	}

	public function getStatusKeyDataProvider() {
		return [
			[ 0, 'none' ],
			[ 1, 'awaiting' ],
			[ 2, 'awaiting' ],
			[ 3, 'approved' ],
			[ 4, 'rejected' ],
			[ 5, 'approved' ],
			[ 6, 'none' ],
			[ 7, 'none' ],
			[ 10, 'none' ]
		];
	}

	/**
	 *
	 * @dataProvider prepareRevisionLinkParamsDataProvider
	 *
	 * @param $revisionId
	 * @param $liveRevisionId
	 * @param $expectedParams
	 */
	public function testPrepareRevisionLinkParams( $revisionId, $liveRevisionId, $expectedParams ) {
		$contentReviewStatusesService = new Wikia\ContentReview\ContentReviewStatusesService();
		$params = $contentReviewStatusesService->prepareRevisionLinkParams( $revisionId, $liveRevisionId );

		$this->assertEquals( $expectedParams, $params );
	}

	public function prepareRevisionLinkParamsDataProvider() {
		return [
			[ 101, 0, [ 'oldid' => 101 ] ],
			[ 101, 50, [ 'oldid' => 50, 'diff' => 101 ] ],
			[ 101, 101, [ 'oldid' => 101 ] ]
		];
	}

	/**
	 *
	 * @dataProvider getLiveRevisionDataProvider
	 *
	 * @param $pageStatus
	 * @param $expectedRevision
	 */
	public function testGetLiveRevision( $pageStatus, $expectedRevision ) {
		$contentReviewStatusesService = new Wikia\ContentReview\ContentReviewStatusesService();
		$revisionId = $contentReviewStatusesService->getLiveRevision( $pageStatus );

		$this->assertEquals( $revisionId, $expectedRevision );
	}

	public function getLiveRevisionDataProvider() {
		return [
			[
				[
					1 => 1011,
					2 => 1012,
					4 => 1014,
					6 => 1016
				],
				0
			],
			[
				[
					2 => 1012,
				],
				0
			],
			[
				[
					5 => 1015,
				],
				1015
			],
			[
				[
					1 => 1011,
					2 => 1012,
					3 => 1013,
					6 => 1016
				],
				1013
			],
			[
				[
					1 => 1011,
					2 => 1012,
					4 => 1014,
					5 => 1015
				],
				1015
			],
			[
				[],
				0
			],
		];
	}

	/**
	 * @dataProvider preparePageStatusesDataProvider
	 *
	 * @param $jsPages
	 * @param $statuses
	 */
	public function testPreparePageStatuses( $message, $pageId, $page, $statuses, $userCan, $expectedPage ) {
		$titleMock = $this->getMock( '\Title', [ 'userCan' ] );
		$contentReviewStatusesServiceMock = $this->getMock( 'Wikia\ContentReview\ContentReviewStatusesService', [ 'initPageData' ] );

		$titleMock
			->expects( $this->any() )
			->method( 'userCan' )
			->willReturn( $userCan );

		$this->getStaticMethodMock( '\Title', 'newFromText' )
			->expects( $this->any() )
			->method( 'newFromText' )
			->willReturn( $titleMock );

		$contentReviewStatusesServiceMock
			->expects( $this->once() )
			->method( 'initPageData' )
			->willReturn( $this->initPageDataMock() );

		$jsPage = $contentReviewStatusesServiceMock->preparePageStatuses( $pageId, $page, $statuses );

		$this->assertEquals(
			$expectedPage['latestRevision']['revisionId'],
			$jsPage['latestRevision']['revisionId'],
			$this->getMessage( $message, 'Compare latest revision ids')
		);
		$this->assertEquals(
			$expectedPage['latestRevision']['statusKey'],
			$jsPage['latestRevision']['statusKey'],
			$this->getMessage( $message, 'Compare latest revision status keys')
		);
		$this->assertEquals(
			$expectedPage['latestReviewed']['revisionId'],
			$jsPage['latestReviewed']['revisionId'],
			$this->getMessage( $message, 'Compare latest reviewed revision ids')
		);
		$this->assertEquals(
			$expectedPage['latestReviewed']['statusKey'],
			$jsPage['latestReviewed']['statusKey'],
			$this->getMessage( $message, 'Compare latest reviviewed status keys')
		);
		$this->assertEquals(
			$expectedPage['liveRevision']['revisionId'],
			$jsPage['liveRevision']['revisionId'],
			$this->getMessage( $message, 'Compare live revision ids')
		);
		$this->assertEquals(
			$expectedPage['liveRevision']['statusKey'],
			$jsPage['liveRevision']['statusKey'],
			$this->getMessage( $message, 'Compare live revision status keys')
		);
		$this->assertEquals(
			$expectedPage['submit'],
			$jsPage['submit'],
			$this->getMessage( $message, 'Compare is submit button present')
		);
	}

	private function getMessage( $message, $assertion ) {
		return implode( " ", [ $message, $assertion ] );
	}

	private function initPageDataMock() {
		return [
			'pageLink' => 'somePageLink',
			'pageName' => 'somePageName',
			'latestRevision' => [
				'statusKey' => 'none',
				'message' => 'status none message'
			],
			'latestReviewed' => [
				'statusKey' => 'none',
				'message' => 'status none message'
			],
			'liveRevision' => [
				'statusKey' => 'none',
				'message' => 'status none message'
			]
		];
	}

	public function preparePageStatusesDataProvider() {
		return [
			#1 test case
			[
				'Page with unsubmitted revision and one revision waiting for review (page_latest != revision_id)',
				101, // page id
				// js page data -> get from Helper::getJsPages()
				[
					'page_id' => 101,
					'page_title' => 'Wikia.js',
					'page_touched' => 1,
					'page_latest' => 10001
				],
				// js page statuses
				[
					101 => [
						1 => 1001
					]
				],
				// can user submit revision
				true,
				// expected output
				[
					'latestRevision' => [
						'revisionId' => 10001,
						'statusKey' => 'unsubmitted'
					],
					'latestReviewed' => [
						'statusKey' => 'none'
					],
					'liveRevision' => [
						'statusKey' => 'none'
					],
					'submit' => true
				]
			],
			#2 test case
			[
				'Page with unsubmitted revision and one revision waiting for review (page_latest != revision_id). User cannot submit revision.',
				101, // page id
				// js page data -> get from Helper::getJsPages()
				[
					'page_id' => 101,
					'page_title' => 'Wikia.js',
					'page_touched' => 1,
					'page_latest' => 10001
				],
				// js page statuses
				[
					101 => [
						1 => 1001
					]
				],
				// can user submit revision
				false,
				// expected output
				[
					'latestRevision' => [
						'revisionId' => 10001,
						'statusKey' => 'unsubmitted'
					],
					'latestReviewed' => [
						'statusKey' => 'none'
					],
					'liveRevision' => [
						'statusKey' => 'none'
					]
				]
			],
			#3 test case
			[
				'Page with submited revision waiting for review (page_latest == revision_id)',
				101, // page id
				// js page data -> get from Helper::getJsPages()
				[
					'page_id' => 101,
					'page_title' => 'Wikia.js',
					'page_touched' => 1,
					'page_latest' => 10001
				],
				// js page statuses
				[
					101 => [
						1 => 10001
					]
				],
				// can user submit revision
				true,
				// expected output
				[
					'latestRevision' => [
						'revisionId' => 10001,
						'statusKey' => 'awaiting'
					],
					'latestReviewed' => [
						'statusKey' => 'none'
					],
					'liveRevision' => [
						'statusKey' => 'none'
					],
				]
			],
			#4 test case
			[
				'Page with revision waiting for review and one already approved revision',
				101, // page id
				// js page data -> get from Helper::getJsPages()
				[
					'page_id' => 101,
					'page_title' => 'Wikia.js',
					'page_touched' => 1,
					'page_latest' => 10011
				],
				// js page statuses
				[
					101 => [
						1 => 10011,
						3 => 10003
					]
				],
				// can user submit revision
				true,
				// expected output
				[
					'latestRevision' => [
						'revisionId' => 10011,
						'statusKey' => 'awaiting'
					],
					'latestReviewed' => [
						'revisionId' => 10003,
						'statusKey' => 'approved'
					],
					'liveRevision' => [
						'revisionId' => 10003,
						'statusKey' => 'live'
					],
				]
			],
			#5 test case
			[
				'Page with revision waiting for review, then rejected and last one approved',
				101, // page id
				// js page data -> get from Helper::getJsPages()
				[
					'page_id' => 101,
					'page_title' => 'Wikia.js',
					'page_touched' => 1,
					'page_latest' => 10011
				],
				// js page statuses
				[
					101 => [
						2 => 10011,
						4 => 10004,
						3 => 10003
					]
				],
				// can user submit revision
				true,
				// expected output
				[
					'latestRevision' => [
						'revisionId' => 10011,
						'statusKey' => 'awaiting'
					],
					'latestReviewed' => [
						'revisionId' => 10004,
						'statusKey' => 'rejected'
					],
					'liveRevision' => [
						'revisionId' => 10003,
						'statusKey' => 'live'
					],
				]
			],
			#6 test case
			[
				'Page with revision waiting for review, then rejected and no live revision',
				101, // page id
				// js page data -> get from Helper::getJsPages()
				[
					'page_id' => 101,
					'page_title' => 'Wikia.js',
					'page_touched' => 1,
					'page_latest' => 10011
				],
				// js page statuses
				[
					101 => [
						2 => 10011,
						4 => 10004,
					]
				],
				// can user submit revision
				true,
				// expected output
				[
					'latestRevision' => [
						'revisionId' => 10011,
						'statusKey' => 'awaiting'
					],
					'latestReviewed' => [
						'revisionId' => 10004,
						'statusKey' => 'rejected'
					],
					'liveRevision' => [
						'statusKey' => 'none'
					],
				]
			],
			#7 test case
			[
				'Page with two revision waiting for review (one already in review process)',
				101, // page id
				// js page data -> get from Helper::getJsPages()
				[
					'page_id' => 101,
					'page_title' => 'Wikia.js',
					'page_touched' => 1,
					'page_latest' => 10011
				],
				// js page statuses
				[
					101 => [
						1 => 10011,
						2 => 10002
					]
				],
				// can user submit revision
				true,
				// expected output
				[
					'latestRevision' => [
						'revisionId' => 10011,
						'statusKey' => 'awaiting'
					],
					'latestReviewed' => [
						'statusKey' => 'none'
					],
					'liveRevision' => [
						'statusKey' => 'none'
					],
				]
			],
			#8 test case
			[
				'Page with unsubmitted revision, one waiting for review, then approved and last one rejected',
				101, // page id
				// js page data -> get from Helper::getJsPages()
				[
					'page_id' => 101,
					'page_title' => 'Wikia.js',
					'page_touched' => 1,
					'page_latest' => 30011
				],
				// js page statuses
				[
					101 => [
						2 => 20001,
						3 => 10033,
						4 => 10004
					]
				],
				// can user submit revision
				true,
				// expected output
				[
					'latestRevision' => [
						'revisionId' => 30011,
						'statusKey' => 'unsubmitted'
					],
					'latestReviewed' => [
						'revisionId' => 10033,
						'statusKey' => 'approved'
					],
					'liveRevision' => [
						'revisionId' => 10033,
						'statusKey' => 'live'
					],
					'submit' => true
				]
			],
		];
	}
}
