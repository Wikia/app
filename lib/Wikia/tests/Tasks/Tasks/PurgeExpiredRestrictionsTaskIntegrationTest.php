<?php
namespace Wikia\Tasks\Tasks;

use Title;
use WikiaDatabaseTest;

/**
 * @group Integration
 */
class PurgeExpiredRestrictionsTaskIntegrationTest extends WikiaDatabaseTest {

	/** @var PurgeExpiredRestrictionsTask $purgeExpiredRestrictionsTask */
	private $purgeExpiredRestrictionsTask;

	protected function setUp() {
		parent::setUp();

		$this->purgeExpiredRestrictionsTask = new PurgeExpiredRestrictionsTask();
	}

	public function testPurgeExpiredPageRestrictionsEntries() {
		$title = Title::newFromId( 1 );

		$this->assertNotEmpty( $title->getRestrictions( 'edit' ) );
		$this->assertNotEmpty( $title->getRestrictions( 'move' ) );

		$this->purgeExpiredRestrictionsTask->purgeExpiredPageRestrictions( [ 2 ] );

		$title->flushRestrictions();

		$this->assertEmpty( $title->getRestrictions( 'edit' )  );
		$this->assertNotEmpty( $title->getRestrictions( 'move' )  );
	}

	public function testPurgeExpiredProtectedTitlesEntry() {
		$title = Title::makeTitle( NS_TALK, 'Nonexistent_talk' );

		$this->assertNotEmpty( $title->getRestrictions( 'create' ) );

		$this->purgeExpiredRestrictionsTask->purgeExpiredProtectedTitles( $title->getNamespace(), $title->getDBkey() );

		$title->flushRestrictions();

		$this->assertEmpty( $title->getRestrictions( 'create' ) );
	}

	protected function getDataSet() {
		return $this->createYamlDataSet( __DIR__ . '/fixtures/purge_expired_restrictions.yaml' );
	}
}
