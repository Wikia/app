package com.wikia.selenium.tests;

import static com.thoughtworks.selenium.grid.tools.ThreadSafeSeleniumSessionStorage.session;
import static org.testng.AssertJUnit.assertTrue;
import static org.testng.AssertJUnit.assertFalse;

import org.testng.annotations.Test;

public class SearchBoxTest extends BaseTest {

	private void randomPage() throws Exception {
		session().open("index.php?title=Special:Random");
		session().waitForPageToLoad(TIMEOUT);
	}

	@Test(groups={"oasis", "CI"})
	public void testSearchSuggest() throws Exception {
		randomPage();
		String title = session().getEval("window.wgTitle");

		// search box
		assertTrue(session().isElementPresent("WikiaSearch"));

		// TODO: try to force autosuggest to appear
		session().runScript("window.jQuery('#WikiaSearch').find('input').eq(0).focus().val(window.wgTitle)");
		//Thread.sleep(4000);

		// submit search box
		clickAndWait("//form[@id='WikiaSearch']//button");

		// check page title
		session().getEval("window.wgTitle").equals(title);
	}
}
