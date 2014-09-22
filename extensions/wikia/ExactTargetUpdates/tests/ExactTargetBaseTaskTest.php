<?php

require_once __DIR__ . '/../lib/exacttarget_soap_client.php';

class ExactTargetBaseTaskTest extends WikiaBaseTest {

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
		$baseTask = new ExactTargetBaseTask();

		/* Run test */
		$aSoapVarsActual = $baseTask->prepareSoapVars( $aDE, 'DataExtensionObject' );
		$this->assertEquals( $aSoapVarsExpected, $aSoapVarsActual );
	}

}
