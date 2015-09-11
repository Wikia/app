<?php

class ContentReviewApiControllerTest extends WikiaBaseTest {
	public function setUp() {
		$this->setupFile = __DIR__ . '/../ContentReview.setup.php';
		parent::setUp();
		$this->contentReviewApiController = new ContentReviewApiController();
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

		if ( isset( $params['user'] ) ) {
			/* @var \User $userMock */
			$userMock = $this->getMockBuilder( '\User' )
				->disableOriginalConstructor()
				->setMethods( [ 'matchEditToken' ] )
				->getMock();
			if ( isset( $params['user']['matchEditToken'] ) ) {
				$userMock->method( 'matchEditToken' )
					->will( $this->returnValue( $params['user']['matchEditToken'] ) );
			}
		}

		if ( isset( $params['user'] ) ) {
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
					'user' => [
						'matchEditToken' => false,
					],
					'expectedException' => 'BadRequestApiException'
				],
				null,
				'User token don\'t match. Throw BadRequestApiException.',
			],
			[
				[
					'wasPosted' => false,
					'user' => [
						'matchEditToken' => false,
					],
					'expectedException' => 'BadRequestApiException'
				],
				null,
				'Not post request. Throw BadRequestApiException.',
			],
			[
				[
					'wasPosted' => true,
					'user' => [
						'matchEditToken' => true,
					],
					'expectedException' => 'NotFoundApiException'
				],
				null,
				'PageName parameter missing throw NotFoundApiException',
			],
		];
	}
}
