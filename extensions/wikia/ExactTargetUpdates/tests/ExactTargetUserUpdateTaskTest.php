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
		( new \Wikia\ExactTarget\ExactTargetUserUpdate() )->update( $userParams, [ ] );
	}

	public function testShouldCallAppropriateMethods() {
		$mockClient = $this->getMock( '\Wikia\ExactTarget\ExactTargetClient',
			[ 'deleteSubscriber', 'createSubscriber', 'updateUser', 'updateUserProperties' ] );
		$mockClient->expects( $this->once() )
			->method( 'deleteSubscriber' );
		$mockClient->expects( $this->once() )
			->method( 'createSubscriber' );
		$mockClient->expects( $this->once() )
			->method( 'updateUser' );
		$mockClient->expects( $this->once() )
			->method( 'updateUserProperties' );

		( new \Wikia\ExactTarget\ExactTargetUserUpdate( $mockClient ) )->update( [ 'user_id' => 1, 'user_email' => 'test@test.com' ], [ ] );
	}

	public function testShouldReturnOkWhenNoErrors() {
		$mockClient = $this->getMock( '\Wikia\ExactTarget\ExactTargetClient',
			[ 'deleteSubscriber', 'createSubscriber', 'updateUser', 'updateUserProperties' ] );

		$userParams = [ 'user_id' => 1, 'user_email' => 'test@test.com' ];

		$this->assertEquals(
			\Wikia\ExactTarget\ExactTargetUserUpdate::STATUS_OK,
			( new \Wikia\ExactTarget\ExactTargetUserUpdate( $mockClient ) )->update( $userParams, [ ] )
		);
	}

	public function errorTestCaseProvider() {
		return [
			[ [ ], 'Wikia\Util\AssertionException', 'User ID missing' ],
			[ [ 'user_id' => 1 ], 'Wikia\Util\AssertionException', 'User email missing' ]
		];
	}

}
