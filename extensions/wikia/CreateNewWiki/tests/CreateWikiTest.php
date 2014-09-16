<?php

/**
 * "Set" of unit tests for CreateWiki class
 *
 * @author Michał Roszka <michal@wikia-inc.com>
 *
 * @category Wikia
 * @group Integration
 */
class CreateWikiTest extends WikiaBaseTest {

	public function setUp() {
		$this->setupFile = __DIR__ . '/../CreateNewWiki_setup.php';
		parent::setUp();
	}

	public function testWgUploadDirectoryExists() {
		$this->assertTrue();
	}
}
