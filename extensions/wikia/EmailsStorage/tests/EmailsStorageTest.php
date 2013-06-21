<?php

class EmailsStorageTest extends WikiaBaseTest {

	public function setUp() {
		$this->setupFile = __DIR__ . '/../EmailsStorage.setup.php';
		parent::setUp();
	}

	public function testCreateNewEntry() {
		/* @var $entry EmailsStorageEntry */
		$entry = (new EmailsStorage)->newEntry(EmailsStorage::SCAVENGER_HUNT);

		$this->assertInstanceOf('EmailsStorageEntry', $entry);
		$this->assertEquals(EmailsStorage::SCAVENGER_HUNT, $entry->getSourceId());

		// check default fields
		$this->assertEquals($this->app->wg->CityId, $entry->getCityId());
		$this->assertEquals($this->app->wg->User->getId(), $entry->getUserId());
		$this->assertNull($entry->getEmail());
		$this->assertNull($entry->getFeedback());

		// set an email
		$email = 'foo@bar.net';
		$entry->setEmail($email);
		$this->assertEquals($email, $entry->getEmail());
	}

}
