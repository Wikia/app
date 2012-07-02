package com.wikia.selenium.tests;

import static com.thoughtworks.selenium.grid.tools.ThreadSafeSeleniumSessionStorage.session;
import static org.testng.AssertJUnit.assertTrue;
import static org.testng.AssertJUnit.assertFalse;
import java.util.Date;

import org.testng.annotations.Test;

public class LatestActivityTest extends BaseTest {
	// Make an edit on a random page and verify that it shows up in the recent activity box
	@Test(groups={"CI", "legacy"})
	public void testLatestActivity() throws Exception {
		loginAsStaff(); 
		session().click("link=Random Page");
		session().waitForPageToLoad(this.getTimeout());
		String ArticleTitle = session().getText("//header[@id='WikiaPageHeader']/h1");
		String content = (new Date()).toString();
		editArticle(ArticleTitle, "*Tested: " + content + " by [[wikia:user:" + getTestConfig().getString("ci.user.wikiabot.username")  + "|" + getTestConfig().getString("ci.user.wikiabot.username") + "]]");
		waitForElement("link=" + ArticleTitle);
	}
}
