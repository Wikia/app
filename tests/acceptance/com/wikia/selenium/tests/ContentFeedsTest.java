/**
 * ContentFeeds extension tests
 * @author ADi
 */
package com.wikia.selenium.tests;

import static com.thoughtworks.selenium.grid.tools.ThreadSafeSeleniumSessionStorage.session;
import static org.testng.AssertJUnit.assertTrue;

import org.testng.annotations.Test;

/**
 * Tests ContentFeeds extension.  To enable the extension, add this to LocalSettings (or set it in WikiFactory):
 * $wgWikiaEnableContentFeedsExt = true;
 */
public class ContentFeedsTest extends BaseTest {

	@Test(groups={"CI"})
	public void testWikiTweetsTag() throws Exception {
		login();

		String content = "<wikitweets size=\"5\" keywords=\"wikia\" />";
		editArticle("Project:WikiTweetsTagTestArticle", content);

		waitForElement("//ul[@class='cfWikiTweetsTag']/li/a", TIMEOUT);

		assertTrue(session().isElementPresent("//ul[@class='cfWikiTweetsTag']"));
		assertTrue(session().isElementPresent("//ul[@class='cfWikiTweetsTag']/li/a"));
	}

	@Test(groups={"CI"})
	public void testMostVisitedTag() throws Exception {
		login();

		String content = "<mostvisited size=\"5\" />";
		editArticle("Project:MostVisitedTagTestArticle", content);

		assertTrue(session().isElementPresent("//ul[@class='cfMostVisitedTag']"));
		assertTrue(session().isElementPresent("//ul[@class='cfMostVisitedTag']/li/a"));
	}

	@Test(groups={"CI"})
	public void testRecentImagesTag() throws Exception {
		login();

		String content = "<recentimages size=\"5\" />";
		editArticle("Project:RecentImagesTagTestArticle", content);

		assertTrue(session().isElementPresent("//div[@class='wikia-gallery-item']"));
	}
}
