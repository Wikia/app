<?php

require_once __DIR__ . '/../lib/exacttarget_soap_client.php';
var_dump('class ExactTargetUpdateUserTaskTest loaded');

class ExactTargetUpdateUserTaskTest extends WikiaBaseTest {

	function testShouldInvokeUpdateMethodWithProperParam() {
		/* Params to compare */
		$iUserId = 12345;
		$aUserProperties = [
			'property1' => 'value1',
			'property2' => 'value2'
		];

		$oRequest = new ExactTarget_CreateRequest();

		$soapClient = $this->getMockBuilder( 'ExactTargetSoapClient' )
			->disableOriginalConstructor()
			->setMethods( [ 'Update' ] )
			->getMock();
		$soapClient
			->expects( $this->once() )
			->method( 'Update' )
			->with( $oRequest );

		/* Mock tested class */
		$mockUpdateUserTask = $this->getMockBuilder( 'ExactTargetUpdateUserTask' )
			->disableOriginalConstructor()
			->setMethods( [ 'wrapUpdateRequest', 'getClient' ] )
			->getMock();
		$mockUpdateUserTask
			->expects( $this->once() )
			->method( 'wrapUpdateRequest' )
			->will( $this->returnValue( $oRequest ) );
		$mockUpdateUserTask
			->expects( $this->once() )
			->method( 'getClient' )
			->will( $this->returnValue( $soapClient ) );

		$mockUpdateUserTask->initClient();
		/* @var ExactTargetUpdateUserTask $mockUpdateUserTask */
		$mockUpdateUserTask->updateUserPropertiesDataExtension( $iUserId, $aUserProperties );
	}
}
