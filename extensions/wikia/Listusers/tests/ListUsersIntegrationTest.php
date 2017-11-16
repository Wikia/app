<?php
use PHPUnit\Framework\TestCase;
use \Wikia\PowerUser\PowerUser;
use \Wikia\Service\User\Permissions\PermissionsServiceAccessor;

/**
 * @group Integration
 */
class ListUsersIntegrationTest extends TestCase {
	use PermissionsServiceAccessor;

	const AION_WIKI_ID = 3505;
	const CENTRAL_WIKI_ID = 177;

	private $wgAllowMemcacheReads;

	protected function setUp() {
		parent::setUp();
		require_once __DIR__ . '/../SpecialListusers_helper.php';

		global $wgAllowMemcacheReads;
		$this->wgAllowMemcacheReads = $wgAllowMemcacheReads;
		$wgAllowMemcacheReads = false;
	}

	/**
	 * SUS-1478: Verify that all global groups are loaded identically for different wikis
	 */
	public function testGlobalGroupsAreLoadedAndMatch() {
		$firstWikiData = new ListusersData( static::AION_WIKI_ID );
		$centralWikiData = new ListusersData( static::CENTRAL_WIKI_ID );

		$firstWikiData->load();
		$centralWikiData->load();

		$firstWikiGroups = $firstWikiData->getGroups();
		$centralWikiGroups = $centralWikiData->getGroups();

		// CE-1487: poweruser group must be excluded from group listing
		$this->assertArrayNotHasKey( PowerUser::GROUP_NAME, $firstWikiGroups );
		$this->assertArrayNotHasKey( PowerUser::GROUP_NAME, $centralWikiGroups );

		foreach ( $this->permissionsService()->getConfiguration()->getGlobalGroups() as $globalGroup ) {
			// Exclude groups with 0 members
			if ( isset( $centralWikiGroups[$globalGroup] ) ) {
				$this->assertArrayHasKey( $globalGroup, $firstWikiGroups );

				$this->assertEquals( $firstWikiGroups[$globalGroup]['count'], $centralWikiGroups[$globalGroup]['count'] );
			} else {
				$this->assertArrayNotHasKey( $globalGroup, $firstWikiGroups );
			}
		}
	}

	protected function tearDown() {
		parent::tearDown();

		global $wgAllowMemcacheReads;
		$wgAllowMemcacheReads = $this->wgAllowMemcacheReads;
	}
}
