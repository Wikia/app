package com.wikia.selenium.tests;

import static com.thoughtworks.selenium.grid.tools.ThreadSafeSeleniumSessionStorage.session;
import static org.testng.AssertJUnit.assertTrue;

import org.testng.annotations.Test;

public class CorporateFooterTest extends BaseTest {
	@Test(groups={"oasis", "CI"})
	public void testLatestPhotos() throws Exception {
		loginAsRegular();
		session().open("/");
		session().waitForPageToLoad(TIMEOUT);
	
		// Coporate Footer Module
		assertTrue(session().isElementPresent("//footer[@class='CorporateFooter']"));
		// checking for a random link
		assertTrue(session().isElementPresent("//footer[@class='CorporateFooter']/nav/ul/li[4]"));
	}
}
