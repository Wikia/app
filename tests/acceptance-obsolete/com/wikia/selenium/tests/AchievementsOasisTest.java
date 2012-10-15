package com.wikia.selenium.tests;

import static com.thoughtworks.selenium.grid.tools.ThreadSafeSeleniumSessionStorage.session;
import static org.testng.AssertJUnit.assertTrue;

import org.testng.annotations.Test;

public class AchievementsOasisTest extends BaseTest {
	private static String testPage = "AchievementsOasisTest";

	@Test(groups={"CI", "legacy"})
	public void testEnsureAchievementsWidgetIsPresentOnUserProfilePage() throws Exception {
		loginAsRegular();

		// edit a page (to have some achievements
		editArticle(testPage, "Lorem ipsum");
		
		// got to user profile page
		openAndWait("wiki/User:" + getTestConfig().getString("ci.user.regular.username"));

		// check for elements
		waitForElement("//div[contains(@class,'AchievementsModule')]");
		assertTrue(session().isElementPresent("//div[contains(@class,'AchievementsModule')]"));
		assertTrue(session().isElementPresent("//ul[@class='badges-icons badges']/li[@class='badge-0']"));
	}
}
 