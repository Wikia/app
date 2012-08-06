package com.wikia.selenium.tests;

import static com.thoughtworks.selenium.grid.tools.ThreadSafeSeleniumSessionStorage.session;
import static org.testng.AssertJUnit.*;

import org.testng.annotations.Test;

public class MainPageTest extends BaseTest {
	@Test(groups={"CI", "legacy"})
	public void testMainPageNoRail() throws Exception {
		session().open("index.php");
		session().waitForPageToLoad(this.getTimeout());

		// rail
		assertFalse(session().isElementPresent("WikiaRail"));
	}
}
