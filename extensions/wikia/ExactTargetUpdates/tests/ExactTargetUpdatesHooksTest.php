<?php

class ExactTargetUpdatesHooksTest extends WikiaBaseTest {

	public function testPrepareParams() {
		$userMock = $this->getMockBuilder( 'User' )
			->disableOriginalConstructor()
			->setMethods( array( 'getId', 'getName', 'getRealName', 'getEmail', 'getEmailAuthenticationTimestamp',
				'getRegistration', 'getEditCount', 'getOptions', 'getTouched') )
			->getMock();

		$aUserParams = [
			'user_id' => 12345,
			'user_name' => 'Test User Name',
			'user_real_name' => 'Some Real Name',
			'user_email' => 'test@test.com',
			'user_email_authenticated' => 20140101000000,
			'user_registration' => 20140101000000,
			'user_editcount' => 1,
			'user_options' => ['testint' => 1, 'teststring' => 'string'],
			'user_touched' => 20140101000000
		];

		$userMock
			->expects( $this->once() )
			->method ( 'getId' )
			->will   ( $this->returnValue( $aUserParams['user_id'] ) );

		$userMock
			->expects( $this->once() )
			->method ( 'getName' )
			->will   ( $this->returnValue( $aUserParams['user_name'] ) );

		$userMock
			->expects( $this->once() )
			->method ( 'getRealName' )
			->will   ( $this->returnValue( $aUserParams['user_real_name'] ) );

		$userMock
			->expects( $this->once() )
			->method ( 'getEmail' )
			->will   ( $this->returnValue( $aUserParams['user_email'] ) );

		$userMock
			->expects( $this->once() )
			->method ( 'getEmailAuthenticationTimestamp' )
			->will   ( $this->returnValue( $aUserParams['user_email_authenticated'] ) );

		$userMock
			->expects( $this->once() )
			->method ( 'getRegistration' )
			->will   ( $this->returnValue( $aUserParams['user_registration'] ) );

		$userMock
			->expects( $this->once() )
			->method ( 'getEditCount' )
			->will   ( $this->returnValue( $aUserParams['user_editcount'] ) );

		$userMock
			->expects( $this->once() )
			->method ( 'getOptions' )
			->will   ( $this->returnValue( $aUserParams['user_options'] ) );

		$userMock
			->expects( $this->once() )
			->method ( 'getTouched' )
			->will   ( $this->returnValue( $aUserParams['user_touched'] ) );

		/* Get mock object of tested class ExactTargetUpdatesHooks without mocking any methods */
		$exactTargetUpdatesHooksMock = $this->getMock( 'ExactTargetUpdatesHooks', null );

		/* Run test */
		/* @var ExactTargetUpdatesHooks $exactTargetUpdatesHooksMock (mock of ExactTargetUpdatesHooks) */
		$aUserParamsResult = $exactTargetUpdatesHooksMock->prepareParams( $userMock );

		$this->assertEquals( $aUserParamsResult, $aUserParams );

	}

	function testTaskNotCreatedOnDev() {
		/* Define environment constants if not defined yet */
		if ( !defined( 'WIKIA_ENV_DEV' ) ) {
			define( WIKIA_ENV_DEV, 'test-dev') ;
		}
		if ( !defined( 'WIKIA_ENV_INTERNAL' ) ) {
			define( WIKIA_ENV_INTERNAL, 'test-internal' );
		}

		/* Mock wgWikiaEnvironment */
		$this->mockGlobalVariable( 'wgWikiaEnvironment', WIKIA_ENV_DEV );

		/* Mock user */
		$userMock = $this->getMockBuilder( 'User' )
			->disableOriginalConstructor()
			->getMock();

		/* Mock ExactTargetAddUserTask */
		$mockAddUserTask = $this->getMock( 'ExactTargetAddUserTask', [ 'call', 'queue' ] );
		$mockAddUserTask
			->expects( $this->never() )
			->method( 'call' );
		$mockAddUserTask
			->expects( $this->never() )
			->method( 'queue' );

		/* Get mock object of tested class ExactTargetUpdatesHooks */
		$exactTargetUpdatesHooksMock = $this->getMock( 'ExactTargetUpdatesHooks', [ 'prepareParams' ] );
		$exactTargetUpdatesHooksMock
			->expects( $this->never() )
			->method( 'prepareParams' );

		/* Run test */
		/* @var ExactTargetUpdatesHooks $exactTargetUpdatesHooksMock (mock of ExactTargetUpdatesHooks) */
		$exactTargetUpdatesHooksMock->addTheAddUserTask( $userMock, $mockAddUserTask );
	}
}
