<?php
class ServiceTest extends WikiaBaseTest {

	// reinitialize memcache
	public static function setUpBeforeClass() {
		global $wgMemc, $wgCaches;

		unset($wgCaches[CACHE_MEMCACHED]);
		$wgMemc = wfGetCache(CACHE_MEMCACHED);
	}

	function testAvatarService() {
		$anonName = '10.10.10.10';
		$userName = 'WikiaBot';

		$this->mockGlobalVariable('wgDevBoxImageServerOverride', 'images.foo.wikia-dev.com');

		// users
		$this->assertRegExp('/width="32"/', AvatarService::render($userName, 32));
		$this->assertRegExp('/\/20px-/', AvatarService::render($userName, 16));
		$this->assertRegExp('/User:WikiaBot/', AvatarService::renderLink($userName));
		$this->assertRegExp('/^<img src="http:\/\/images/', AvatarService::renderAvatar($userName));
		$this->assertRegExp('/^http:\/\/images/', AvatarService::getAvatarUrl($userName));

		// anons
		$this->assertRegExp('/Special:Contributions\//', AvatarService::getUrl($anonName));
		$this->assertRegExp('/^<img src="/', AvatarService::renderAvatar($anonName));
		$this->assertRegExp('/\/20px-/', AvatarService::renderAvatar($anonName, 20));
		$this->assertRegExp('/Special:Contributions/', AvatarService::renderLink($anonName));
	}

	function testPageStatsService() {
		global $wgTitle, $wgMemc;

		$wgTitle = Title::newMainPage();
		$articleId = $wgTitle->getArticleId();
		$article = Article::newFromId($articleId);
		$key = wfMemcKey('services', 'pageheader', 'current-revision', $articleId);

		// macbre: perform this test only for existing pages
		if (!$wgTitle->exists()) {
			$this->markTestSkipped('Main page cannot be found');
			return;
		}

		$service = new PageStatsService($articleId);

		$this->assertInternalType('int', $service->getCommentsCount());
		$this->assertInternalType('int', $service->getLikesCount());
		$this->assertInternalType('array', $service->getCurrentRevision());
		$this->assertInternalType('array', $service->getPreviousEdits());
		$this->assertInternalType('string', $service->getFirstRevisionTimestamp());

		// comments counter regenerating
		$comments = $service->getCommentsCount();

		$service->regenerateCommentsCount();
		$this->assertEquals($comments, $service->getCommentsCount());

		// remove cached stats when article is edited
		$user = $flags = $status = false;
		PageStatsService::onArticleSaveComplete($article, $user, false, false, false, false, false, $flags, false, $status, false);

		$data = $wgMemc->get($key);
		$this->assertTrue(empty($data));

		$service->getCurrentRevision();

		$data = $wgMemc->get($key);
		$this->assertFalse(empty($data));

		// remove cached stats when article (comment) is deleted
		PageStatsService::onArticleDeleteComplete($article, $user, false, $articleId);

		$data = $wgMemc->get($key);
		$this->assertTrue(empty($data));

		$service->getCurrentRevision();

		// regenerate data
		$service->regenerateData();

		$data = $wgMemc->get($key);
		$this->assertTrue(empty($data));
	}

	function testUserStatsService() {
		global $wgArticle;
		$user = User::newFromName('QATestsBot');

		$service = new UserStatsService($user->getId());
		$stats = $service->getStats();

		$this->assertInternalType('int', $stats['edits']);
		$this->assertInternalType('int', $stats['likes']);
		$this->assertInternalType('string', $stats['date']);

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
