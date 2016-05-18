<?php

class ExactTargetUserTaskTest extends WikiaBaseTest {

	public function setUp() {
		$this->setupFile = __DIR__ . '/../../ExactTargetUpdates.setup.php';
		parent::setUp();
	}

	/**
	 * @dataProvider errorTestCaseProvider
	 */
	public function testErrorOnUserUpdate( array $userParams, $errorClass, $errorMessage ) {
		$this->setExpectedException( $errorClass, $errorMessage );
		( new \Wikia\ExactTarget\ExactTargetUserTask() )->updateUser( $userParams );
	}

	public function testShouldReturnOkWhenNoErrors() {
		// Mock all client methods to avoid calls to API
		$mockClient = $this->prepareClientMock();

		// Return proper type from retrieveUserIdsByEmail to avoid errors
		$mockClient->expects( $this->any() )
			->method( 'retrieveUserIdsByEmail' )
			->will( $this->returnValue( [ ] ) );

		// Prepare minimum required params for happy path
		$userParams = [ 'user_id' => 1, 'user_email' => 'test@test.com' ];

		$this->assertEquals(
			\Wikia\ExactTarget\ExactTargetUserTask::STATUS_OK,
			( new \Wikia\ExactTarget\ExactTargetUserTask( $mockClient ) )->updateUser( $userParams ),
			'User update failed to return OK status for minimum required params provided.'
		);
	}

	public function testShouldDeleteSubscriber() {
		// Prepare test case params
		$userParams = [ 'user_id' => 1, 'user_email' => 'test@test.com' ];
		$oldEmail = 'old@test.com';
		$newEmail = $userParams[ 'user_email' ];

		// Mock all client methods to avoid calls to API
		$mockClient = $this->prepareClientMock();

		// Mock client responses to cause subscriber removal
		$mockClient->expects( $this->any() )
			->method( 'retrieveEmailByUserId' )
			->will( $this->returnValueMap( [ [ $userParams[ 'user_id' ], $oldEmail ] ] ) );
		$mockClient->expects( $this->any() )
			->method( 'retrieveUserIdsByEmail' )
			->will( $this->returnValueMap( [ [ $oldEmail, [ 1 ] ], [ $newEmail, [ ] ] ] ) );

		// Setup requirements
		$mockClient->expects( $this->once() )
			->method( 'deleteSubscriber' )
			->with( $oldEmail );

		( new \Wikia\ExactTarget\ExactTargetUserTask( $mockClient ) )->updateUser( $userParams );
	}

	public function errorTestCaseProvider() {
		return [
			[ [ ], 'Wikia\Util\AssertionException', 'User ID missing' ],
			[ [ 'user_id' => 1 ], 'Wikia\Util\AssertionException', 'User email missing' ]
		];
	}

	/**
	 * @return PHPUnit_Framework_MockObject_MockObject
	 */
	private function prepareClientMock() {
		$mockClient = $this->getMock( '\Wikia\ExactTarget\ExactTargetClient',
			[
				'createSubscriber',
				'deleteSubscriber',
				'retrieveEmailByUserId',
				'retrieveUserIdsByEmail',
				'updateUser'
			]
		);

		return $mockClient;
	}

}
