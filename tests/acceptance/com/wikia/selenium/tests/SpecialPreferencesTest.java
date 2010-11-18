package com.wikia.selenium.tests;

import static com.thoughtworks.selenium.grid.tools.ThreadSafeSeleniumSessionStorage.session;
import static org.testng.AssertJUnit.assertTrue;

import org.testng.annotations.Test;

public class SpecialPreferencesTest extends BaseTest {

	private void loadPage() throws Exception {
		session().open("/wiki/Special:Preferences");
		session().waitForPageToLoad(TIMEOUT);
		assertTrue(session().getLocation().contains("/wiki/Special:Preferences"));
	}

	@Test(groups="oasis")
	public void testEnsureRegisteredUserCanChangeSkin() throws Exception {
		loginAsRegular();

		loadPage();
		assertTrue(session().isElementPresent("//h2[.='Site Layouts']"));
		session().click("//input[@value='oasis']");
		session().click("//input[@id='wpSaveprefs']");
		session().waitForPageToLoad(TIMEOUT);
		assertTrue(session().isElementPresent("//body[contains(@class, 'skin-oasis')]"));

		loadPage();
		session().click("//input[@value='monobook']");
		session().click("//input[@id='wpSaveprefs']");
		session().waitForPageToLoad(TIMEOUT);
		assertTrue(session().isElementPresent("//body[contains(@class, 'wikiaSkinMonobook')]"));

		loadPage();
		session().click("//input[@value='oasis']");
		session().click("//input[@id='wpSaveprefs']");
		session().waitForPageToLoad(TIMEOUT);
	}
}
