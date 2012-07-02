package com.wikia.selenium.tests;

import static com.thoughtworks.selenium.grid.tools.ThreadSafeSeleniumSessionStorage.session;
import static org.testng.AssertJUnit.assertEquals;
import static org.testng.AssertJUnit.assertTrue;
import static org.testng.AssertJUnit.assertFalse;

import org.testng.annotations.Test;
import java.util.Random;

public class SkinChooserTest extends BaseTest {

	@Test(groups={"CI", "legacy"})
	public void testCheckPresenceOfOldSkins() throws Exception {
		login();

		openAndWait("index.php?title=Special:Preferences");

		// new version of preferences page, skins that should be enabled
		assertTrue(session().isElementPresent("//select[@name='wpskin']/option[@value='oasis']"));
		assertTrue(session().isElementPresent("//select[@name='wpskin']/option[@value='monobook']"));
		
		// only above 2 skins should be on the list, all other skins are disabled and removed from UI
		assertEquals(2, session().getXpathCount("//select[@name='wpskin']/option"));
	}
}
