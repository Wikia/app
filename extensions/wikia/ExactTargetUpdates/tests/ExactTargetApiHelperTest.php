<?php


class ExactTargetApiHelperTest extends WikiaBaseTest {

	const TEST_EMAIL = 'test@wikia-inc.com';
	const TEST_KEY = 'abc123';

	private $helper;

	public function setUp() {
		$this->setupFile = __DIR__ . '/../ExactTargetUpdates.setup.php';
		parent::setUp();

		$this->helper = new \Wikia\ExactTarget\ExactTargetApiHelper();
	}


	public function testWrapRetrieveRequest() {
		$request = $this->helper->wrapRetrieveRequest( [
			'ObjectType' => 'sometype',
			'Properties' => [ 'a' => 1 ],
			]);
		$this->assertNotNull( $request );
	}

	public function testPrepareSubscriberObjects() {
		$emptySubscriber = [];
		$partialSubscriber1 = [ 'EmailAddress' => self::TEST_EMAIL ];
		$partialSubscriber2 = [ 'SubscriberKey' => self::TEST_KEY ];
		$setSubscriber = [ 'SubscriberKey' => self::TEST_KEY, 'EmailAddress' => self::TEST_EMAIL ];
		$input = [ $emptySubscriber, $partialSubscriber1, $partialSubscriber2, $setSubscriber ];

		$subscribers = $this->helper->prepareSubscriberObjects( $input );
		$this->assertNotEmpty( $input );
		$this->assertEquals( count($input), count($subscribers) );

		$this->assertEmpty( $subscribers[0]->EmailAddress );
		$this->assertEmpty( $subscribers[0]->SubscriberKey );

		$this->assertEquals( self::TEST_EMAIL, $subscribers[1]->EmailAddress );
		$this->assertEmpty( $subscribers[1]->SubscriberKey );

		$this->assertEquals( self::TEST_KEY, $subscribers[2]->SubscriberKey );
		$this->assertEmpty( $subscribers[2]->EmailAddress );

		$this->assertEquals( self::TEST_EMAIL, $subscribers[3]->EmailAddress );
		$this->assertEquals( self::TEST_KEY, $subscribers[3]->SubscriberKey );
	}

}
