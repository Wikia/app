<?php
class ServiceTest extends PHPUnit_Framework_TestCase {

	function testAvatarService() {
		$anonName = '10.10.10.10';
		$userName = 'WikiaBot';

		$this->assertRegExp('/width="32"/', AvatarService::render($userName, 32));
		$this->assertRegExp('/User:WikiaBot/', AvatarService::renderLink($userName));
		$this->assertRegExp('/^<img src="http:\/\/images/', AvatarService::renderAvatar($userName));
		$this->assertRegExp('/^http:\/\/images/', AvatarService::getAvatarUrl($userName));
		$this->assertRegExp('/Special:Contributions\//', AvatarService::getUrl($anonName));
	}

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

	function testUserStatsService() {
		global $wgArticle;
		$user = User::newFromName('WikiaBot');

		$service = new UserStatsService($user->getId());
		$stats = $service->getStats();

		$this->assertType('int', $stats['edits']);
		$this->assertType('int', $stats['likes']);
		$this->assertType('string', $stats['date']);

		// edits increase - perform fake edit
		$edits = $stats['edits'];

		$flags = $status = false;
		UserStatsService::onArticleSaveComplete($wgArticle, $user, false, false, false, false, false, $flags, false, $status, false);

		$stats = $service->getStats();

		$this->assertEquals($edits+1, $stats['edits']);

		// edits increase ("manual")
		$edits = $stats['edits'];

		$service->increaseEditsCount();

		$stats = $service->getStats();

		$this->assertEquals($edits+1, $stats['edits']);

	}

}
