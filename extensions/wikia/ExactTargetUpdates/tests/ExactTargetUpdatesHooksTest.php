<?php

class ExactTargetUpdatesHooksTest extends WikiaBaseTest {
	public function PrepareParamstest() {
		$userMock = $this->getMockBuilder( 'User' )
			->disableOriginalConstructor()
			->setMethods( array( 'getId', 'getName', 'getRealName', 'getEmail', 'getEmailAuthenticationTimestamp',
				'getRegistration', 'getEditCount', 'getOptions', 'getTouched') )
			->getMock();

		$userParams = [
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
			->will   ( $this->returnValue( $userParams['user_id'] ) );

		$userMock
			->expects( $this->once() )
			->method ( 'getName' )
			->will   ( $this->returnValue( $userParams['user_name'] ) );

		$userMock
			->expects( $this->once() )
			->method ( 'getRealName' )
			->will   ( $this->returnValue( $userParams['user_real_name'] ) );

		$userMock
			->expects( $this->once() )
			->method ( 'getEmail' )
			->will   ( $this->returnValue( $userParams['user_email'] ) );

		$userMock
			->expects( $this->once() )
			->method ( 'getEmailAuthenticationTimestamp' )
			->will   ( $this->returnValue( $userParams['user_email_authenticated'] ) );

		$userMock
			->expects( $this->once() )
			->method ( 'getRegistration' )
			->will   ( $this->returnValue( $userParams['user_registration'] ) );

		$userMock
			->expects( $this->once() )
			->method ( 'getEditCount' )
			->will   ( $this->returnValue( $userParams['user_editcount'] ) );

		$userMock
			->expects( $this->once() )
			->method ( 'getOptions' )
			->will   ( $this->returnValue( $userParams['user_options'] ) );

		$userMock
			->expects( $this->once() )
			->method ( 'getTouched' )
			->will   ( $this->returnValue( $userParams['user_touched'] ) );

		$userParamsResult = ExactTargetUpdatesHooks::prepareParams( $userMock );

		$this->assertEquals($userParamsResult, $userParams);

	}

	function testTaskNotCreatedOnDev() {

		// Define environment constants if not defined yet
		if ( !defined( 'WIKIA_ENV_DEV' ) ) {
				define( WIKIA_ENV_DEV, 'test-dev') ;
		}
		if ( !defined( 'WIKIA_ENV_INTERNAL' ) ) {
				define( WIKIA_ENV_INTERNAL, 'test-internal' );
		}

		// Setup mocks
		$this->mockGlobalVariable( 'wgWikiaEnvironment', WIKIA_ENV_DEV );

		$userMock = $this->getMockBuilder( 'User' )
			->disableOriginalConstructor()
			->getMock();

		// ExactTargetAddUserTask
		$mockAddUserTaskParams = array (
			'call' => [ 'will' => 'null', 'expects' => 0 ],
			'queue' => [ 'will' => 'null', 'expects' => 0 ],
		);
		$this->setUpMockObject( 'ExactTargetAddUserTask', $mockAddUserTaskParams, true );

		// Mock tested class ExactTargetUpdatesHooks
		$exactTargetUpdatesHooksMock = $this->getMock( 'ExactTargetUpdatesHooks', [ 'prepareParams' ] );
		// Override prepareParams method output
		$exactTargetUpdatesHooksMock->expects( $this->never() )
			->method( 'prepareParams' )
			->will( $this->returnValue( ['foo'=>'bar'] ) );

		$getReturnToFromQueryMethod = new ReflectionMethod( 'ExactTargetUpdatesHooks', 'onSignupConfirmEmailCompleteRun' );

		$getReturnToFromQueryMethod->invoke( $exactTargetUpdatesHooksMock, $userMock );
	}

	protected function setUpMockObject( $objectName, $objectParams = null, $needSetInstance = false ) {
		$mockObject = $objectParams;
		if ( is_array( $objectParams ) ) {

			$methods = array_keys( $objectParams );

			$mockObject = $this->getMock( $objectName, $methods );

			foreach( $objectParams as $method => $methodParams ) {
					if ( isset( $methodParams['expects'] ) && is_int( $methodParams['expects'] ) ) {
						$mockObject->expects( $this->exactly($methodParams['expects']) )
							->method( $method )
							->will( $this->returnValue( $methodParams['will'] ) );
					} else {

					$mockObject->expects( $this->any() )
						->method( $method )
						->will( $this->returnValue( $methodParams['will'] ) );
					}
			}

		}

		if ( $needSetInstance ) {
			$this->mockClass( $objectName, $mockObject );
		}
	}
}
