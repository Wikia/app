package com.wikia.selenium.tests;

import org.testng.annotations.Test;
import static com.thoughtworks.selenium.grid.tools.ThreadSafeSeleniumSessionStorage.session;
import static org.testng.AssertJUnit.assertTrue;
import static org.testng.AssertJUnit.assertEquals;

import java.util.UUID;

public class SearchTest extends BaseTest {

	@Test(groups={"CI", "legacy"})
	public void testEnsureThatWhenThereAreNoSearchResultProperMessageIsDisplayed() throws Exception {
		openAndWait("/");

		String searchTerm = "randomSearchTerm" + UUID.randomUUID().toString().replace("-","");

		if (isOasis()) {
			waitForElement("//form[@id='WikiaSearch']//input[@type='text']");
			session().type("//form[@id='WikiaSearch']//input[@type='text']", searchTerm);
			clickAndWait("//form[@id='WikiaSearch']//button");
		}
		else {
			waitForElement("search_field");
			session().type("search_field", searchTerm);
			clickAndWait("search-button");
		}

		waitForTextPresent("There were no results matching the query.");
	}
	
	@Test(groups={"CI", "legacy"})
	public void testEnsureThatWhenUserSearchesForExactPageTitleTheSearchedPageIsDisplayed() throws Exception {
		openAndWait("wiki/Special:Random");
		
		String pageName = session().getText("//header[@id='WikiaPageHeader']/h1");
		
		openAndWait("/");
		waitForElement("//input[@name='search']");
		session().type("//input[@name='search']", pageName);
		clickAndWait("//form[@id='WikiaSearch']/input[3]");

		// check what page you land on
		assertTrue(session().getLocation().contains("wiki/" + pageName.replace(" ", "_")));
		assertTrue(session().getText("//header[@id='WikiaPageHeader']/h1").equals(pageName));
	}
}
