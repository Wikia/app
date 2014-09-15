<?php

require_once __DIR__ . '/../lib/exacttarget_soap_client.php';

class ExactTargetAddUserTaskTest extends WikiaBaseTest {


	function testSendNewUserShouldInvokeFollowingMethods() {
		/* Params to compare */
		$aUserData = [
			'user_id' => '12345',
			'user_email' => 'email@email.com'
		];
		$aUserProperties = [];

		/* @var ExactTargetAddUserTask $addTaskMock */
		$addTaskMock = $this->getMockBuilder( 'ExactTargetAddUserTask' )
			->disableOriginalConstructor()
			->setMethods( [ 'getClient', 'createUserPropertiesDataExtension', 'createUserDataExtension', 'createSubscriber' ] )
			->getMock();

		/* require getClient once */
		$addTaskMock
			->expects( $this->once() )
			->method( 'getClient' );

		/* require createSubscriber once */
		$addTaskMock
			->expects( $this->once() )
			->method( 'createSubscriber' );

		/* require createUserDataExtension once */
		$addTaskMock
			->expects( $this->once() )
			->method( 'createUserDataExtension' );

		/* require createUserPropertiesDataExtension once */
		$addTaskMock
			->expects( $this->once() )
			->method( 'createUserPropertiesDataExtension' );

		/* Run tested method */
		$addTaskMock->sendNewUserData( $aUserData, $aUserProperties );
	}

	function testCreateUserPropertiesDataExtensionShouldInvokeCreateMethodOnceWithRequestParam() {
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

			$soapVar = new SoapVar( $DE, SOAP_ENC_OBJECT, 'DataExtensionObject', 'http://exacttarget.com/wsdl/partnerAPI' );
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
		$mockAddUserTask = $this->getMockBuilder( 'ExactTargetAddUserTask' )
			->disableOriginalConstructor()
			->setMethods( [ 'wrapCreateRequest', 'getClient' ] )
			->getMock();
		$mockAddUserTask
			->expects( $this->once() )
			->method( 'wrapCreateRequest' )
			->will( $this->returnValue( $oRequest ) );

		/* Run tested method */
		$mockAddUserTask->createUserPropertiesDataExtension( $iUserId, $aUserProperties, $soapClient );
	}

	function testCreateUserDataExtensionShouldInvokeCreateMethodOnceWithRequestParam() {
		/* Params to compare */
		$aUserData = [
			'user_id' => 12345,
			'user_email' => 'test@test.com'
		];

		/* Prepare request object */
		$aSoapVars = [];
		$apiProperties = [];

		$DE = new ExactTarget_DataExtensionObject();
		$DE->CustomerKey = 'user';

		foreach ( $aUserData as $sProperty => $sValue ) {
			$apiProperty = new ExactTarget_APIProperty();
			$apiProperty->Name = $sProperty;
			$apiProperty->Value = $sValue;

			$apiProperties[] = $apiProperty;
		}

		$DE->Properties = $apiProperties;

		$soapVar = new SoapVar( $DE, SOAP_ENC_OBJECT, 'DataExtensionObject', 'http://exacttarget.com/wsdl/partnerAPI' );
		$aSoapVars[] = $soapVar;

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
		/* @var ExactTargetAddUserTask $mockAddUserTask mock of ExactTargetAddUserTask */
		$mockAddUserTask = $this->getMockBuilder( 'ExactTargetAddUserTask' )
			->disableOriginalConstructor()
			->setMethods( [ 'wrapCreateRequest' ] )
			->getMock();
		$mockAddUserTask
			->expects( $this->once() )
			->method( 'wrapCreateRequest' )
			->will( $this->returnValue( $oRequest ) );

		/* Run tested method */
		$mockAddUserTask->createUserDataExtension( $aUserData, $soapClient );
	}

}
