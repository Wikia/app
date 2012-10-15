package com.wikia.selenium.tests;

import com.thoughtworks.selenium.SeleniumException;
import static com.thoughtworks.selenium.grid.tools.ThreadSafeSeleniumSessionStorage.session;
import static org.testng.AssertJUnit.assertFalse;
import static org.testng.AssertJUnit.assertTrue;

import org.testng.annotations.Test;

import java.util.Date;

// FIXME: the tests here need to be redesigned

public class RegexBlockArticleTest extends BaseTest {

	private boolean isRegexBlockEnabled() {
		boolean isRegexBlockEnabled = true;
		try {
			session().open("index.php?title=Special:RegexBlock");
		} catch (SeleniumException se) {
			if (se.getMessage().contains("Response_Code = 404")) {
				isRegexBlockEnabled = false;
			}
		}
		return isRegexBlockEnabled;
	}
	
	@Test(groups={"CI","uncyclopedia"})
	public void testRegexBlockArticleSave() throws Exception {
		loginAsRegular();
		if (isRegexBlockEnabled()) {
			String content = (new Date()).toString();
			editArticle("Project:WikiaBotAutomatedTest",
				"Regex Block Test. Tested: " + content + " \n");
			assertFalse(session().isElementPresent("wpSave"));
		}
	}

	@Test(groups={"CI","uncyclopedia"})
	public void testRegexBlockArticleSaveUnmatching() throws Exception {
		login();
		if (isRegexBlockEnabled()) {
			String content = (new Date()).toString();
			editArticle("Project:WikiaBotAutomatedTest",
				"Regex Block Test. Tested: " + content + " \n");
			assertTrue(session().isElementPresent("wpSave"));
		}
	}

	@Test(groups={"CI","uncyclopedia"})
	public void testRegexBlockArticleAddFreshMatch() throws Exception {
		loginAsStaff();
		if (isRegexBlockEnabled()) {
			session().open("index.php?title=Special:RegexBlock");
			session().type("wpRegexBlockedAddress", getTestConfig().getString("ci.user.wikiabot.username"));
			session().check("wpRegexBlockedExact");
			clickAndWait("wpRegexBlockedSubmit");

			login();
			session().open("index.php?title=Project:WikiaBotAutomatedTest");
			clickAndWait("//a[@data-id='edit']");
			assertTrue(session().isElementPresent("wpSave"));
		}
	}

	@Test(groups={"CI","uncyclopedia"})
	public void testRegexBlockArticleClearFreshMatch() throws Exception {
		loginAsStaff();
		if (isRegexBlockEnabled()) {
			String content = (new Date()).toString();
			// session().open("index.php?title=Special:SpamRegex&action=delete&limit=50&offset=0&text=Sonoelementariakillus");
			editArticle("Project:WikiaBotAutomatedTest",
				"Regex Block Test. Tested: " + content + " \n");
			assertFalse(session().isElementPresent("spamprotected"));
		}
	}
}
