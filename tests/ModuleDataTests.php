<?php
class ModuleDataTests extends PHPUnit_Framework_TestCase {

	function testLatestActivityModule() {
		global $wgSitename;

		$moduleData = Module::get('LatestActivity')->getData();

		$this->assertEquals(
			3,
			count($moduleData)
		);
	}

	function testSearchModule() {
		global $wgSitename;

		$moduleData = Module::get('Search')->getData();

		$this->assertEquals(
			wfMsg('Tooltip-search', $wgSitename),
			$moduleData['placeholder']
		);
	}

	function testRailModule() {
		global $wgTitle;
		$wgTitle = Title::newMainPage();

		$moduleData = Module::get('Rail')->getData();

		$this->assertType("array",
			$moduleData
		);

	}

	function testRailSubmoduleExists() {
		global $wgTitle;
		$wgTitle = Title::newFromText('FooBar');

		$moduleData = Module::get('Body')->getData();

		// search module lives at index 1500
		$this->assertType("array",
			$moduleData['railModuleList'][1500]
		);

	}

	function testAdModule() {
		global $wgTitle;
		$wgTitle = Title::newMainPage();

		$moduleData = Module::get('Ad', 'Index', array ('slot' => 'TOP_BOXAD'))->getData();

		// boxad is 300 wide
		$this->assertEquals(
			'300',
			$moduleData['imgWidth']
		);
	}

	function testNotificationsModule() {
		// add notification
		NotificationsModule::addNotification('Notification about something very important', array('data' => 'bar'));

		$moduleData = Module::get('Notifications')->getData();

		$this->assertEquals(
			array(
				array(
					'message' => 'Notification about something very important',
					'data' => array('data' => 'bar'),
					'type' => 1,
				)
			),
			$moduleData['notifications']
		);

		// add confirmation
		NotificationsModule::addConfirmation('Confirmation of something done');

		$moduleData = Module::get('Notifications', 'Confirmation')->getData();

		$this->assertEquals(
			'Confirmation of something done',
			$moduleData['confirmation']
		);
	}
}
