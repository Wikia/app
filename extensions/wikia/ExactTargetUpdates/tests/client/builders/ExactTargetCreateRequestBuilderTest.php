<?php

class ExactTargetCreateRequestBuilderTest extends WikiaBaseTest {

	public function setUp() {
		require_once __DIR__ . '/../../helpers/RequestBuilderTestsHelper.class.php';
		$this->setupFile = __DIR__ . '/../../../ExactTargetUpdates.setup.php';
		parent::setUp();
	}

	/**
	 * @dataProvider groupsDataProvider
	 */
	public function testCreateUserGroupRequestBuild( $userId, $group ) {
		$data = $this->prepareGroupData( $userId, $group );
		$expected = $this->prepareCreateOption( $data, 'DataExtensionObject' );

		$request = \Wikia\ExactTarget\ExactTargetRequestBuilder::getUserGroupCreateBuilder()
			->withUserId( $userId )
			->withGroup( $group )
			->build();

		$this->assertEquals( $expected, $request );
	}

	public function groupsDataProvider() {
		return [
			[ 1, 'test' ],
			[ 0, '' ],
			[ null, null ]
		];
	}

	/**
	 * @dataProvider emailsDataProvider
	 */
	public function testCreateRequest( $email ) {
		$subscriber = RequestBuilderTestsHelper::prepareSubscriber( $email, true );
		$expected = $this->prepareCreateOption( $subscriber, 'Subscriber' );

		$oRequest = \Wikia\ExactTarget\ExactTargetRequestBuilder::getSubscriberCreateBuilder()
			->withUserEmail( $email )
			->build();

		$this->assertEquals( $expected, $oRequest );
	}

	public function emailsDataProvider() {
		return [
			[ ],
			[ 'test@test.com' ],
		];
	}

	private function prepareGroupData( $userId, $group ) {
		$obj = new ExactTarget_DataExtensionObject();
		$obj->CustomerKey = 'user_groups';
		$obj->Properties = [
			RequestBuilderTestsHelper::prepareApiProperty( 'ug_user', $userId ),
			RequestBuilderTestsHelper::prepareApiProperty( 'ug_group', $group ),
		];

		return [ $obj ];
	}

	private function prepareCreateOption( $subscribers, $type ) {
		$oRequest = new \ExactTarget_CreateRequest();
		$vars = [ ];
		foreach ( $subscribers as $item ) {
			$vars[] = $this->wrapToSoapVar( $item, $type );
		}
		$oRequest->Options = NULL;
		$oRequest->Objects = $vars;
		return $oRequest;
	}

	private function wrapToSoapVar( $oObject, $objectType ) {
		return new \SoapVar( $oObject, SOAP_ENC_OBJECT, $objectType, 'http://exacttarget.com/wsdl/partnerAPI' );
	}
}
