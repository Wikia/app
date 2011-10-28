<?php
require_once dirname(__FILE__) . '/../EmailsStorage.setup.php';

class EmailsStorageTest extends WikiaBaseTest {

	public function testCreateNewEntry() {
		$entry = F::build('EmailsStorage')->newEntry(EmailsStorage::SCAVENGER_HUNT);

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

		// store it in database
		//var_dump( $entry->store() );
	}

}
