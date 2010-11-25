package com.wikia.selenium.tests;

import static com.thoughtworks.selenium.grid.tools.ThreadSafeSeleniumSessionStorage.session;
import static org.testng.AssertJUnit.assertEquals;
import static org.testng.AssertJUnit.assertTrue;
import static org.testng.AssertJUnit.assertFalse;

import org.testng.annotations.Test;
import java.util.Random;

public class SkinChooserTest extends BaseTest {

	@Test(groups={"CI"})
	public void testCheckPresenceOfOldSkins() throws Exception {
		login();

		session().open("index.php?title=Special:Preferences");
		session().waitForPageToLoad(TIMEOUT);

		assertFalse(session().isElementPresent("//input[@id='wpSkincologneblue']"));
		assertFalse(session().isElementPresent("//input[@id='wpSkinmodern']"));
		assertFalse(session().isElementPresent("//input[@id='wpSkinmyskin']"));
		assertFalse(session().isElementPresent("//input[@id='wpSkinsimple']"));
		assertFalse(session().isElementPresent("//input[@id='wpSkinstandard']"));
		assertFalse(session().isElementPresent("//input[@id='wpCorporate']"));
		assertFalse(session().isElementPresent("//input[@id='wpSkinmonaco_old']")); // RT#25098
		assertTrue(session().isElementPresent("//input[@id='wpSkinoasis']"));
		assertTrue(session().isElementPresent("//input[@id='wpSkinmonobook']"));
	}
}
