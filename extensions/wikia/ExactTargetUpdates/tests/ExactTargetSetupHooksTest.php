<?php

class ExactTargetSetupHooksTest extends WikiaBaseTest {

	/**
	 * Determine whether update should be performed on specific environment
	 * @dataProvider shouldUpdateProvider
	 * @param string $sProduction
	 * @param bool $bDevelopmentMode
	 * @param bool $bExpectsShouldUpdate
	 */
	function testShouldUpdate( $sEnvironment, $bDevelopmentMode, $bExpectsShouldUpdate ) {
		/* Mock global vars */
		$this->mockGlobalVariable( 'wgWikiaEnvironment', $sEnvironment );
		$this->mockGlobalVariable( 'wgExactTargetDevelopmentMode', $bDevelopmentMode );
		/* Get mock object of tested class */
		$exactTargetUpdatesHooksMock = $this->getMockBuilder( 'ExactTargetSetupHooks' )
			->setMethods( null )
			->getMock();

		/* Use reflection and set accessibility of method as some of tested methods may be private */
		$method = new ReflectionMethod( 'ExactTargetSetupHooks', 'shouldUpdate' );
		$method->setAccessible( true );

		/* Run tested method */
		$bActualResult = $method->invoke( $exactTargetUpdatesHooksMock );

		$this->assertEquals( $bActualResult, $bExpectsShouldUpdate );

	}

	function shouldUpdateProvider() {
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

		$bDevelopmentModeEnabled = true;
		$bDevelopmentModeDisabled = false;
		$bExpectsShouldUpdate = true;
		$bExpectsShouldNotUpdate = false;

		return [
			[ WIKIA_ENV_PROD, $bDevelopmentModeDisabled, $bExpectsShouldUpdate ],
			[ WIKIA_ENV_PROD, $bDevelopmentModeEnabled, $bExpectsShouldUpdate ],
			[ WIKIA_ENV_DEV, $bDevelopmentModeDisabled, $bExpectsShouldNotUpdate ],
			[ WIKIA_ENV_DEV, $bDevelopmentModeEnabled, $bExpectsShouldUpdate ],
			[ WIKIA_ENV_INTERNAL, $bDevelopmentModeDisabled, $bExpectsShouldNotUpdate ],
			[ WIKIA_ENV_INTERNAL, $bDevelopmentModeEnabled, $bExpectsShouldUpdate ],
		];
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
			[ 'getExactTargetDeleteUserTask', 'onEditAccountClosed', [ $userMock ], WIKIA_ENV_PROD, 1 ],
			/* test onEditAccountClosed shouldn't add taks on production */
			[ 'getExactTargetDeleteUserTask', 'onEditAccountClosed', [ $userMock ], WIKIA_ENV_DEV, 0 ],
			/* test addTheUpdateCreateUserTask should add taks on production */
			[ 'getExactTargetCreateUserTask', 'addTheUpdateCreateUserTask', [ $userMock ], WIKIA_ENV_PROD, 1 ],
			/* test addTheUpdateCreateUserTask shouldn't add taks on production */
			[ 'getExactTargetCreateUserTask', 'addTheUpdateCreateUserTask', [ $userMock ], WIKIA_ENV_DEV, 0 ]
		];
	}

	function _testShouldAddUpdateUserDataTask() {
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
