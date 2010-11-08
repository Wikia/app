package com.wikia.selenium.tests;

import org.testng.annotations.Test;
import static com.thoughtworks.selenium.grid.tools.ThreadSafeSeleniumSessionStorage.session;
import static org.testng.AssertJUnit.assertEquals;

public class WikiaLogoTest extends BaseTest {

	@Test(groups={"oasis"})
	public void testWikiaLogoLink() throws Exception {
		session().open("/");
		session().click("//li[@class='WikiaLogo']/a");
		session().waitForPageToLoad(TIMEOUT);
		assertEquals("http://www.wikia.com/Wikia", session().getLocation());
	}
}
