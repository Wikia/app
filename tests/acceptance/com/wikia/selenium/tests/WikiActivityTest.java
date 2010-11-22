//@author Sean Colombo - based on MyHomeTest by Macbre
package com.wikia.selenium.tests;

import org.testng.annotations.Test;
import static com.thoughtworks.selenium.grid.tools.ThreadSafeSeleniumSessionStorage.session;
import static org.testng.AssertJUnit.assertTrue;

public class WikiActivityTest extends BaseTest {

	@Test(groups={"oasis","CI"})
	public void testEnsuresThatWikiActivityButtonLeadsToProperSpecialPage() throws Exception {
		login();

		// check presence of link to WikiActivity
		assertTrue(session().isElementPresent("//a[@data-id='wikiactivity']"));

		// and click it
		session().click("//a[@data-id='wikiactivity']");
		session().waitForPageToLoad(TIMEOUT);

		// check what page you land on
		assertTrue(session().getLocation().contains("/wiki/Special:WikiActivity"));

		// check presence of myhome feed (still has this name in WikiActivity)
		assertTrue(session().isElementPresent("myhome-activityfeed"));
	}

	@Test(groups={"oasis","CI"})
	public void testEnsuresThatActivityFeedModuleIsPresentOnAnArticlePage() throws Exception {
		session().open("index.php?title=Special:Random");

		// check that there are items in the Recent Wiki Activity module.
		assertTrue(session().isElementPresent("//section[contains(@class,'WikiaActivityModule')]/ul/li"));

		// check presence of link to ActivityFeed for anons
		assertTrue(session().isElementPresent("//section[contains(@class,'WikiaActivityModule')]/a[@class='more']"));
	}
}
