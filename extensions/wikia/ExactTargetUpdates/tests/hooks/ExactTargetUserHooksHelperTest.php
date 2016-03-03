<?php

class ExactTargetUserHooksHelperTest extends WikiaBaseTest {

	public function setUp() {
		$this->setupFile = __DIR__ . '/../../ExactTargetUpdates.setup.php';
		parent::setUp();
	}

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
		$exactTargetUpdatesHooksMock = $this->getMock( 'Wikia\ExactTarget\ExactTargetUserHooksHelper', null );

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
			->setMethods( [ 'getGlobalPreference' ] )
			->getMock();

		// Create a map of arguments to return values.
		$returnMap = [
			[ 'marketingallowed', null, false, 1 ],
			[ 'unsubscribed', null, false, null ],
			[ 'language', null, false, 'en' ]
		];

		$userMock
			->expects( $this->exactly( 3 ) )
			->method( 'getGlobalPreference' )
			->will( $this->returnValueMap( $returnMap ) );

		/* Get mock object of tested class ExactTargetUpdatesHooks without mocking any methods */
		$exactTargetUpdatesHooksMock = $this->getMock( 'Wikia\ExactTarget\ExactTargetUserHooksHelper', null );

		/* Run test */
		/* @var ExactTargetUpdatesHooks $exactTargetUpdatesHooksMock (mock of ExactTargetUpdatesHooks) */
		$aUserPropertiesParamsActual = $exactTargetUpdatesHooksMock->prepareUserPropertiesParams( $userMock );

		$this->assertEquals( $aUserPropertiesParamsActual, $aUserPropertiesParamsExpected );
	}
}
