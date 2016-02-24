<?php

class ExactTargetDeleteRequestBuilderTest extends WikiaBaseTest {

	public function setUp() {
		require_once __DIR__ . '/helpers/RequestBuilderTestsHelper.class.php';
		$this->setupFile = __DIR__ . '/../ExactTargetUpdates.setup.php';
		parent::setUp();
	}

	/**
	 * @dataProvider userIdProvider
	 */
	public function testDeleteUserRequestBuild( $userId ) {
		$data = $this->prepareUserData( $userId );
		$expected = $this->prepareDeleteOption( $data, 'DataExtensionObject' );

		$request = \Wikia\ExactTarget\ExactTargetRequestBuilder::getUserDeleteBuilder()
			->withUserId( $userId )
			->build();

		$this->assertEquals( $expected, $request );
	}

	public function userIdProvider() {
		return [
			[ 0 ],
			[ 1 ],
			[ null ]
		];
	}

	/**
	 * @dataProvider emailsDataProvider
	 */
	public function testDeleteRequest( $email ) {
		// Prepare expected structure
		$subscribers = RequestBuilderTestsHelper::prepareSubscriber( $email );
		$expected = $this->prepareDeleteOption( $subscribers, 'Subscriber' );

		$oDeleteRequest = \Wikia\ExactTarget\ExactTargetRequestBuilder::getSubscriberDeleteBuilder()
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

		$oDeleteRequest = \Wikia\ExactTarget\ExactTargetRequestBuilder::getUserGroupDeleteBuilder()
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

	private function prepareUserData( $userId ) {
		$obj = new ExactTarget_DataExtensionObject();
		$obj->CustomerKey = 'user';
		$obj->Keys = [
			RequestBuilderTestsHelper::prepareApiProperty( 'user_id', $userId ),
		];
		return [ $obj ];
	}

	private function prepareDeleteOption( $data, $type ) {
		$oDeleteRequest = new \ExactTarget_DeleteRequest();
		$vars = [ ];
		foreach ( $data as $item ) {
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
