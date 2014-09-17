<?php

class ExactTargetUpdatesHooksTest extends WikiaBaseTest {

	public function testPrepareUserParams() {
		$userMock = $this->getMockBuilder( 'User' )
			->disableOriginalConstructor()
			->setMethods( [ 'getId', 'getName', 'getRealName', 'getEmail', 'getEmailAuthenticationTimestamp',
				'getRegistration', 'getEditCount', 'getOptions', 'getTouched' ] )
			->getMock();

		$aUserParams = [
			'user_id' => 12345,
			'user_name' => 'Test User Name',
			'user_real_name' => 'Some Real Name',
			'user_email' => 'test@test.com',
			'user_email_authenticated' => 20140101000000,
			'user_registration' => 20140101000000,
			'user_editcount' => 1,
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
			->method ( 'getTouched' )
			->will   ( $this->returnValue( $aUserParams['user_touched'] ) );

		/* Get mock object of tested class ExactTargetUpdatesHooks without mocking any methods */
		$exactTargetUpdatesHooksMock = $this->getMock( 'ExactTargetUpdatesHooks', null );

		/* Run test */
		/* @var ExactTargetUpdatesHooks $exactTargetUpdatesHooksMock (mock of ExactTargetUpdatesHooks) */
		$aUserParamsResult = $exactTargetUpdatesHooksMock->prepareUserParams( $userMock );

		$this->assertEquals( $aUserParamsResult, $aUserParams );

	}

	public function testPrepareUserPropertiesParams() {
		$aUserPropertiesParamsExpected = [
			'marketingallowed' => 1,
			'unsubscribed' => NULL,
			'language' => 'en'
		];

		$userMock = $this->getMockBuilder( 'User' )
			->disableOriginalConstructor()
			->setMethods( [ 'getOption' ] )
			->getMock();

		// Create a map of arguments to return values.
		$returnMap = [
			[ 'marketingallowed', null, false, 1 ],
			[ 'unsubscribed', null, false, null ],
			[ 'language', null, false, 'en' ]
		];

		$userMock
			->expects( $this->exactly( 3 ) )
			->method( 'getOption' )
			->will( $this->returnValueMap( $returnMap ) );

		/* Get mock object of tested class ExactTargetUpdatesHooks without mocking any methods */
		$exactTargetUpdatesHooksMock = $this->getMock( 'ExactTargetUpdatesHooks', null );

		/* Run test */
		/* @var ExactTargetUpdatesHooks $exactTargetUpdatesHooksMock (mock of ExactTargetUpdatesHooks) */
		$aUserPropertiesParamsActual = $exactTargetUpdatesHooksMock->prepareUserPropertiesParams( $userMock );

		$this->assertEquals( $aUserPropertiesParamsActual, $aUserPropertiesParamsExpected );
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
		$mockAddUserTask = $this->getMockBuilder( 'ExactTargetAddUserTask' )
			->disableOriginalConstructor()
			->setMethods( [ 'call', 'queue' ] )
			->getMock();
		$mockAddUserTask
			->expects( $this->never() )
			->method( 'call' );
		$mockAddUserTask
			->expects( $this->never() )
			->method( 'queue' );

		/* Get mock object of tested class ExactTargetUpdatesHooks */
		$exactTargetUpdatesHooksMock = $this->getMockBuilder( 'ExactTargetUpdatesHooks' )
			->setMethods( [ 'prepareUserParams' ] )
			->getMock();
		$exactTargetUpdatesHooksMock
			->expects( $this->never() )
			->method( 'prepareUserParams' );

		/* Run test */
		/* @var ExactTargetUpdatesHooks $exactTargetUpdatesHooksMock (mock of ExactTargetUpdatesHooks) */
		$exactTargetUpdatesHooksMock->addTheAddUserTask( $userMock, $mockAddUserTask );
	}

	function testShouldAddUpdateUserDataTask() {
		/* Define environment constants if not defined yet */
		if ( !defined( 'WIKIA_ENV_PROD' ) ) {
			define( WIKIA_ENV_PROD, 'test-prod') ;
		}
		if ( !defined( 'WIKIA_ENV_DEV' ) ) {
			define( WIKIA_ENV_DEV, 'test-dev' );
		}
		if ( !defined( 'WIKIA_ENV_INTERNAL' ) ) {
			define( WIKIA_ENV_INTERNAL, 'test-internal' );
		}

		/* Mock wgWikiaEnvironment */
		$this->mockGlobalVariable( 'wgWikiaEnvironment', WIKIA_ENV_PROD );

		/* Mock user */
		$userMock = $this->getMockBuilder( 'User' )
			->disableOriginalConstructor()
			->getMock();

		/* Mock ExactTargetUpdateUserTask */
		$mockUpdateUserTask = $this->getMockBuilder( 'ExactTargetUpdateUserTask' )
			->disableOriginalConstructor()
			->setMethods( [ 'call', 'queue' ] )
			->getMock();
		$mockUpdateUserTask
			->expects( $this->once() )
			->method( 'call' );
		$mockUpdateUserTask
			->expects( $this->once() )
			->method( 'queue' );

		/* Get mock object of tested class ExactTargetUpdatesHooks */
		$exactTargetUpdatesHooksMock = $this->getMockBuilder( 'ExactTargetUpdatesHooks' )
			->setMethods( [ 'prepareUserParams' ] )
			->getMock();
		$exactTargetUpdatesHooksMock
			->expects( $this->once() )
			->method( 'prepareUserParams' );

		/* Run test */
		/* @var ExactTargetUpdatesHooks $exactTargetUpdatesHooksMock (mock of ExactTargetUpdatesHooks) */
		$exactTargetUpdatesHooksMock->addTheUpdateUserPropertiesTask( $userMock, $mockUpdateUserTask );
	}
}
