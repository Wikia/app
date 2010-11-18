package com.wikia.selenium.tests;

import org.testng.annotations.Test;
import static com.thoughtworks.selenium.grid.tools.ThreadSafeSeleniumSessionStorage.session;
import static org.testng.AssertJUnit.assertEquals;
import static org.testng.AssertJUnit.assertTrue;

public class WikiaLogoTest extends BaseTest {

	@Test(groups={"oasis"})
	public void testEnsuraThatWikiaLogoLeadsToSpecialLandingPage() throws Exception {
		session().open("/");
		session().click("//li[@class='WikiaLogo']/a");
		session().waitForPageToLoad(TIMEOUT);
		assertEquals("http://www.wikia.com/Special:LandingPage?uselang=", session().getLocation());
		assertTrue(session().isElementPresent("//section[@class='LandingPage']"));
	}
}
