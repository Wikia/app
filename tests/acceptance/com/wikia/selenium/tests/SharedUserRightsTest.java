package com.wikia.selenium.tests;

import org.testng.annotations.Test;
import static com.thoughtworks.selenium.grid.tools.ThreadSafeSeleniumSessionStorage.session;
import static org.testng.AssertJUnit.assertTrue;
import static org.testng.AssertJUnit.assertFalse;

public class SharedUserRightsTest extends BaseTest {

	@Test(groups={"oasis"})
	public void testEnsureAnonymousUserCanNotChangeUserRights() throws Exception {
		session().open("index.php?title=Special:UserRights");
		session().waitForPageToLoad(TIMEOUT);
		assertFalse(session().isElementPresent("//form[@id='mw-userrights-form1']"));
		assertTrue(session().isTextPresent("You do not have permission to do that"));
	}

	@Test(groups={"oasis"})
	public void testEnsureRegularUserCanNotChangeUserRights() throws Exception {
		loginAsRegular();
		session().open("index.php?title=Special:UserRights");
		session().waitForPageToLoad(TIMEOUT);
		assertFalse(session().isElementPresent("//form[@id='mw-userrights-form1']"));
		assertTrue(session().isTextPresent("You do not have permission to do that"));
	}

	@Test(groups={"oasis"})
	public void testEnsureStaffCanChangeUserRights() throws Exception {
		loginAsStaff();
		session().open("index.php?title=Special:UserRights");
		session().waitForPageToLoad(TIMEOUT);
		assertTrue(session().isElementPresent("//form[@id='mw-userrights-form1']"));
	}
}
