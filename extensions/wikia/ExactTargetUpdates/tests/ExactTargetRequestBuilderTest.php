<?php

use Wikia\ExactTarget\ExactTargetApiHelper;

class ExactTargetRequestBuilderTest extends WikiaBaseTest {
	public function setUp() {
		$this->setupFile = __DIR__ . '/../ExactTargetUpdates.setup.php';
		parent::setUp();
	}

	/**
	 * @dataProvider usersDataProvider
	 */
	public function testBuildRequest( $usersData, $expectedParams ) {
		// Prepare Expected
		$dataExtensions = array_map( [ $this, 'prepareDataExtension' ], $expectedParams );
		$expected = $this->prepareSaveOption( $dataExtensions );

		$oRequest = \Wikia\ExactTarget\ExactTargetRequestBuilder::createUpdate()
			->withUserData( $usersData )
			->build();

		$this->assertEquals( $expected, $oRequest );
	}

	public function testEmptyUser() {
		$this->setExpectedException( 'Wikia\Util\AssertionException' );
		\Wikia\ExactTarget\ExactTargetRequestBuilder::createUpdate()
			->withUserData( [ [ 'user_id' => 0 ] ] )
			->build();
	}

	/**
	 * @dataProvider emailsDataProvider
	 */
	public function testDeleteRequest( $email ) {
		// Prepare expected structure
		$subscribers = $this->prepareSubscriber( $email );
		$expected = $this->prepareDeleteOption( $subscribers );

		$oDeleteRequest = \Wikia\ExactTarget\ExactTargetRequestBuilder::createDelete()
			->withUserEmail( $email )
			->build();

		$this->assertEquals( $expected, $oDeleteRequest );
	}

	public function usersDataProvider() {
		return [
			// Test empty array
			[
				[ ], [ ]
			],
			// Test single user
			[
				[ [ 'user_id' => 1 ] ],
				[ [ 'user_id' => 1, 'properties' => [ ] ] ]
			],
			// Test double user
			[
				[ [ 'user_id' => 1 ], [ 'user_id' => 2 ] ],
				[ [ 'user_id' => 1, 'properties' => [ ] ], [ 'user_id' => 2, 'properties' => [ ] ] ]
			],
			// Test properties
			[
				[ [ 'user_id' => 1, 'user_email' => 'test@wikia.com' ] ],
				[ [ 'user_id' => 1, 'properties' => [ 'user_email' => 'test@wikia.com' ] ] ]
			],
			// Test two properties
			[
				[ [ 'user_id' => 1, 'user_email' => 'test@wikia.com', 'prop2' => 'val2' ] ],
				[ [ 'user_id' => 1, 'properties' => [ 'user_email' => 'test@wikia.com', 'prop2' => 'val2' ] ] ]
			]
		];
	}

	public function emailsDataProvider() {
		return [
			[ ],
			[ 'test@test.com' ],
		];
	}

	/** Tests helpers methods */

	private function prepareDataExtension( $userParams ) {
		$apiProperty = new ExactTarget_APIProperty();
		$apiProperty->Name = 'user_id';
		$apiProperty->Value = $userParams[ 'user_id' ];

		$dataExtension = new ExactTarget_DataExtensionObject();
		$dataExtension->Name = '';
		$dataExtension->Keys = [ $apiProperty ];
		$dataExtension->CustomerKey = 'user';
		$dataExtension->Properties = $this->prepareProperties( $userParams[ 'properties' ] );
		return $dataExtension;
	}

	private function prepareSubscriber( $email ) {
		$oSubscriber = new \ExactTarget_Subscriber();
		$oSubscriber->SubscriberKey = $email;

		return [ $oSubscriber ];
	}

	private function prepareSaveOption( $dataExtensions ) {
		$saveOption = new \ExactTarget_SaveOption();
		$saveOption->PropertyName = 'DataExtensionObject';
		$saveOption->SaveAction = \ExactTarget_SaveAction::UpdateAdd;

		$options = new ExactTarget_UpdateOptions();
		$options->SaveOptions = [ $this->wrapToSoapVar( $saveOption, 'SaveOption' ) ];

		$expected = new ExactTarget_UpdateRequest();
		$expected->Options = $options;
		$expected->Objects = array_map( [ $this, 'wrapToSoapVar' ], $dataExtensions );
		return $expected;
	}

	private function wrapToSoapVar( $oObject, $objectType = 'DataExtensionObject' ) {
		return new \SoapVar( $oObject, SOAP_ENC_OBJECT, $objectType, 'http://exacttarget.com/wsdl/partnerAPI' );
	}

	private function prepareProperties( $param ) {
		$result = [ ];
		foreach ( $param as $key => $value ) {
			$userExtensionObject = new ExactTarget_APIProperty();
			$userExtensionObject->Name = $key;
			$userExtensionObject->Value = $value;
			$result[] = $userExtensionObject;
		}
		return $result;
	}

	private function prepareDeleteOption( $aSubscribers ) {
		$oDeleteRequest = new \ExactTarget_DeleteRequest();
		$vars = [ ];
		foreach ( $aSubscribers as $item ) {
			$vars[] = $this->wrapToSoapVar( $item, 'Subscriber' );
		}
		$oDeleteRequest->Objects = $vars;
		$oDeleteRequest->Options = new \ExactTarget_DeleteOptions();
		return $oDeleteRequest;
	}
}
