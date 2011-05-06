<?php

/**
 * create wiki tester as maintenance script
 */

include_once( dirname(__FILE__) . "/../AutoCreateWiki.php" );
include_once( dirname(__FILE__) . "/../CreateWiki.php" );

class CreateWikiTest extends PHPUnit_Framework_TestCase {

	const TEST_PROJECT_NAME = 'CreateWiki Project';
	const TEST_PROJECT_DESC = 'Create Wiki';
	const TEST_WIKI_ID = 177;
	const TEST_EXTENSION = '';
	const TEST_USER_ID1 = 1;
	const TEST_USER_ID2 = 2;
	
	private $wgUserBackup = null;
	
	protected function setUp() {
		global $wgUser;
		$this->wgUserBackup = $wgUser;
		$wgUser = User::newFromId(self::TEST_USER_ID1);
	}
	
	protected function tearDown() {
		global $wgUser;
		$wgUser = $this->wgUserBackup;
	}

	/**
	 * CreateWikiProject object
	 * @var CreateWikiProject
	 * @group Infrastructure
	 */
	public function testWikiCreation() {
		
		$languages = array( 'en', 'pl', 'de', 'pt-br' );;

		$types = array( false, "answers" );

		foreach ( $types as $type ) {
			foreach ( $languages as $lang ) {
				$domain = sprintf("test%s", date('YmdHis'));

				$this->oCWiki = new CreateWiki( 
					"Test Create Wiki", // sitename
					$domain, // domain
					$lang, // lang
					1, // hub
					$type
				);		
				
				$this->assertEquals( 0, $this->oCWiki->create(), "CreateWiki failed for language: {$lang} and type: {$type}" );
			}
		}
	}
}

