package com.wikia.selenium.tests;

import static com.thoughtworks.selenium.grid.tools.ThreadSafeSeleniumSessionStorage.session;
import java.util.regex.Pattern;
import org.testng.annotations.Test;
import static org.testng.AssertJUnit.assertTrue;
import static org.testng.AssertJUnit.assertEquals;

public class SearchResultsTest extends BaseTest {

	// Perform a search for "main"... it should find the main page
	@Test(groups={"oasis", "CI"})
	public void testSearchResults() throws Exception {
		session().open("/");
		session().type("//input[@name='search']", "main page");
		session().click("//form[@id='WikiaSearch']/input[3]");
		session().waitForPageToLoad(TIMEOUT);
		
		// check what page you land on
		assertTrue(session().getLocation().contains("wiki/Main_page"));
		assertEquals(session().getText("//header[@id='WikiaPageHeader']/h1"), "Main Page");
	}
}
