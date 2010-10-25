<?php

class ModuleDataAnonTest extends PHPUnit_Framework_TestCase {

	// initialize skin only once
	public static function setUpBeforeClass() {
		global $wgTitle, $wgUser, $wgForceSkin, $wgOut;

		$wgForceSkin = 'oasis';
		$wgTitle = Title::newMainPage();
		$wgUser = User::newFromId(0); // anon

		wfSuppressWarnings();
		ob_start();

		$wgOut->setCategoryLinks(array('foo' => 1, 'bar' => 2));

		$skin = $wgUser->getSkin();
		$skin->outputPage(new OutputPage());

		wfClearOutputBuffers();
		wfRestoreWarnings();
	}

	function testAccountNavigationModule() {
		global $wgUser;
		$userName = $wgUser->getName();

		$moduleData = Module::get('AccountNavigation')->getData();

		// there should be no avatar or profile link
		$this->assertNull($moduleData['profileLink']);
		$this->assertNull($moduleData['profileAvatar']);
		$this->assertNull($moduleData['dropdown']);

		// log in / register links
		$this->assertRegExp('/Special:Signup(.*)type=login/', $moduleData['links'][0]);
		$this->assertRegExp('/Special:Signup(.*)type=signup/', $moduleData['links'][1]);

		// user data
		$this->assertTrue($moduleData['isAnon']);
		$this->assertEquals($userName, $moduleData['username']);
	}

}
