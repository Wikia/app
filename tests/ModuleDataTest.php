<?php
// initialize skin only once

global $wgTitle, $wgUser, $wgForceSkin;

$wgForceSkin = 'oasis';
$wgTitle = Title::newMainPage();
$wgUser = User::newFromName('WikiaBot');

wfSuppressWarnings();
ob_start();

$skin = $wgUser->getSkin();
$skin->outputPage(new OutputPage());

wfClearOutputBuffers();
wfRestoreWarnings();

class ModuleDataTest extends PHPUnit_Framework_TestCase {

	function testLatestActivityModule() {
		global $wgSitename;

		$moduleData = Module::get('LatestActivity')->getData();

		$this->assertEquals(
			3,
			count($moduleData)
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

		$moduleData = Module::get('Body')->getData();

		// search module lives at index 1500
		$this->assertType("array",
			$moduleData['railModuleList'][1500]
		);

	}

	function testAdModule() {
		global $wgTitle;
		$this->markTestSkipped();
		$wgTitle = Title::newMainPage();

		$moduleData = Module::get('Ad', 'Index', array ('slot' => 'TOP_BOXAD'))->getData();

		// boxad is 300 wide
		$this->assertEquals(
			'300',
			$moduleData['imgWidth']
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
			'type' => NotificationsModule::NOTIFICATION_MESSAGE,
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
		$this->assertRegExp('/ testCssClass/', $moduleData['bodyClasses']);
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
	}

	function testAchievementsModule() {
		global $wgTitle;
		$this->markTestSkipped();
		$wgTitle = Title::newFromText('User:WikiaBot');

		$moduleData = Module::get('Achievements')->getData();

		$this->assertEquals ($moduleData['ownerName'], 'WikiaBot');
		$this->assertEquals ($moduleData['viewer_is_owner'], true);
		$this->assertEquals ($moduleData['max_challenges'], count($moduleData['challengesBadges']));
		$this->assertType ('array', $moduleData['challengesBadges'][0]);
		$this->assertType ('object', $moduleData['challengesBadges'][0]['badge']);

		if (count($moduleData['ownerBadges']) > 0) {
			// TODO: WikiaBot has no badges, but we could add some
		}
	}

}
