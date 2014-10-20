<?php

class ExactTargetUserTasksAdderHooksTest extends WikiaBaseTest {

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
		$exactTargetUpdatesHooksMock = $this->getMock( 'ExactTargetUserTasksAdderBaseHooks', null );

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
		$exactTargetUpdatesHooksMock = $this->getMock( 'ExactTargetUserTasksAdderBaseHooks', null );

		/* Run test */
		/* @var ExactTargetUpdatesHooks $exactTargetUpdatesHooksMock (mock of ExactTargetUpdatesHooks) */
		$aUserPropertiesParamsActual = $exactTargetUpdatesHooksMock->prepareUserPropertiesParams( $userMock );

		$this->assertEquals( $aUserPropertiesParamsActual, $aUserPropertiesParamsExpected );
	}


	/**
	 * Test that task should be created or shouldn't be created on specific environment
	 * @dataProvider taskNotCreatedOnDevAnyProvider
	 * @param string $sTaskClassGetterName Name of method that gets task instance
	 * @param string $sTestedMethodName Name of method being tested
	 * @param array $aParams List of params for method being tested
	 * @param string $sProduction Environment name WIKIA_ENV_PROD / WIKIA_ENV_DEV
	 * @param bool $shouldQueue whether task should be queued of not
	 */
	function testTaskShouldBeQueuedOrNot( $sTaskClassGetterName, $sTestedMethodName, $aParams, $sProduction, $shouldQueue ) {
		/* Mock wgWikiaEnvironment */
		$this->mockGlobalVariable( 'wgWikiaEnvironment', $sProduction );

		/* Mock ExactTargetBaseTask
		 * Mock just base class as it's only important to have call and queue methods available for test
		 */
		$mockTask = $this->getMockBuilder( 'ExactTargetBaseTask' )
			->disableOriginalConstructor()
			->setMethods( [ 'call', 'queue' ] )
			->getMock();
		$mockTask
			->expects( $this->exactly( (int)$shouldQueue ) )
			->method( 'call' );
		$mockTask
			->expects( $this->exactly( (int)$shouldQueue ) )
			->method( 'queue' );

		/* Get mock object of tested class */
		$exactTargetUpdatesHooksMock = $this->getMockBuilder( 'ExactTargetUserTasksAdderHooks' )
			->setMethods( [ $sTaskClassGetterName ] )
			->getMock();
		$exactTargetUpdatesHooksMock
			->method( $sTaskClassGetterName )
			->will( $this->returnValue( $mockTask ) );

		/* Use reflection and set accessibility of method as some of tested methods may be private */
		$method = new ReflectionMethod( 'ExactTargetUserTasksAdderHooks', $sTestedMethodName );
		$method->setAccessible( true );

		/* Add mock of tested class at the begining of params array */
		array_unshift( $aParams, $exactTargetUpdatesHooksMock );
		/* Run tested method */
		call_user_func_array ( [$method, 'invoke'], $aParams );
	}

	function taskNotCreatedOnDevAnyProvider() {
		/* Define environment constants if not defined yet */
		if ( !defined( 'WIKIA_ENV_PROD' ) ) {
			define( WIKIA_ENV_PROD, 'test-prod') ;
		}
		if ( !defined( 'WIKIA_ENV_DEV' ) ) {
			define( WIKIA_ENV_DEV, 'test-dev') ;
		}
		if ( !defined( 'WIKIA_ENV_INTERNAL' ) ) {
			define( WIKIA_ENV_INTERNAL, 'test-internal' );
		}

		/* Mock User */
		$userMock = $this->getMockBuilder( 'User' )
			->disableOriginalConstructor()
			->getMock();

		/* Mock WikiPage */
		$oArticle = $this->getMockBuilder( 'WikiPage' )
			->disableOriginalConstructor()
			->getMock();

		return [
			/* test onUserSaveSettings should add taks on production */
			[ 'getExactTargetUpdateUserTask', 'onUserSaveSettings', [ $userMock ], WIKIA_ENV_PROD, 1 ],
			/* test onUserSaveSettings shouldn't add taks on production */
			[ 'getExactTargetUpdateUserTask', 'onUserSaveSettings', [ $userMock ], WIKIA_ENV_DEV, 0 ],
			/* test onEmailChangeConfirmed should add taks on production */
			[ 'getExactTargetUpdateUserTask', 'onEmailChangeConfirmed', [ $userMock ], WIKIA_ENV_PROD, 1 ],
			/* test onEmailChangeConfirmed shouldn't add taks on production */
			[ 'getExactTargetUpdateUserTask', 'onEmailChangeConfirmed', [ $userMock ], WIKIA_ENV_DEV, 0 ],
			/* test onArticleSaveComplete should add taks on production */
			[ 'getExactTargetUpdateUserTask', 'onArticleSaveComplete', [ $oArticle, $userMock ], WIKIA_ENV_PROD, 1 ],
			/* test onArticleSaveComplete shouldn't add taks on production */
			[ 'getExactTargetUpdateUserTask', 'onArticleSaveComplete', [ $oArticle, $userMock ], WIKIA_ENV_DEV, 0 ],
			/* test onAfterAccountRename should add taks on production */
			[ 'getExactTargetUpdateUserTask', 'onAfterAccountRename', [ 123, 'oldUserName', 'newUserName' ], WIKIA_ENV_PROD, 1 ],
			/* test onAfterAccountRename shouldn't add taks on production */
			[ 'getExactTargetUpdateUserTask', 'onAfterAccountRename', [ 123, 'oldUserName', 'newUserName' ], WIKIA_ENV_DEV, 0 ],
			/* test onEditAccountClosed should add taks on production */
			[ 'getExactTargetRemoveUserTask', 'onEditAccountClosed', [ $userMock ], WIKIA_ENV_PROD, 1 ],
			/* test onEditAccountClosed shouldn't add taks on production */
			[ 'getExactTargetRemoveUserTask', 'onEditAccountClosed', [ $userMock ], WIKIA_ENV_DEV, 0 ],
			/* test addTheUpdateCreateUserTask should add taks on production */
			[ 'getExactTargetCreateUserTask', 'addTheUpdateCreateUserTask', [ $userMock ], WIKIA_ENV_PROD, 1 ],
			/* test addTheUpdateCreateUserTask shouldn't add taks on production */
			[ 'getExactTargetCreateUserTask', 'addTheUpdateCreateUserTask', [ $userMock ], WIKIA_ENV_DEV, 0 ]
		];
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
		$exactTargetUpdatesHooksMock = $this->getMockBuilder( 'ExactTargetUserTasksAdderHooks' )
			->setMethods( [ 'prepareUserParams', 'getExactTargetUpdateUserTask' ] )
			->getMock();
		$exactTargetUpdatesHooksMock
			->expects( $this->once() )
			->method( 'prepareUserParams' );
		$exactTargetUpdatesHooksMock
			->expects( $this->once() )
			->method( 'getExactTargetUpdateUserTask' )
			->will( $this->returnValue( $mockUpdateUserTask ) );

		/* Run test */
		/* @var ExactTargetUpdatesHooks $exactTargetUpdatesHooksMock (mock of ExactTargetUpdatesHooks) */
		$exactTargetUpdatesHooksMock->onUserSaveSettings( $userMock );
	}
}
