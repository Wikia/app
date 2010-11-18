package com.wikia.selenium.tests;

import org.testng.annotations.Test;
import static com.thoughtworks.selenium.grid.tools.ThreadSafeSeleniumSessionStorage.session;
import static org.testng.AssertJUnit.assertTrue;
import static org.testng.AssertJUnit.assertEquals;

import java.util.UUID;

public class SearchTest extends BaseTest {

	@Test(groups={"oasis", "CI"})
	public void testEnsureThatWhenThereAreNoSearchResultProperMessageIsDisplayed() throws Exception {
		session().open("/");
		session().waitForPageToLoad(TIMEOUT);

		String searchTerm = "randomSearchTerm" + UUID.randomUUID().toString().replace("-","");

		if (isOasis()) {
			session().type("//form[@id='WikiaSearch']//input[@type='text']", searchTerm);
			session().click("//form[@id='WikiaSearch']//button");
		}
		else {
			session().type("search_field", searchTerm);
			session().click("search-button");
		}

		session().waitForPageToLoad(TIMEOUT);
		assertTrue(session().isTextPresent("No search results for that term."));
	}
	
	@Test(groups={"oasis", "CI"})
	public void testEnsureThatWhenUserSearchesForExactPageTitleTheSearchedPageIsDisplayed() throws Exception {
		session().open("/");
		session().type("//input[@name='search']", "main page");
		session().click("//form[@id='WikiaSearch']/input[3]");
		session().waitForPageToLoad(TIMEOUT);
		
		// check what page you land on
		assertTrue(session().getLocation().contains("wiki/Main_page"));
		assertEquals(session().getText("//header[@id='WikiaPageHeader']/h1"), "Main Page");
	}
}
