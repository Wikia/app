package com.wikia.selenium.tests;

import static com.thoughtworks.selenium.grid.tools.ThreadSafeSeleniumSessionStorage.session;
import static org.testng.AssertJUnit.assertTrue;
import static org.testng.AssertJUnit.assertFalse;

import org.testng.annotations.Test;

public class SearchBoxTest extends BaseTest {

	private void randomPage() throws Exception {
		openAndWait("index.php?title=Special:Random");
	}

	@Test(groups={"CI", "legacy"})
	public void testSearchSuggest() throws Exception {
		randomPage();
		session().waitForCondition("typeof window.wgTitle != 'undefined'", this.getTimeout());
		String title = session().getEval("window.wgTitle");

		// search box
		assertTrue(session().isElementPresent("WikiaSearch"));

		// TODO: try to force autosuggest to appear
		session().runScript("window.jQuery('#WikiaSearch').find('input').eq(0).focus().val(window.wgTitle)");

		// submit search box
		clickAndWait("//form[@id='WikiaSearch']//button");
		session().waitForCondition("typeof window.wgTitle != 'undefined'", this.getTimeout());

		// check page title
		session().getEval("window.wgTitle").equals(title);
	}
}
