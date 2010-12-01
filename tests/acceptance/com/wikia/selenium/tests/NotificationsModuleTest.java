package com.wikia.selenium.tests;

import static com.thoughtworks.selenium.grid.tools.ThreadSafeSeleniumSessionStorage.session;
import static org.testng.AssertJUnit.assertTrue;
import static org.testng.AssertJUnit.assertFalse;

import org.testng.annotations.Test;

public class NotificationsModuleTest extends BaseTest {

	private void randomPage() throws Exception {
		session().open("index.php?title=Special:Random");
		session().waitForPageToLoad(TIMEOUT);
	}

	@Test(groups={"oasis", "CI"})
	public void testTalkPageNotification() throws Exception {
		loginAsRegular();
		session().open("index.php?title=User_talk:" + getTestConfig().getString("ci.user.wikiastaff.username") + "&action=edit&section=new");
		session().waitForPageToLoad(TIMEOUT);

		// leave message for staff
		session().type("//input[@name='wpSummary']", "Message");
		doEdit("Test message --~~~~");
		doSave();

		// check messages for staff
		loginAsStaff();

		String xPath = "//ul[@id='WikiaNotifications']//div[@data-type='1']";
		assertTrue(session().isElementPresent(xPath));

		// dismiss the message
		session().click(xPath + "//a[@class='close']");
		Thread.sleep(5000);

		// message should be removed from DOM
		assertFalse(session().isElementPresent(xPath));

		// message should now be dismissed
		randomPage();
		assertFalse(session().isElementPresent(xPath));
	}

	@Test(groups={"oasis", "CI"})
	public void testCommunityMessageNotification() throws Exception {
		loginAsStaff();

		// edit community message
		editArticle("Mediawiki:community-corner", "Community message test --~~~~");

		loginAsRegular();
	
		// check confirmation
		String xPath = "//ul[@id='WikiaNotifications']//div[@data-type='2']";
		assertTrue(session().isElementPresent(xPath));

		// dismiss the message
		session().click(xPath + "//a[@class='close']");
		session().waitForCondition("selenium.isElementNotPresent('" + xPath + "')", TIMEOUT);

		// message should be removed from DOM
		assertFalse(session().isElementPresent(xPath));

		// message should now be dismissed
		randomPage();
		assertFalse(session().isElementPresent(xPath));
	}

	@Test(groups={"oasis", "CI"})
	public void testPreferencesAndLogoutConfirmation() throws Exception {
		loginAsRegular();

		// go to user preferences
		session().open("index.php?title=Special:Preferences");
		session().waitForPageToLoad(TIMEOUT);

		String xPath = "//div[@class='WikiaConfirmation']";
		assertFalse(session().isElementPresent(xPath));

		// save preferences
		session().click("wpSaveprefs");
		session().waitForPageToLoad(TIMEOUT);

		// check confirmation
		assertTrue(session().isElementPresent(xPath));

		// logout
		session().click("link=Log out");
		session().waitForPageToLoad(TIMEOUT);

		assertTrue(session().isElementPresent(xPath));
	}

	@Test(groups={"oasis", "CI"})
	public void testPageActionsConfirmation() throws Exception {
		String pageA = "User:" + getTestConfig().getString("ci.user.wikiastaff.username") + "/Foo";
		String pageB = "User:" + getTestConfig().getString("ci.user.wikiastaff.username") + "/Bar";
		String xPath = "//div[@class='WikiaConfirmation']";
		String reason = "Notifications test";

		loginAsStaff();
		
		editArticle("MediaWiki:Mainpage", "Mainpage");

		// let's create test page (A)
		editArticle(pageA, "Test --~~~~");
		assertFalse(session().isElementPresent(xPath));

		// move a page (A -> B)
		moveArticle(pageA, pageB, reason);

		// we should be redirected to B
		assertTrue(session().getEval("window.wgPageName").equals(pageB));
		assertTrue(session().isElementPresent(xPath));

		// delete a page (B)
		deleteArticle(pageB, "label=regexp:^.*Author request", reason);

		// we should be redirected to main page
		assertTrue(session().getEval("window.wgIsMainpage ? 'true' : 'false'").equals("true"));
		assertTrue(session().isElementPresent(xPath));

		// undelete a page (B)
		undeleteArticle(pageB, reason);

		// we should be redirected to B
		assertTrue(session().getEval("window.wgPageName").equals(pageB));
		assertTrue(session().isElementPresent(xPath));

		// cleanup
		deleteArticle(pageB, "label=regexp:^.*Author request", reason);
	}
}
