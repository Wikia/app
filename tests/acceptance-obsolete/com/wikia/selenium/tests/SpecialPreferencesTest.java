package com.wikia.selenium.tests;

import static com.thoughtworks.selenium.grid.tools.ThreadSafeSeleniumSessionStorage.session;
import static org.testng.AssertJUnit.assertTrue;

import org.testng.annotations.Test;

public class SpecialPreferencesTest extends BaseTest {

	private void loadPage() throws Exception {
		openAndWait("wiki/Special:Preferences");
		assertTrue(session().getLocation().contains("wiki/Special:Preferences"));
		waitForElement("//select[@name='wpskin']");
	}

	@Test(groups={"CI", "legacy"})
	public void testEnsureRegisteredUserCanChangeSkin() throws Exception {
		loginAsRegular();

		loadPage();
		session().select("//select[@name='wpskin']","value=oasis");
		clickAndWait("//input[@id='prefcontrol']");
		waitForElement("//body[contains(@class, 'skin-oasis')]");

		loadPage();
		session().select("//select[@name='wpskin']","value=monobook");
		clickAndWait("//input[@id='prefcontrol']");
		waitForElement("//body[contains(@class, 'skin-monobook')]");

		loadPage();
		session().select("//select[@name='wpskin']","value=oasis");
		clickAndWait("//input[@id='prefcontrol']");
	}
}