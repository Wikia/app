<?php

require_once __DIR__ . '/../lib/exacttarget_soap_client.php';

class ExactTargetAddUserTaskTest extends WikiaBaseTest {

	public function setUp() {
		$this->setupFile = __DIR__ . '/../ExactTargetUpdates.setup.php';
		parent::setUp();
	}

	function testSendNewUserShouldDistributeParams() {
		/* Params to compare */
		$aUserData = [
			'user_id' => 12345,
			'user_email' => 'email@email.com'
		];
		$aUserProperties = [
			'property_name' => 'property_value'
		];

		$oSoapClient = $this->getMockBuilder( 'ExactTargetSoapClient' )
			->disableOriginalConstructor()
			->setMethods( [ 'Create' ] )
			->getMock();

		$oRemoveUserTask = $this->getMockBuilder( 'ExactTargetRemoveUserTask' )
			->disableOriginalConstructor()
			->setMethods( [ 'removeSubscriber' ] )
			->getMock();

		/* Mock tested class /*
		/* @var ExactTargetAddUserTask $addTaskMock mock of ExactTargetAddUserTask class */
		$addTaskMock = $this->getMockBuilder( 'ExactTargetAddUserTask' )
			->disableOriginalConstructor()
			->setMethods( [ 'getClient', 'getRemoveUserTaskObject', 'createUserPropertiesDataExtension', 'createUserDataExtension', 'createSubscriber' ] )
			->getMock();

		$addTaskMock
			->expects( $this->once() )
			->method( 'getClient' )
			->will( $this->returnValue( $oSoapClient ) );

		$addTaskMock
			->expects( $this->once() )
			->method( 'getRemoveUserTaskObject' )
			->will( $this->returnValue( $oRemoveUserTask ) );

		/* test createSubscriber invoke params */
		$addTaskMock
			->expects( $this->once() )
			->method( 'createSubscriber' )
			->with( $aUserData['user_email'], $oSoapClient );

		/* test createUserDataExtension invoke params */
		$addTaskMock
			->expects( $this->once() )
			->method( 'createUserDataExtension' )
			->with( $aUserData, $oSoapClient );

		/* test createUserPropertiesDataExtension invoke params */
		$addTaskMock
			->expects( $this->once() )
			->method( 'createUserPropertiesDataExtension' )
			->with( $aUserData['user_id'], $aUserProperties, $oSoapClient );

		/* Run tested method */
		$addTaskMock->updateAddUserData( $aUserData, $aUserProperties );
	}

	function testCreateUserPropertiesDataExtensionShouldSendData() {
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

	function testCreateUserDataExtensionShouldSendData() {
		/* Params to compare */
		$aUserData = [
			'user_id' => 12345,
			'user_email' => 'email@email.com'
		];

		/* Prepare request object */
		$aSoapVars = [];

		$DE = new ExactTarget_DataExtensionObject();
		$DE->CustomerKey = 'user';

		/* Prepare properties */
		$apiProperty = new ExactTarget_APIProperty();
		$apiProperty->Name = 'user_email';
		$apiProperty->Value = $aUserData['user_email'];
		$DE->Properties = [ $apiProperty ];

		/* Prepare keys */
		$apiProperty = new ExactTarget_APIProperty();
		$apiProperty->Name = 'user_id';
		$apiProperty->Value = $aUserData['user_id'];
		$DE->Keys = [ $apiProperty ];

		$soapVar = new SoapVar( $DE, SOAP_ENC_OBJECT, 'DataExtensionObject', 'http://exacttarget.com/wsdl/partnerAPI' );
		$aSoapVars[] = $soapVar;

		$oRequest = new ExactTarget_UpdateRequest();

		/* Prepare update-add options */
		$updateOptions = new ExactTarget_UpdateOptions();
		$saveOption = new ExactTarget_SaveOption();
		$saveOption->PropertyName = 'DataExtensionObject';
		$saveOption->SaveAction = ExactTarget_SaveAction::UpdateAdd;
		$updateOptions->SaveOptions[] = new SoapVar( $saveOption, SOAP_ENC_OBJECT, 'SaveOption', 'http://exacttarget.com/wsdl/partnerAPI' );

		$oRequest->Options = $updateOptions;
		$oRequest->Objects = $aSoapVars;

		$soapClient = $this->getMockBuilder( 'ExactTargetSoapClient' )
			->disableOriginalConstructor()
			->setMethods( [ 'Update' ] )
			->getMock();
		$soapClient
			->expects( $this->once() )
			->method( 'Update' )
			->with( $oRequest );

		/* Mock tested class */
		/* @var ExactTargetAddUserTask $mockAddUserTask mock of ExactTargetAddUserTask */
		$mockAddUserTask = $this->getMockBuilder( 'ExactTargetAddUserTask' )
			->disableOriginalConstructor()
			->setMethods( [ 'wrapUpdateRequest' ] )
			->getMock();
		$mockAddUserTask
			->expects( $this->once() )
			->method( 'wrapUpdateRequest' )
			->will( $this->returnValue( $oRequest ) );

		/* Run tested method */
		$mockAddUserTask->createUserDataExtension( $aUserData, $soapClient );
	}

	function testCreateSubscriberShouldSendData() {
		/* Params to compare */
		$sUserEmail = 'email@email.com';

		$oSubscriber = new ExactTarget_Subscriber();
		$oSubscriber->SubscriberKey = $sUserEmail;
		$oSubscriber->EmailAddress = $sUserEmail;

		$soapVar = new SoapVar( $oSubscriber, SOAP_ENC_OBJECT, 'Subscriber', 'http://exacttarget.com/wsdl/partnerAPI' );

		$oRequest = new ExactTarget_CreateRequest();
		$oRequest->Options = NULL;
		$oRequest->Objects = [ $soapVar ];

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
		$mockAddUserTask->createSubscriber( $sUserEmail, $soapClient );
	}

}
