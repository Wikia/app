package com.wikia.selenium.tests;

import org.testng.annotations.Test;
import static com.thoughtworks.selenium.grid.tools.ThreadSafeSeleniumSessionStorage.session;
import static org.testng.AssertJUnit.assertTrue;
import static org.testng.AssertJUnit.assertFalse;

public class SharedUserRightsTest extends BaseTest {

	@Test(groups={"CI", "legacy"})
	public void testEnsureAnonymousUserCanNotChangeUserRights() throws Exception {
		openAndWait("index.php?title=Special:UserRights");
		waitForTextPresent("You do not have permission to do that");
		assertFalse(session().isElementPresent("//form[@id='mw-userrights-form1']"));
		assertTrue(session().isTextPresent("You do not have permission to do that"));
	}

	@Test(groups={"CI", "legacy"})
	public void testEnsureRegularUserCanNotChangeUserRights() throws Exception {
		loginAsRegular();
		openAndWait("index.php?title=Special:UserRights");
		waitForTextPresent("You do not have permission to do that");
		assertFalse(session().isElementPresent("//form[@id='mw-userrights-form1']"));
		assertTrue(session().isTextPresent("You do not have permission to do that"));
	}

	@Test(groups={"CI", "legacy"})
	public void testEnsureStaffCanChangeUserRights() throws Exception {
		loginAsStaff();
		openAndWait("index.php?title=Special:UserRights");
		waitForElement("//form[@id='mw-userrights-form1']");
	}
}
