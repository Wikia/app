package com.wikia.selenium.tests;

import org.testng.annotations.Test;
import static com.thoughtworks.selenium.grid.tools.ThreadSafeSeleniumSessionStorage.session;
import static org.testng.AssertJUnit.assertTrue;

public class AjaxLoginTest extends BaseTest {
	@Test(groups={"CI", "legacy"})
	public void testAjaxLogin() throws Exception {
		openAndWait("index.php");
		waitForElement("//a[@class='ajaxLogin']");
		session().click("//a[@class='ajaxLogin']");
		waitForElement("wpGoLogin");
		session().click("wpGoLogin");
		waitForElement("userajaxloginform");
		session().type("wpName2Ajax", getTestConfig().getString("ci.user.wikiabot.username"));
		session().type("wpPassword2Ajax", getTestConfig().getString("ci.user.wikiabot.password"));
		clickAndWait("wpLoginattempt");
		if(isOasis()) {
			assertTrue(session().isElementPresent("//ul[@id='AccountNavigation']/li/a[contains(., '" + getTestConfig().getString("ci.user.wikiabot.username") + "')]"));
		} else {
			assertTrue(session().isElementPresent("//span[@id=\"pt-userpage\"]/a[text() = \"" + getTestConfig().getString("ci.user.wikiabot.username") + "\"]"));
		}
	}

	@Test(groups={"CI", "legacy"})
	public void testAjaxLoginMailNewPassword() throws Exception {
		openAndWait("index.php");
		waitForElement("//a[@class='ajaxLogin']");
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

	@Test(groups={"CI", "legacy"})
	public void testAjaxLoginNewAccount() throws Exception {
		openAndWait("index.php");
		waitForElement("//a[@class='ajaxLogin']");
		session().click("//a[@class='ajaxLogin']");
		waitForElement("wpGoRegister");
		session().click("wpGoRegister");
		waitForElement("AjaxLoginRegisterForm");
		clickAndWait("wpAjaxRegister");
	}
}
