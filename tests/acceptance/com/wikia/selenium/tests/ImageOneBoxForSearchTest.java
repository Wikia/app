package com.wikia.selenium.tests;

import org.testng.annotations.Test;
import static com.thoughtworks.selenium.grid.tools.ThreadSafeSeleniumSessionStorage.session;
import static org.testng.AssertJUnit.assertTrue;

public class ImageOneBoxForSearchTest extends BaseTest {

	@Test(groups={"CI"})
	public void testImageSearchResults() throws Exception {
		session().open("/");
		waitForElement("WikiaSearch", TIMEOUT); 
		session().type("search", "kermit piggy");
		session().click("//form[@id='WikiaSearch']//button/img[contains(@class, 'search')]");

		session().waitForPageToLoad(TIMEOUT);
		assertTrue(session().isElementPresent("image-one-box-search-results"));
		assertTrue(session().isElementPresent("image-one-box-search-result-1"));

		session().click("//li[@id='image-one-box-search-result-1']/div/a");

		session().waitForPageToLoad(TIMEOUT);
		assertTrue(session().isElementPresent("article"));
	}
}
