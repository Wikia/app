<?php
class AttributionCacheTest extends PHPUnit_Framework_TestCase {

	protected $testData = array();

	protected function setUp() {
		$testPageName = wfMsgForContent('Mainpage');
		$testPageTitle = Title::newFromText($testPageName);

		$contribs = AttributionCache::getInstance()->getArticleContribs($testPageTitle);

		$this->testData = $contribs;
	}

	public function testGetArticleContribs() {
		$this->assertTrue(is_array($this->testData));
	}

	/*
	public function testUpdateArticleContribs() {
		$this->assertTrue(true);
	}
	*/

	public function testGetUserEditPoints() {
		if(count($this->testData) == 0) {
			// no test data provided, skiping..
			$this->markTestSkipped('No test data provided (due to previous failures)');
		}

		foreach($this->testData as $testUser) {
			$userId = $testUser['user_id'];
			$editPoints = AttributionCache::getInstance()->getUserEditPoints($userId);

			$this->assertTrue(is_int($editPoints));
			$this->assertEquals($editPoints, $testUser['edits']);
		}
	}

}
