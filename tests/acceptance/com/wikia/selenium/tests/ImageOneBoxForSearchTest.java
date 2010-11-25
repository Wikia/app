package com.wikia.selenium.tests;

import org.testng.annotations.Test;
import static com.thoughtworks.selenium.grid.tools.ThreadSafeSeleniumSessionStorage.session;
import static org.testng.AssertJUnit.assertTrue;

public class ImageOneBoxForSearchTest extends BaseTest {

	@Test(groups={"CI"})
	public void testImageSearchResults() throws Exception {
		session().open("/");
		waitForElement("search_box", TIMEOUT);
		session().type("search_field", "kermit piggy");
		session().click("search-button");

		session().waitForPageToLoad(TIMEOUT);
		assertTrue(session().isElementPresent("image-one-box-search-results"));
		assertTrue(session().isElementPresent("image-one-box-search-result-1"));

		session().click("//li[@id='image-one-box-search-result-1']/div/a");

		session().waitForPageToLoad(TIMEOUT);
		assertTrue(session().isElementPresent("article"));
	}
}
