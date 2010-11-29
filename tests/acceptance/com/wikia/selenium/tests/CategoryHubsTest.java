package com.wikia.selenium.tests;

import static com.thoughtworks.selenium.grid.tools.ThreadSafeSeleniumSessionStorage.session;
import static org.testng.AssertJUnit.assertEquals;
import static org.testng.AssertJUnit.assertTrue;

import org.testng.annotations.Test;
import java.util.Random;

public class CategoryHubsTest extends BaseTest {

	@Test(groups={"answers", "CI"})
	public void testViewMode() throws Exception {
		loginAsStaff();
		session().open("index.php?title=Category:Lyrics");
		session().waitForPageToLoad(TIMEOUT);

		// Test to make some basic elements show up (title bar, progress bar, top contributors).
		// System.out.println("\tLooking for title bar...");
		waitForElement("//div[@id='cathub-title-bar']");
		// System.out.println("\tLooking for progress bar...");
		assertTrue(session().isElementPresent("//div[@class='cathub-progbar-wrapper']"));
		// System.out.println("\tLooking for Top Contributors list (and at least one all-time Top Contributor)...");
		assertTrue(session().isElementPresent("//div[@id='topContributorsWrapper']"));
		assertTrue(session().isElementPresent("//div[@id='topContribsAllTime']"));
		assertTrue(session().isElementPresent("//div[@id='topContribsAllTime']/ol/li")); // there should be some top contributors of all time
		assertTrue(session().isElementPresent("//div[@id='topContribsRecent']")); // there may not be any recent contributors

		// System.out.println("Test completed: " + Thread.currentThread().getStackTrace()[1].getMethodName());
	}

	@Test(groups={"answers", "CI"})
	public void testContent() throws Exception {
		loginAsStaff();
		session().open("index.php?title=Category:Lyrics");
		session().waitForPageToLoad(TIMEOUT);

		// Make sure that there are tabs of content (it's possible that there won't be any unanswered).
		// System.out.println("\tLooking at the Answered/Unanswered tabs...");
		assertTrue(session().isElementPresent("//div[@id='cathub-tab-unanswered']"));
		// Make sure that there are answers questions (since we know there have been answered questions in this category at some point).
		session().click("//a[@id='cathub-tablink-answered']");
		assertTrue(session().isElementPresent("//div[@id='cathub-tab-answered']/ul[@class='interactive-questions']"));
		assertTrue(session().isElementPresent("//div[@id='cathub-tab-answered']/ul[@class='interactive-questions']/li"));

		//System.out.println("Test completed: " + Thread.currentThread().getStackTrace()[1].getMethodName());
	}

	/**
	 * Make sure that the tabs get applied.  This means that jquery-ui code loaded properly and that
	 * the classes are still right in the HTML source.
	 * 
	 * @throws Exception
	 */
	@Test(groups={"answers", "CI"})
	public void testTabs() throws Exception {
		loginAsStaff();
		session().open("index.php?title=Category:Lyrics");
		session().waitForPageToLoad(TIMEOUT);

		// Test to make sure that jquery-ui applies to the tabs (look for classes inserted by it).
		waitForElement("//div[@id='cathub-title-bar']");
		// System.out.println("\tMaking sure that jquery-ui correctly formatted the tabs...");
		assertTrue(session().isElementPresent("//ul[contains(@class, 'ui-tabs-nav')]"));

		// System.out.println("Test completed: " + Thread.currentThread().getStackTrace()[1].getMethodName());
	}
}
