<?php

class ModuleDataTest extends PHPUnit_Framework_TestCase {

	// initialize skin only once
	public static function setUpBeforeClass() {
		global $wgTitle, $wgUser, $wgForceSkin, $wgOut;

		$wgForceSkin = 'oasis';
		$wgTitle = Title::newMainPage();
		$wgUser = User::newFromName('WikiaBot');

		wfSuppressWarnings();
		ob_start();

		$wgOut->setCategoryLinks(array('foo' => 1, 'bar' => 2));

		$skin = $wgUser->getSkin();
		$skin->outputPage(new OutputPage());

		wfClearOutputBuffers();
		wfRestoreWarnings();
	}

	function testLatestActivityModule() {
		global $wgSitename;

		$moduleData = Module::get('LatestActivity')->getData();
		$this->assertType ('array', $moduleData['changeList']);
		$this->assertEquals(
			3,
			count($moduleData['changeList'])
		);
	}

	function testSearchModule() {
		global $wgSitename;

		$moduleData = Module::get('Search')->getData();

		$this->assertEquals(
			wfMsg('Tooltip-search', $wgSitename),
			$moduleData['placeholder']
		);
	}

	function testRailModule() {
		global $wgTitle;
		$wgTitle = Title::newMainPage();

		$moduleData = Module::get('Rail')->getData();

		$this->assertType("array",
			$moduleData
		);

	}

	function testRailSubmoduleExists() {
		global $wgTitle;
		$wgTitle = Title::newFromText('FooBar');

		$moduleData = Module::get('Rail', 'Index', array("railModuleList" => array(100 => "foo")))->getData();
		// railmodule just prints whatever it is given
		$this->assertEquals($moduleData['railModuleList'][100], "foo");

	}

	function testAdModule() {
		global $wgTitle;
		$wgTitle = Title::newFromText('Foo');
//		$moduleData = Module::get('Ad', 'Config', null)->getData();
		$moduleData = Module::get('Ad', 'Index', array ('slotname' => 'INVISIBLE_1'))->getData();
		$this->assertNotEquals(
			null,
			$moduleData['ad']
		);
	}

	// TODO: maybe move to separate test class
	function testNotificationsModule() {
		global $wgUser, $wgRequest;

		// create set of fake objects
		$fakeTitleA = Title::newFromText('Foo');
		$fakeTitleB = Title::newFromText('Bar');
		$fakeArticle = new Article($fakeTitleA);

		/**
		 * Test notifications
		 */
		NotificationsModule::clearNotifications();

		$message = 'Notification about something very important';
		NotificationsModule::addNotification($message, array('data' => 'bar'));

		$moduleData = Module::get('Notifications')->getData();

		$notification = array(
			'message' => $message,
			'data' => array('data' => 'bar'),
			'type' => NotificationsModule::NOTIFICATION_GENERIC_MESSAGE,
		);

		$this->assertEquals(
			array($notification),
			$moduleData['notifications']
		);

		// badge notification
		if (class_exists('AchBadge')) {
			NotificationsModule::clearNotifications();

			// create fake badge
			$badge = new AchBadge(BADGE_WELCOME, 1, BADGE_LEVEL_BRONZE);
			$html = '';

			wfSuppressWarnings();
			$data = array(
				'name' => $badge->getName(),
				'picture' => $badge->getPictureUrl(90),
				'points' => wfMsg('achievements-points', AchConfig::getInstance()->getLevelScore($badge->getLevel())),
				'reason' => $badge->getPersonalGivenFor(),
				'userName' => $wgUser->getName(),
				'userPage' => $wgUser->getUserPage()->getLocalUrl(),
			);

			$message = wfMsg('oasis-badge-notification', $data['userName'], $data['name'], $data['reason']);

			NotificationsModule::addBadgeNotification($wgUser, $badge, $html);
			wfRestoreWarnings();

			$moduleData = Module::get('Notifications')->getData();

			$notification = array(
				'message' => $message,
				'data' => $data,
				'type' => NotificationsModule::NOTIFICATION_NEW_ACHIEVEMENTS_BADGE,
			);

			$this->assertEquals(
				array($notification),
				$moduleData['notifications']
			);
		}

		// edit similar
		NotificationsModule::clearNotifications();

		$message = 'Edit similar message';
		NotificationsModule::addEditSimilarNotification($message);

		$moduleData = Module::get('Notifications')->getData();

		$notification = array(
			'message' => $message,
			'data' => array(),
			'type' => NotificationsModule::NOTIFICATION_EDIT_SIMILAR,
		);

		$this->assertEquals(
			array($notification),
			$moduleData['notifications']
		);

		// community messages
		NotificationsModule::clearNotifications();

		$message = 'Edit similar message';
		NotificationsModule::addCommunityMessagesNotification($message);

		$moduleData = Module::get('Notifications')->getData();

		$notification = array(
			'message' => $message,
			'data' => array(),
			'type' => NotificationsModule::NOTIFICATION_COMMUNITY_MESSAGE,
		);

		$this->assertEquals(
			array($notification),
			$moduleData['notifications']
		);


		/**
		 * Test confirmations
		 */
		NotificationsModule::clearNotifications();
		NotificationsModule::addConfirmation('Confirmation of something done');

		$moduleData = Module::get('Notifications', 'Confirmation')->getData();

		$this->assertEquals(
			'Confirmation of something done',
			$moduleData['confirmation']
		);

		// preferences saved
		NotificationsModule::clearNotifications();

		$prefs = (object) array('mSuccess' => true);
		$status = 'success';
		NotificationsModule::addPreferencesConfirmation($prefs, $status, '');

		$moduleData = Module::get('Notifications', 'Confirmation')->getData();

		$this->assertEquals(
			wfMsg('savedprefs'),
			$moduleData['confirmation']
		);

		// page moved
		NotificationsModule::clearNotifications();

		$form = false;
		$oldUrl = $fakeTitleA->getFullUrl('redirect=no');
		$newUrl = $fakeTitleB->getFullUrl();
		$oldText = $fakeTitleA->getPrefixedText();
		$newText = $fakeTitleB->getPrefixedText();

		// don't render links
		$oldLink = $oldText;
		$newLink = $newText;

		$message = wfMsgExt('movepage-moved', array('parseinline'), $oldLink, $newLink, $oldText, $newText);
		NotificationsModule::addPageMovedConfirmation($form, $fakeTitleA, $fakeTitleB);

		$moduleData = Module::get('Notifications', 'Confirmation')->getData();

		$this->assertEquals(
			$message,
			$moduleData['confirmation']
		);

		// page removed
		NotificationsModule::clearNotifications();

		$reason = '';
		$message = wfMsgExt('oasis-confirmation-page-deleted', array('parseinline'), $fakeTitleA->getPrefixedText());
		NotificationsModule::addPageDeletedConfirmation($fakeArticle, $wgUser, $reason, $fakeArticle->getId());

		$moduleData = Module::get('Notifications', 'Confirmation')->getData();

		$this->assertEquals(
			$message,
			$moduleData['confirmation']
		);

		// page removed
		NotificationsModule::clearNotifications();

		$message = wfMsg('oasis-confirmation-page-undeleted');
		NotificationsModule::addPageUndeletedConfirmation($fakeTitleA, false);

		$moduleData = Module::get('Notifications', 'Confirmation')->getData();

		$this->assertEquals(
			$message,
			$moduleData['confirmation']
		);

		// log out
		NotificationsModule::clearNotifications();

		$html = '';
		$message = wfMsg('oasis-confirmation-user-logout');
		NotificationsModule::addLogOutConfirmation($wgUser, $html, false);

		$moduleData = Module::get('Notifications', 'Confirmation')->getData();

		$this->assertEquals(
			$message,
			$moduleData['confirmation']
		);

		// facebook connect
		NotificationsModule::clearNotifications();
		$wgRequest->setVal('fbconnected', 2);

		$html = '';
		$preferencesUrl = SpecialPage::getTitleFor('Preferences')->getFullUrl();
		$message = wfMsgExt('fbconnect-connect-error-msg', array('parseinline'), $preferencesUrl);
		NotificationsModule::addFacebookConnectConfirmation($html);

		$moduleData = Module::get('Notifications', 'Confirmation')->getData();

		$this->assertEquals($message, $moduleData['confirmation']);
		$this->assertEquals(' error', $moduleData['confirmationClass']);
	}

	function testRandomWikiModule() {
		global $wgEnableRandomWikiOasisButton;

		// let's enable the module
		$wgEnableRandomWikiOasisButton = true;

		$moduleData = Module::get('RandomWiki')->getData();

		$this->assertType('string', $moduleData['url']);

		// now let's disable the module
		$wgEnableRandomWikiOasisButton = false;

		$moduleData = Module::get('RandomWiki')->getData();

		$this->assertEquals(
			null,
			$moduleData['url']);
	}

	function testOasisModule() {

		// add custom CSS class to <body>
		OasisModule::addBodyClass('testCssClass');

		// turn of PHP warnings / don't emit skin's HTML
		wfSuppressWarnings();
		ob_start();

		// render the skin
		$moduleData = Module::get('Oasis')->getData();

		wfClearOutputBuffers();
		wfRestoreWarnings();

		// assertions
		$this->assertTrue(in_array('testCssClass', $moduleData['bodyClasses']));
		$this->assertRegExp('/^<link href=/', $moduleData['printableCss']);
		$this->assertType('string', $moduleData['body']);
		$this->assertType('string', $moduleData['headscripts']);
		$this->assertType('string', $moduleData['csslinks']);
		$this->assertType('string', $moduleData['headlinks']);
		$this->assertType('string', $moduleData['globalVariablesScript']);
	}


	function testCommentsLikesModule() {
		global $wgTitle;
		$wgTitle = Title::newMainPage();

		$moduleData = Module::get('CommentsLikes', 'Index', array ('comments' => 123))->getData();

		$this->assertRegExp('/^123$/', $moduleData['comments']);
		$this->assertRegExp('/'.preg_quote($wgTitle->getDBkey()).'/', $moduleData['commentsLink']);
		$this->assertRegExp('/^$/', $moduleData['commentsTooltip']);
		$this->assertEquals(null, $moduleData['likes']);

		// not-existing page
		$title = Title::newFromText('NotExistingPage');

		$moduleData = Module::get('CommentsLikes', 'Index', array ('comments' => 0, 'likes' => 20, 'title' => $title))->getData();

		$this->assertEquals('0', $moduleData['comments']);
		$this->assertRegExp('/Talk:NotExistingPage/', $moduleData['commentsLink']);
		$this->assertTrue($moduleData['commentsTooltip'] != '');
		$this->assertEquals(20, $moduleData['likes']);
	}

	function testAchievementsModule() {
		global $wgTitle, $wgEnableAchievementsExt;
		if (!$wgEnableAchievementsExt) $this->markTestSkipped();

		$wgTitle = Title::newFromText('User:WikiaBot');

		$moduleData = Module::get('Achievements')->getData();

		$this->assertEquals ($moduleData['ownerName'], 'WikiaBot');
		$this->assertEquals ($moduleData['viewer_is_owner'], true);
		$this->assertEquals ($moduleData['max_challenges'], 'all');
		$this->assertType ('array', $moduleData['challengesBadges'][0]);
		$this->assertType ('object', $moduleData['challengesBadges'][0]['badge']);

		if (count($moduleData['ownerBadges']) > 0) {
			// TODO: WikiaBot has no badges, but we could add some
		}
	}

	function testBodyModule() {
		global $wgTitle;

		//Special pages should have no modules
		$wgTitle = Title::newFromText('Special:SpecialPages');
		$moduleData = Module::get('Body')->getData();
		$railList = $moduleData['railModuleList'];
		$this->assertEquals (null, $railList);

		//Special search page should only have ad modules on it
		$wgTitle = Title::newFromText('Special:Search');
		$moduleData = Module::get('Body')->getData();
		$railList = $moduleData['railModuleList'];
		foreach ($railList as $module) {
			$this->assertEquals ('Ad', $module[0]);
		}

		// User page check
		$wgTitle = Title::newFromText('User:WikiaBot');
		$moduleData = Module::get('Body')->getData();
		$railList = $moduleData['railModuleList'];
		$this->assertEquals($railList[1200][0], 'FollowedPages');
		$this->assertEquals($railList[1350][0], 'Achievements');

		// Content page check
		$wgTitle = Title::newFromText('Foo');
		$moduleData = Module::get('Body')->getData();
		$railList = $moduleData['railModuleList'];
		$this->assertEquals($railList[1500][0], 'Search');
		$this->assertEquals($railList[1150][0], 'Spotlights');
	}

	function testAccountNavigationModule() {
		global $wgUser;
		$userName = $wgUser->getName();

		$moduleData = Module::get('AccountNavigation')->getData();

		// user urls
		$this->assertEquals(6, count($moduleData['personal_urls']));
		$this->assertRegExp("/User:{$userName}$/", $moduleData['personal_urls']['userpage']['href']);

		// dropdown
		$this->assertRegExp("/User_talk:{$userName}/", $moduleData['dropdown'][0]);

		// logout link
		$this->assertRegExp('/Log out<\/a>$/', $moduleData['links'][0]);

		// user data
		$this->assertFalse($moduleData['isAnon']);
		$this->assertEquals($userName, $moduleData['username']);
		$this->assertEquals($moduleData['profileAvatar'], AvatarService::renderAvatar($userName, 16));
	}

	function testArticleCategoriesModule() {
		$moduleData = Module::get('ArticleCategories')->getData();

		$this->assertRegExp('/^<div id=\'catlinks\'/', $moduleData['catlinks']);
		$this->assertRegExp('/Category:Foo/', $moduleData['catlinks']);
		$this->assertRegExp('/Category:Bar/', $moduleData['catlinks']);
	}

	function testContentDisplayModule() {
		$moduleData = Module::get('ContentDisplay')->getData();

		// content display
		$this->assertType ('string', $moduleData['bodytext']);

		// picture attribution
		$html = 'TESTTESTTESTTEST';
		$file = wfFindFile('Wiki.png');
		$addedBy = str_replace(' ', '_', $file->getUser());

		ContentDisplayModule::renderPictureAttribution(false, false, $file, false, false, $html);

		$this->assertRegExp('/^TEST<div class="picture-attribution"><img src/', $html);
		$this->assertRegExp('/User:' . $addedBy . '/', $html);
	}

	function testGlobalHeaderModule() {
		$moduleData = Module::get('GlobalHeader')->getData();

		$this->assertRegExp('/^http:\/\/www.wikia.com\/Special:CreateWiki/', $moduleData['createWikiUrl']);
		$this->assertRegExp('/wikia.com\//', $moduleData['centralUrl']);
		$this->assertType('array', $moduleData['menuNodes']);
		$this->assertType('array', $moduleData['menuNodes'][0]);
	}

	function testHistoryDropdownModule() {
		$revisions = array('foo', 'bar');
		$moduleData = Module::get('HistoryDropdown', 'Index', array('revisions' => $revisions))->getData();

		$this->assertType('array', $moduleData['content_actions']);
		$this->assertEquals($revisions, $moduleData['revisions']);
	}

	function testHotSpotsModule() {
		$moduleData = Module::get('HotSpots', 'Index')->getData();

		$this->assertType('array', $moduleData['data']['results']);
		$this->assertEquals(count($moduleData['data']['results']), 5);
		$this->assertTrue(array_key_exists('title', $moduleData['data']['results'][0]));
		$this->assertTrue(array_key_exists('url', $moduleData['data']['results'][0]));
		$this->assertTrue(array_key_exists('count', $moduleData['data']['results'][0]));
	}

	function testFollowedPagesModule () {
		global $wgTitle;

		// User page check
		$wgTitle = Title::newFromText('User:WikiaBot');
		$moduleData = Module::get('FollowedPages')->getData();
		#print_r($moduleData);
		$this->assertType('array', $moduleData['data']);
		$this->assertTrue(count($moduleData['data']) >= $moduleData['max_followed_pages']);
	}

	function testMenuButtonModule() {
		$data = array(
			'action' => 'url',
			'name' => 'edit',
			'image' => MenuButtonModule::EDIT_ICON,
			'dropdown' => array(
				'move' => array(),
				'protect' => array(),
				'delete' => array(),
				'foo' => array(),
			),
		);

		$moduleData = Module::get('MenuButton', 'Index', $data)->getData();

		$this->assertEquals($data['action'], $moduleData['action']);
		$this->assertEquals($data['name'], $moduleData['actionName']);
		$this->assertRegExp('/^<img /', $moduleData['icon']);
		$this->assertEquals(array_keys($data['dropdown']), array_keys($moduleData['dropdown']));
		$this->assertEquals('m', $moduleData['dropdown']['move']['accesskey']);
	}

	function testPageHeaderModule() {
		global $wgTitle, $wgSupressPageTitle, $wgRequest;

		// main page
		$wgTitle = Title::newMainPage();
		$wgSupressPageTitle = true;

		$moduleData = Module::get('PageHeader')->getData();

		$this->assertTrue($moduleData['isMainPage']);
		$this->assertEquals('', $moduleData['title']);
		$this->assertEquals('', $moduleData['subtitle']);

		$wgSupressPageTitle = false;

		// talk page
		$wgTitle = Title::newFromText('Foo', NS_TALK);

		$moduleData = Module::get('PageHeader')->getData();

		$this->assertRegExp('/Talk:/', $moduleData['title']);
		$this->assertRegExp('/Foo" title="Foo"/', $moduleData['subtitle']);

		// forum page
		$wgTitle = Title::newFromText('Foo', NS_FORUM);

		$moduleData = Module::get('PageHeader')->getData();

		$this->assertEquals('Foo', $moduleData['title']);
		$this->assertFalse($moduleData['comments']);

		// file page
		$wgTitle = Title::newFromText('Foo', NS_FILE);

		$moduleData = Module::get('PageHeader')->getData();

		$this->assertEquals('Foo', $moduleData['title']);
		$this->assertEquals('', $moduleData['subtitle']);

		// history page header
		$wgRequest->setVal('action', 'history');

		$wgTitle = Title::newFromText('Foo');

		$moduleData = Module::get('PageHeader', 'EditPage')->getData();

		$this->assertRegExp('/History/', $moduleData['title']);
		$this->assertTrue($moduleData['displaytitle']);
		$this->assertType('int', $moduleData['comments']);

		$wgRequest->setVal('action', '');

		// edit page
		$wgTitle = Title::newFromText('Foo', NS_TALK);

		$moduleData = Module::get('PageHeader', 'EditPage')->getData();

		$this->assertRegExp('/Editing:/', $moduleData['title']);
		$this->assertRegExp('/Talk:Foo" title="Talk:Foo"/', $moduleData['subtitle']);

		// edit box header
		$moduleData = Module::get('PageHeader', 'EditBox')->getData();

		$this->assertRegExp('/Editing:/', $moduleData['title']);
		$this->assertRegExp('/Talk:Foo" title="Talk:Foo"/', $moduleData['subtitle']);

		// add edit box header
		$editPage = (object) array(
			'preview' => true,
			'diff' => false,
			'editFormTextTop' => '',
		);

		PageHeaderModule::modifyEditPage($editPage);

		$this->assertRegExp('/<div id="WikiaEditBoxHeader"/', $editPage->editFormTextTop);
		$this->assertRegExp('/Editing:/', $editPage->editFormTextTop);
	}

	function testUserPagesHeaderModule() {
		global $wgUser, $wgTitle;
		$wgTitle = $wgUser->getTalkPage();
		$userName =  $wgUser->getName();

		$this->assertTrue(UserPagesHeaderModule::isItMe($userName));

		// user pages
		$moduleData = Module::get('UserPagesHeader')->getData();

		$this->assertRegExp('/Special:Preferences/', $moduleData['avatarMenu'][0]);
		$this->assertEquals($userName, $moduleData['userName']);
		$this->assertEquals($userName, $moduleData['title']);
		$this->assertType('array', $moduleData['stats']);
		$this->assertNull($moduleData['comments']);

		// blog posts
		$wgTitle = Title::newFromText('User_Blog:WikiaBotBlogger/BlogPost/foo');

		$moduleData = Module::get('UserPagesHeader', 'BlogPost')->getData();

		$this->assertRegExp('/WikiaBotBlogger/', $moduleData['avatar']);
		$this->assertNull($moduleData['avatarMenu']);
		$this->assertEquals('BlogPost/foo', $moduleData['title']);
		$this->assertEquals('WikiaBotBlogger', $moduleData['userName']);

		// blog listing
		$moduleData = Module::get('UserPagesHeader', 'BlogListing')->getData();

		$this->assertRegExp('/Special:CreateBlogPage/', $moduleData['actionButton']['href']);
		$this->assertNull($moduleData['userName']);
	}

	function testFeedbackModule() {
		global $wgUser;
		$moduleData = Module::get('Feedback')->getData();

		$this->assertEquals($wgUser->getName(), $moduleData['userData']['u_disp']);
		$this->assertEquals(64, strlen($moduleData['userData']['u_code']));
	}

	function testBlogListingModule() {
		global $wgUser, $wgTitle;
		$userName = $wgUser->getName();

		// extend posts data coming from Blogs ext
		wfLoadExtensionMessages('Blogs');
		$cutSign = wfMsg('blug-cut-sign');

		$posts = array(
			array(
				'comments' => 1,
				'namespace' => 500,
				'page' => 1,
				'text' => "text{$cutSign}",
				'timestamp' => wfTimestamp(TS_MW),
				'title' => 'My blog post',
				'username' => $userName,
			)
		);

		BlogListingModule::getResults($posts);

		$this->assertEquals(AvatarService::renderAvatar($userName, 48), $posts[0]['avatar']);
		$this->assertEquals(AvatarService::getUrl($userName), $posts[0]['userpage']);
		$this->assertTrue($posts[0]['readmore']);
		$this->assertType('int', $posts[0]['likes']);
		$this->assertType('string', $posts[0]['date']);

		// render blog listing for Oasis
		$html = 'foo';
		$aOptions = array(
			'class' => 'bar',
			'title' => 'Blog posts box',
			'type' => 'box',
		);

		BlogListingModule::renderBlogListing($html, $posts, $aOptions);

		$this->assertRegExp('/^foo<section class="WikiaBlogListingBox bar"/', $html);
		$this->assertRegExp('/User_blog:My_blog_post/', $html);
		$this->assertRegExp('/User:WikiaBot">WikiaBot<\/a>/', $html);
	}

	function testCommunityCornerModule() {
		global $wgUser;
		$wgUser = User::newFromName('WikiaSysop');
		$moduleData = Module::get('CommunityCorner')->getData();

		$this->assertFalse($moduleData['isAdmin']);
		$wgUser = User::newFromName('WikiaStaff');
		$moduleData = Module::get('CommunityCorner')->getData();
		$this->assertTrue($moduleData['isAdmin']);
	}

	function testFooterModule() {
		global $wgSuppressToolbar, $wgShowMyToolsOnly;

		$moduleData = Module::get('Footer')->getData();
		$this->assertTrue($moduleData['showMyTools']);
		$this->assertTrue($moduleData['showToolbar']);

		$wgSuppressToolbar = true;
		$moduleData = Module::get('Footer')->getData();
		$this->assertFalse($moduleData['showToolbar']);

	}

	// These are hards one to test, since the old ArticleCommentsCode is not modular
	function testArticleCommentsModule() {
		global $wgTitle, $wgDevelEnvironment;
		$wgDevelEnvironment = false;  // Suppress memkey logic that uses SERVER_NAME

		$wgTitle = Title::newFromText("Foo");
		$moduleData = Module::get('ArticleComments')->getData();
		$this->assertEquals("Title", get_class($moduleData['wgTitle']));
		$this->assertEquals("Foo", $moduleData['wgTitle']->getText());

	}
	function testPopularBlogPostsModule() {
		$moduleData = Module::get('PopularBlogPosts')->getData();
		$this->assertRegExp('/No posts found/', $moduleData['body']);
	}

	function testLatestPhotosModule() {
		global $wgDevelEnvironment;
		$wgDevelEnvironment = false;  // Suppress memkey logic that uses SERVER_NAME

		$moduleData = Module::get('LatestPhotos')->getData();
		$this->assertType('array', $moduleData['thumbUrls']);

		$thumbUrls = $moduleData['thumbUrls'];
		$this->assertEquals(11, count($thumbUrls));

		foreach ($thumbUrls as $item) {
			$this->assertRegExp('/File:/', $item['image_filename']);
		}
	}

}
