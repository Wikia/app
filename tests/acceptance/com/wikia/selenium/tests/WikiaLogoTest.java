package com.wikia.selenium.tests;

import org.testng.annotations.Test;
import static com.thoughtworks.selenium.grid.tools.ThreadSafeSeleniumSessionStorage.session;
import static org.testng.AssertJUnit.assertTrue;
import static org.testng.AssertJUnit.assertFalse;

public class WikiaLogoTest extends BaseTest {

	@Test(groups={"envProduction", "CI", "legacy"})
	public void testEnsureThatWikiaLogoLeadsToSpecialLandingPage() throws Exception {
		openAndWait("/");
		clickAndWait("//li[@class='WikiaLogo']/a");
		assertFalse(session().getLocation().contains("http://www.wikia.com/Special:LandingPage"));
		assertTrue(session().getLocation().contains("http://www.wikia.com/Wikia"));
		assertFalse(session().isElementPresent("//section[@class='LandingPage']"));
	}
}
