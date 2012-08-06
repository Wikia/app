package com.wikia.selenium.tests;

import java.util.Date;

import org.testng.annotations.Test;
import static com.thoughtworks.selenium.grid.tools.ThreadSafeSeleniumSessionStorage.session;
import static org.testng.AssertJUnit.assertTrue;

public class EditAnArticleTest extends BaseTest {
	@Test(groups={"CI"})
	public void testEditAnArticle() throws Exception {
		login();
		String content = (new Date()).toString();
		editArticle("Project:WikiaBotAutomatedTest", "*Tested: " + content
				+ " by [[wikia:user:" + getTestConfig().getString("ci.user.wikiabot.username") + "|" + getTestConfig().getString("ci.user.wikiabot.username") + "]]");
		assertTrue(session().isTextPresent("Tested: " + content));
	}
}
