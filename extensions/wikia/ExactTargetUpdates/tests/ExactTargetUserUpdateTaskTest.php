<?php

class ExactTargetUserUpdateTaskTest extends WikiaBaseTest {

	public function setUp() {
		$this->setupFile = __DIR__ . '/../ExactTargetUpdates.setup.php';
		parent::setUp();
	}

	/**
	 * @dataProvider errorTestCaseProvider
	 */
	public function testErrorOnUserUpdate( array $userParams, $errorClass, $errorMessage ) {
		$this->setExpectedException( $errorClass, $errorMessage );
		( new \Wikia\ExactTarget\ExactTargetUserUpdate() )->updateUser( $userParams, [ ] );
	}

	public function testShouldReturnOkWhenNoErrors() {
		$mockClient = $this->getMock( '\Wikia\ExactTarget\ExactTargetClient',
			[
				'createSubscriber',
				'deleteSubscriber',
				'retrieveEmailByUserId',
				'retrieveUserIdsByEmail',
				'updateUser'
			]
		);

		$userParams = [ 'user_id' => 1, 'user_email' => 'test@test.com' ];

		$this->assertEquals(
			\Wikia\ExactTarget\ExactTargetUserUpdate::STATUS_OK,
			( new \Wikia\ExactTarget\ExactTargetUserUpdate( $mockClient ) )->updateUser( $userParams, [ ] )
		);
	}

	public function errorTestCaseProvider() {
		return [
			[ [ ], 'Wikia\Util\AssertionException', 'User ID missing' ],
			[ [ 'user_id' => 1 ], 'Wikia\Util\AssertionException', 'User email missing' ]
		];
	}

}
