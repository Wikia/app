<?php
require_once dirname(__FILE__) . '/../../../extensions/wikia/WikiaVideo/PartnerVideoHelper.php';

class ImportPartnerVideoTest extends PHPUnit_Framework_TestCase {
	public function testImportingFromFile() {
		$result = PartnerVideoHelper::importFromScreenplay('<xml></xml>');
	}
}
