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
		$requestMock = $this->getMock( '\WikiaRequest', [ 'wasPosted' ], [ [] ] );
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

	/**
	 * A test for the API method that enable JS test mode.
	 * @dataProvider enableTestModeDataProvider
	 * @param array $inputData
	 *	[
	 * 		'wasPosted' => bool,
	 * 		'requestToken' => string,
	 * 		'userEditToken' => string,
	 * 		'isJsPage' => bool,
	 * 		'userId' => int,
	 * 		'userCanEdit' => bool,
	 *	],
	 * @param string $expected 'success' or a class name of an expected exception
	 * @param $message
	 */
	public function testEnableTestMode( array $inputData, $expected, $message ) {
		if ( $expected !== 'success' ) {
			$this->setExpectedException( $expected );
		}

		/**
		 * User Mock
		 */
		$userMock = $this->getMock( '\User', [ 'getId', 'getEditToken' ] );
		$userMock->expects( $this->any() )
			->method( 'getId' )
			->willReturn( $inputData['userId'] );
		$userMock->expects( $this->any() )
			->method( 'getEditToken' )
			->willReturn( $inputData['userEditToken'] );

		$this->mockGlobalVariable( 'wgUser', $userMock );

		/**
		 * Wikia Request Mock
		 */
		$requestMock = $this->getMock( '\WikiaRequest', [ 'wasPosted', 'getVal' ], [ [] ] );
		$requestMock->expects( $this->any() )
			->method( 'wasPosted' )
			->willReturn( $inputData['wasPosted'] );
		$requestMock->expects( $this->any() )
			->method( 'getVal' )
			->willReturn( $inputData['requestToken'] );
		$requestMock->expects( $this->any() )
			->method( 'getInt' )
			->willReturn( 0 ); // pageId, does not really matter since the Title is overwritten

		/**
		 * Title Mock
		 */
		$titleMock = $this->getMock( '\Title', [ 'isJsPage', 'userCan' ] );
		$titleMock->expects( $this->any() )
			->method( 'isJsPage' )
			->willReturn( $inputData['isJsPage'] );
		$titleMock->expects( $this->any() )
			->method( 'userCan' )
			->with( 'edit' )
			->willReturn( $inputData['userCanEdit'] );
		$this->getStaticMethodMock( '\Title', 'newFromId' )
			->expects( $this->any() )
			->method( 'newFromId' )
			->willReturn( $titleMock );

		/**
		 * API Controller Mock
		 */
		$apiController = $this->getMock( '\ContentReviewApiController', [ 'getHelper', 'makeSuccessResponse', 'setVal' ] );
		$helperMock = $this->getMock( '\Wikia\ContentReview\Helper', [ 'setContentReviewTestMode' ] );
		$apiController->expects( $this->any() )
			->method( 'getHelper' )
			->willReturn( $helperMock );

		$apiController->setRequest( $requestMock );
		$apiController->enableTestMode();
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

	/**
	 * A data provider for a test of the ContentReview API method - enableTestMode().
	 * @return array
	 */
	public function enableTestModeDataProvider() {
		$validToken = MWCryptRand::generateHex( 32 );
		$invalidToken = MWCryptRand::generateHex( 32 );

		return [
			[
				[
					'wasPosted' => false,
					'requestToken' => $validToken,
					'userEditToken' => $validToken,
					'isJsPage' => true,
					'userId' => 1234,
					'userCanEdit' => true,
				],
				'BadRequestApiException',
				'The request would be ok if it was POSTed.',
			],
			[
				[
					'wasPosted' => true,
					'requestToken' => $validToken,
					'userEditToken' => $invalidToken,
					'isJsPage' => true,
					'userId' => 1234,
					'userCanEdit' => true,
				],
				'BadRequestApiException',
				'A token sent in the request does not match with the user\'s edit token.',
			],
			[
				[
					'wasPosted' => true,
					'requestToken' => $validToken,
					'userEditToken' => $validToken,
					'isJsPage' => false,
					'userId' => 1234,
					'userCanEdit' => true,
				],
				'NotFoundApiException',
				'A request was sent from a non-JS page.',
			],
			[
				[
					'wasPosted' => TRUE,
					'requestToken' => $validToken,
					'userEditToken' => $validToken,
					'isJsPage' => true,
					'userId' => 0,
					'userCanEdit' => true,
				],
				'PermissionsException',
				'Asking for the user\'s ID returned 0. For some reason.',
			],
			[
				[
					'wasPosted' => TRUE,
					'requestToken' => $validToken,
					'userEditToken' => $validToken,
					'isJsPage' => true,
					'userId' => 123,
					'userCanEdit' => false,
				],
				'PermissionsException',
				'The user does not have permissions to edit the JS page.',
			],
			[
				[
					'wasPosted' => TRUE,
					'requestToken' => $validToken,
					'userEditToken' => $validToken,
					'isJsPage' => true,
					'userId' => 123,
					'userCanEdit' => true,
				],
				'success',
				'Everything is fine, methods to enable the test mode and make a success response should be called once.',
			],
		];
	}
}
