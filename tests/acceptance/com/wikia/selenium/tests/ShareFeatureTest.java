package com.wikia.selenium.tests;

import static com.thoughtworks.selenium.grid.tools.ThreadSafeSeleniumSessionStorage.session;
import static org.testng.AssertJUnit.assertFalse;

import org.testng.annotations.Test;

public class ShareFeatureTest extends BaseTest {

	@Test(groups={"CI"})
	public void testSharedFeatureLoggedIn() throws Exception {
		login();
		session().open("index.php?title=Special:Random");
		session().waitForPageToLoad(TIMEOUT);
		session().click(isOasis() ? "control_share_feature" : "ca-share_feature");
		waitForElement("//section[@id='shareFeatureInsideWrapper']");
		session().click("link=Facebook");
		session().selectWindow(session().getAllWindowTitles()[1]);
		waitForElement("facebook");
	}

	@Test(groups={"CI"})
	public void testSharedFeatureAnon() throws Exception {
		session().open("index.php?title=Special:Random");
		session().waitForPageToLoad(TIMEOUT);
		session().click(isOasis() ? "control_share_feature" : "ca-share_feature");
		waitForElement("//section[@id='shareFeatureInsideWrapper']");
		session().click("link=Facebook");
		session().selectWindow(session().getAllWindowTitles()[1]);
		waitForElement("facebook");
	}

	@Test(groups={"CI"})
	public void testSharedFeatureNoFooter() throws Exception {
		login();
		session().open("index.php?title=Special:Random");
		assertFalse(session().isElementPresent("shareFacebook"));
	}
}
