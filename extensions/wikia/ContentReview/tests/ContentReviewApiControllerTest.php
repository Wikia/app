<?php

class ContentReviewApiControllerTest extends WikiaBaseTest {
	public function setUp() {
		$this->setupFile = __DIR__ . '/../ContentReview.setup.php';
		$this->contentReviewApiController = new ContentReviewApiController();
		parent::setUp();
	}

	/**
	 * @dataProvider submitPageForReviewProvider
	 */
	public function testSubmitPageForReview( $params, $textExpected, $message ) {

		$this->prepareControllerPropertiesMocks( $params );

		if ( $params['expectedException'] ) {
			$this->setExpectedException( $params['expectedException'] );
		}

		/* Run tested function */
		$this->contentReviewApiController->submitPageForReview();
	}

	private function prepareControllerPropertiesMocks( $params ) {
		/* @var \WikiaRequest $requestMock */
		$requestMock = $this->getMockBuilder( '\WikiaRequest' )
			->disableOriginalConstructor()
			->setMethods( [ 'wasPosted' ] )
			->getMock();

		if ( $params['wasPosted'] ) {
			$requestMock->method('wasPosted')
				->will($this->returnValue($params['wasPosted']));
		}

		if ( isset( $params['User'] ) ) {
			/* @var \User $userMock */
			$userMock = $this->getMockBuilder( '\User' )
				->disableOriginalConstructor()
				->setMethods( [ 'matchEditToken' ] )
				->getMock();
			if ( isset( $params['User']['matchEditToken'] ) ) {
				$userMock->method( 'matchEditToken' )
					->will( $this->returnValue( false ) );
			}
		}

		if ( isset( $params['User'] ) ) {
			$app = new WikiaApp();
			$app->setGlobal( 'wgUser', $userMock );
		}

		/* Set dependencies */
		if ( isset( $app ) ) {
			$this->contentReviewApiController->setApp( $app );
		}
		$this->contentReviewApiController->setRequest( $requestMock );

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
