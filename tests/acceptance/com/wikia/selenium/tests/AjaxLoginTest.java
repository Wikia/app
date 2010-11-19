package com.wikia.selenium.tests;

import org.testng.annotations.Test;
import static com.thoughtworks.selenium.grid.tools.ThreadSafeSeleniumSessionStorage.session;
import static org.testng.AssertJUnit.assertTrue;

public class AjaxLoginTest extends BaseTest {
	@Test(groups={"oasis", "CI"})
	public void testAjaxLogin() throws Exception {
		session().open("index.php");
		session().click("//a[@class='ajaxLogin']");
		waitForElement("wpGoLogin");
		session().click("wpGoLogin");
		waitForElement("userajaxloginform");
		session().type("wpName2Ajax", getTestConfig().getString("ci.user.wikiabot.username"));
		session().type("wpPassword2Ajax", getTestConfig().getString("ci.user.wikiabot.password"));
		session().click("wpLoginattempt");
		session().waitForPageToLoad(TIMEOUT);
		if(isOasis()) {
			assertTrue(session().isElementPresent("//ul[@id='AccountNavigation']/li/a[contains(., '" + getTestConfig().getString("ci.user.wikiabot.username") + "')]"));
		} else {
			assertTrue(session().isElementPresent("//span[@id=\"header_username\"]/a[text() = \"" + getTestConfig().getString("ci.user.wikiabot.username") + "\"]"));
		}
	}

	@Test(groups={"oasis", "CI"})
	public void testAjaxLoginMailNewPassword() throws Exception {
		session().open("index.php");
		session().click("//a[@class='ajaxLogin']");
		waitForElement("wpGoLogin");
		session().click("wpGoLogin");
		waitForElement("userajaxloginform");
		session().type("wpName2Ajax", getTestConfig().getString("ci.user.wikiabot.username"));
		session().click("wpMailmypassword");
		waitForElementVisible("wpError");
		assertTrue(session().isTextPresent("A new password has been sent")
				|| session().isTextPresent("A password reminder has already been sent"));
		waitForElement("wpGoLogin");
	}

	@Test(groups={"oasis", "CI"})
	public void testAjaxLoginNewAccount() throws Exception {
		session().open("index.php");
		session().click("//a[@class='ajaxLogin']");
		waitForElement("wpGoRegister");
		session().click("wpGoRegister");
		waitForElement("AjaxLoginRegisterForm");
		clickAndWait("wpAjaxRegister");
	}
}
