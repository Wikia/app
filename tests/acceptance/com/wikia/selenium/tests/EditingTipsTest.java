package com.wikia.selenium.tests;

import org.testng.annotations.Test;
import static com.thoughtworks.selenium.grid.tools.ThreadSafeSeleniumSessionStorage.session;
import static org.testng.AssertJUnit.assertTrue;
import static org.testng.AssertJUnit.assertFalse;

public class EditingTipsTest extends BaseTest {

	@Test(groups={"CI", "disabled"})
	public void testEditingTips() throws Exception {
		// let's log in
		login();

		// load edit page in non-FCK namespace
		session().open("index.php?title=User_talk:" + getTestConfig().getString("ci.user.wikiabot.username") + "&action=edit");

		// check for and click "Show Editing Tips"
		assertTrue(session().isElementPresent("//a[@id='toggleEditingTips']"));

		// hide editing tips, if they're are visible
		if (session().isVisible("//dl[@id='editingTips']")) {
			session().click("toggleEditingTips");
			waitForElementNotVisible("//dl[@id='editingTips']", TIMEOUT);
		}

		// show editing tips
		session().click("toggleEditingTips");
		waitForElementVisible("//dl[@id='editingTips']", TIMEOUT);

		// now let's hide editing tips
		session().click("toggleEditingTips");
	}

	@Test(groups={"CI", "disabled"})
	public void testWidescreen() throws Exception {
		// let's log in
		login();

		// load edit page in non-FCK namespace
		session().open("index.php?title=User_talk:" + getTestConfig().getString("ci.user.wikiabot.username") + "&action=edit");

		// check for and click "Show Editing Tips"
		assertTrue(session().isElementPresent("toggleWideScreen"));

		// exit widescreen mode
		if (!session().isVisible("sidebar_1")) {
			session().click("toggleWideScreen");
			waitForElementVisible("sidebar_1", TIMEOUT);
		}

		// enter widescreen mode
		session().click("toggleWideScreen");
		waitForElementNotVisible("sidebar_1", TIMEOUT);
		assertFalse(session().isVisible("widget_sidebar"));
		assertFalse(session().isVisible("headerButtonHub"));

		// now let's exit widescreen mode
		session().click("toggleWideScreen");
	}
}
