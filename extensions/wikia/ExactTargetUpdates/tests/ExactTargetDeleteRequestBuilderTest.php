<?php

class ExactTargetDeleteRequestBuilderTest extends WikiaBaseTest {

	public function setUp() {
		require_once __DIR__ . '/helpers/RequestBuilderTestsHelper.class.php';
		$this->setupFile = __DIR__ . '/../ExactTargetUpdates.setup.php';
		parent::setUp();
	}

	/**
	 * @dataProvider emailsDataProvider
	 */
	public function testDeleteRequest( $email ) {
		// Prepare expected structure
		$subscribers = RequestBuilderTestsHelper::prepareSubscriber( $email );
		$expected = $this->prepareDeleteOption( $subscribers, 'Subscriber' );

		$oDeleteRequest = \Wikia\ExactTarget\ExactTargetRequestBuilder::getDeleteBuilder()
			->withUserEmail( $email )
			->build();

		$this->assertEquals( $expected, $oDeleteRequest );
	}

	public function emailsDataProvider() {
		return [
			[ ],
			[ 'test@test.com' ],
		];
	}

	/**
	 * @dataProvider groupsDataProvider
	 */
	public function testGroupRemovalRequestBuild( $userId, $group ) {
		$preparedData = $this->prepareGroupData( $userId, $group );
		$expected = $this->prepareDeleteOption( $preparedData, 'DataExtensionObject' );

		$oDeleteRequest = \Wikia\ExactTarget\ExactTargetRequestBuilder::getDeleteBuilder()
			->withUserId( $userId )
			->withGroup( $group )
			->build();

		$this->assertEquals( $expected, $oDeleteRequest );
	}

	public function groupsDataProvider() {
		return [
			[ 1, 'test' ],
			[ 0, '' ],
		];
	}

	private function prepareGroupData( $userId, $group ) {
		$obj = new ExactTarget_DataExtensionObject();
		$obj->CustomerKey = 'user_groups';
		$obj->Keys = [
			RequestBuilderTestsHelper::prepareApiProperty( 'ug_user', $userId ),
			RequestBuilderTestsHelper::prepareApiProperty( 'ug_group', $group ),
		];

		return [ $obj ];
	}

	private function prepareDeleteOption( $aSubscribers, $type ) {
		$oDeleteRequest = new \ExactTarget_DeleteRequest();
		$vars = [ ];
		foreach ( $aSubscribers as $item ) {
			$vars[] = $this->wrapToSoapVar( $item, $type );
		}
		$oDeleteRequest->Objects = $vars;
		$oDeleteRequest->Options = new \ExactTarget_DeleteOptions();
		return $oDeleteRequest;
	}

	private function wrapToSoapVar( $oObject, $objectType ) {
		return new \SoapVar( $oObject, SOAP_ENC_OBJECT, $objectType, 'http://exacttarget.com/wsdl/partnerAPI' );
	}

}
