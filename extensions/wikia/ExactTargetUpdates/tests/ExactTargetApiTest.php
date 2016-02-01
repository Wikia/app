<?php

require_once __DIR__ . '/../lib/exacttarget_soap_client.php';

class ExactTargetApiTest extends WikiaBaseTest {

	public function setUp() {
		$this->setupFile = __DIR__ . '/../ExactTargetUpdates.setup.php';
		parent::setUp();
		require_once __DIR__ . '/helpers/ExactTargetApiWrapper.php';
	}

	function testPrepareSoapVarsShouldReturnSoapVarsArray() {
		/* Params to compare */
		$iUserId = 12345;
		$aUserProperties = [
			'property1' => 'value1',
			'property2' => 'value2'
		];

		/* prepare DataExtension objects array */
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

			$aDE[] = $DE;
		}

		/* prepare request mock - array of SoapVars */
		$aSoapVarsExpected = [];
		foreach ( $aDE as $DE ) {
			$soapVar = new SoapVar( $DE, SOAP_ENC_OBJECT, 'DataExtensionObject', 'http://exacttarget.com/wsdl/partnerAPI' );
			$aSoapVarsExpected[] = $soapVar;
		}

		/* Mock tested class */
		$baseTask = new Wikia\ExactTarget\ExactTargetApiHelper();

		/* Run test */
		$aSoapVarsActual = $baseTask->prepareSoapVars( $aDE, 'DataExtensionObject' );
		$this->assertEquals( $aSoapVarsExpected, $aSoapVarsActual );
	}

	/**
	 * @dataProvider deleteSubscriberProvider
	 */
	function testDeleteSubscriber( $aApiParams, $expectedRequest) {
		// Mock tested class
		$mockApiSubscriber = $this->getMockBuilder( 'Wikia\ExactTarget\ExactTargetApiSubscriber' )
			->disableOriginalConstructor()
			->setMethods( [ 'sendRequest' ] )
			->getMock();
		$mockApiSubscriber
			->expects( $this->once() )
			->method( 'sendRequest' )
			->with( 'Delete', $expectedRequest );

		// Set helper property
		$oReflection = new ReflectionClass($mockApiSubscriber);
		$oReflectionProperty = $oReflection->getProperty('helper');
		$oReflectionProperty->setAccessible(true);
		$oReflectionProperty->setValue($mockApiSubscriber, new Wikia\ExactTarget\ExactTargetApiHelper());

		// Run tested method
		$mockApiSubscriber->deleteRequest($aApiParams);
	}

	/**
	 * Ensure that SoapFaults thrown by the SoapClient are caught.
	 */
	function testSendRequestCatchSoapFault() {
		$mockSoapClient = $this->getExactTargetSoapClientMock();

		$mockSoapClient
			->expects( $this->once() )
			->method( 'Update' )
			->with( array() )
			->will($this->throwException(new SoapFault("Could not connect to host")));

		$api = new ExactTargetApiWrapper();
		$api->setClient( $mockSoapClient );
		$this->assertFalse( $api->sendRequest( 'Update', array() ) );
	}



	function deleteSubscriberProvider () {
		// Prepare input parameters
		$aApiParams = [
			'Subscriber' => [
				[
					'SubscriberKey' => 'test@test.com',
				],
			],
		];

		// Prepare expected request parameter to be send
		$aSoapVars = [];
		$oSubscriber = new ExactTarget_Subscriber();
		$oSubscriber->SubscriberKey = 'test@test.com';
		$aSoapVars[] = new SoapVar( $oSubscriber, SOAP_ENC_OBJECT, 'Subscriber', 'http://exacttarget.com/wsdl/partnerAPI' );

		$oExpectedRequest = new ExactTarget_DeleteRequest();
		$oExpectedRequest->Objects = $aSoapVars;
		$oExpectedRequest->Options = new ExactTarget_DeleteOptions();

		return [
			[ $aApiParams, $oExpectedRequest ]
		];
	}

	protected function getExactTargetSoapClientMock() {
		return $this->getMockBuilder( '\ExactTargetSoapClient' )
			->disableOriginalConstructor()
			->setMethods( [ 'Update' ] )
			->getMock();
	}

}
