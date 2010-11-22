package com.wikia.selenium.tests;

import static com.thoughtworks.selenium.grid.tools.ThreadSafeSeleniumSessionStorage.session;
import static org.testng.AssertJUnit.*;

import org.testng.annotations.Test;

public class MainPageTest extends BaseTest {
	@Test(groups={"oasis", "CI"})
	public void testMainPageNoRail() throws Exception {
		session().open("index.php");
		session().waitForPageToLoad(TIMEOUT);

		// rail
		assertFalse(session().isElementPresent("WikiaRail"));
	}
}
