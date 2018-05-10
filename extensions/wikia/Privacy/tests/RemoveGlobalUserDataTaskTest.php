<?php

use Wikia\Factory\ServiceFactory;
use Wikia\Service\User\Attributes\UserAttributes;

/**
 * @group Integration
 */
class RemoveGlobalUserDataTaskTest extends WikiaDatabaseTest {

	const REMOVED_USER_ID = 1;
	const OTHER_USER_ID = 2;

	/**
	 * Returns the test dataset.
	 *
	 * @return \PHPUnit\DbUnit\DataSet\IDataSet
	 */
	protected function getDataSet() {
		return $this->createYamlDataSet( __DIR__ . '/fixtures/pii_wikicities_data.yaml' );
	}

	protected function setUp() {
		parent::setUp();
		include __DIR__ . '/../Privacy.setup.php';

		$userAttributesMock = $this->createMock( UserAttributes::class );

		$serviceFactory = ServiceFactory::instance();
		$serviceFactory->attributesFactory()->setUserAttributes( $userAttributesMock );
	}

	public static function tearDownAfterClass() {
		ServiceFactory::clearState();
	}

	public function testUserDataShouldBeAnonymizedInUserTable() {
		( new RemoveGlobalUserDataTask() )->removeData( self::REMOVED_USER_ID );

		$anonymizedUser = User::newFromId( self::REMOVED_USER_ID );
		$otherUser = User::newFromId( self::OTHER_USER_ID );

		$this->assertStringStartsWith( 'Anonymous', $anonymizedUser->getName(), 'User name does not start with \'Anonymous\'' );
		$this->assertEquals( '', $anonymizedUser->getRealName(), 'User real name is not cleared' );
		$this->assertEquals( '', $anonymizedUser->getEmail(), 'User email is not cleared' );
		$this->assertEquals( '', $anonymizedUser->mBirthDate, 'User birth date is not cleared' );

		$this->assertStringStartsWith( 'should_not_anonymize', $otherUser->getName(), 'Wrong user is anonymized' );
		$this->assertEquals( 'user real name2', $otherUser->getRealName(), 'Wrong user has real name cleared' );
		$this->assertEquals( 'user2@gmail.com', $otherUser->getEmail(), 'Wrong user has email cleared' );
		$this->assertEquals( '1998-01-02', $otherUser->mBirthDate, 'Wrong user has birth date cleared' );
	}

	public function testUserDataShouldBeRemovedFromUserEmailLogTable() {
		( new RemoveGlobalUserDataTask() )->removeData( self::REMOVED_USER_ID );

		$wikicitiesSlave = wfGetDB( DB_SLAVE, [], 'wikicities' );

		$this->assertEquals( 0,
			$wikicitiesSlave->estimateRowCount(
				'user_email_log',
				'*',
				[ 'user_id' => self::REMOVED_USER_ID ],
				__METHOD__
			),
			'user_email_log table contains data related to user who wants to be forgotten'
		);

		$this->assertEquals( 1,
			$wikicitiesSlave->estimateRowCount(
				'user_email_log',
				'*',
				[ 'user_id' => self::OTHER_USER_ID ],
				__METHOD__
			),
			'data was removed for wrong user'
		);
	}

	public function testUserDataSHouldBeRemovedFromUserPropertiesTable() {
		( new RemoveGlobalUserDataTask() )->removeData( self::REMOVED_USER_ID );

		$wikicitiesSlave = wfGetDB( DB_SLAVE, [], 'wikicities' );

		$this->assertEquals( 0,
			$wikicitiesSlave->estimateRowCount(
				'user_properties',
				'*',
				[ 'up_user' => self::REMOVED_USER_ID ],
				__METHOD__
			),
			'user_properties table contains data related to user who wants to be forgotten'
		);

		$this->assertEquals( 2,
			$wikicitiesSlave->estimateRowCount(
				'user_properties',
				'*',
				[ 'up_user' => self::OTHER_USER_ID ],
				__METHOD__
			),
			'data was removed for wrong user'
		);
	}
}
