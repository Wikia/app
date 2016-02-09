<?php


class ExactTargetUserTaskHelperTest extends WikiaBaseTest {

	const TEST_EMAIL = 'test@wikia-inc.com';

	private $helper;

	public function setUp() {
		$this->setupFile = __DIR__ . '/../ExactTargetUpdates.setup.php';
		parent::setUp();

		$this->helper = new \Wikia\ExactTarget\ExactTargetUserTaskHelper();
	}

	/**
	 * @dataProvider simpleFilterPartProvider
	 */
	public function testPrepareSubscriberData( $email, $subscribed, $expectedSubscription ) {
		$object = $this->helper->prepareSubscriberData( $email, $subscribed );

		$this->assertEquals( $email, $object[ 'Subscriber' ][0][ 'SubscriberKey' ] );
		$this->assertEquals( $email, $object[ 'Subscriber' ][0][ 'EmailAddress' ] );
		$this->assertEquals( $expectedSubscription, $object[ 'Subscriber' ][0][ 'Status' ] );
	}

	public function simpleFilterPartProvider() {
		return [
			[ self::TEST_EMAIL, true, \ExactTarget_SubscriberStatus::Active ],
			[ self::TEST_EMAIL, null, \ExactTarget_SubscriberStatus::Active ],
			[ self::TEST_EMAIL, 1, \ExactTarget_SubscriberStatus::Active ],
			[ self::TEST_EMAIL, 0, \ExactTarget_SubscriberStatus::Unsubscribed ],
			[ self::TEST_EMAIL, false, \ExactTarget_SubscriberStatus::Unsubscribed ],
			];
	}

}
