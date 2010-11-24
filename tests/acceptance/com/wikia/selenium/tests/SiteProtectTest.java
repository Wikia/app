package com.wikia.selenium.tests;

import org.testng.annotations.Test;
import static com.thoughtworks.selenium.grid.tools.ThreadSafeSeleniumSessionStorage.session;
import static org.testng.AssertJUnit.assertEquals;
import static org.testng.AssertJUnit.assertTrue;

public class SiteProtectTest extends BaseTest {

	@Test(groups={"CI"})
	public void testProtectSite() throws Exception {
		// Protect the site
		loginAsStaff();
		session().open("index.php?title=Special:Protectsite");
		session().waitForPageToLoad(TIMEOUT);
		waitForElement("//input[@name='createpage']");
		session().click("//input[@name='createpage' and @value='1']");
		session().click("//input[@name='edit' and @value='1']");
		session().type("timeout", "5 minutes");
		session().type("comment", "Wikia automated test");
		session().click("protect");
		session().waitForPageToLoad(TIMEOUT);
		logout();

		// Verify
		session().open("index.php?title=WikiaAutomatedTest&action=edit");
		session().waitForPageToLoad(TIMEOUT);
		if(isOasis()){
			assertTrue(session().isTextPresent("You do not have permission to edit this page, for the following reason:"));
		} else {
			assertEquals("Permission error", session().getText("//div[@id='article']/h1"));
		}
		assertTrue(session().isTextPresent("You do not have permission to edit this page"));
	}

	@Test(dependsOnMethods="testProtectSite", alwaysRun=true)
	public void testUnprotectSite() throws Exception {
		// Unprotect the site
		loginAsStaff();
		session().open("index.php?title=Special:Protectsite");
		session().waitForPageToLoad(TIMEOUT);
		session().type("ucomment", "end of test");
		session().click("unprotect");
		session().waitForPageToLoad(TIMEOUT);
		logout();
		// Verify
		session().open("index.php?title=WikiaAutomatedTest&action=edit");
		session().waitForPageToLoad(TIMEOUT);
		if(isOasis()){
			assertEquals("Editing: WikiaAutomatedTest", session().getText("//article/div[@id='WikiaPageHeader']/h1"));
		} else {
			assertEquals("Editing WikiaAutomatedTest", session().getText("//div[@id='article']/h1"));
		}
	}
}
