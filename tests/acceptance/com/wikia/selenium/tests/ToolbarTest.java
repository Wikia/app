package com.wikia.selenium.tests;

import static com.thoughtworks.selenium.grid.tools.ThreadSafeSeleniumSessionStorage.session;
import static org.testng.AssertJUnit.assertFalse;
import static org.testng.AssertJUnit.assertTrue;

import org.testng.annotations.Test;

public class ToolbarTest extends BaseTest {

	@Test(groups={"CI", "verified"})
	public void testEnsuresThatToolbarIsNotPresentForAnonymousUsers() throws Exception {
		openAndWait("/");
		assertTrue(session().isElementPresent("WikiaFooter"));
		assertFalse(session().isElementPresent("//div[contains(@class, 'toolbar')]"));
	}

	@Test(groups={"CI", "verified"})
	public void testEnsuresThatToolbarIsPresentForSignedInUsers() throws Exception {
		login();
		openAndWait("/");
		assertTrue(session().isElementPresent("WikiaFooter"));
		assertTrue(session().isElementPresent("//div[contains(@class, 'toolbar')]"));
	}
}
