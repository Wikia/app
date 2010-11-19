package com.wikia.selenium.tests;

import static com.thoughtworks.selenium.grid.tools.ThreadSafeSeleniumSessionStorage.session;
import static org.testng.AssertJUnit.assertTrue;

import org.testng.annotations.Test;

public class AchievementsOasisTest extends BaseTest {
	@Test(groups="oasis")
	public void testEnsureAchievementsWidgetIsPresentOnUserProfilePage() throws Exception {
		loginAsRegular();

		// got to user profile page  
		session().open("/wiki/User:" + getTestConfig().getString("ci.user.regular.username"));
		session().waitForPageToLoad(TIMEOUT);

		// check for elements
		assertTrue(session().isElementPresent("//div[contains(@class,'AchievementsModule')]"));
		assertTrue(session().isElementPresent("//ul[@class='badges-icons badges']/li[@class='badge-0']"));
	}
}
