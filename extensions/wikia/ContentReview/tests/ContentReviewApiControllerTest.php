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

		/**
		 * Mock tested controller
		 * @var \ContentReviewApiController $contentReviewApiControllerMock
		 */
		$contentReviewApiControllerMock = $this->getMockBuilder( '\ContentReviewApiController' )
			->disableOriginalConstructor()
			->setMethods( null )
			->getMock();

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

		/* @var \WikiaApp $appMock */
		$appMock = $this->getMockBuilder( '\WikiaApp' )
			->setMethods( null )
			->getMock();
		$appMock->setGlobal( 'wgUser', $userMock);

		/* Set dependencies */
		$contentReviewApiControllerMock->setApp($appMock);
		$contentReviewApiControllerMock->setRequest($requestMock);

		if ( $params['expectedException'] ) {
			$this->setExpectedException( $params['expectedException'] );
		}

		/* Run tested function */
		$contentReviewApiControllerMock->submitPageForReview();
	}

	public function submitPageForReviewProvider() {
		return [
			[
				[
					'wasPosted' => true,
					'expectedException' => 'BadRequestApiException'
				],
				null,
				'User token don\'t match. Throw BadRequestApiException.',
			],
		];
	}
}
