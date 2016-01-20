<?php
namespace Wikia\Search\Test\ResultSet;
use \WikiaBaseTest as WikiaBaseTest, Wikia\Search\Result\ResultHelper;

class AbstractResultSetTest extends WikiaBaseTest {
	public function testLimitTextLength() {
		$this->assertEquals(ResultHelper::limitTextLength("word1 word2 word3 word4", 2), "word1 word2...");
	}
}