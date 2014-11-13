<?php

class CuratedContentApiTest extends WikiaBaseTest {

	public function setUp() {
		global $IP;
		$this->setupFile = "{$IP}/extensions/wikia/CuratedContent/CuratedContent.setup.php";
		parent::setUp();
	}
}