<?php

class ContentReviewApiControllerTest extends WikiaBaseTest {
	public function setUp() {
		$this->setupFile = __DIR__ . '/../ContentReview.setup.php';
		parent::setUp();
	}

	/**
	 * @dataProvider submitPageForReviewProvider
	 */
	public function testSubmitPageForReview( $params, $textExpected, $message ) {

		/* @var \WikiaRequest $requestMock */
		$requestMock = $this->getMockBuilder( '\WikiaRequest' )
			->disableOriginalConstructor()
			->setMethods( [ 'wasPosted' ] )
			->getMock();
		$requestMock->method( 'wasPosted' )
			->will( $this->returnValue( $params['wasPosted'] ) );

		/* @var \User $userMock */
		$userMock = $this->getMockBuilder( '\User' )
			->disableOriginalConstructor()
			->setMethods( [ 'matchEditToken' ] )
			->getMock();
		$userMock->method( 'matchEditToken' )
			->will( $this->returnValue( false ) );

		$app = new WikiaApp();
		$app->setGlobal( 'wgUser', $userMock );

		$contentReviewApiController = new ContentReviewApiController();
		/* Set dependencies */
		$contentReviewApiController->setApp( $app );
		$contentReviewApiController->setRequest( $requestMock );

		if ( $params['expectedException'] ) {
			$this->setExpectedException( $params['expectedException'] );
		}

		/* Run tested function */
		$contentReviewApiController->submitPageForReview();
	}

	public function submitPageForReviewProvider() {
		return [
			[
				[
					'wasPosted' => true,
					'matchEditToken' => false,
					'expectedException' => 'BadRequestApiException'
				],
				null,
				'User token don\'t match. Throw BadRequestApiException.',
			],
			[
				[
					'wasPosted' => false,
					'matchEditToken' => true,
					'expectedException' => 'BadRequestApiException'
				],
				null,
				'Not post request. Throw BadRequestApiException.',
			],
		];
	}
}
