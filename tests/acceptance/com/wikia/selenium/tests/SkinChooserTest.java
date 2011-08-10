package com.wikia.selenium.tests;

import static com.thoughtworks.selenium.grid.tools.ThreadSafeSeleniumSessionStorage.session;
import static org.testng.AssertJUnit.assertEquals;
import static org.testng.AssertJUnit.assertTrue;
import static org.testng.AssertJUnit.assertFalse;

import org.testng.annotations.Test;
import java.util.Random;

public class SkinChooserTest extends BaseTest {

	@Test(groups={"CI", "verified"})
	public void testCheckPresenceOfOldSkins() throws Exception {
		login();

		openAndWait("index.php?title=Special:Preferences");

		assertTrue(session().isElementPresent("//input[@id='mw-input-skin-oasis']"));
		assertTrue(session().isElementPresent("//input[@id='mw-input-skin-monobook']"));

		assertFalse(session().isElementPresent("//input[@id='mw-input-skin-cologneblue']"));
		assertFalse(session().isElementPresent("//input[@id='mw-input-skin-modern']"));
		assertFalse(session().isElementPresent("//input[@id='mw-input-skin-myskin']"));
		assertFalse(session().isElementPresent("//input[@id='mw-input-skin-simple']"));
		assertFalse(session().isElementPresent("//input[@id='mw-input-skin-standard']"));
		assertFalse(session().isElementPresent("//input[@id='mw-input-skin-corporate']"));
		assertFalse(session().isElementPresent("//input[@id='mw-input-skin-monaco']")); // RT#25098
		assertFalse(session().isElementPresent("//input[@id='mw-input-skin-vector']"));
	}
}
