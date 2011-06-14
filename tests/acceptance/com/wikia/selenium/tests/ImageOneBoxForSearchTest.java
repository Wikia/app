package com.wikia.selenium.tests;

import org.testng.annotations.Test;
import static com.thoughtworks.selenium.grid.tools.ThreadSafeSeleniumSessionStorage.session;
import static org.testng.AssertJUnit.assertTrue;

public class ImageOneBoxForSearchTest extends BaseTest {

	// hard to test on devbox - search works on production data, not devbox
	@Test(groups={"CI", "broken"})
	public void testImageSearchResults() throws Exception {
		session().open("/");
		waitForElement("WikiaSearch", this.getTimeout()); 
		session().type("search", "test test");
		session().click("//form[@id='WikiaSearch']//button/img[contains(@class, 'search')]");

		session().waitForPageToLoad(this.getTimeout());
		assertTrue(session().isElementPresent("image-one-box-search-results"));
		assertTrue(session().isElementPresent("image-one-box-search-result-1"));

		session().click("//li[@id='image-one-box-search-result-1']/div/a");

		session().waitForPageToLoad(this.getTimeout());
		assertTrue(session().isElementPresent("//article[@id='WikiaMainContent']"));
	}
}
