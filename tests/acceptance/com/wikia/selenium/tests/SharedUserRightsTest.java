package com.wikia.selenium.tests;

import org.testng.annotations.Test;
import static com.thoughtworks.selenium.grid.tools.ThreadSafeSeleniumSessionStorage.session;
import static org.testng.AssertJUnit.assertEquals;
import static org.testng.AssertJUnit.assertTrue;

public class SharedUserRightsTest extends BaseTest {

	@Test(groups={"oasis"})
	public void testEnsureAnonymousUserCanNotChangeUserRights() throws Exception {
		session().open("index.php?title=Special:UserRights");
		session().waitForPageToLoad(TIMEOUT);
		assertEquals(session().getText("//header[@id='WikiaPageHeader']/h1"), "Permissions errors");
	}

	@Test(groups={"oasis"})
	public void testEnsureRegularUserCanNotChangeUserRights() throws Exception {
		loginAsRegular();
		session().open("index.php?title=Special:UserRights");
		session().waitForPageToLoad(TIMEOUT);
		assertEquals(session().getText("//header[@id='WikiaPageHeader']/h1"), "Permissions errors");
	}

	@Test(groups={"oasis"})
	public void testEnsureStaffCanChangeUserRights() throws Exception {
		loginAsStaff();
		session().open("index.php?title=Special:UserRights");
		session().waitForPageToLoad(TIMEOUT);
		assertTrue(session().isElementPresent("//form[@id='mw-userrights-form1']"));
	}
}
