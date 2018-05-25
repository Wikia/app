<?php
class ServiceTest extends WikiaBaseTest {

	function testCategoriesService() {
		global $wgBiggestCategoriesBlacklist;

		// blacklist to be used by this unit test
		$wgBiggestCategoriesBlacklist = array('stub', 'foo');

		$service = new CategoriesService();

		$this->assertTrue($service->isCategoryBlacklisted('foo'));
		$this->assertTrue($service->isCategoryBlacklisted('BARFOO'));
		$this->assertTrue($service->isCategoryBlacklisted('Stubs'));
		$this->assertFalse($service->isCategoryBlacklisted('test'));
		$this->assertFalse($service->isCategoryBlacklisted('stu'));

		// test filtering helper method
		$categories = array('Characters', 'Stubs', 'Footest', 'testfoo', 'bar', 'test');

		$this->assertEquals(array('Characters', 'bar', 'test'), CategoriesService::filterOutBlacklistedCategories($categories));
	}
}
