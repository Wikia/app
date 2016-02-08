<?php

require_once __DIR__ . '/helpers/ExactTargetApiTestBase.php';

class ExactTargetApiTest extends ExactTargetApiTestBase {

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
	 * Ensure that SoapFaults thrown by the SoapClient are caught.
	 */
	function testSendRequestCatchSoapFault() {
		$mockLogger = $this->getWikiaLoggerMock();
		$mockSoapClient = $this->getExactTargetSoapClientMock();

		$mockSoapClient
			->expects( $this->once() )
			->method( 'Update' )
			->with( array() )
			->will($this->throwException(new SoapFault("Could not connect to host")));

		$mockLogger
			->expects( $this->once() )
			->method( 'error' )
			->with( 'Wikia\ExactTarget\ExactTargetApi::sendRequest' );


		$api = new ExactTargetApiWrapper();
		$api->setClient( $mockSoapClient );
		$api->setLogger( $mockLogger );
		$this->assertFalse( $api->sendRequest( 'Update', array() ) );
	}

	function testSendRequestSuccess() {
		$responseValue = 'response';
		$lastRespose = 'last response';
		$mockLogger = $this->getWikiaLoggerMock();
		$mockSoapClient = $this->getExactTargetSoapClientMock();

		$mockSoapClient
			->expects( $this->once() )
			->method( 'Update' )
			->with( $this->anything() )
			->willReturn( $responseValue );

		$mockSoapClient
			->expects( $this->once() )
			->method( '__getLastResponse' )
			->willReturn( $lastRespose );

		$mockLogger
			->expects( $this->once() )
			->method( 'info' )
			->with( $this->matchesRegularExpression( "/.*{$lastRespose}.*/") );

		$api = new ExactTargetApiWrapper();
		$api->setClient( $mockSoapClient );
		$api->setLogger( $mockLogger );
		$this->assertEquals( $responseValue, $api->sendRequest( 'Update', array() ) );
	}

}
