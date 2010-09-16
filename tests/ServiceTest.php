<?php
class ServiceTest extends PHPUnit_Framework_TestCase {

	function testAvatarService() {
		$anonName = '10.10.10.10';
		$userName = 'WikiaBot';

		// users
		$this->assertRegExp('/width="32"/', AvatarService::render($userName, 32));
		$this->assertRegExp('/User:WikiaBot/', AvatarService::renderLink($userName));
		$this->assertRegExp('/^<img src="http:\/\/images/', AvatarService::renderAvatar($userName));
		$this->assertRegExp('/^http:\/\/images/', AvatarService::getAvatarUrl($userName));

		// anons
		$this->assertRegExp('/Special:Contributions\//', AvatarService::getUrl($anonName));
		$this->assertRegExp('/^<img src="/', AvatarService::renderAvatar($anonName));
		$this->assertRegExp('/Special:Contributions/', AvatarService::renderLink($anonName));
	}

	function testPageStatsService() {
		global $wgTitle, $wgMemc;

		$wgTitle = Title::newMainPage();
		$articleId = $wgTitle->getArticleId();
		$article = Article::newFromId($articleId);
		$key = wfMemcKey('services', 'pageheader', 'revisions3', $articleId);

		$service = new PageStatsService($articleId);

		$this->assertType('array', $service->getMostLinkedCategories());
		$this->assertType('int', $service->getCommentsCount());
		$this->assertType('int', $service->getLikesCount());
		$this->assertType('array', $service->getRecentRevisions());
		$this->assertType('string', $service->getFirstRevisionTimestamp());

		// comments counter regenerating
		$comments = $service->getCommentsCount();

		$service->regenerateCommentsCount();
		$this->assertEquals($comments, $service->getCommentsCount());

		// remove cached stats when article is edited
		$user = $flags = $status = false;
		PageStatsService::onArticleSaveComplete($article, $user, false, false, false, false, false, $flags, false, $status, false);

		$data = $wgMemc->get($key);
		$this->assertTrue(empty($data));

		$service->getRecentRevisions();

		$data = $wgMemc->get($key);
		$this->assertFalse(empty($data));

		// remove cached stats when article (comment) is deleted
		PageStatsService::onArticleDeleteComplete($article, $user, false, $articleId);

		$data = $wgMemc->get($key);
		$this->assertTrue(empty($data));

		$service->getRecentRevisions();

		// regenerate data
		$service->regenerateData();

		$data = $wgMemc->get($key);
		$this->assertTrue(empty($data));
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
