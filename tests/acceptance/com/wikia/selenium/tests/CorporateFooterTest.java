package com.wikia.selenium.tests;

import static com.thoughtworks.selenium.grid.tools.ThreadSafeSeleniumSessionStorage.session;
import static org.testng.AssertJUnit.assertTrue;

import org.testng.annotations.Test;

public class CorporateFooterTest extends BaseTest {
	@Test(groups={"oasis", "CI"})
	public void testFooterLinks() throws Exception {
		session().open("/");
		session().waitForPageToLoad(this.getTimeout());

		// Coporate Footer Module
		assertTrue(session().isElementPresent("//footer[@class='CorporateFooter']"));

		// checking for "Random Wiki" link
		assertTrue(session().isElementPresent("//footer[@id='WikiaFooter']//a[@id='WikiaRandomWiki']"));

		// checking for spotlights
		assertTrue(session().isElementPresent("//footer[@class='WikiaFooter']//ul[@id='SPOTLIGHT_FOOTER']/li"));
		assertTrue(session().isElementPresent("//footer[@class='WikiaFooter']//ul[@id='SPOTLIGHT_FOOTER']/li/div[contains(@id,'beacon_')]"));

		// checking for hub branding
		assertTrue(session().isElementPresent("//footer[@class='CorporateFooter']/nav/div[@class='WikiaHubBranding']"));

		// checking for corporate nav
		assertTrue(session().isElementPresent("//footer[@class='CorporateFooter']/nav/ul"));
	}
}
