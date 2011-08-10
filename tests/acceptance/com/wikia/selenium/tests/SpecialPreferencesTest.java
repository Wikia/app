package com.wikia.selenium.tests;

import static com.thoughtworks.selenium.grid.tools.ThreadSafeSeleniumSessionStorage.session;
import static org.testng.AssertJUnit.assertTrue;

import org.testng.annotations.Test;

public class SpecialPreferencesTest extends BaseTest {

	private void loadPage() throws Exception {
		openAndWait("wiki/Special:Preferences");
		assertTrue(session().getLocation().contains("wiki/Special:Preferences"));
		waitForElement("//input[@name='wpskin']");
	}

	@Test(groups={"CI", "verified"})
	public void testEnsureRegisteredUserCanChangeSkin() throws Exception {
		loginAsRegular();

		loadPage();
		session().click("//input[@value='oasis']");
		clickAndWait("//input[@id='prefcontrol']");
		waitForElement("//body[contains(@class, 'skin-oasis')]");

		loadPage();
		session().click("//input[@value='monobook']");
		clickAndWait("//input[@id='prefcontrol']");
		waitForElement("//body[contains(@class, 'skin-monobook')]");

		loadPage();
		session().click("//input[@value='oasis']");
		clickAndWait("//input[@id='prefcontrol']");
	}
}