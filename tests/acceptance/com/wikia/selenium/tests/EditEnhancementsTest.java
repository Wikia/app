package com.wikia.selenium.tests;

import org.testng.annotations.Test;
import static com.thoughtworks.selenium.grid.tools.ThreadSafeSeleniumSessionStorage.session;
import static org.testng.AssertJUnit.assertTrue;

public class EditEnhancementsTest extends BaseTest {
	@Test(groups={"CI"})
	public void testIsEditEnhancementsToolbarPresent() throws Exception {
		login();
		session().open("index.php?title=WikiaAutomatedTest&action=edit");
		assertTrue(session().isElementPresent("edit_enhancements_toolbar"));
		session().click("wpPreview");
		waitForElement("edit_enhancements_toolbar", TIMEOUT);
	}
}
