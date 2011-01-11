package com.wikia.selenium.tests;

import org.testng.annotations.Test;
import static com.thoughtworks.selenium.grid.tools.ThreadSafeSeleniumSessionStorage.session;
import static org.testng.AssertJUnit.assertTrue;

public class WikiaLogoTest extends BaseTest {

	@Test(groups={"oasis","envProduction", "CI"})
	public void testEnsureThatWikiaLogoLeadsToSpecialLandingPage() throws Exception {
		session().open("/");
		session().waitForPageToLoad(TIMEOUT);
		session().click("//li[@class='WikiaLogo']/a");
		session().waitForPageToLoad(TIMEOUT);
		assertTrue(session().getLocation().contains("http://www.wikia.com/Special:LandingPage"));
		assertTrue(session().isElementPresent("//section[@class='LandingPage']"));
	}
}
