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
		$userMock = $this->prepareUserMockWithEditToken( $inputData['userEditToken'], [ 'isAllowed' ] );
		$userMock->expects( $this->any() )
			->method( 'isAllowed' )
			->willReturn( $inputData['hasTestModeRights'] );
		$this->mockGlobalVariable( 'wgUser', $userMock );

		/**
		 * Wikia Request Mock
		 */
		$requestMock = $this->preparePostRequestValidatingMock( $inputData['wasPosted'], $inputData['requestToken'] );

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

	/**
	 * @dataProvider removeCompletedAndUpdateLogsDataProvider
	 * @param array $inputData
	 * @param string $expected
	 * @param string $message
	 */
	public function testRemoveCompletedAndUpdateLogs( $inputData, $expected, $message ) {
		/**
		 * Set exception if expected
		 */
		if ( $inputData['exception'] ) {
			$this->setExpectedException( $expected );
		}

		$requestMock = $this->preparePostRequestValidatingMock( $inputData['wasPosted'], $inputData['requestToken'], [ 'getInt' ] );

		$userMock = $this->prepareUserMockWithEditToken( $inputData['userEditToken'], [ 'isAllowed' ] );
		$userMock->expects( $this->any() )
			->method( 'isAllowed' )
			->willReturn( $inputData['userIsAllowed'] );
		$this->mockGlobalVariable( 'wgUser', $userMock );

		$currentRevisionModelMock = $this->getMock( 'Wikia\ContentReview\Models\CurrentRevisionModel', [
			'approveRevision',
		] );

		$helperMock = $this->getMock( 'Wikia\ContentReview\Helper', [
			'hasPageApprovedId',
			'isDiffPageInReviewProcess',
			'purgeReviewedJsPagesTimestamp',
			'prepareProvideFeedbackLink',
		] );
		$helperMock->expects( $this->any() )
			->method( 'hasPageApprovedId' )
			->willReturn( $inputData['hasPageApprovedId'] );
		$helperMock->expects( $this->any() )
			->method( 'isDiffPageInReviewProcess' )
			->willReturn( $inputData['isDiffPageInReviewProcess'] );

		$reviewLogModelMock = $this->getMock( 'Wikia\ContentReview\Models\ReviewLogModel', [
			'backupCompletedReview',
		] );

		$reviewModelMock = $this->getMock( 'Wikia\ContentReview\Models\ReviewModel', [
			'getReviewOfPageByStatus',
			'updateCompletedReview',
		] );
		$reviewModelMock->expects( $this->any() )
			->method( 'getReviewOfPageByStatus' )
			->willReturn( $inputData['inReviewRevision'] );

		$this->mockStaticMethod( '\Title', 'newFromId', 'Mocked title' );

		$responseMock = $this->getMock( '\WikiaResponse' );

		/**
		 * Mock ContentReviewApiController
		 * @var ContentReviewApiController
		 */
		$apiControllerMock = $this->getMock( '\ContentReviewApiController', [
			'getCurrentRevisionModel',
			'getHelper',
			'getReviewLogModel',
			'getReviewModel',
		] );

		$apiControllerMock->setRequest( $requestMock );
		$apiControllerMock->setResponse( $responseMock );

		$apiControllerMock->expects( $this->any() )
			->method( 'getCurrentRevisionModel' )
			->willReturn( $currentRevisionModelMock );
		$apiControllerMock->expects( $this->any() )
			->method( 'getHelper' )
			->willReturn( $helperMock );
		$apiControllerMock->expects( $this->any() )
			->method( 'getReviewLogModel' )
			->willReturn( $reviewLogModelMock );
		$apiControllerMock->expects( $this->any() )
			->method( 'getReviewModel' )
			->willReturn( $reviewModelMock );

		/**
		 * If no exception occurs - check a status with which a notification has been retrieved
		 */
		if ( !$inputData['exception'] ) {
			$apiControllerMock->expects( $this->once() )
				->method( 'getReviewUpdateNotification' )
				->with( $expected );
		}

		$apiControllerMock->removeCompletedAndUpdateLogs();
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

	/**
	 * Returns a mock of WikiaRequest object that can be used for validating a POST request
	 * with a matching edit token.
	 * @param bool $wasPosted
	 * @param string $requestToken
	 * @param array $methodsToMock
	 * @return PHPUnit_Framework_MockObject_MockObject
	 */
	private function preparePostRequestValidatingMock( $wasPosted, $requestToken, array $methodsToMock = [] ) {
		/**
		 * Wikia Request Mock
		 */
		if ( !in_array( 'wasPosted', $methodsToMock ) ) {
			$methodsToMock[] = 'wasPosted';
		}
		if ( !in_array( 'getVal', $methodsToMock ) ) {
			$methodsToMock[] = 'getVal';
		}

		$requestMock = $this->getMock( '\WikiaRequest', $methodsToMock, [ [] ] );
		$requestMock->expects( $this->any() )
			->method( 'wasPosted' )
			->willReturn( $wasPosted );

		if ( $wasPosted ) {
			$requestTokenMatcher = $this->atLeastOnce();
		} else {
			$requestTokenMatcher = $this->never();
		}
		$requestMock->expects( $requestTokenMatcher )
			->method( 'getVal' )
			->willReturn( $requestToken );

		return $requestMock;
	}

	/**
	 * Returns a mock of User object that can be used for validating a POST request
	 * with a matching edit token.
	 * @param string $userEditToken
	 * @param array $methodsToMock An array of methods other than getEditToken to mock
	 * @return PHPUnit_Framework_MockObject_MockObject
	 */
	private function prepareUserMockWithEditToken( $userEditToken, array $methodsToMock = [] ) {
		/**
		 * User Mock
		 */
		if ( !in_array( 'getEditToken', $methodsToMock ) ) {
			$methodsToMock[] = 'getEditToken';
		}

		$userMock = $this->getMock( '\User', $methodsToMock );
		$userMock->expects( $this->any() )
			->method( 'getEditToken' )
			->willReturn( $userEditToken );

		return $userMock;
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
					'hasTestModeRights' => true,
				],
				'BadRequestApiException',
				'The request would be ok if it was POSTed.',
			],
			[
				[
					'wasPosted' => true,
					'requestToken' => $validToken,
					'userEditToken' => $invalidToken,
					'hasTestModeRights' => true,
				],
				'BadRequestApiException',
				'A token sent in the request does not match with the user\'s edit token.',
			],
			[
				[
					'wasPosted' => true,
					'requestToken' => $validToken,
					'userEditToken' => $validToken,
					'hasTestModeRights' => false,
				],
				'PermissionsException',
				'User is not logged in.',
			],
			[
				[
					'wasPosted' => true,
					'requestToken' => $validToken,
					'userEditToken' => $validToken,
					'hasTestModeRights' => true,
				],
				'success',
				'Everything is fine, methods to enable the test mode and make a success response should be called once.',
			],
		];
	}

	public function removeCompletedAndUpdateLogsDataProvider() {
		$validToken = MWCryptRand::generateHex( 32 );
		$invalidToken = MWCryptRand::generateHex( 32 );

		return [
			[
				[
					'exception' => true,
					'wasPosted' => false,
				],
				$expected = 'BadRequestApiException',
				$message = 'The request would be ok if it was POSTed.',
			],
			[
				[
					'exception' => true,
					'wasPosted' => true,
					'requestToken' => $invalidToken,
					'userEditToken' => $validToken,
				],
				$expected = 'BadRequestApiException',
				$message = 'An invalid editToken was sent in the request.',
			],
			[
				[
					'exception' => true,
					'wasPosted' => true,
					'requestToken' => $validToken,
					'userEditToken' => $validToken,
					'userIsAllowed' => false
				],
				$expected = 'PermissionsException',
				$message = 'User does not have content-review rights.',
			],
			[
				[
					'exception' => true,
					'wasPosted' => true,
					'requestToken' => $validToken,
					'userEditToken' => $validToken,
					'userIsAllowed' => true,
					'hasPageApprovedId' => true,
					'isDiffPageInReviewProcess' => true,
					'inReviewRevision' => [
						// empty array
					],
				],
				$expected = 'NotFoundApiException',
				$message = 'No revision in review - should throw an exception.',
			],
		];
	}
}
