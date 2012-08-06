package com.wikia.selenium.tests;

import org.testng.annotations.Test;
import static com.thoughtworks.selenium.grid.tools.ThreadSafeSeleniumSessionStorage.session;
import static org.testng.AssertJUnit.assertEquals;
import static org.testng.AssertJUnit.assertTrue;

public class SiteProtectTest extends BaseTest {

	//BugId: 10385
	@Test(groups={"CI", "broken"})
	public void testProtectSite() throws Exception {
		// Protect the site
		loginAsStaff();
		openAndWait("index.php?title=Special:Protectsite");
		waitForElement("//input[@name='createpage']");
		session().click("//input[@name='createpage' and @value='1']");
		session().click("//input[@name='edit' and @value='1']");
		session().type("//input[@name='timeout']", "5 minutes");
		session().type("//input[@name='comment']", "Wikia automated test");
		clickAndWait("protect");
		logout();

		// Verify
		openAndWait("index.php?title=WikiaAutomatedTest&action=edit");
		if(isOasis()){
			assertTrue(session().isTextPresent("You do not have permission to edit this page, for the following reason"));
		} else {
			assertEquals("Permission error", session().getText("//div[@id='article']/h1"));
		}
		assertTrue(session().isTextPresent("You do not have permission to edit this page"));
	}

	//BugId: 10385
	@Test(groups={"CI", "broken"},dependsOnMethods="testProtectSite", alwaysRun=true)
	public void testUnprotectSite() throws Exception {
		// Unprotect the site
		loginAsStaff();
		openAndWait("index.php?title=Special:Protectsite");
		waitForElement("//input[@name='ucomment']");
		session().type("//input[@name='ucomment']", "end of test");
		clickAndWait("unprotect");
		logout();
		// Verify
		openAndWait("index.php?title=WikiaAutomatedTest&action=edit");
		if(isOasis()){
			assertEquals("Editing", session().getText("//header[@id='EditPageHeader']//h2"));
			assertEquals("WikiaAutomatedTest", session().getText("//header[@id='EditPageHeader']//h1"));
		} else {
			assertEquals("Editing WikiaAutomatedTest", session().getText("//div[@id='article']/h1"));
		}
	}
}
