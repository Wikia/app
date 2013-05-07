<?php

/**
 * create wiki tester as maintenance script
 */

class CreateWikiTest extends WikiaBaseTest {

	const TEST_PROJECT_NAME = 'CreateWiki Project';
	const TEST_PROJECT_DESC = 'Create Wiki';
	const TEST_WIKI_ID = 177;
	const TEST_EXTENSION = '';
	const TEST_USER_ID1 = 4663069; // WikiaBot

	private $wgUserBackup = null;
	private $mIP = null;

	protected function setUp() {
		global $wgUser, $IP;

		$this->setupFile = dirname(__FILE__) . '/../CreateNewWiki_setup.php';

		parent::setUp();

		$this->wgUserBackup = $wgUser;
		$this->mIP = $IP;
		$wgUser = User::newFromId(self::TEST_USER_ID1);
	}

	protected function tearDown() {
		global $wgUser;
		$wgUser = $this->wgUserBackup;
		parent::tearDown();
	}

	/**
	 * CreateWikiProject object
	 * @group Infrastructure
	 */
	public function testWikiCreation() {
		global $wgCityId, $wgWikiaLocalSettingsPath, $wgMaxShellMemory, $wgMaxShellTime;

		$wgMaxShellMemory = 0;
		$wgMaxShellTime = 0;

		$languages = array( 'en', 'pl', 'de', 'pt-br' );;

		foreach ( $languages as $lang ) {
			$domain = sprintf("test%stest", date('YmdHis'));

			$oCWiki = new CreateWiki(
				"Test Create Wiki", // sitename
				$domain, // domain
				$lang, // lang
				1 // hub
			);

			$created = $oCWiki->create();

			$this->assertEquals( 0, $created, "CreateWiki failed for language: {$lang}" );

			if ( $created == 0 ) {
				$city_id = $oCWiki->getWikiInfo('city_id');
				$cmd = sprintf(
					"SERVER_ID=%d %s %s/extensions/wikia/WikiFactory/Close/simpleclose.php --wiki_id=%d --conf %s",
					$wgCityId,
					"/usr/bin/php",
					$this->mIP,
					$city_id,
					$wgWikiaLocalSettingsPath
				);
				$err = wfShellExec( $cmd, $retval );
				$this->assertEquals( 0, $retval, "Drop Wiki failed for id: {$city_id}, language: {$lang}, err: {$err}" );
			}
		}
	}
}
