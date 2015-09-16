<?php

class ContentReviewApiControllerTest extends WikiaBaseTest {

	/* @var \ContentReviewApiController $contentReviewApiControllerMock */
	private $contentReviewApiControllerMock;

	public function setUp() {
		$this->setupFile = __DIR__ . '/../ContentReview.setup.php';
		parent::setUp();

		$this->contentReviewApiControllerMock = $this->getMockBuilder( 'ContentReviewApiController' )
			->setMethods( [ 'getTitle', 'canUserSubmit' ] )
			->getMock();
	}

	/**
	 * @param array $params An array as defined in the dataProvider
	 * @dataProvider submitPageForReviewProvider
	 */
	public function testSubmitPageForReview( $params ) {

		$this->prepareControllerPropertiesMocks( $params );

		if ( $params['title'] ) {
			$this->prepareTitleMock( $params['title'] );
		}

		if ( $params['expectedException'] ) {
			$this->setExpectedException( $params['expectedException'] );
		}

		/* Run tested function */
		$this->contentReviewApiControllerMock->submitPageForReview();
	}

	/**
	 * Tests if the updateReviewsStatus method performs all necessary checks to validate
	 * a request and check a user's permissions to perform the action.
	 * @param bool $wasPosted
	 * @param bool $matchEditToken
	 * @param bool $isAllowed
	 * @param string $exception A name of a class of an expected exception
	 * @dataProvider updateReviewsStatusDataProvider
	 */
	public function testUpdateReviewsStatus( $wasPosted, $matchEditToken, $isAllowed, $exception ) {
		/* @var \WikiaRequest $requestMock */
		$requestMock = $this->getMockBuilder( '\WikiaRequest' )
			->disableOriginalConstructor()
			->setMethods( [ 'wasPosted' ] )
			->getMock();
		$requestMock->expects( $this->once() )
			->method( 'wasPosted' )
			->willReturn( $wasPosted );

		$userMock = $this->getMock( '\User', [ 'matchEditToken', 'isAllowed' ] );
		if ( $wasPosted ) {
			$userMock->expects( $this->once() )
				->method( 'matchEditToken' )
				->willReturn( $matchEditToken );
		}
		if ( $wasPosted && $matchEditToken ) {
			$userMock->expects( $this->once() )
				->method( 'isAllowed' )
				->willReturn( $isAllowed );
		}

		$this->setExpectedException( $exception );

		$this->mockGlobalVariable( 'wgUser', $userMock );
		$this->contentReviewApiControllerMock->setRequest( $requestMock );

		$this->contentReviewApiControllerMock->updateReviewsStatus();
	}

	private function prepareControllerPropertiesMocks( $params ) {
		/* @var \WikiaRequest $requestMock */
		$requestMock = $this->getMockBuilder( '\WikiaRequest' )
			->disableOriginalConstructor()
			->setMethods( [ 'wasPosted' ] )
			->getMock();

		if ( $params['wasPosted'] ) {
			$requestMock->method( 'wasPosted' )
				->will( $this->returnValue( $params['wasPosted'] ) );
		}

		if ( isset( $params['user'] ) ) {
			/* @var \User $userMock */
			$userMock = $this->getMockBuilder( '\User' )
				->disableOriginalConstructor()
				->setMethods( [ 'matchEditToken', 'getId' ] )
				->getMock();
			if ( isset( $params['user']['matchEditToken'] ) ) {
				$userMock->method( 'matchEditToken' )
					->will( $this->returnValue( $params['user']['matchEditToken'] ) );
			}
			if ( isset( $params['user']['id'] ) ) {
				$userMock->method( 'getId' )
					->will( $this->returnValue( $params['user']['id'] ) );
			}
			$this->mockGlobalVariable( 'wgUser', $userMock );
		}

		if ( isset( $params['canUserSubmit'] ) ) {
			$this->contentReviewApiControllerMock->method( 'canUserSubmit' )
				->will( $this->returnValue( $params['canUserSubmit'] ) );
		}

		/* Set dependencies */
		$this->contentReviewApiControllerMock->setRequest( $requestMock );

	}

	private function prepareTitleMock( $params ) {
		$titleMock = $this->getMockBuilder( '\Title' )
			->disableOriginalConstructor()
			->setMethods( [ 'getArticleID', 'isJsPage' ] )
			->getMock();
		if ( isset( $params['articleID'] ) ) {
			$titleMock->method( 'getArticleID' )
				->will( $this->returnValue( $params['articleID'] ) );
		}
		if ( isset( $params['isJsPage'] ) ) {
			$titleMock->method( 'isJsPage' )
				->will( $this->returnValue( $params['isJsPage'] ) );
		}

		$this->contentReviewApiControllerMock->method( 'getTitle' )
			->will( $this->returnValue( $titleMock ) );
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
					'expectedException' => 'NotFoundApiException',
					'title' => [
						'articleID' => 0,
						'isJsPage' => false,
					],
				],
				null,
				'Non existent page',
			],
			[
				[
					'wasPosted' => true,
					'user' => [
						'matchEditToken' => true,
					],
					'expectedException' => 'NotFoundApiException',
					'title' => [
						'articleID' => 123,
						'isJsPage' => false,
					],
				],
				null,
				'Not JS page',
			],
			[
				[
					'wasPosted' => true,
					'user' => [
						'matchEditToken' => true,
						'id' => 0,
					],
					'expectedException' => 'PermissionsException',
					'title' => [
						'articleID' => 123,
						'isJsPage' => true,
					],
				],
				null,
				'Non existent user',
			],
			[
				[
					'wasPosted' => true,
					'user' => [
						'matchEditToken' => true,
						'id' => 888,
					],
					'expectedException' => 'PermissionsException',
					'title' => [
						'articleID' => 123,
						'isJsPage' => true,
					],
					'canUserSubmit' => false
				],
				null,
				'Non existent user',
			],
		];
	}

	public function updateReviewsStatusDataProvider() {
		return [
			[ false, false, false, 'BadRequestApiException' ],
			[ true, false, false, 'BadRequestApiException' ],
			[ true, true, false, 'PermissionsException' ],
		];
	}
}
