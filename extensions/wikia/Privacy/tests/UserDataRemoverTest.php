<?php

use Wikia\Factory\ServiceFactory;
use Wikia\Service\Helios\HeliosClient;
use Wikia\Service\User\Attributes\UserAttributes;
use Wikia\Service\User\Preferences\PreferenceService;

/**
 * @group Integration
 */
class UserDataRemoverTest extends WikiaDatabaseTest {

	const REMOVED_USER_ID = 1;
	const OTHER_USER_ID = 2;
	const RENAMED_USER_ID = 3;
	const FAKE_USER_ID = 4;
	const REMOVED_USER_NAME = 'should_anonymize';
	const EXACT_HASH = '9ce937b220262ce1bb62b918ea196d78c39d6326ceaae974f8d3fbf1d550b44b';
	const NORMALIZED_HASH = 'dd6846900c173f39d39c0760dc8d23a35f5799cea4a91239fba16620ad4e59e6';

	/**
	 * Returns the test dataset.
	 *
	 * @return \PHPUnit\DbUnit\DataSet\IDataSet
	 */
	protected function getDataSet() {
		return $this->createYamlDataSet( __DIR__ . '/fixtures/pii_wikicities_data.yaml' );
	}

	protected function extraSchemaFiles() {
		return [
			__DIR__ . '/fixtures/wikiastaff_log.sql',
			__DIR__ . '/fixtures/spoofuser.sql',
			__DIR__ . '/fixtures/user_replicate_queue.sql',
		];
	}

	protected function setUp() {
		parent::setUp();
		include __DIR__ . '/../Privacy.setup.php';

		$heliosMock = $this->createMock( HeliosClient::class );
		$heliosMock->method( 'deletePassword' )->willReturn( ['response' => 'ok'] );

		$serviceFactory = ServiceFactory::instance();
		$serviceFactory->attributesFactory()->setUserAttributes( $this->createMock( UserAttributes::class ) );
		$serviceFactory->preferencesFactory()->setPreferenceService( $this->createMock( PreferenceService::class ) );
		$serviceFactory->heliosFactory()->setHeliosClient( $heliosMock );
	}

	public static function tearDownAfterClass() {
		ServiceFactory::clearState();
	}

	public function testUserDataShouldBeAnonymizedInUserTable() {
		( new UserDataRemover() )->removeAllGlobalUserData( self::REMOVED_USER_ID );

		$anonymizedUser = User::newFromId( self::REMOVED_USER_ID );
		$otherUser = User::newFromId( self::OTHER_USER_ID );

		$this->assertStringStartsWith( 'Anonymous', $anonymizedUser->getName(), 'User name does not start with \'Anonymous\'' );
		$this->assertEquals( '', $anonymizedUser->getRealName(), 'User real name is not cleared' );
		$this->assertEquals( '', $anonymizedUser->getEmail(), 'User email is not cleared' );
		$this->assertEquals( '', $anonymizedUser->mBirthDate, 'User birth date is not cleared' );
		$this->assertEquals( '1', $anonymizedUser->getGlobalFlag( 'disabled' ) );

		$this->assertStringStartsWith( 'should_not_anonymize', $otherUser->getName(), 'Wrong user is anonymized' );
		$this->assertEquals( 'user real name2', $otherUser->getRealName(), 'Wrong user has real name cleared' );
		$this->assertEquals( 'user2@gmail.com', $otherUser->getEmail(), 'Wrong user has email cleared' );
		$this->assertEquals( '1998-01-02', $otherUser->mBirthDate, 'Wrong user has birth date cleared' );
	}

	public function testUserDataShouldBeRemovedFromUserEmailLogTable() {
		( new UserDataRemover() )->removeAllGlobalUserData( self::REMOVED_USER_ID );

		$wikicitiesSlave = wfGetDB( DB_SLAVE );

		$this->assertEquals( 0,
			$wikicitiesSlave->selectField(
				'user_email_log',
				'count(*)',
				['user_id' => self::REMOVED_USER_ID],
				__METHOD__
			),
			'user_email_log table contains data related to user who wants to be forgotten'
		);

		$this->assertEquals( 1,
			$wikicitiesSlave->selectField(
				'user_email_log',
				'count(*)',
				['user_id' => self::OTHER_USER_ID],
				__METHOD__
			),
			'data was removed for wrong user'
		);
	}

	public function testUserDataShouldBeRemovedFromUserPropertiesTable() {
		( new UserDataRemover() )->removeAllGlobalUserData( self::REMOVED_USER_ID );

		$wikicitiesSlave = wfGetDB( DB_SLAVE );

		$this->assertEquals( 1,
			$wikicitiesSlave->selectField( 'user_properties', 'count(*)', [
				'up_user' => self::REMOVED_USER_ID
			], __METHOD__ ),
			'user_properties table contains data related to user who wants to be forgotten' );

		$this->assertEquals( '1',
			$wikicitiesSlave->selectField( 'user_properties', 'up_value', [
				'up_user' => self::REMOVED_USER_ID,
				'up_property' => 'disabled'
			] ),
			'user_properties table doesn\'t contain disabled property for user who wants to be forgotten' );

		$this->assertEquals( 2,
			$wikicitiesSlave->selectField(
				'user_properties',
				'count(*)',
				['up_user' => self::OTHER_USER_ID],
				__METHOD__
			),
			'data was removed for wrong user'
		);
	}

	public function testStaffLogsShouldBeRemoved() {
		( new UserDataRemover() )->removeAllGlobalUserData( self::REMOVED_USER_ID );

		$db = wfGetDB( DB_SLAVE, [] );

		$this->assertEquals( 0,
			$db->selectField( 'wikiastaff_log', 'count(*)', ['slog_user' => self::REMOVED_USER_ID],
				__METHOD__ ), 'Staff logs for removed user are not removed' );

		$this->assertEquals( 0,
			$db->selectField( 'wikiastaff_log', 'count(*)', ['slog_userdst' => self::REMOVED_USER_ID],
				__METHOD__ ), 'Staff logs for removed user are not removed' );

		$this->assertEquals( 1,
			$db->selectField( 'wikiastaff_log', 'count(*)', ['slog_user' => self::OTHER_USER_ID],
				__METHOD__ ), 'Staff logs were removed for wrong user' );
	}

	public function testShouldAnonymizeAnfispoof() {
		( new UserDataRemover() )->removeAllGlobalUserData( self::REMOVED_USER_ID );

		// check basic functionality
		$spoof = new SpoofUser( self::REMOVED_USER_NAME );
		$this->assertEquals( 1, count( $spoof->getConflicts() ), 'Username is not blocked for removed user' );

		// check if username is in plaintext
		$db = $db = wfGetDB( DB_SLAVE, [] );
		$this->assertEquals( 0,
			$db->selectField( 'spoofuser', 'count(*)', ['su_name' => self::REMOVED_USER_NAME],
				__METHOD__ ), 'Username is stored in plaintext for removed user' );

		// check if hash is correct
		$this->assertEquals( 1,
			$db->selectField( 'spoofuser_forgotten', 'count(*)',
				[
					'suf_normalized_hash' => self::NORMALIZED_HASH,
					'suf_exact_hash' => self::EXACT_HASH,
				],
				__METHOD__ ), 'Spoof hash is different than expected' );

	}
}
