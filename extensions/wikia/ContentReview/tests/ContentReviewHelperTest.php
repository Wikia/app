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
		$titleMock->expects( $this->once() )
			->method( 'getArticleID' )
			->will( $this->returnValue( $params['pageId'] ) );
		$titleMock->expects( $this->once() )
			->method( 'getLatestRevID' )
			->will( $this->returnValue( $params['latestRevId'] ) );
		$titleMock->expects( $this->once() )
			->method( 'isJsPage' )
			->will( $this->returnValue( $params['isJsPage'] ) );

		/* @var \Wikia\ContentReview\Models\CurrentRevisionModel $currentRevisionModelMock */
		$currentRevisionModelMock = $this->getMockBuilder( '\Wikia\ContentReview\Models\CurrentRevisionModel' )
			->disableOriginalConstructor()
			->setMethods( [ 'getLatestReviewedRevision' ] )
			->getMock();
		$currentRevisionModelMock->expects( $this->once() )
			->method( 'getLatestReviewedRevision' )
			->will( $this->returnValue( $params['latestApprovedRevData'] ) );

		/* @var \Revision $revisionMock */
		$revisionMock = $this->getMockBuilder( '\Revision' )
			->disableOriginalConstructor()
			->setMethods( [ 'getRawText' ] )
			->getMock();
		$revisionMock->expects( $this->once() )
			->method( 'getRawText' )
			->will( $this->returnValue( $params['latestApprovedRevText'] ) );

		/* @var \Wikia\ContentReview\Helper $helperMock */
		$helperMock = $this->getMockBuilder( '\Wikia\ContentReview\Helper' )
			->disableOriginalConstructor()
			->setMethods( [ 'getCurrentRevisionModel', 'getRevisionById', 'isContentReviewTestModeEnabled' ] )
			->getMock();
		$helperMock->expects( $this->once() )
			->method( 'getCurrentRevisionModel' )
			->will( $this->returnValue( $currentRevisionModelMock ) );
		$helperMock->expects( $this->once() )
			->method( 'isContentReviewTestModeEnabled' )
			->will( $this->returnValue( $params['isContentReviewTestModeEnabled'] ) );
		$helperMock->expects( $this->once() )
			->method( 'getRevisionById' )
			->will( $this->returnValue( $revisionMock ) );

		$helperMock->replaceWithLastApproved( $titleMock, $params['contentType'], $params['text'] );

		$this->assertEquals( $textExpected, $params['text'], $message );
	}

	public function replaceWithLastApprovedRevisionProvider() {
		return [
			[
				[
					'pageId' => 123,
					'latestRevId' => 567,
					'isJsPage' => true,
					'contentType' => 'sometype',
					'latestApprovedRevData' => [
						'revision_id' => 123
					],
					'latestApprovedRevText' => 'revision text',
					'isContentReviewTestModeEnabled' => false,
				],
				'revision text',
				'Text replaced',
			],
		];
	}
}
