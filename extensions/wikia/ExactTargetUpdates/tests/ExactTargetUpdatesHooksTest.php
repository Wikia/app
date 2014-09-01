<?php

include __DIR__ . "/../lib/exacttarget_soap_client.php";

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

	function testPrepareRequestShouldReturnRequestObject() {
		/* Params to compare */
		$iUserId = 12345;
		$aUserProperties = [
			'property1' => 'value1',
			'property2' => 'value2'
		];

		/* prepare request mock */
		$aSoapVars = [];
		foreach ( $aUserProperties as $sProperty => $sValue ) {

			$DE = new ExactTarget_DataExtensionObject();
			$DE->CustomerKey = 'user_properties';

			$apiPropertyUser = new ExactTarget_APIProperty();
			$apiPropertyUser->Name = 'up_user';
			$apiPropertyUser->Value = $iUserId;

			$apiPropertyProperty = new ExactTarget_APIProperty();
			$apiPropertyProperty->Name = 'up_property';
			$apiPropertyProperty->Value = $sProperty;

			$apiPropertyValue = new ExactTarget_APIProperty();
			$apiPropertyValue->Name = 'up_value';
			$apiPropertyValue->Value = $sValue;

			$apiProperties = [ $apiPropertyUser, $apiPropertyProperty, $apiPropertyValue ];

			$DE->Properties = $apiProperties;

			$soapVar = new SoapVar( $DE, SOAP_ENC_OBJECT, 'DataExtensionObject', "http://exacttarget.com/wsdl/partnerAPI" );
			$aSoapVars[] = $soapVar;
		}

		$oRequestExpected = new ExactTarget_CreateRequest();

		$oRequestExpected->Options = NULL;
		$oRequestExpected->Objects = $aSoapVars;

		/* Mock tested class */
		$mockAddUserTask = $this->getMock( 'ExactTargetAddUserTask', [ 'getClient' ] );

		/* Run test */
		$oRequestActual = $mockAddUserTask->prepareRequest( $iUserId, $aUserProperties );
		$this->assertEquals( $oRequestExpected, $oRequestActual );
	}

	function testCallApiToCreateUserPropertiesDataExtensionShouldInvokeCreateMethodOnceWithRequestParam() {
		/* Params to compare */
		$iUserId = 12345;
		$aUserProperties = [
			'property1' => 'value1',
			'property2' => 'value2'
		];

		/* Prepare request object */
		$aSoapVars = [];
		foreach ( $aUserProperties as $sProperty => $sValue ) {

			$DE = new ExactTarget_DataExtensionObject();
			$DE->CustomerKey = 'user_properties';

			$apiPropertyUser = new ExactTarget_APIProperty();
			$apiPropertyUser->Name = 'up_user';
			$apiPropertyUser->Value = $iUserId;

			$apiPropertyProperty = new ExactTarget_APIProperty();
			$apiPropertyProperty->Name = 'up_property';
			$apiPropertyProperty->Value = $sProperty;

			$apiPropertyValue = new ExactTarget_APIProperty();
			$apiPropertyValue->Name = 'up_value';
			$apiPropertyValue->Value = $sValue;

			$apiProperties = [ $apiPropertyUser, $apiPropertyProperty, $apiPropertyValue ];

			$DE->Properties = $apiProperties;

			$soapVar = new SoapVar( $DE, SOAP_ENC_OBJECT, 'DataExtensionObject', "http://exacttarget.com/wsdl/partnerAPI" );
			$aSoapVars[] = $soapVar;
		}

		$oRequest = new ExactTarget_CreateRequest();

		$oRequest->Options = NULL;
		$oRequest->Objects = $aSoapVars;

		$soapClient = $this->getMockBuilder( 'ExactTargetSoapClient' )
			->disableOriginalConstructor()
			->setMethods( [ 'Create' ] )
			->getMock();
		$soapClient
			->expects( $this->once() )
			->method( 'Create' )
			->with( $oRequest );

		/* Mock tested class */
		$mockAddUserTask = $this->getMock( 'ExactTargetAddUserTask', ['prepareRequest', 'getClient'] );
		$mockAddUserTask
			->expects( $this->once() )
			->method( 'prepareRequest' )
			->will( $this->returnValue( $oRequest ) );
		$mockAddUserTask
			->expects( $this->once() )
			->method( 'getClient' )
			->will( $this->returnValue( $soapClient ) );

		/* Run test */
		$mockAddUserTask->callApiToCreateUserPropertiesDataExtension( $iUserId, $aUserProperties );
	}
}
