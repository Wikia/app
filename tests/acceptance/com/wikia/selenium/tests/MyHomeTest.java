//@author Macbre
package com.wikia.selenium.tests;

import org.testng.annotations.Test;
import static com.thoughtworks.selenium.grid.tools.ThreadSafeSeleniumSessionStorage.session;
import static org.testng.AssertJUnit.assertTrue;

/**
 * NOTE: MyHome won't be used in Oasis: MyHome has been replaced by WikiActivity.
 * Please see WikiActivityTest.java for the Oasis test.
 */
public class MyHomeTest extends BaseTest {

	@Test(groups={"monaco"})
	public void testMyHome() throws Exception {
		login();

		// check presence of link to MyHome
		assertTrue(session().isElementPresent("header_myhome"));

		// and click it
		session().click("//span[@id='header_myhome']/a");
		session().waitForPageToLoad(TIMEOUT);

		// check presence of masthead
		assertTrue(session().isElementPresent("user_masthead"));

		// check presence of myhome feed
		assertTrue(session().isElementPresent("myhome-main"));
	}

	@Test(groups={"monaco"})
	public void testActivityFeed() throws Exception {
		session().open("index.php?title=Special:Random");

		// check presence of link to ActivityFeed for anons
		assertTrue(session().isElementPresent("community-widget-action-button"));

		// and click it
		session().click("community-widget-action-button");
		session().waitForPageToLoad(TIMEOUT);

		// masthead should not be shown
		assertTrue(!session().isElementPresent("user_masthead"));

		// check presence of activity feed
		assertTrue(session().isElementPresent("activityfeed-wrapper"));
	}
}
