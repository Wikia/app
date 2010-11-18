package com.wikia.selenium.tests;

import org.testng.annotations.Test;
import static com.thoughtworks.selenium.grid.tools.ThreadSafeSeleniumSessionStorage.session;
import static org.testng.AssertJUnit.assertTrue;
import static org.testng.AssertJUnit.assertEquals;

public class SpecialVersionTest extends BaseTest {

	@Test(groups={"oasis"})
	public void testEnsureSpecialVersionPageDisplaysMediaWikiAndWikiaVersion() throws Throwable {
		session().open("index.php?title=Special:Version");

		assertTrue(session().getLocation().contains("index.php?title=Special:Version"));
		assertEquals(session().getText("//header[@id='WikiaPageHeader']/h1"), "Version");
		assertEquals(session().getText("//header[@id='WikiaPageHeader']/h2"), "Special page");

		assertTrue(session().isElementPresent("//table[@id='sv-software']/tbody/tr[2]/td[2]"));
		assertTrue(session().isElementPresent("//table[@id='sv-software']/tbody/tr[3]/td[2]"));
	}
}
