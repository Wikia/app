<?php
class ServiceTests extends PHPUnit_Framework_TestCase {

	function testPageStatsService() {
		global $wgTitle;
		$wgTitle = Title::newMainPage();

		$service = new PageStatsService($wgTitle->getArticleId());

		$this->assertType('array', $service->getMostLinkedCategories());
		$this->assertType('int', $service->getCommentsCount());
		$this->assertType('int', $service->getLikesCount());
		$this->assertType('array', $service->getRecentRevisions());
		$this->assertType('string', $service->getFirstRevisionTimestamp());
	}

}
