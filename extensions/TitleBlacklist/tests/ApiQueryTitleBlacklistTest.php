<?php
/**
 * Test the TitleBlacklist API
 *
 * This wants to run with phpunit.php, like so:
 * cd $IP/tests/phpunit
 * php phpunit.php ../../extensions/TitleBlacklist/tests/ApiQueryTitleBlacklistTest.php
 *
 * Ian Baker <ian@wikimedia.org>
 */

ini_set( 'include_path', ini_get('include_path') . ':' . __DIR__ . '/../../../tests/phpunit/includes/api' );

class ApiQueryTitleBlacklistTest extends ApiTestCase {

	function setUp() {
		parent::setUp();
		$this->doLogin();
	}

	function testApiQueryTitleBlacklist() {
		global $wgMetaNamespace, $wgGroupPermissions, $wgTitleBlacklistSources;

		// without this, blacklist applies only to anonymous users.
		$wgGroupPermissions['sysop']['tboverride'] = false;

		$wgTitleBlacklistSources = array(
		    array(
		         'type' => TBLSRC_FILE,
		         'src'  => __DIR__ . '/testSource',
		    ),
		);

		$unlisted = $this->doApiRequest( array(
			'action' => 'titleblacklist',
			'tbtitle' => 'foo',
			'tbaction' => 'create',
		) );

		$this->assertEquals( $unlisted[0]['titleblacklist']['result'], 'ok', 'Unlisted title returns ok');

		$listed = $this->doApiRequest( array(
			'action' => 'titleblacklist',
			'tbtitle' => 'bar',
			'tbaction' => 'create',
		) );

		$this->assertEquals( $listed[0]['titleblacklist']['result'], 'blacklisted', 'Listed title returns error');
		$this->assertEquals(
			$listed[0]['titleblacklist']['reason'],
			"The title \"bar\" has been banned from creation.\nIt matches the following blacklist entry: <code>[Bb]ar #example blacklist entry</code>",
			'Listed title error text is as expected'
		);

		$this->assertEquals(
			$listed[0]['titleblacklist']['message'],
			"titleblacklist-forbidden-edit",
			'Correct blacklist message name is returned'
		);

		$this->assertEquals(
			$listed[0]['titleblacklist']['line'],
			"[Bb]ar #example blacklist entry",
			'Correct blacklist line is returned'
		);

	}
}
