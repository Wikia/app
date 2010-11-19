package com.wikia.selenium.tests;

import org.testng.annotations.Test;
import static com.thoughtworks.selenium.grid.tools.ThreadSafeSeleniumSessionStorage.session;

/**
 * We no longer use this extension.
 */
public class ArticleVotingTest extends BaseTest {

	@Test(groups={"deprecated"})
	public void testArticleVoting() throws Exception {
		login();
		if (!isOasis()) {
			session().open("index.php?title=Special:Random");
			session().click("star5");
			waitForElementVisible("unrateLink", TIMEOUT);
			session().click("unrate");
			waitForElementNotVisible("unrateLink", TIMEOUT);
		}
	}
}
