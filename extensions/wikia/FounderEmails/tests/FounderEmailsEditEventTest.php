<?php

class FounderEmailsEditEventTest extends WikiaBaseTest {

	protected function setUp() {
		parent::setUp();
	}

	public function testRegisterForFirstEdit() {
		$this->markTestIncomplete('To be implemented');
		$this->assertEquals(true,true,'On first edit value $isRegisteredUserFirstEdit should be set');
		$this->assertEquals(true,true,'On first edit founderemails-first-edit-notification-sent user property should be set');
	}

	public function testRegisterForSecondEdit() {
		$this->markTestIncomplete('To be implemented');
		$this->assertEquals(true,true,'On first edit value $isRegisteredUserFirstEdit should NOT be set');
		$this->assertEquals(true,true,'On first edit founderemails-first-edit-notification-sent user property should be set');

	}

	public function testRegisterForNoEdits() {
		$this->markTestIncomplete('To be implemented');
		$this->assertEquals(true,true,'On entry with no edits (i.e. after editing only profile page) $isRegisteredUserFirstEdit should NOT be set');
		$this->assertEquals(true,true,'On first edit founderemails-first-edit-notification-sent user property should NOT be set');
	}

}
