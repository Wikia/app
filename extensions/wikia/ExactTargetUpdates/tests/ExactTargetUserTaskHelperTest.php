<?php


class ExactTargetUserTaskHelperTest extends WikiaBaseTest {

	const TEST_EMAIL = 'test@wikia-inc.com';
	const ACTIVE = ExactTarget_SubscriberStatus::Active;
	const UNSUBSCRIBED = ExactTarget_SubscriberStatus::Unsubscribed;

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
			[ self::TEST_EMAIL, true, self::ACTIVE ],
			[ self::TEST_EMAIL, null, self::ACTIVE ],
			[ self::TEST_EMAIL, 1, self::ACTIVE ],
			[ self::TEST_EMAIL, 0, self::UNSUBSCRIBED ],
			[ self::TEST_EMAIL, false, self::UNSUBSCRIBED ],
			];
	}

}
